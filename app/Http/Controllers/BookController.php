<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function show(Book $book)
    {
        $book->load(['author', 'publisher', 'category', 'reviews.user']);

        $totalReviews = $book->reviews->count();
        $averageRating = $totalReviews ? round($book->reviews->avg('Score'), 1) : null;

        $ratingsDistribution = collect(range(1, 5))->mapWithKeys(function ($score) use ($book, $totalReviews) {
            $count = $book->reviews->where('Score', $score)->count();
            $percent = $totalReviews ? round(($count / $totalReviews) * 100) : 0;

            return [$score => [
                'count' => $count,
                'percent' => $percent,
            ]];
        })->sortKeysDesc();

        // Check if current user has reviewed this book
        $userReview = null;
        if (Auth::check()) {
            $userReview = $book->reviews->where('UserID', Auth::id())->first();
        }

        return view('book', [
            'book' => $book,
            'averageRating' => $averageRating,
            'totalReviews' => $totalReviews,
            'ratingsDistribution' => $ratingsDistribution,
            'userReview' => $userReview,
        ]);
    }
}
