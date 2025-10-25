@extends('layouts.app')

@section('content')
  @include('component.navbar')

  <!-- Banner -->
  <section class="bg-gradient-to-r from-indigo-50 to-white py-16">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center gap-10 px-5">
      <div class="md:w-1/2">
        <h2 class="text-3xl font-bold text-indigo-900 mb-4">น้ำข้าวรักหนังสือ</h2>
        <p class="text-gray-600 mb-6">
          “ที่นี่...เราคัดสรรหนังสือดี ๆ เพื่อให้ทุกคนได้เจอเรื่องราวที่ใช่
          ในวันที่ต้องการแรงบันดาลใจ”
        </p>
        <a href="#" class="border border-indigo-600 text-indigo-600 px-5 py-2 rounded hover:bg-indigo-50">Read More →</a>
      </div>
      <div class="grid grid-cols-3 gap-4 md:w-1/2">
        <img src="{{ asset('images/book1.jpg') }}" class="w-32 shadow-lg rounded">
        <img src="{{ asset('images/book2.jpg') }}" class="w-32 shadow-lg rounded">
        <img src="{{ asset('images/book3.jpg') }}" class="w-32 shadow-lg rounded">
      </div>
    </div>
  </section>

  <!-- Categories -->
  <section class="py-20 text-center">
    <h3 class="text-orange-500 uppercase mb-2">Categories</h3>
    <h2 class="text-2xl font-bold mb-3">Explore our Top Categories</h2>
    <p class="text-gray-500 mb-10">
      สำรวจหมวดหมู่ยอดนิยมจาก “น้ำข้าวรักหนังสือ” ที่เราคัดสรรมาอย่างตั้งใจ
    </p>

    <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto px-5">
      <div class="shadow-md rounded-lg overflow-hidden">
        <img src="{{ asset('images/science.jpg') }}" class="w-full h-48 object-cover">
        <div class="p-5">
          <h4 class="font-bold text-indigo-900">Science & Technology</h4>
          <p class="text-gray-500 text-sm">เปิดโลกแห่งความรู้ด้านวิทยาศาสตร์และเทคโนโลยี</p>
        </div>
      </div>
      <div class="shadow-md rounded-lg overflow-hidden">
        <img src="{{ asset('images/art.jpg') }}" class="w-full h-48 object-cover">
        <div class="p-5">
          <h4 class="font-bold text-indigo-900">Art & Design</h4>
          <p class="text-gray-500 text-sm">ดื่มด่ำกับงานออกแบบและแรงบันดาลใจ</p>
        </div>
      </div>
      <div class="shadow-md rounded-lg overflow-hidden">
        <img src="{{ asset('images/manga.jpg') }}" class="w-full h-48 object-cover">
        <div class="p-5">
          <h4 class="font-bold text-indigo-900">Comics / Manga</h4>
          <p class="text-gray-500 text-sm">สนุกกับเรื่องราวจากการ์ตูนที่คุณชื่นชอบ</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Best Seller -->
  <section class="bg-gradient-to-r from-white to-orange-50 py-16">
    <div class="text-center mb-10">
      <p class="text-gray-400 uppercase text-sm tracking-widest">Some Quality Items</p>
      <h2 class="text-3xl font-bold text-indigo-900">Best Seller</h2>
    </div>
    <div class="flex flex-wrap justify-center gap-10">
      @foreach (['bookA.jpg'=>'เขมจิราต้องรอด','bookB.jpg'=>'ดอกรักผลิบานที่กลางใจ','bookC.jpg'=>'จดหมายจากดาวแมว','bookD.jpg'=>'แนวข้อสอบ TGAT'] as $img=>$title)
        <div class="bg-white shadow-md rounded-lg overflow-hidden w-52">
          <img src="{{ asset('images/'.$img) }}" class="w-full h-64 object-cover">
          <div class="p-3 text-center">
            <h4 class="font-semibold text-indigo-900">{{ $title }}</h4>
            <p class="text-orange-600 font-semibold">฿ {{ rand(150,500) }}.00</p>
          </div>
        </div>
      @endforeach
    </div>
    <div class="text-center mt-8">
      <a href="#" class="text-orange-600 font-semibold hover:underline">View All Products →</a>
    </div>
  </section>
@endsection
