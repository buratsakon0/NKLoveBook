<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// หน้าแรก
Route::get('/', [HomeController::class, 'index'])->name('home');

// หน้า home (view ตรง)
Route::view('/home', 'home');

// หน้า book
Route::get('/book', function () {
    return view('book');
})->name('book');

// หน้า contact
Route::get('/contact', function () {
    return view('contact');
})->name('contact');