<!-- หน้า wishlist.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto my-10">
    <h2 class="text-2xl font-bold text-indigo-900 mb-6">My Wishlist</h2>
    @foreach($wishlists as $wishlist)
        <div class="wishlist-item flex justify-between items-center mb-4">
            <div>
                <img src="{{ asset('images/' . $wishlist->book->cover_image) }}" alt="{{ $wishlist->book->BookName }}" class="w-24 h-32">
                <span>{{ $wishlist->book->BookName }}</span>
            </div>
            <div>
                <span>฿{{ number_format($wishlist->book->Price, 2) }}</span>
                <button 
                    onclick="addToCart({{ $wishlist->book->id }})" 
                    class="bg-indigo-600 text-white py-1 px-4 rounded hover:bg-indigo-700">
                    Add to Cart
                </button>
                <button 
                    onclick="removeFromWishlist({{ $wishlist->book->id }})" 
                    class="text-red-500 ml-4">
                    <i class="fa fa-trash"></i> Remove
                </button>
            </div>
        </div>
    @endforeach
</div>
@endsection
