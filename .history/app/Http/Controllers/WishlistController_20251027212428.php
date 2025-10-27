<?php


namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Book;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return view('cart.index', [
                'cart' => [],
                'totalPrice' => 0,
            ]);
        }

        $bookIds = array_keys($cart);
        $books = Book::whereIn('BookID', $bookIds)->get()->keyBy('BookID');

        foreach ($cart as $productId => &$product) {
            $book = $books->get($productId);
            if ($book) {
                $product['author'] = $book->author?->AuthorName ?? $product['author'] ?? 'UNKNOWN AUTHOR';
                $product['name'] = $book->BookName;
                $product['price'] = $book->Price;
            } 
            elseif (!isset($product['image']) || empty($product['image'])) {
                $product['image'] = asset('images/default-book.jpg');
            } else {
                $product['image'] = $this->normalizeStoredImagePath($product['image']);
            }
        }
        unset($product); // ป้องกัน reference ค้าง

        session()->put('cart', $cart);

        $totalPrice = array_sum(array_map(function($product) {
            return $product['price'] * $product['quantity'];
        }, $cart));

        return view('cart.index', [
            'cart' => $cart,
            'totalPrice' => $totalPrice,
        ]);
    }
}
