@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
  <div class="flex items-center justify-center gap-4 text-indigo-900 mb-10">
    <svg fill="#393280"  class="sw-10 h-10" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <path  d="M25 39.7l-.6-.5C11.5 28.7 8 25 8 19c0-5 4-9 9-9 4.1 0 6.4 2.3 8 4.1 1.6-1.8 3.9-4.1 8-4.1 5 0 9 4 9 9 0 6-3.5 9.7-16.4 20.2l-.6.5zM17 12c-3.9 0-7 3.1-7 7 0 5.1 3.2 8.5 15 18.1 11.8-9.6 15-13 15-18.1 0-3.9-3.1-7-7-7-3.5 0-5.4 2.1-6.9 3.8L25 17.1l-1.1-1.3C22.4 14.1 20.5 12 17 12z" />
    </svg>
    <h1 class="text-3xl font-bold uppercase tracking-wide">My Wishlist</h1>
  </div>

  @if (session('success'))
    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">
      {{ session('success') }}
    </div>
  @elseif (session('info'))
    <div class="mb-6 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-blue-800">
      {{ session('info') }}
    </div>
  @elseif (session('error'))
    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800">
      {{ session('error') }}
    </div>
  @endif

  @if ($wishlistItems->isEmpty())
    <p class="mt-10 text-center text-lg text-gray-500">ยังไม่มีสินค้าใน Wishlist ของคุณ</p>
  @else
    <div class="flex flex-col gap-6">
      @foreach ($wishlistItems as $item)
        @php($book = $item->book)
        <div class="flex flex-col  gap-6 rounded-[16px] border-2 border-[#393280] bg-white px-6 py-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md sm:flex-row sm:items-center sm:justify-between">
          <div class="flex w-full flex-1 items-center gap-6">
            <form action="{{ route('wishlist.remove', $book->BookID) }}" method="POST" class="flex-shrink-0">
              @csrf
              @method('DELETE')
              <button type="submit" class="flex h-12 w-12 items-center justify-center rounded-full border border-indigo-200 text-indigo-800 transition hover:bg-red-50 hover:text-red-600" aria-label="Remove from wishlist">
                <i class="fa-regular fa-trash-can text-2xl"></i>
              </button>
            </form>

            <img src="{{ $item->resolved_cover }}" alt="{{ $book->BookName }}" class="h-36 w-28 rounded-xl border border-indigo-100 object-cover shadow-sm" loading="lazy">

            <div class="space-y-2">
              <h2 class="text-xl font-semibold uppercase text-indigo-900">{{ $book->BookName }}</h2>
              <p class="text-sm font-medium uppercase tracking-wide text-gray-500">{{ $item->author_name }}</p>
              <p class="text-2xl font-semibold text-black">฿ {{ number_format($book->Price, 2) }}</p>
            </div>
          </div>

          <form action="{{ route('cart.add', $book->BookID) }}" method="POST" class="self-end sm:self-auto">
            @csrf
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="inline-flex items-center gap-3 bg-[#393280] px-6 py-3 font-semibold uppercase tracking-wide text-white shadow transition hover:bg-indigo-900">
              <i class="fa-solid fa-cart-shopping text-lg"></i>
              Add to Cart
            </button>
          </form>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
