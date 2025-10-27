<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function store(Book $book)
    {
        $wishlist = Wishlist::firstOrCreate([
            'UserID' => auth()->id(),
            'BookID' => $book->id,
        ]);

        return redirect()->route('wishlist.index')->with('success', 'Added to wishlist');
    }

    public function index()
    {
        $wishlists = auth()->user()->wishlists()->with('book')->get();
        return view('wishlist.index', compact('wishlists'));
    }

    public function destroy(Book $book)
    {
        $wishlist = auth()->user()->wishlists()->where('BookID', $book->id)->first();
        $wishlist->delete();

        return redirect()->route('wishlist.index')->with('success', 'Removed from wishlist');
    }
}
