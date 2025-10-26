<?php

// app/Http/Controllers/CartController.php

// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // ฟังก์ชันสำหรับแสดงตะกร้า
    public function showCart()
    {
        $cart = session()->get('cart', []);
        $totalPrice = array_sum(array_map(function($product) {
            return $product['price'] * $product['quantity'];
        }, $cart));

        return view('cart.index', compact('cart', 'totalPrice'));
    }

    // ฟังก์ชันอัปเดตจำนวนสินค้า
   public function updateQuantity(Request $request)
    {
        $productId = $request->input('productId');
        $action = $request->input('action');
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            if ($action == 'increase') {
                $cart[$productId]['quantity']++;
            } elseif ($action == 'decrease' && $cart[$productId]['quantity'] > 1) {
                $cart[$productId]['quantity']--;
            }

            session()->put('cart', $cart);
            return response()->json(['success' => true, 'cart' => $cart]);
        }

        return response()->json(['success' => false]);
    }

    // ฟังก์ชันลบสินค้าจากตะกร้า
    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$productId]);

        session()->put('cart', $cart);
        return redirect()->route('cart.index');
    }

    public function addToCart($bookId)
    {
        // ดึงข้อมูลหนังสือพร้อมผู้เขียน
        $book = \App\Models\Book::with('author')->find($bookId);

        if (!$book) {
            return redirect()->back()->with('error', 'ไม่พบหนังสือ');
        }

        // ดึงข้อมูลตะกร้า
        $cart = session()->get('cart', []);

        // ถ้ามีหนังสือเล่มนี้อยู่แล้วในตะกร้า
        if (isset($cart[$bookId])) {
            $cart[$bookId]['quantity']++;
        } else {
            $cart[$bookId] = [
                'name' => $book->BookName,
                'price' => $book->Price,
                'quantity' => 1,
                'image' => $book->cover_image ? 'storage/' . $book->cover_image : 'images/default-book.jpg',
                'author' => $book->author?->AuthorName ?? 'UNKNOWN AUTHOR',
            ];
        }

        // เก็บตะกร้าใน session
        session()->put('cart', $cart);

        return redirect()->route('cart.index');
    }
    // ฟังก์ชันสำหรับลบสินค้าออกจากตะกร้า
    public function remove($productId)
    {
        // ดึงข้อมูลตะกร้าจาก session
        $cart = session()->get('cart', []);

        // ตรวจสอบว่ามีสินค้าในตะกร้านี้หรือไม่
        if (isset($cart[$productId])) {
            // ลบสินค้าออกจากตะกร้า
            unset($cart[$productId]);

            // บันทึกข้อมูลตะกร้าหลังลบสินค้า
            session()->put('cart', $cart);
        }

        // เปลี่ยนเส้นทางไปยังหน้าตะกร้า
        return redirect()->route('cart.index');
    }

}
