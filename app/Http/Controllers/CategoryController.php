<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Book;

class CategoryController extends Controller
{
    public function show($id)
    {
        $category = Category::findOrFail($id);
        $books = Book::where('CategoryID', $id)->get();

        return view('category', compact('category', 'books'));
    }
}
