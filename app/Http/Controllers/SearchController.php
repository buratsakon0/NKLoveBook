<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = trim($request->input('query', ''));

        // If no query, return empty results
        if (empty($query)) {
            return view('search', [
                'books' => collect([]),
                'query' => $query,
                'totalResults' => 0
            ]);
        }

        // Search books by name, author, ISBN, or description
        $books = Book::with(['author', 'category'])
            ->where(function ($q) use ($query) {
                $q->where('BookName', 'LIKE', "%{$query}%")
                  ->orWhere('ISBN', 'LIKE', "%{$query}%")
                  ->orWhere('Description', 'LIKE', "%{$query}%")
                  ->orWhereHas('author', function ($authorQuery) use ($query) {
                      $authorQuery->where('AuthorName', 'LIKE', "%{$query}%");
                  })
                  ->orWhereHas('category', function ($categoryQuery) use ($query) {
                      $categoryQuery->where('CategoryName', 'LIKE', "%{$query}%");
                  });
            })
            ->get();

        return view('search', [
            'books' => $books,
            'query' => $query,
            'totalResults' => $books->count()
        ]);
    }
}

