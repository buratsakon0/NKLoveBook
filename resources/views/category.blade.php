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

 <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10 justify-items-start">
    @foreach ($books as $book)
      <div class="bg-white shadow-lg rounded-xl overflow-hidden w-72 h-[480px] flex flex-col justify-between hover:shadow-2xl transition duration-200">

        <!--  รูปหนังสือ -->
        <div class="bg-transparent p-15 flex justify-center items-center h-80 overflow-hidden">
        <a href="{{ route('book.show', $book->BookID) }}">
            <img src="{{ asset('images/'.$book->cover_image) }}" 
                alt="{{ $book->BookName }}"
                class="w-full h-full object-contain rounded-md shadow-lg transition-transform duration-300 hover:scale-105">
        </a>
        </div>

        <!--  ข้อมูลหนังสือ -->
        <div class="px-5 pb-5 text-center">
          <h4 class="font-semibold text-indigo-900 text-l uppercase tracking-wide leading-snug mb-1">
            {{ $book->BookName }}
          </h4>

          <p class="text-gray-500 text-xs mb-2">
            {{ $book->author ? $book->author->AuthorName : 'ไม่ระบุผู้แต่ง' }}
          </p>

          <p class="text-orange-600 font-semibold text-xl mb-3">
            ฿ {{ number_format($book->Price, 2) }}
          </p>

          <!--  ปุ่ม -->
          <div class="flex justify-center gap-3">
            <button
              class="flex items-center justify-center gap-2 bg-[#ED553B] text-white text-xs px-4 py-2 rounded shadow hover:bg-[#e94c2f] transition w-32">
              <i class="fa fa-shopping-cart text-[0.8rem]"></i>
              ADD TO CART
            </button>
            <button
              class="flex items-center justify-center border border-[#ED553B] text-[#ED553B] text-xs px-4 py-2 rounded hover:bg-[#ED553B] hover:text-white transition w-20">
              <i class="fa fa-credit-card text-[0.8rem] mr-1"></i>
              BUY
            </button>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  @if ($books->isEmpty())
    <p class="text-center text-gray-500 mt-10">ยังไม่มีหนังสือในหมวดนี้</p>
  @endif
</section>
@endsection