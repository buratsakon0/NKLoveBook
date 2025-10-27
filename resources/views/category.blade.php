@extends('layouts.app')

@section('content')

<!-- 🟣 Banner Section -->
  <section style="background: linear-gradient(to right, #ffe6f0 0%, #ffffff 100%); padding-top:2rem; padding-bottom:2rem;">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center gap-8 px-20">
      <div class="md:w-1/2">
        <h2 class="font-bold text-indigo-900 mb-6" style="font-size:3rem;">{{ $category->CategoryName }}</h2>
          <!-- ใช้ if เพื่อแสดงข้อความตามหมวดหมู่ -->
          <p class="text-gray-700 mb-8" style="font-size:1.1rem; line-height:1.8;">
            @if($category->CategoryName == 'Science & Technology')
              “เปิดโลกแห่งความรู้ด้านวิทยาศาสตร์และเทคโนโลยี เรียนรู้สิ่งใหม่ ๆ ที่เปลี่ยนแปลงโลกและพัฒนาแนวคิดของคุณให้ก้าวไกล”
            @elseif($category->CategoryName == 'Art & Design')
              “ดื่มด่ำกับแรงบันดาลใจจากศิลปะและการออกแบบ ไม่ว่าจะเป็นงานภาพ สี หรือแนวคิดสร้างสรรค์ ที่จะเติมเต็มจินตนาการของคุณ”
            @elseif($category->CategoryName == 'Comics / Manga')
              “ผ่อนคลายไปกับเรื่องราวสนุก ๆ จากโลกการ์ตูนและมังงะ ทั้งแนวอบอุ่นหัวใจ แอ็กชันเข้มข้น และเรื่องราวสุดแฟนตาซีที่คุณหลงรัก”
            @elseif($category->CategoryName == 'Education & Learning')
              “เปิดประตูสู่โลกแห่งความรู้ ที่จะช่วยพัฒนาทักษะและมุมมองของคุณให้ก้าวไกล ไม่ว่าจะเป็นความรู้ด้านวิชาการ ภาษา หรือทักษะชีวิตในยุคใหม่”
            @elseif($category->CategoryName == 'Fiction')
              “ดำดิ่งสู่โลกแห่งจินตนาการ ผ่านเรื่องราวที่สะท้อนอารมณ์ ความรัก และแรงบันดาลใจ ที่จะทำให้คุณไม่อยากวางหนังสือลงเลย”
            @elseif($category->CategoryName == 'Health & Lifestyle')
              “ดูแลทั้งกายและใจให้สมดุล ด้วยหนังสือที่เต็มไปด้วยแรงบันดาลใจ เคล็ดลับสุขภาพดี และแนวคิดการใช้ชีวิตอย่างมีความสุข”
            @elseif($category->CategoryName == 'Children\'s Book')
              “ปลุกจินตนาการและการเรียนรู้ของเด็ก ๆ ผ่านเรื่องราวสนุก สีสันสดใส ที่ช่วยเสริมทักษะและปลูกฝังนิสัยรักการอ่านตั้งแต่เยาว์วัย”
            @elseif($category->CategoryName == 'Travel')
              “ออกเดินทางไปค้นหาแรงบันดาลใจใหม่ ๆ ผ่านหนังสือท่องเที่ยวทั่วทุกมุมโลก ทั้งเรื่องราวการผจญภัย วัฒนธรรม และความงดงามของสถานที่ต่าง ๆ”
            @else
              “ที่นี่...เราคัดสรรหนังสือดี ๆ เพื่อให้ทุกคนได้เจอเรื่องราวที่ใช่ ในวันที่ต้องการแรงบันดาลใจ”
            @endif
          </p>
        </div>
      <!-- เปลี่ยนแสดงรูปภาพตามหมวดหมู่ -->
      <div>
        @if($category->CategoryName == 'Science & Technology')
          <img src="{{ asset('images/science_banner.png') }}" style="width:500px; height:320px; object-fit:cover; margin-left: 45px;">
        @elseif($category->CategoryName == 'Art & Design')
          <img src="{{ asset('images/art_banner.png') }}" style="width:500px; height:320px; object-fit:cover; margin-left: 45px;">
        @elseif($category->CategoryName == 'Comics / Manga')
          <img src="{{ asset('images/comics_banner.png') }}" style="width:500px; height:320px; object-fit:cover; margin-left: 45px;">
        @elseif($category->CategoryName == 'Education & Learning')
          <img src="{{ asset('images/education_banner.png') }}" style="width:500px; height:320px; object-fit:cover; margin-left: 45px;">
        @elseif($category->CategoryName == 'Fiction')
          <img src="{{ asset('images/fiction_banner.png') }}" style="width:500px; height:320px; object-fit:cover; margin-left: 45px;">
        @elseif($category->CategoryName == 'Health & Lifestyle')
          <img src="{{ asset('images/health_banner.png') }}" style="width:500px; height:320px; object-fit:cover; margin-left: 45px;">
        @elseif($category->CategoryName == 'Children\'s Book')
          <img src="{{ asset('images/children_banner.png') }}" style="width:500px; height:320px; object-fit:cover; margin-left: 45px;">
        @elseif($category->CategoryName == 'Travel')
          <img src="{{ asset('images/travel_banner.png') }}" style="width:500px; height:320px; object-fit:cover; margin-left: 45px;">
        @else
          <img src="{{ asset('images/default_banner.png') }}" style="width:500px; height:320px; object-fit:cover; margin-left: 45px;">
        @endif
      </div>
    </div>
  </section>

<section class="py-16 bg-gradient-to-r from-pink-20 to-white">
 <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10 justify-items-start">
    @foreach ($books as $book)
      <div class="bg-white shadow-lg rounded-xl overflow-hidden w-72 h-[480px] flex flex-col justify-between hover:shadow-2xl transition duration-200">

        <!-- รูปหนังสือ -->
        <div class="bg-transparent p-15 flex justify-center items-center h-80 overflow-hidden">
        <a href="{{ route('book.show', $book->BookID) }}">
            <img src="{{ asset('images/'.$book->cover_image) }}" 
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

          <p class="text-orange-600 font-semibold text-xl mb-3">
            ฿ {{ number_format($book->Price, 2) }}
          </p>

        <div class="flex justify-center gap-3">
          @auth
            <!-- ✅ ถ้าล็อกอินแล้ว -->
            <button onclick="addToCart({{ $book->BookID }})"
              class="flex items-center justify-center gap-2 bg-[#ED553B] text-white text-xs px-4 py-2 rounded shadow hover:bg-[#e94c2f] transition w-32">
              <i class="fa fa-shopping-cart text-[0.8rem]"></i>
              ADD TO CART
            </button>

            <button onclick="buyBook({{ $book->BookID }})"
              class="flex items-center justify-center border border-[#ED553B] text-[#ED553B] text-xs px-4 py-2 rounded hover:bg-[#ED553B] hover:text-white transition w-20">
              <i class="fa fa-credit-card text-[0.8rem] mr-1"></i>
              BUY
            </button>
          @else
            <!-- 🚫 ถ้ายังไม่ได้ login -->
            <button onclick="window.location.href='/login'"
              class="flex items-center justify-center gap-2 bg-[#ED553B] text-white text-xs px-4 py-2 rounded shadow hover:bg-[#e94c2f] transition w-32">
              <i class="fa fa-shopping-cart text-[0.8rem]"></i>
              ADD TO CART
            </button>

            <button onclick="window.location.href='/login'"
              class="flex items-center justify-center border border-[#ED553B] text-[#ED553B] text-xs px-4 py-2 rounded hover:bg-[#ED553B] hover:text-white transition w-20">
              <i class="fa fa-credit-card text-[0.8rem] mr-1"></i>
              BUY
            </button>
          @endauth
      </div>

        </div>
      </div>
    @endforeach
  </div>

    <!-- ปุ่ม Pagination แบบวงกลม -->
  <div class="flex justify-center mt-10">
    {{ $books->links('pagination::simple-tailwind') }}
  </div>

  @if ($books->isEmpty())
    <p class="text-center text-gray-500 mt-10">ยังไม่มีหนังสือในหมวดนี้</p>
  @endif
</section>

<script>
  // เพิ่มจำนวนสินค้า
  function updateCartQuantity(bookId, quantity) {
    fetch('/update-cart', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
      },
      body: JSON.stringify({
        book_id: bookId,
        quantity: quantity
      })
    })
    .then(response => response.json())
    .then(data => {
      // อัปเดตจำนวนในไอคอน Cart
      document.getElementById('cartCount').textContent = data.cartCount;
    });
  }

  // ฟังก์ชันเมื่อคลิก "Add to Cart"
  function addToCart(bookId) {
    let quantity = 1; // ค่า default
    updateCartQuantity(bookId, quantity);
  }

  // ฟังก์ชันเมื่อคลิก "Buy"
  function buyBook(bookId) {
    let quantity = 1; // ค่า default
    updateCartQuantity(bookId, quantity);
    window.location.href = "/cart"; // ไปหน้า Cart
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // ฟังก์ชันเมื่อคลิก "Add to Cart"
  function addToCart(bookId) {
    let quantity = 1; // ค่า default
    // เรียกใช้งานฟังก์ชันอัปเดตจำนวนสินค้าในตะกร้า
    updateCartQuantity(bookId, quantity);

    // แสดง SweetAlert2 แจ้งเตือนเมื่อเพิ่มหนังสือลงในตะกร้า
    Swal.fire({
      icon: 'success',
      title: 'เพิ่มหนังสือใน Cart แล้ว',
      text: 'สินค้าถูกเพิ่มลงใน Cart ของคุณเรียบร้อย',
      showConfirmButton: false,
      timer: 1500, // จะแสดง 1.5 วินาทีแล้วหายไป
      customClass: {
        popup: 'bg-green-500 text-white font-semibold p-4 rounded-lg', // ปรับสไตล์ป๊อปอัพ
      }
    });
  }

  // ฟังก์ชันเพิ่มจำนวนสินค้า
  function updateCartQuantity(bookId, quantity) {
    fetch('/update-cart', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
      },
      body: JSON.stringify({
        book_id: bookId,
        quantity: quantity
      })
    })
    .then(response => response.json())
    .then(data => {
      // อัปเดตจำนวนในไอคอน Cart
      document.getElementById('cartCount').textContent = data.cartCount;
    });
  }
</script>

@endsection