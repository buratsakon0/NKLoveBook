<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class HomeController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลหนังสือทั้งหมด หรือเฉพาะ bestseller
        $books = Book::limit(4)->get();  // หรือใช้ ->orderBy('price', 'desc')->limit(4)->get();

        return view('home', compact('books'));
    }
}
