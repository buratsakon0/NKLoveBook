@extends('layouts.app')

@section('content')

  <!-- 🟣 Banner Section -->
  <section style="background: linear-gradient(to right, #ffe6f0 0%, #e8f3ff 50%, #ffffff 100%); padding-top:8rem; padding-bottom:8rem;">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center gap-8 px-6">
      <div class="md:w-1/2">
        <h2 class="font-bold text-indigo-900 mb-6" style="font-size:3rem;">น้ำข้าวรักหนังสือ</h2>
        <p class="text-gray-700 mb-8" style="font-size:1.1rem; line-height:1.8;">
          “ที่นี่...เราคัดสรรหนังสือดี ๆ เพื่อให้ทุกคนได้เจอเรื่องราวที่ใช่<br>
          ในวันที่ต้องการแรงบันดาลใจ”
        </p>

        <a href="#" class="border border-indigo-600 text-indigo-600 px-6 py-2 rounded hover:bg-indigo-50">
          Read More →
        </a>
      </div>
      <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:10px; justify-items:center;">
        <img src="{{ asset('images/book1.jpg') }}" style="width:180px; height:260px; object-fit:cover; border-radius:10px; box-shadow:0 4px 8px rgba(0,0,0,0.2);">
        <img src="{{ asset('images/book2.jpg') }}" style="width:180px; height:260px; object-fit:cover; border-radius:10px; box-shadow:0 4px 8px rgba(0,0,0,0.2);">
        <img src="{{ asset('images/book3.jpg') }}" style="width:180px; height:260px; object-fit:cover; border-radius:10px; box-shadow:0 4px 8px rgba(0,0,0,0.2);">
      </div>
    </div>
  </section>

  <!-- 🟠 Categories Section -->
  <section class="py-20 text-center bg-white">
    <div class="max-w-6xl mx-auto px-6">
      {{-- หัวข้อ --}}
      <h3 class="text-orange-500 uppercase mb-2">Categories</h3>
      <h2 class="text-2xl font-bold mb-3">Explore our Top Categories</h2>
      <p class="text-gray-500 mb-10">
        สำรวจหมวดหมู่ยอดนิยมจาก “น้ำข้าวรักหนังสือ” ที่เราคัดสรรมาอย่างตั้งใจ
      </p>

      {{-- หมวดหมู่ --}}
      <div id="category-grid" class="grid md:grid-cols-3 gap-8 transition-all duration-500 ease-in-out max-h-[1500px]">
        {{-- 🟣 หมวด 1 --}}
        <div class="shadow-md rounded-lg overflow-hidden">
          <img src="{{ asset('images/science.jpg') }}" class="w-full h-48 object-cover">
          <div class="p-5">
            <h4 class="font-bold text-indigo-900">Science & Technology</h4>
            <p class="text-gray-500 text-sm">เปิดโลกแห่งความรู้ด้านวิทยาศาสตร์และเทคโนโลยี</p>
          </div>
        </div>

        {{-- 🟣 หมวด 2 --}}
        <div class="shadow-md rounded-lg overflow-hidden">
          <img src="{{ asset('images/art.jpg') }}" class="w-full h-48 object-cover">
          <div class="p-5">
            <h4 class="font-bold text-indigo-900">Art & Design</h4>
            <p class="text-gray-500 text-sm">ดื่มด่ำกับงานออกแบบและแรงบันดาลใจ</p>
          </div>
        </div>

        {{-- 🟣 หมวด 3 --}}
        <div class="shadow-md rounded-lg overflow-hidden">
          <img src="{{ asset('images/manga.jpg') }}" class="w-full h-48 object-cover">
          <div class="p-5">
            <h4 class="font-bold text-indigo-900">Comics / Manga</h4>
            <p class="text-gray-500 text-sm">สนุกกับเรื่องราวจากการ์ตูนที่คุณชื่นชอบ</p>
          </div>
        </div>

        {{-- 🔸 หมวดเพิ่มเติม (เริ่มซ่อน) --}}
        <div class="hidden extra-category shadow-md rounded-lg overflow-hidden">
          <img src="{{ asset('images/novel.jpg') }}" class="w-full h-48 object-cover">
          <div class="p-5">
            <h4 class="font-bold text-indigo-900">Fiction & Novel</h4>
            <p class="text-gray-500 text-sm">เรื่องราวเหนือจินตนาการที่จะพาคุณเข้าสู่โลกแห่งความคิดสร้างสรรค์</p>
          </div>
        </div>

        <div class="hidden extra-category shadow-md rounded-lg overflow-hidden">
          <img src="{{ asset('images/history.jpg') }}" class="w-full h-48 object-cover">
          <div class="p-5">
            <h4 class="font-bold text-indigo-900">History</h4>
            <p class="text-gray-500 text-sm">เรียนรู้จากเหตุการณ์ในอดีต เพื่อเข้าใจปัจจุบันและอนาคต</p>
          </div>
        </div>

        <div class="hidden extra-category shadow-md rounded-lg overflow-hidden">
          <img src="{{ asset('images/psychology.jpg') }}" class="w-full h-48 object-cover">
          <div class="p-5">
            <h4 class="font-bold text-indigo-900">Psychology</h4>
            <p class="text-gray-500 text-sm">เข้าใจจิตใจมนุษย์ผ่านศาสตร์แห่งความคิดและอารมณ์</p>
          </div>
        </div>

        <div class="hidden extra-category shadow-md rounded-lg overflow-hidden">
          <img src="{{ asset('images/business.jpg') }}" class="w-full h-48 object-cover">
          <div class="p-5">
            <h4 class="font-bold text-indigo-900">Business & Management</h4>
            <p class="text-gray-500 text-sm">พัฒนาทักษะการบริหารและกลยุทธ์ทางธุรกิจอย่างมืออาชีพ</p>
          </div>
        </div>

        <div class="hidden extra-category shadow-md rounded-lg overflow-hidden">
          <img src="{{ asset('images/travel.jpg') }}" class="w-full h-48 object-cover">
          <div class="p-5">
            <h4 class="font-bold text-indigo-900">Travel & Adventure</h4>
            <p class="text-gray-500 text-sm">เปิดประสบการณ์ใหม่ไปกับเรื่องราวการเดินทางทั่วโลก</p>
          </div>
        </div>
      </div>

      {{-- ปุ่ม View More --}}
      <div class="mt-16">
        <button id="viewMoreBtn" 
          class="border border-indigo-600 text-indigo-600 px-6 py-2 rounded hover:bg-indigo-50 transition">
          View More ↓
        </button>
      </div>
    </div>
  </section>

  {{-- 🧠 Script --}}
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const btn = document.getElementById("viewMoreBtn");
      const hiddenItems = document.querySelectorAll(".extra-category");
      let expanded = false;

      btn.addEventListener("click", () => {
        hiddenItems.forEach((item, i) => {
          setTimeout(() => {
            item.classList.toggle("hidden");
            item.classList.toggle("fade-in");
          }, i * 100); // หน่วงเวลานิดหน่อยให้มันโผล่ทีละกล่อง
        });
        expanded = !expanded;
        btn.textContent = expanded ? "View Less ↑" : "View More ↓";
      });
    });
  </script>

  {{-- 💅 CSS เสริมสำหรับ fade-in --}}
  <style>
    .fade-in {
      animation: fadeIn 0.6s ease forwards;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>

  <!-- 🟡 Best Seller Section -->
  <section style="background: linear-gradient(to right, #ffe6f0 0%, #e8f3ff 50%, #ffffff 100%); padding-top:8rem; padding-bottom:8rem;">
    <div class="text-center mb-10">
      <p class="text-gray-400 uppercase text-sm tracking-widest">Some Quality Items</p>
      <h2 class="text-3xl font-bold text-indigo-900">Best Seller</h2>
    </div>

    <div class="flex flex-wrap justify-center gap-10 px-4 md:px-10">
      @if(isset($books) && count($books) > 0)
        @foreach ($books as $book)
          @php
            $coverImage = $book->cover_image
              ? (filter_var($book->cover_image, FILTER_VALIDATE_URL)
                  ? $book->cover_image
                  : asset('images/' . ltrim($book->cover_image, '/')))
              : asset('images/manga.jpg');
            $authorName = optional($book->author)->AuthorName ?? 'Unknown Author';
          @endphp
          <a href="{{ route('book.show', $book->BookID) }}" class="bg-white shadow-md rounded-lg overflow-hidden w-60 hover:shadow-lg transition-shadow">
            <img src="{{ $coverImage }}" alt="{{ $book->BookName }} cover" class="w-full h-64 object-cover">
            <div class="p-4 text-center">
              <h4 class="font-semibold text-indigo-900">{{ $book->BookName }}</h4>
              <p class="text-gray-500 text-sm">{{ $book->author->AuthorName ?? 'ไม่ระบุผู้แต่ง' }}</p>
              <p class="text-orange-600 font-semibold mt-1">฿ {{ number_format($book->Price, 2) }}</p>
              <p class="text-xs text-gray-400 mt-2">ISBN: {{ $book->ISBN }}</p>
              {{-- <p class="text-xs text-gray-400">Pages: {{ $book->Pages }}</p> --}}
            </div>
          </a>
        @endforeach
      @else
        <p class="text-gray-500 italic">No books available right now.</p>
      @endif
    </div>
  </section>

@endsection
