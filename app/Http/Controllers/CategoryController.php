<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Book;

class CategoryController extends Controller
{
    public function show($id)
    {
        $category = Category::findOrFail($id);
        // ใช้ paginate แสดงหนังสือแค่ 8 เล่มต่อหน้า
        $books = Book::where('CategoryID', $id)->paginate(8);  // เพิ่ม pagination

        return view('category', compact('category', 'books'));
    }
}
