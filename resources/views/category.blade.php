@extends('layouts.app')

@section('content')

<section class="py-16 bg-gradient-to-r from-orange-50 to-white">
  <div class="text-center mb-10">
    <h2 class="text-3xl font-bold text-indigo-900">
      {{ $category->CategoryName }}
    </h2>
    <p class="text-gray-500 mt-2">
      สำรวจหนังสือในหมวด "{{ $category->CategoryName }}"
    </p>
  </div>

  <div class="flex flex-wrap justify-center gap-10">
    @foreach ($books as $book)
      <div class="bg-white shadow-md rounded-lg overflow-hidden w-60 hover:shadow-xl transition">
        <img src="{{ asset('images/'.$book->cover_image) }}" 
             class="w-full h-64 object-cover" 
             alt="{{ $book->BookName }}">
        <div class="p-4 text-center">
          <h4 class="font-semibold text-indigo-900">{{ $book->BookName }}</h4>
          <p class="text-gray-500 text-sm">{{ $book->ISBN }}</p>
          <p class="text-orange-600 font-semibold mt-1">฿ {{ number_format($book->Price, 2) }}</p>
          <button class="mt-3 bg-orange-500 text-white px-4 py-1 rounded hover:bg-orange-600">Add to Cart</button>
        </div>
      </div>
    @endforeach
  </div>

  @if ($books->isEmpty())
    <p class="text-center text-gray-500 mt-10">ยังไม่มีหนังสือในหมวดนี้</p>
  @endif
</section>
@endsection
