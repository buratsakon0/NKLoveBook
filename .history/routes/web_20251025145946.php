<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/book', function(){
    return view('book');
})->name('book');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
