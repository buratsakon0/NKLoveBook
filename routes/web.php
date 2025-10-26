<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;

// หน้าแรก
Route::get('/', [HomeController::class, 'index'])->name('home');

// หน้า home (view ตรง)
Route::view('/home', 'home');

// หน้า book
Route::get('/book/{book}', [BookController::class, 'show'])->name('book.show');

// หน้า contact
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');
