<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = trim($request->input('query', ''));
        $sort = $request->input('sort');

        // If no query, return empty results
        if (empty($query)) {
            return view('search', [
                'books' => collect([]),
                'query' => $query,
                'totalResults' => 0,
                'currentSort' => null,
            ]);
        }

        // Search books by name, author, ISBN, or description
        $booksQuery = Book::with(['author', 'category'])
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
            });

        if ($sort === 'price_asc') {
            $booksQuery->orderBy('Price', 'asc');
        } elseif ($sort === 'price_desc') {
            $booksQuery->orderBy('Price', 'desc');
        } else {
            $sort = null;
        }

        $books = $booksQuery->get();

        return view('search', [
            'books' => $books,
            'query' => $query,
            'totalResults' => $books->count(),
            'currentSort' => $sort,
        ]);
    }
}
