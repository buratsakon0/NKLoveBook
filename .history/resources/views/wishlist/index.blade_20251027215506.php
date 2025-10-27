@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-12 px-4">
  <h1 class="text-3xl font-bold text-center text-indigo-900 mb-6 flex items-center justify-center gap-2">
    <svg width="50px" height="50px" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
      <path d="M25 39.7l-.6-.5C11.5 28.7 8 25 8 19c0-5 4-9 9-9 4.1 0 6.4 2.3 8 4.1 1.6-1.8 3.9-4.1 8-4.1 5 0 9 4 9 9 0 6-3.5 9.7-16.4 20.2l-.6.5zM17 12c-3.9 0-7 3.1-7 7 0 5.1 3.2 8.5 15 18.1 11.8-9.6 15-13 15-18.1 0-3.9-3.1-7-7-7-3.5 0-5.4 2.1-6.9 3.8L25 17.1l-1.1-1.3C22.4 14.1 20.5 12 17 12z"/>
    </svg>
    My Wishlist
  </h1>

  @if(!empty($cart))
    <div class="bg-white shadow-md rounded-lg border border-gray-200">
       @foreach($cart as $productId => $product)
      <div class="flex justify-between items-center p-6 border-b border-gray-200">
        <div class="flex items-center space-x-4">
          <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-24 h-auto rounded shadow-sm">
                <div>
             <p class="font-semibold text-indigo-900">{{ $product['name'] }}</p>
                  <p class="text-sm text-gray-500 mt-1 uppercase tracking-wide">
                    {{ $product['author'] ?? 'Unknown Author' }}
                    </p>
        </div>

        <div class="flex items-center space-x-4">
           <form action="{{ route('cart.remove', $productId) }}" method="POST" onsubmit="return confirm('Remove this item?')">
                  @csrf
            @method('DELETE')
            <button type="submit" class="text-gray-600 hover:text-red-600">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </form>

           <form action="{{ route('cart.remove', $productId) }}" method="POST" onsubmit="return confirm('Remove this item?')">
                  @csrf
            <button type="submit" class="flex items-center bg-indigo-600 text-white font-medium py-2 px-6 rounded hover:bg-indigo-700 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 3v18m0-18l18 18"/>
              </svg>
              Add to Cart
            </button>
          </form>
        </div>
      </div>
      @endforeach
    </div>
  @else
    <p class="mt-6 text-center text-lg text-gray-600">Your wishlist is empty.</p>
  @endif
</div>
@endsection
