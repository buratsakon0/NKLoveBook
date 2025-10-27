<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\PaymentController;


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

// Search route
Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

//  หน้าสมัครสมาชิก
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

//  ปุ่มออกจากระบบ
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/profile', [ProfileController::class, 'show'])->middleware('auth')->name('profile');

Route::get('/api/check-username', function (Request $request) {
    $exists = User::where('Username', $request->Username)->exists();
    return response()->json(['exists' => $exists]);
});

Route::get('/api/check-email', function (Request $request) {
    $exists = User::where('Email', $request->Email)->exists();
    return response()->json(['exists' => $exists]);
});

// เส้นทางสำหรับเพิ่มสินค้าไปยังตะกร้า
Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');

// เส้นทางสำหรับแสดงสินค้าทั้งหมดในตะกร้า
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.index');

// เส้นทางสำหรับอัพเดตจำนวนสินค้าภายในตะกร้า
Route::put('/cart/update/{productId}', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/update/{productId}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/update-cart', [CartController::class, 'updateCart']);


// Review routes
Route::post('/book/{bookId}/review', [ReviewController::class, 'store'])->name('review.store')->middleware('auth');
Route::delete('/book/{bookId}/review', [ReviewController::class, 'destroy'])->name('review.destroy')->middleware('auth');


// Wishlist
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{bookId}', [WishlistController::class, 'store'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{bookId}', [WishlistController::class, 'destroy'])->name('wishlist.remove');
});


// เส้นทางสำหรับการ submit ข้อมูลใน Checkout
Route::post('/checkout/submit', [CheckoutController::class, 'submit'])->name('checkout.submit');

// shipping
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [ShippingController::class, 'showShippingForm'])->name('checkout');
    Route::get('/checkout/edit', [ShippingController::class, 'editShippingForm'])->name('checkout.edit');
    Route::post('/checkout/save', [ShippingController::class, 'saveShippingAddress'])->name('checkout.save');
    Route::get('/checkout/payment', [PaymentController::class, 'show'])->name('checkout.payment');
    Route::post('/checkout/payment', [PaymentController::class, 'process'])->name('checkout.payment.process');
});
