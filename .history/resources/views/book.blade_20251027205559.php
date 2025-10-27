@extends('layouts.app')

@section('content')
  @php
    $coverImage = $book->cover_image
      ? (filter_var($book->cover_image, FILTER_VALIDATE_URL)
          ? $book->cover_image
          : asset('images/' . ltrim($book->cover_image, '/')))
      : asset('images/manga.jpg');
    $authorName = optional($book->author)->AuthorName ?? 'Unknown Author';
    $publisherName = optional($book->publisher)->PublisherName ?? 'Unknown Publisher';
    $categoryName = optional($book->category)->CategoryName ?? 'Uncategorized';
    $averageDisplay = $averageRating !== null ? number_format($averageRating, 1) : '—';
    $quantity = 1; // Default quantity
  @endphp

  <section class="bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-3xl p-10">

      <div class="grid lg:grid-cols-[340px,1fr] gap-12">
        <div class="bg-gray-100 rounded-2xl p-6 flex items-center justify-center shadow-inner">
          <img src="{{ $coverImage }}" alt="{{ $book->BookName }} cover"
            class="w-full max-w-xs rounded-lg shadow-lg">
        </div>
<div class="flex justify-between items-center mb-4">
    <h1 class="text-3xl font-bold text-indigo-900 leading-tight">{{ $book->BookName }}</h1>
    <button 
        onclick="toggleWishlist({{ $book->id }})" 
        id="wishlist-{{ $book->id }}" 
        class="text-2xl text-gray-400 transition-colors duration-300 w-14 h-14 ml-4">
        <i id="heart-icon-{{ $book->id }}" class="fa fa-heart text-4xl"></i>
    </button>
</div>
        <div class="flex flex-col gap-6">
          <div>
           
            <div class="mt-4 text-sm text-gray-600 space-y-1">
              <p><span class="font-semibold text-gray-900">ผู้เขียน:</span> {{ $authorName }}</p>
              <p><span class="font-semibold text-gray-900">สำนักพิมพ์:</span> {{ $publisherName }}</p>
              <p><span class="font-semibold text-gray-900">หมวดหมู่:</span> <a href="/category/{{$book->CategoryID}}">{{ $categoryName }}<a></p>
              <p><span class="font-semibold text-gray-900">ISBN:</span> {{ $book->ISBN }}</p>
              <p><span class="font-semibold text-gray-900">จำนวนหน้า:</span> {{ $book->Pages }}</p>
            </div>
          </div>

          <p class="text-4xl font-bold text-orange-500">฿ {{ number_format($book->Price, 2) }}</p>

          <div class="flex flex-wrap items-center gap-5">
            <div class="flex items-center border border-gray-200 rounded-full overflow-hidden bg-white shadow-sm">
              <button id="decrease" class="px-4 py-2 text-lg text-indigo-600 hover:bg-indigo-50">-</button>
              <span id="quantity" class="px-6 py-2 text-lg font-semibold border-x border-gray-200">1</span>
              <button id="increase" class="px-4 py-2 text-lg text-indigo-600 hover:bg-indigo-50">+</button>
            </div>

            <!-- ฟอร์ม Add to Cart -->
            <form action="{{ route('cart.add', $book->BookID) }}" method="POST">
              @csrf
              <input type="hidden" name="quantity" id="cartQuantity" value="1">
              <button type="submit" class="flex items-center gap-2 bg-orange-500 text-white px-6 py-3 rounded-full text-sm font-semibold tracking-wide shadow hover:bg-orange-600 transition">
                <i class="fa fa-shopping-cart"></i>
                ADD TO CART
              </button>
            </form>

            <!-- ฟอร์ม Buy -->
            <form action="{{ route('cart.add', $book->BookID) }}" method="POST">
              @csrf
              <input type="hidden" name="quantity" id="cartQuantityBuy" value="1">
              <button type="submit" class="flex items-center gap-2 border border-orange-500 text-orange-500 px-6 py-3 rounded-full text-sm font-semibold tracking-wide hover:bg-orange-50 transition">
                <i class="fa fa-bolt"></i>
                BUY
              </button>
            </form>
          </div>
        </div>
      </div>

      <div class="mt-12 grid lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 space-y-5">
          <h2 class="text-lg font-bold text-gray-900 uppercase tracking-wide">Details:</h2>
          <p class="text-sm leading-7 text-gray-600 whitespace-pre-line">
            {{ $book->Description ?? 'รายละเอียดของหนังสือเล่มนี้ยังไม่พร้อมให้แสดงในขณะนี้' }}
          </p>
        </div>
      </div>

      <div class="mt-12">
        <h2 class="text-lg font-bold text-gray-900 uppercase tracking-wide">Reviews:</h2>
        <div class="mt-6 grid md:grid-cols-2 gap-6">
          <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow-sm">
            <div class="flex items-center gap-4">
              <div class="text-4xl font-bold text-indigo-900 leading-none">{{ $averageDisplay }}</div>
              <div class="flex flex-col gap-1">
                @auth
                  @if($userReview)
                    <!-- Show user's rating -->
                    <div class="text-orange-500">
                      @for ($i = 1; $i <= 5; $i++)
                        @if($i <= $userReview->Score)
                          <i class="fa-solid fa-star"></i>
                        @else
                          <i class="fa-regular fa-star"></i>
                        @endif
                      @endfor
                    </div>
                    <span class="text-xs text-gray-500 uppercase tracking-widest">Your Rating</span>
                    <form action="{{ route('review.destroy', $book->BookID) }}" method="POST" class="inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-red-500 hover:text-red-700 text-xs" 
                        onclick="return confirm('Delete your review?')">
                        Delete Review
                      </button>
                    </form>
                  @else
                    <!-- Clickable stars for rating -->
                    <div class="text-gray-300" id="rating-stars">
                      @for ($i = 1; $i <= 5; $i++)
                        <i class="fa-regular fa-star cursor-pointer hover:text-orange-500 transition-colors" 
                           data-rating="{{ $i }}" onclick="submitRating({{ $i }})"></i>
                      @endfor
                    </div>
                    <span class="text-xs text-gray-500 uppercase tracking-widest">Click to Rate</span>
                  @endif
                @else
                  <!-- Show average rating for non-logged users -->
                  <div class="text-orange-500">
                    @for ($i = 1; $i <= 5; $i++)
                      @if($averageRating !== null && $averageRating >= $i)
                        <i class="fa-solid fa-star"></i>
                      @elseif($averageRating !== null && $averageRating >= ($i - 0.5))
                        <i class="fa-solid fa-star-half-stroke"></i>
                      @else
                        <i class="fa-regular fa-star"></i>
                      @endif
                    @endfor
                  </div>
                  <span class="text-xs text-gray-500 uppercase tracking-widest">
                    {{ $totalReviews ? 'Average Rating' : 'No Ratings Yet' }}
                  </span>
                  @if($totalReviews)
                    <span class="text-[0.65rem] text-gray-400">{{ $totalReviews }} รีวิว</span>
                  @endif
                @endauth
              </div>
            </div>

            <div class="mt-6 space-y-3 text-sm text-gray-600">
              @foreach ($ratingsDistribution as $stars => $data)
                <div class="flex items-center gap-3">
                  <div class="w-6 text-right font-semibold text-gray-500">{{ $stars }}</div>
                  <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-orange-500" style="width: {{ $data['percent'] }}%;"></div>
                  </div>
                  <div class="w-12 text-right text-gray-500">{{ $data['percent'] }}%</div>
                </div>
              @endforeach
            </div>
          </div>

          <div class="bg-gray-100 border border-gray-200 rounded-3xl flex items-center justify-center text-gray-400 text-lg font-medium">
            @if($totalReviews)
              <div class="text-center text-gray-600">
                <p class="uppercase text-xs tracking-widest text-gray-400">Total Reviews</p>
                <p class="text-4xl font-bold text-indigo-900 mt-2">{{ $totalReviews }}</p>
                <p class="text-sm mt-3 text-gray-500">ขอบคุณสำหรับทุกคำติชมของคุณ!</p>
              </div>
            @else
              Not Yet Reviewed
            @endif
          </div>
        </div>
      </div>

      <div class="mt-16 text-center text-sm text-gray-300">น้ำข้าวรักหนังสือ</div>
    </div>
  </section>

  <!-- Hidden form for rating submission -->
  <form id="rating-form" action="{{ route('review.store', $book->BookID) }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="score" id="rating-score" value="">
    <input type="hidden" name="comment" value="">
  </form>

  <script>
  // เพิ่มจำนวนสินค้า
  document.getElementById("increase").addEventListener("click", function() {
    let quantityElement = document.getElementById("quantity");
    let currentQuantity = parseInt(quantityElement.textContent);
    let newQuantity = currentQuantity + 1;

    // อัปเดตจำนวนที่แสดง
    quantityElement.textContent = newQuantity;

    // อัปเดตค่าใน hidden input สำหรับทั้งฟอร์ม
    document.getElementById("cartQuantity").value = newQuantity;
    document.getElementById("cartQuantityBuy").value = newQuantity;

  });

  // ลดจำนวนสินค้า
  document.getElementById("decrease").addEventListener("click", function() {
    let quantityElement = document.getElementById("quantity");
    let currentQuantity = parseInt(quantityElement.textContent);
    if (currentQuantity > 1) {
      let newQuantity = currentQuantity - 1;
      quantityElement.textContent = newQuantity;

      // อัปเดตค่าใน hidden input สำหรับทั้งฟอร์ม
      document.getElementById("cartQuantity").value = newQuantity;
      document.getElementById("cartQuantityBuy").value = newQuantity;

    }
  });

  // ฟังก์ชันสำหรับอัปเดต Cart ไอคอน
  function updateCart(quantity, showAlert) {
    fetch('/update-cart', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
      },
      body: JSON.stringify({
        book_id: {{ $book->BookID }},
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
  const addToCartForm = document.querySelector('form[action="{{ route('cart.add', $book->BookID) }}"]');
  addToCartForm.addEventListener('submit', function(event) {
    event.preventDefault(); // หยุดการส่งฟอร์มปกติ

    let quantity = document.getElementById("cartQuantity").value;
    updateCart(quantity, true);  // แสดง alert เฉพาะเมื่อคลิก Add to Cart

  });
 function toggleWishlist(bookId) {
    const heartIcon = document.getElementById(`heart-icon-${bookId}`);
    const isInWishlist = heartIcon.classList.contains('fa-heart-solid'); // ตรวจสอบว่าไอคอนเป็นสีแดงหรือไม่

    if (isInWishlist) {
        // ลบออกจาก Wishlist
        heartIcon.classList.remove('fa-heart-solid');
        heartIcon.classList.add('fa-heart');
        removeFromWishlist(bookId);
    } else {
        // เพิ่มลงใน Wishlist
        heartIcon.classList.remove('fa-heart');
        heartIcon.classList.add('fa-heart-solid');
        addToWishlist(bookId);
    }
}

function addToWishlist(bookId) {
    fetch(`/wishlist/add/${bookId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            console.log('Added to Wishlist');
        }
    });
}

function removeFromWishlist(bookId) {
    fetch(`/wishlist/remove/${bookId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            console.log('Removed from Wishlist');
        }
    });
}



@endsection
