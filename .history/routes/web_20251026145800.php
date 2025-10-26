<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

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

Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

//  หน้าสมัครสมาชิก
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

//  ปุ่มออกจากระบบ
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/profile', [ProfileController::class, 'show'])->middleware('auth')->name('profile');


