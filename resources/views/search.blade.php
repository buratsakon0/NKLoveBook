@extends('layouts.app')

@section('content')

<section class="py-16 bg-gradient-to-r from-pink-20 to-white">
  <div class="text-center mb-10">
    <h2 class="text-3xl font-bold text-indigo-900">
      Search Results
    </h2>
    @if($query)
      <p class="text-gray-500 mt-2">
        คุณค้นหา: "<strong>{{ $query }}</strong>"
      </p>
    @endif
    <p class="text-gray-400 text-sm mt-2">
      พบผลลัพธ์ {{ $totalResults }} รายการ
    </p>
  </div>

  @if($books->count() > 0)
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10 justify-items-start">
      @foreach ($books as $book)
        @php
          $coverImage = $book->cover_image
            ? (filter_var($book->cover_image, FILTER_VALIDATE_URL)
                ? $book->cover_image
                : asset('images/' . ltrim($book->cover_image, '/')))
            : asset('images/manga.jpg');
        @endphp
        <div class="bg-white shadow-lg rounded-xl overflow-hidden w-72 h-[480px] flex flex-col justify-between hover:shadow-2xl transition duration-200">

          <!-- รูปหนังสือ -->
          <div class="bg-transparent p-15 flex justify-center items-center h-80 overflow-hidden">
            <a href="{{ route('book.show', $book->BookID) }}">
              <img src="{{ $coverImage }}" 
                  alt="{{ $book->BookName }}"
                  class="w-full h-full object-contain rounded-md shadow-lg transition-transform duration-300 hover:scale-105">
            </a>
          </div>

          <!-- ข้อมูลหนังสือ -->
          <div class="px-5 pb-5 text-center">
            <h4 class="font-semibold text-indigo-900 text-l uppercase tracking-wide leading-snug mb-1">
              {{ $book->BookName }}
            </h4>

            <p class="text-gray-500 text-xs mb-2">
              {{ $book->author ? $book->author->AuthorName : 'ไม่ระบุผู้แต่ง' }}
            </p>

            @if($book->category)
              <p class="text-indigo-500 text-xs mb-2">
                {{ $book->category->CategoryName }}
              </p>
            @endif

            <p class="text-orange-600 font-semibold text-xl mb-3">
              ฿ {{ number_format($book->Price, 2) }}
            </p>

            <!-- ปุ่ม -->
            <div class="flex justify-center gap-3">
              <!-- ปุ่ม Add to Cart -->
              <form action="{{ route('cart.add', $book->BookID) }}" method="POST">
                @csrf
                <button
                  class="flex items-center justify-center gap-2 bg-[#ED553B] text-white text-xs px-4 py-2 rounded shadow hover:bg-[#e94c2f] transition w-32">
                  <i class="fa fa-shopping-cart text-[0.8rem]"></i>
                  ADD TO CART
                </button>
              </form>

              <!-- ปุ่ม BUY (ไปที่หน้า Cart) -->
              <form action="{{ route('cart.add', $book->BookID) }}" method="POST">
                @csrf
                <button
                  class="flex items-center justify-center border border-[#ED553B] text-[#ED553B] text-xs px-4 py-2 rounded hover:bg-[#ED553B] hover:text-white transition w-20">
                  <i class="fa fa-credit-card text-[0.8rem] mr-1"></i>
                  BUY
                </button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <div class="max-w-2xl mx-auto text-center py-16">
      <div class="mb-6">
        <i class="fas fa-search text-6xl text-gray-300"></i>
      </div>
      <h3 class="text-2xl font-bold text-gray-700 mb-4">ไม่พบผลลัพธ์</h3>
      <p class="text-gray-500 mb-6">
        ไม่พบหนังสือที่ตรงกับการค้นหา "<strong>{{ $query }}</strong>"
      </p>
      <div class="flex gap-4 justify-center">
        <a href="{{ route('home') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
          กลับหน้าหลัก
        </a>
        <button onclick="document.querySelector('input[name=query]').focus()" class="border border-indigo-600 text-indigo-600 px-6 py-2 rounded-lg hover:bg-indigo-50 transition">
          ค้นหาใหม่
        </button>
      </div>
      <div class="mt-8">
        <p class="text-sm text-gray-400 mb-4">คำแนะนำ:</p>
        <ul class="text-left inline-block text-gray-500 text-sm space-y-2">
          <li>• ตรวจสอบการสะกดคำของคุณ</li>
          <li>• ลองคำอื่นที่คล้ายกัน</li>
          <li>• ลองค้นหาโดยชื่อผู้แต่งหรือชื่อหนังสือ</li>
          <li>• ลองใช้คำหลักสั้น ๆ</li>
        </ul>
      </div>
    </div>
  @endif
</section>

@endsection

