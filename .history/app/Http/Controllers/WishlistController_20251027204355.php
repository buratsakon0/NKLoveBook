<?php

// app/Http/Controllers/WishlistController.php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Book;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    // เพิ่มหนังสือไปที่ Wishlist
    public function store(Book $book)
    {
        $wishlist = Wishlist::firstOrCreate([
            'UserID' => auth()->id(),  // ไอดีผู้ใช้จากการ login
            'BookID' => $book->id,     // ไอดีของหนังสือที่ต้องการเพิ่ม
        ]);

        // ส่งกลับไปที่หน้าเดิม
        return response()->json(['status' => 'success']);
    }

    // ลบหนังสือออกจาก Wishlist
    public function remove(Book $book)
    {
        $wishlist = auth()->user()->wishlists()->where('BookID', $book->id)->first();
        
        if ($wishlist) {
            $wishlist->delete();  // ลบรายการออกจากฐานข้อมูล
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'Item not found']);
    }

    // แสดงรายการ Wishlist ของผู้ใช้
    public function index()
    {
        $wishlists = auth()->user()->wishlists()->with('book')->get();
        return view('wishlist.index', compact('wishlists'));
    }
}
