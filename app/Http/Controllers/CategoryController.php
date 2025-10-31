<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Book;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $sort = $request->query('sort');

        $booksQuery = Book::where('CategoryID', $id);

        if ($sort === 'price_asc') {
            $booksQuery->orderBy('Price', 'asc');
        } elseif ($sort === 'price_desc') {
            $booksQuery->orderBy('Price', 'desc');
        } else {
            $sort = null;
        }

        $books = $booksQuery->paginate(8);

        if ($sort) {
            $books->appends(['sort' => $sort]);
        }

        return view('category', [
            'category' => $category,
            'books' => $books,
            'currentSort' => $sort,
        ]);
    }
}
