<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Book;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
        $cartItems = $cart->items
            ->filter(fn ($item) => $item->book !== null)
            ->map(function ($item) {
                $item->setAttribute('available_stock', max((int) $item->book->Stock, 0));
                return $item;
            })
            ->values();

        $insufficientItems = $cartItems->filter(fn ($item) => $item->available_stock < $item->Quantity);
        if ($insufficientItems->isNotEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'บางรายการมีจำนวนเกินสต็อกที่มีอยู่ กรุณาปรับจำนวนในตะกร้า');
        }

        $total = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item->book->Price * $item->Quantity);
        }, 0);
        $total = round($total, 2);

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

        $cartItems = $cart->items
            ->filter(fn ($item) => $item->book !== null)
            ->map(function ($item) {
                $item->setAttribute('available_stock', max((int) $item->book->Stock, 0));
                return $item;
            })
            ->values();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'ไม่พบสินค้าที่สามารถชำระเงินได้');
        }

        $insufficientItems = $cartItems->filter(fn ($item) => $item->available_stock < $item->Quantity);
        if ($insufficientItems->isNotEmpty()) {
            $itemList = $insufficientItems
                ->map(fn ($item) => "{$item->book->BookName} (คงเหลือ {$item->available_stock})")
                ->implode(', ');

            return back()
                ->withErrors(['stock' => "จำนวนคงเหลือไม่เพียงพอสำหรับ: {$itemList}"])
                ->withInput();
        }

        $total = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item->book->Price * $item->Quantity);
        }, 0);
        $total = round($total, 2);

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

        $address = Address::where('UserID', $user->getKey())->first();
        if (!$address) {
            return redirect()
                ->route('checkout')
                ->withErrors(['address' => 'กรุณาเพิ่มที่อยู่จัดส่งก่อนทำการชำระเงิน']);
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

        try {
            [$payment, $order] = DB::transaction(function () use (
                $user,
                $validated,
                $total,
                $normalizedCardNumber,
                $expMonth,
                $expYear,
                $cart,
                $cartItems,
                $address
            ) {
                $payment = Payment::create([
                    'Status' => 'pending',
                    'PayDate' => null,
                    'Method' => strtoupper($validated['card_type']),
                    'TransactionID' => sprintf('%.2f|%s|%02d/%d', $total, substr($normalizedCardNumber, -4), $expMonth, $expYear),
                    'Amount' => $total,
                    'UserID' => $user->getKey(),
                    'CardType' => strtoupper($validated['card_type']),
                    'CardLastFour' => substr($normalizedCardNumber, -4),
                    'CardExpMonth' => $expMonth,
                    'CardExpYear' => $expYear,
                ]);

                $order = Order::create([
                    'UserID' => $user->getKey(),
                    'OrderDate' => now(),
                    'TotalPrice' => $total,
                    'PaymentID' => $payment->getKey(),
                    'TrackingID' => null,
                    'AddressID' => $address->getKey(),
                ]);

                foreach ($cartItems as $item) {
                    $lockedBook = Book::where('BookID', $item->book->BookID)
                        ->lockForUpdate()
                        ->first();

                    if (!$lockedBook) {
                        throw ValidationException::withMessages([
                            'stock' => 'ไม่สามารถดำเนินการชำระเงินได้ เนื่องจากมีหนังสือบางเล่มถูกลบออกจากระบบ',
                        ]);
                    }

                    if ($lockedBook->Stock < $item->Quantity) {
                        throw ValidationException::withMessages([
                            'stock' => "จำนวนคงเหลือไม่เพียงพอสำหรับ {$lockedBook->BookName}",
                        ]);
                    }

                    OrderItem::create([
                        'OrderID' => $order->getKey(),
                        'BookID' => $lockedBook->BookID,
                        'Quantity' => $item->Quantity,
                        'UnitPrice' => $lockedBook->Price,
                    ]);

                    $lockedBook->decrement('Stock', $item->Quantity);
                }

                $payment->update([
                    'Status' => 'completed',
                    'PayDate' => now(),
                ]);

                $cart->items()->delete();

                return [$payment, $order];
            });
        } catch (ValidationException $exception) {
            return back()
                ->withErrors($exception->errors())
                ->withInput();
        }

        session()->forget('cart');

        return redirect()
            ->route('checkout.complete')
            ->with([
                'payment_id' => $payment->getKey(),
                'order_id' => $order->getKey(),
            ]);
    }

    public function complete()
    {
        $user = Auth::user();

        return view('checkout.complete', [
            'user' => $user,
            'orderId' => session('order_id'),
            'paymentId' => session('payment_id'),
        ]);
    }
}
