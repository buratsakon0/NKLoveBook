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
        $stockAdjusted = false;

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
                    $stockAdjusted = true;
                    $item->delete();
                    continue;
                }

                $availableStock = max((int) $item->book->Stock, 0);
                if ($availableStock <= 0) {
                    $stockAdjusted = true;
                    $item->delete();
                    continue;
                }

                $finalQuantity = min($item->Quantity, $availableStock);

                if ($finalQuantity !== $item->Quantity) {
                    $stockAdjusted = true;
                    $item->Quantity = $finalQuantity;
                    $item->save();
                }

                $productArray = $this->formatProductArray($item->book, $finalQuantity);
                if ($productArray !== null) {
                    $cart[$item->book->BookID] = $productArray;
                }
            }

            session()->put('cart', $cart);
        } else {
            $cart = session()->get('cart', []);

            if (!empty($cart)) {
                $bookIds = array_keys($cart);
                $books = Book::whereIn('BookID', $bookIds)->with('author')->get()->keyBy('BookID');

                $normalizedCart = [];

                foreach ($cart as $productId => $product) {
                    $book = $books->get($productId);
                    if ($book) {
                        $quantity = (int) ($product['quantity'] ?? 1);
                        $availableStock = max((int) $book->Stock, 0);

                        if ($availableStock <= 0) {
                            $stockAdjusted = true;
                            continue;
                        }

                        $finalQuantity = min($quantity, $availableStock);
                        if ($finalQuantity !== $quantity) {
                            $stockAdjusted = true;
                        }
                        $formatted = $this->formatProductArray(
                            $book,
                            $finalQuantity,
                            $product
                        );

                        if ($formatted !== null) {
                            $normalizedCart[$productId] = $formatted;
                        }
                    } else {
                        if (!isset($product['image']) || empty($product['image'])) {
                            $product['image'] = asset('images/default-book.jpg');
                        } else {
                            $product['image'] = $this->normalizeStoredImagePath($product['image']);
                        }
                        $normalizedCart[$productId] = $product;
                    }
                }

                $cart = $normalizedCart;

                session()->put('cart', $cart);
            }
        }

        if ($stockAdjusted) {
            session()->flash('warning', 'จำนวนสินค้าในตะกร้าบางรายการถูกปรับตามสต็อกที่มีอยู่ในขณะนี้');
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
            $book = Book::find($productId);

            if (!$book || (int) $book->Stock <= 0) {
                unset($cart[$productId]);
                session()->put('cart', $cart);
                $this->removeFromDatabase((int) $productId);

                return response()->json([
                    'success' => false,
                    'cart' => $cart,
                    'message' => 'หนังสือเล่มนี้หมดสต็อกแล้ว',
                ]);
            }

            $availableStock = (int) $book->Stock;

            if ($action === 'increase') {
                if ($cart[$productId]['quantity'] >= $availableStock) {
                    $cart[$productId]['quantity'] = $availableStock;

                    session()->put('cart', $cart);
                    $this->syncQuantityToDatabase((int) $productId, $availableStock);

                    return response()->json([
                        'success' => false,
                        'cart' => $cart,
                        'message' => "จำนวนสูงสุดที่สามารถสั่งซื้อได้คือ {$availableStock} เล่ม",
                    ]);
                }

                $cart[$productId]['quantity']++;
            } elseif ($action === 'decrease' && $cart[$productId]['quantity'] > 1) {
                $cart[$productId]['quantity']--;
            }

            $formattedProduct = $this->formatProductArray(
                $book,
                $cart[$productId]['quantity'],
                $cart[$productId]
            );

            if ($formattedProduct === null) {
                unset($cart[$productId]);
                session()->put('cart', $cart);
                $this->removeFromDatabase((int) $productId);

                return response()->json([
                    'success' => false,
                    'cart' => $cart,
                    'message' => 'ไม่สามารถอัปเดตสินค้าได้เนื่องจากสต็อกหมด',
                ]);
            }

            $cart[$productId] = $formattedProduct;

            $this->syncQuantityToDatabase((int) $productId, $cart[$productId]['quantity']);
            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'cart' => $cart,
            ]);
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

        $availableStock = max((int) $book->Stock, 0);
        if ($availableStock <= 0) {
            return redirect()->back()->with('error', 'หนังสือเล่มนี้หมดสต็อกแล้ว');
        }

        $currentQuantity = $cart[$bookId]['quantity'] ?? 0;
        $desiredQuantity = $currentQuantity + $requestedQuantity;
        $finalQuantity = min($desiredQuantity, $availableStock);

        $existingProduct = $cart[$bookId] ?? [
            'author' => $book->author?->AuthorName ?? 'UNKNOWN AUTHOR',
        ];
        $formattedProduct = $this->formatProductArray($book, $finalQuantity, $existingProduct);

        if ($formattedProduct === null) {
            unset($cart[$bookId]);
            return redirect()
                ->back()
                ->with('error', 'ไม่สามารถเพิ่มหนังสือเล่มนี้ได้เนื่องจากสต็อกหมด');
        }

        $cart[$bookId] = $formattedProduct;

        if ($finalQuantity <= 0) {
            unset($cart[$bookId]);
            return redirect()
                ->back()
                ->with('error', 'ไม่สามารถเพิ่มหนังสือเล่มนี้ได้เนื่องจากสต็อกหมด');
        }

        // เก็บตะกร้าใน session
        session()->put('cart', $cart);
        $this->syncQuantityToDatabase($bookId, $finalQuantity);

        $message = $finalQuantity < $desiredQuantity
            ? "จำนวนถูกจำกัดตามสต็อกที่มีอยู่ (สูงสุด {$availableStock} เล่ม)"
            : 'เพิ่มหนังสือลงในตะกร้าเรียบร้อยแล้ว';
        $messageType = $finalQuantity < $desiredQuantity ? 'warning' : 'success';

        return redirect()->route('cart.index')->with($messageType, $message);
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
        $book = Book::find($bookId);
        if (!$book || (int) $book->Stock <= 0) {
            unset($cart[$bookId]);
            session()->put('cart', $cart);
            $this->removeFromDatabase((int) $bookId);

            return response()->json([
                'cartCount' => count($cart),
                'message' => 'หนังสือเล่มนี้หมดสต็อกแล้ว',
            ]);
        }

        $clampedQuantity = max(1, min((int) $quantity, (int) $book->Stock));

        $formattedProduct = $this->formatProductArray(
            $book,
            $clampedQuantity,
            $cart[$bookId] ?? [
                'author' => $book->author?->AuthorName ?? 'UNKNOWN AUTHOR',
            ]
        );

        if ($formattedProduct === null) {
            unset($cart[$bookId]);
            session()->put('cart', $cart);
            $this->removeFromDatabase((int) $bookId);

            return response()->json([
                'cartCount' => count($cart),
                'message' => 'สินค้านี้หมดสต็อกแล้ว',
            ]);
        }

        $cart[$bookId] = $formattedProduct;

        session()->put('cart', $cart);
        $this->syncQuantityToDatabase((int) $bookId, (int) $cart[$bookId]['quantity']);

        // คืนค่าจำนวนสินค้าทั้งหมดใน Cart
        return response()->json([
            'cartCount' => count($cart),
            'message' => $clampedQuantity < (int) $quantity
                ? "จำนวนถูกจำกัดตามสต็อกที่มีอยู่ (สูงสุด {$book->Stock} เล่ม)"
                : null,
        ]);
    }

    protected function formatProductArray(Book $book, int $quantity, array $existing = []): ?array
    {
        if ($quantity <= 0) {
            return null;
        }

        return [
            'name' => $book->BookName,
            'price' => $book->Price,
            'quantity' => $quantity,
            'image' => $this->resolveImagePath($book->cover_image),
            'author' => $book->author?->AuthorName ?? ($existing['author'] ?? 'UNKNOWN AUTHOR'),
            'stock' => (int) $book->Stock,
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

        $book = Book::find($bookId);
        if (!$book || (int) $book->Stock <= 0) {
            $this->removeFromDatabase($bookId);
            return;
        }

        $quantity = max(1, min($quantity, (int) $book->Stock));

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

        $book = Book::find($bookId);
        if (!$book || (int) $book->Stock <= 0) {
            CartItem::where('CartID', $cart->getKey())
                ->where('BookID', $bookId)
                ->delete();
            return;
        }

        $quantity = min($quantity, (int) $book->Stock);

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
