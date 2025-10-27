<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        $cart = Cart::with(['items.book.author'])
            ->where('UserID', $user->getKey())
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'ตะกร้าสินค้าว่างเปล่า');
        }

        $address = Address::where('UserID', $user->getKey())->first();
        $cartItems = $cart->items->filter(fn ($item) => $item->book !== null);

        $total = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item->book->Price * $item->Quantity);
        }, 0);

        return view('checkout.payment', [
            'user' => $user,
            'address' => $address,
            'cartItems' => $cartItems,
            'orderValue' => $total,
            'deliveryFee' => 0,
            'total' => $total,
        ]);
    }

    public function process(Request $request)
    {
        $user = Auth::user();

        $cart = Cart::with(['items.book'])
            ->where('UserID', $user->getKey())
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'ตะกร้าสินค้าว่างเปล่า');
        }

        $total = $cart->items->reduce(function ($carry, $item) {
            if (!$item->book) {
                return $carry;
            }

            return $carry + ($item->book->Price * $item->Quantity);
        }, 0);

        $validated = $request->validate(
            [
                'card_type' => 'required|in:visa,mastercard',
                'card_number' => 'required|string|min:12|max:25',
                'expiration' => ['required', 'regex:/^(0[1-9]|1[0-2])\\/\\d{2}$/'],
                'security_code' => 'required|digits_between:3,4',
            ],
            [
                'expiration.regex' => 'กรุณากรอกวันหมดอายุในรูปแบบ MM/YY',
            ]
        );

        $normalizedCardNumber = preg_replace('/\D/', '', $validated['card_number']);
        if (strlen($normalizedCardNumber) < 12) {
            return back()
                ->withErrors(['card_number' => 'หมายเลขบัตรเครดิตไม่ถูกต้อง'])
                ->withInput();
        }

        [$expMonthValue, $expYearTwoDigits] = explode('/', $validated['expiration']);
        $expMonth = (int) $expMonthValue;
        $expYear = 2000 + (int) $expYearTwoDigits;

        $currentYear = (int) date('Y');
        $currentMonth = (int) date('m');
        if ($expYear < $currentYear || ($expYear === $currentYear && $expMonth < $currentMonth)) {
            return back()
                ->withErrors(['expiration' => 'วันหมดอายุของบัตรต้องอยู่ในอนาคต'])
                ->withInput();
        }

        DB::transaction(function () use ($user, $validated, $total, $normalizedCardNumber, $expMonth, $expYear) {
            Payment::create([
                'Status' => 'pending',
                'PayDate' => null,
                'Method' => 'credit_card',
                'TransactionID' => null,
                'Amount' => $total,
                'UserID' => $user->getKey(),
                'CardType' => strtoupper($validated['card_type']),
                'CardLastFour' => substr($normalizedCardNumber, -4),
                'CardExpMonth' => $expMonth,
                'CardExpYear' => $expYear,
            ]);

            // Leave cart items intact for now; fulfillment logic can clear them later
        });

        return redirect()
            ->route('checkout.payment')
            ->with('success', 'บันทึกรายการชำระเงินเรียบร้อยแล้ว');
    }
}
