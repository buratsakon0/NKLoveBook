<?php

// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // ฟังก์ชันสำหรับแสดงตะกร้า
    public function showCart()
    {
        $user = Auth::user();
        $cart = [];

        if ($user) {
            $cartModel = Cart::firstOrCreate(['UserID' => $user->getKey()]);

            $sessionCart = session()->get('cart', []);
            if (!empty($sessionCart)) {
                foreach ($sessionCart as $bookId => $product) {
                    $this->persistCartItem($cartModel, (int) $bookId, (int) ($product['quantity'] ?? 1));
                }
            }

            $cartItems = $cartModel->items()->with('book.author')->get();
            foreach ($cartItems as $item) {
                if (!$item->book) {
                    continue;
                }

                $cart[$item->book->BookID] = $this->formatProductArray($item->book, $item->Quantity);
            }

            session()->put('cart', $cart);
        } else {
            $cart = session()->get('cart', []);

            if (!empty($cart)) {
                $bookIds = array_keys($cart);
                $books = Book::whereIn('BookID', $bookIds)->with('author')->get()->keyBy('BookID');

                foreach ($cart as $productId => &$product) {
                    $book = $books->get($productId);
                    if ($book) {
                        $product = $this->formatProductArray(
                            $book,
                            $product['quantity'] ?? 1,
                            $product
                        );
                    } elseif (!isset($product['image']) || empty($product['image'])) {
                        $product['image'] = asset('images/default-book.jpg');
                    } else {
                        $product['image'] = $this->normalizeStoredImagePath($product['image']);
                    }
                }
                unset($product);

                session()->put('cart', $cart);
            }
        }

        if (empty($cart)) {
            return view('cart.index', [
                'cart' => [],
                'totalPrice' => 0,
            ]);
        }

        $totalPrice = array_sum(array_map(function($product) {
            return $product['price'] * $product['quantity'];
        }, $cart));

        return view('cart.index', [
            'cart' => $cart,
            'totalPrice' => $totalPrice,
        ]);
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
            $this->syncQuantityToDatabase((int) $productId, $cart[$productId]['quantity']);

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
        $this->removeFromDatabase((int) $productId);

        session()->put('cart', $cart);
        return redirect()->route('cart.index');
    }

    public function addToCart(Request $request, $bookId)
    {
        // ดึงข้อมูลหนังสือพร้อมผู้เขียน
        $book = \App\Models\Book::with('author')->find($bookId);

        if (!$book) {
            return redirect()->back()->with('error', 'ไม่พบหนังสือ');
        }

        // ดึงข้อมูลตะกร้า
        $cart = session()->get('cart', []);

        // อ่านจำนวนจากฟอร์มและป้องกันค่าจำนวนที่ไม่ถูกต้อง
        $requestedQuantity = (int) $request->input('quantity', 1);
        $requestedQuantity = $requestedQuantity > 0 ? $requestedQuantity : 1;

        $imageUrl = $this->resolveImagePath($book->cover_image);

        // ถ้ามีหนังสือเล่มนี้อยู่แล้วในตะกร้า
        if (isset($cart[$bookId])) {
            $cart[$bookId]['quantity'] += $requestedQuantity;
        } else {
            $cart[$bookId] = [
                'name' => $book->BookName,
                'price' => $book->Price,
                'quantity' => $requestedQuantity,
                'image' => $imageUrl,
                'author' => $book->author?->AuthorName ?? 'UNKNOWN AUTHOR',
            ];
        }

        // เก็บตะกร้าใน session
        session()->put('cart', $cart);
        $this->syncQuantityToDatabase($bookId, $cart[$bookId]['quantity']);

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
            $this->removeFromDatabase((int) $productId);
            session()->put('cart', $cart);
        }

        // เปลี่ยนเส้นทางไปยังหน้าตะกร้า
        return redirect()->route('cart.index');
    }

    /**
     * แปลง path รูปภาพของหนังสือในฐานข้อมูลให้พร้อมใช้งานบนหน้าเว็บ
     */
    protected function resolveImagePath(?string $coverImage): string
    {
        // return $coverImage;
        if (!$coverImage) {
            return asset('images/default-book.jpg');
        }

        if (filter_var($coverImage, FILTER_VALIDATE_URL)) {
            return $coverImage;
        }

        return asset('images/' . ltrim($coverImage, '/'));
    }

    /**
     * แปลง path รูปภาพที่เก็บไว้ใน session ให้กลับมาเป็น URL ที่ใช้งานได้
     */
    protected function normalizeStoredImagePath(string $storedPath): string
    {
        if (filter_var($storedPath, FILTER_VALIDATE_URL)) {
            return $storedPath;
        }

        $cleanPath = ltrim($storedPath, '/');
        return asset($cleanPath);
    }

   public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $bookId = $request->input('book_id');
        $quantity = $request->input('quantity');

        // ตรวจสอบว่าใน Cart มีสินค้านี้อยู่แล้วหรือไม่
        if (isset($cart[$bookId])) {
            $cart[$bookId]['quantity'] = $quantity;  // อัปเดตจำนวนสินค้า
        } else {
            // ถ้าไม่มีสินค้าใน Cart, เพิ่มสินค้าใหม่
            $cart[$bookId] = [
                'book_name' => $request->input('book_name'),
                'quantity' => $quantity,
                'price' => $request->input('price')
            ];
        }

        session()->put('cart', $cart);
        $this->syncQuantityToDatabase((int) $bookId, (int) $cart[$bookId]['quantity']);

        // คืนค่าจำนวนสินค้าทั้งหมดใน Cart
        return response()->json(['cartCount' => count($cart)]);
    }

    protected function formatProductArray(Book $book, int $quantity, array $existing = []): array
    {
        return [
            'name' => $book->BookName,
            'price' => $book->Price,
            'quantity' => $quantity,
            'image' => $this->resolveImagePath($book->cover_image),
            'author' => $book->author?->AuthorName ?? ($existing['author'] ?? 'UNKNOWN AUTHOR'),
        ];
    }

    protected function getUserCart(): ?Cart
    {
        $user = Auth::user();
        return $user ? Cart::firstOrCreate(['UserID' => $user->getKey()]) : null;
    }

    protected function syncQuantityToDatabase(int $bookId, int $quantity): void
    {
        $cart = $this->getUserCart();
        if (!$cart) {
            return;
        }

        if ($quantity <= 0) {
            $this->removeFromDatabase($bookId);
            return;
        }

        CartItem::updateOrCreate(
            [
                'CartID' => $cart->getKey(),
                'BookID' => $bookId,
            ],
            [
                'Quantity' => $quantity,
            ]
        );
    }

    protected function persistCartItem(Cart $cart, int $bookId, int $quantity): void
    {
        $quantity = max($quantity, 1);

        $existing = CartItem::where('CartID', $cart->getKey())
            ->where('BookID', $bookId)
            ->first();

        if ($existing) {
            if ($existing->Quantity !== $quantity) {
                $existing->Quantity = $quantity;
                $existing->save();
            }
        } else {
            CartItem::create([
                'CartID' => $cart->getKey(),
                'BookID' => $bookId,
                'Quantity' => $quantity,
            ]);
        }
    }

    protected function removeFromDatabase(int $bookId): void
    {
        $cart = $this->getUserCart();
        if (!$cart) {
            return;
        }

        CartItem::where('CartID', $cart->getKey())
            ->where('BookID', $bookId)
            ->delete();
    }
}
