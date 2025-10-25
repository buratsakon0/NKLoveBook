@extends('layouts.app')

@section('content')
  <section class="bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-3xl p-10">
      <div class="grid lg:grid-cols-[340px,1fr] gap-12">
        <div class="bg-gray-100 rounded-2xl p-6 flex items-center justify-center shadow-inner">
          <img src="{{ asset('images/manga.jpg') }}" alt="Frieren Volume 10 Cover"
            class="w-full max-w-xs rounded-lg shadow-lg">
        </div>

        <div class="flex flex-col gap-6">
          <div>
            <h1 class="text-3xl font-bold text-indigo-900 leading-tight">คำอธิษฐานในวันที่จากลา FRIEREN เล่ม 10</h1>

            <div class="mt-4 text-sm text-gray-600 space-y-1">
              <p><span class="font-semibold text-gray-900">ผู้เขียน:</span> KANEHITO YAMA / TSUKASA ABE</p>
              <p><span class="font-semibold text-gray-900">สำนักพิมพ์:</span> สยามอินเตอร์คอมิกส์ / Siam Inter Comics</p>
              <p><span class="font-semibold text-gray-900">หมวดหมู่:</span> Comics / Manga</p>
            </div>
          </div>

          <p class="text-4xl font-bold text-orange-500">฿ 99.00</p>

          <div class="flex flex-wrap items-center gap-5">
            <div class="flex items-center border border-gray-200 rounded-full overflow-hidden bg-white shadow-sm">
              <button class="px-4 py-2 text-lg text-indigo-600 hover:bg-indigo-50">-</button>
              <span class="px-6 py-2 text-lg font-semibold border-x border-gray-200">1</span>
              <button class="px-4 py-2 text-lg text-indigo-600 hover:bg-indigo-50">+</button>
            </div>

            <button class="flex items-center gap-2 bg-orange-500 text-white px-6 py-3 rounded-full text-sm font-semibold tracking-wide shadow hover:bg-orange-600 transition">
              <i class="fa fa-shopping-cart"></i>
              ADD TO CART
            </button>

            <button class="flex items-center gap-2 border border-orange-500 text-orange-500 px-6 py-3 rounded-full text-sm font-semibold tracking-wide hover:bg-orange-50 transition">
              <i class="fa fa-bolt"></i>
              BUY
            </button>
          </div>
        </div>
      </div>

      <div class="mt-12 grid lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 space-y-5">
          <h2 class="text-lg font-bold text-gray-900 uppercase tracking-wide">Details:</h2>
          <p class="text-sm leading-7 text-gray-600 whitespace-pre-line">
เมฟฟรีเเอนร่วมเดินทางไปกับของขบวนฮีโร่
เดินทางไปยังโฮร์ดอยล์ อันแดนต์รู้วัญญาณหลังไหล
ในอดีตพี่เลี้ยงได้ให้ "น้ำตาของฮีโร่"
ปรธำให้กับนักรบมนุสลายท้องเรือ เบทท์
ถึงได้มีความสัมพันธ์อันดงประหลาดกับเผ่าพันธุ์มนุษย์
ด้านหนึ่งสีบทีสีบสันอนมหลากหลายเส้นไปกับฮอกง่า
เรื่องราวแฟนตาซีที่ยกระดับหลังศึกสะท้อน "เขตินร้าย" ต่อเหล่าผู้กล้า
          </p>
        </div>

        <div class="bg-indigo-50 rounded-2xl border border-indigo-100 p-6 shadow-sm">
          <p class="text-sm uppercase font-semibold text-indigo-700 tracking-wide">Shipping</p>
          <p class="mt-3 text-sm text-gray-600 leading-6">
            จัดส่งทั่วประเทศ ระยะเวลาการจัดส่งโดยประมาณ 2-5 วันทำการ
            พร้อมบริการห่อของขวัญฟรีสำหรับทุกคำสั่งซื้อ
            แจ้งเลขพัสดุทางอีเมลหรือไลน์ออฟฟิเชียลของร้าน.
          </p>
        </div>
      </div>

      <div class="mt-12">
        <h2 class="text-lg font-bold text-gray-900 uppercase tracking-wide">Reviews:</h2>

        <div class="mt-6 grid md:grid-cols-2 gap-6">
          <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow-sm">
            <div class="flex items-center gap-4">
              <div class="text-4xl font-bold text-indigo-900 leading-none">4.0</div>
              <div class="flex flex-col gap-1">
                <div class="text-orange-500">
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-regular fa-star"></i>
                </div>
                <span class="text-xs text-gray-500 uppercase tracking-widest">Average Rating</span>
              </div>
            </div>

            <div class="mt-6 space-y-3 text-sm text-gray-600">
              @foreach ([5 => 86, 4 => 90, 3 => 0, 2 => 0, 1 => 0] as $stars => $percent)
                <div class="flex items-center gap-3">
                  <div class="w-6 text-right font-semibold text-gray-500">{{ $stars }}</div>
                  <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-orange-500" style="width: {{ $percent }}%;"></div>
                  </div>
                  <div class="w-12 text-right text-gray-500">{{ $percent }}%</div>
                </div>
              @endforeach
            </div>
          </div>

          <div class="bg-gray-100 border border-gray-200 rounded-3xl flex items-center justify-center text-gray-400 text-lg font-medium">
            Not Yet Reviewed
          </div>
        </div>
      </div>

      <div class="mt-16 text-center text-sm text-gray-300">น้ำข้าวรักหนังสือ</div>
    </div>
  </section>
@endsection
