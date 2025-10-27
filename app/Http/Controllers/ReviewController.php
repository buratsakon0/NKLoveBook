<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function store(Request $request, $bookId)
    {
        $request->validate([
            'score' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $book = Book::findOrFail($bookId);
        $userId = Auth::id();

        // Check if user already reviewed this book
        $existingReview = Review::where('BookID', $bookId)
            ->where('UserID', $userId)
            ->first();

        if ($existingReview) {
            // Update existing review
            $existingReview->update([
                'Score' => $request->score,
                'Comment' => $request->comment,
            ]);
            
            return redirect()->route('book.show', $book)
                ->with('success', 'Your review has been updated successfully!');
        } else {
            // Create new review
            Review::create([
                'BookID' => $bookId,
                'UserID' => $userId,
                'Score' => $request->score,
                'Comment' => $request->comment,
            ]);
            
            return redirect()->route('book.show', $book)
                ->with('success', 'Thank you for your review!');
        }
    }

    public function destroy($bookId)
    {
        $userId = Auth::id();
        
        // Use DB query builder for deletion with composite primary key
        $deleted = DB::table('reviews')
            ->where('BookID', $bookId)
            ->where('UserID', $userId)
            ->delete();

        if ($deleted) {
            return redirect()->route('book.show', $bookId)
                ->with('success', 'Your review has been deleted.');
        }

        return redirect()->route('book.show', $bookId)
            ->with('error', 'Review not found.');
    }
}
