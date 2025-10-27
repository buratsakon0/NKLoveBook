<?php
namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'กรุณาเข้าสู่ระบบเพื่อดูรายการโปรด');
        }

        $wishlistItems = $user->wishlists()
            ->with(['book.author'])
            ->latest('wishlists.created_at')
            ->get()
            ->filter(fn ($item) => $item->book !== null)
            ->map(function (Wishlist $item) {
                $book = $item->book;

                $item->setAttribute('resolved_cover', $this->resolveImagePath($book->cover_image ?? null));
                $item->setAttribute('author_name', $book->author?->AuthorName ?? 'UNKNOWN AUTHOR');

                return $item;
            });

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function store(Request $request, $bookId)
    {
        $user = Auth::user();

        $expectsJson = $request->expectsJson() || $request->ajax() || $request->wantsJson();

        if (!$user) {
            if ($expectsJson) {
                return response()->json([
                    'status' => 'unauthenticated',
                    'message' => 'กรุณาเข้าสู่ระบบก่อนเพิ่มหนังสือใน Wishlist',
                ], 401);
            }

            return redirect()->route('login')->with('error', 'กรุณาเข้าสู่ระบบเพื่อบันทึกหนังสือในรายการโปรด');
        }

        $book = Book::findOrFail($bookId);

        $wishlistItem = Wishlist::firstOrCreate(
            [
                'UserID' => $user->getKey(),
                'BookID' => $book->getKey(),
            ]
        );

        if ($wishlistItem->wasRecentlyCreated) {
            if ($expectsJson) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'เพิ่มหนังสือลงใน Wishlist แล้ว',
                ], 201);
            }

            return redirect()->back()->with('success', 'เพิ่มหนังสือลงใน Wishlist แล้ว');
        }

        if ($expectsJson) {
            return response()->json([
                'status' => 'exists',
                'message' => 'หนังสือเล่มนี้อยู่ใน Wishlist แล้ว',
            ]);
        }

        return redirect()->back()->with('info', 'หนังสือเล่มนี้อยู่ใน Wishlist แล้ว');
    }

    public function destroy(Request $request, $bookId)
    {
        $user = Auth::user();

        $expectsJson = $request->expectsJson() || $request->ajax() || $request->wantsJson();

        if (!$user) {
            if ($expectsJson) {
                return response()->json([
                    'status' => 'unauthenticated',
                    'message' => 'กรุณาเข้าสู่ระบบก่อนจัดการ Wishlist',
                ], 401);
            }

            return redirect()->route('login')->with('error', 'กรุณาเข้าสู่ระบบเพื่อจัดการรายการโปรด');
        }

        $deleted = Wishlist::where('UserID', $user->getKey())
            ->where('BookID', $bookId)
            ->delete();

        if ($expectsJson) {
            return response()->json([
                'status' => $deleted ? 'success' : 'not_found',
                'message' => $deleted ? 'ลบหนังสือออกจาก Wishlist แล้ว' : 'ไม่พบหนังสือใน Wishlist',
            ]);
        }

        return redirect()->back()->with('success', 'ลบหนังสือออกจาก Wishlist แล้ว');
    }

    protected function resolveImagePath(?string $coverImage): string
    {
        if (!$coverImage) {
            return asset('images/default-book.jpg');
        }

        if (filter_var($coverImage, FILTER_VALIDATE_URL)) {
            return $coverImage;
        }

        return asset('images/' . ltrim($coverImage, '/'));
    }
}
