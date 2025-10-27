<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('component.navbar', function ($view) {
            $cartCount = 0;

            if (Auth::check()) {
                $sessionCart = session('cart', []);

                if (is_array($sessionCart) && !empty($sessionCart)) {
                    $cartCount = count($sessionCart);
                } else {
                    $userId = Auth::user()->getKey();
                    $cartId = Cart::where('UserID', $userId)->value('CartID');

                    if ($cartId) {
                        $cartCount = CartItem::where('CartID', $cartId)->count();
                    }
                }
            } else {
                $guestCart = session('cart', []);
                if (is_array($guestCart)) {
                    $cartCount = count($guestCart);
                }
            }

            $view->with('cartCount', $cartCount);
        });
    }
}
