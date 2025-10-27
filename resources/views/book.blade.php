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
    $inWishlist = auth()->check()
        ? auth()->user()->wishlists()->where('BookID', $book->BookID)->exists()
        : false;
  @endphp

  <section class="bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-3xl p-10">
      <div class="grid lg:grid-cols-[340px,1fr] gap-6">
        <div class="bg-gray-100 rounded-2xl p-6 flex items-center justify-center shadow-inner">
          <img src="{{ $coverImage }}" alt="{{ $book->BookName }} cover"
            class="w-full max-w-xs rounded-lg shadow-lg">
        </div>
        <div class="flex justify-between items-center">
          <h1 class="text-3xl font-bold text-indigo-900 leading-tight">{{ $book->BookName }}</h1>
          <button
            type="button"
            onclick="toggleWishlist({{ $book->BookID }})"
            id="wishlist-{{ $book->BookID }}"
            class="ml-4 flex h-14 w-14 items-center justify-center rounded-full border border-indigo-100 text-2xl transition-colors duration-300 hover:border-indigo-300">
            <i
              id="heart-icon-{{ $book->BookID }}"
              class="fa fa-heart text-4xl transition-colors duration-300 {{ $inWishlist ? 'fa-solid text-red-500' : 'fa-regular text-gray-300' }}"></i>
          </button>
        </div>
        <div class="flex flex-col gap-6">
          <div>
            <div class="text-sm text-gray-600 space-y-1">
              <p><span class="font-semibold text-gray-900">ผู้เขียน:</span> {{ $authorName }}</p>
              <p><span class="font-semibold text-gray-900">สำนักพิมพ์:</span> {{ $publisherName }}</p>
              <p><span class="font-semibold text-gray-900">หมวดหมู่:</span> <a href="/category/{{$book->CategoryID}}">{{ $categoryName }}<a></p>
              <p><span class="font-semibold text-gray-900">ISBN:</span> {{ $book->ISBN }}</p>
              <p><span class="font-semibold text-gray-900">จำนวนหน้า:</span> {{ $book->Pages }}</p>
            </div>
          </div>

          <p class="text-4xl font-bold text-orange-500">฿ {{ number_format($book->Price, 2) }}</p>

          <div class="flex flex-wrap items-center mt-4 gap-5">
            @auth
              <!-- ✅ ผู้ใช้ล็อกอินแล้ว -->
              <form action="{{ route('cart.add', $book->BookID) }}" method="POST" onsubmit="event.preventDefault(); addToCart({{ $book->BookID }});">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="flex items-center gap-2 bg-orange-500 text-white px-6 py-3 rounded-full text-sm font-semibold tracking-wide shadow hover:bg-orange-600 transition">
                  <i class="fa fa-shopping-cart"></i>
                  ADD TO CART
                </button>
              </form>

              <form action="{{ route('cart.add', $book->BookID) }}" method="POST" onsubmit="window.location.href='/cart'">
                @csrf
                <input type="hidden" name="quantity" id="cartQuantityBuy" value="1">
                <button type="submit" class="flex items-center gap-2 border border-orange-500 text-orange-500 px-6 py-3 rounded-full text-sm font-semibold tracking-wide hover:bg-orange-50 transition">
                  <i class="fa fa-bolt"></i>
                  BUY
                </button>
              </form>
            @else
              <!-- 🚫 ผู้ใช้ยังไม่ได้ล็อกอิน -->
              <button onclick="showLoginAlert()" 
                class="flex items-center gap-2 bg-orange-500 text-white px-6 py-3 rounded-full text-sm font-semibold tracking-wide shadow hover:bg-orange-600 transition">
                <i class="fa fa-shopping-cart"></i>
                ADD TO CART
              </button>

              <button onclick="window.location.href='/login'" 
                class="flex items-center gap-2 border border-orange-500 text-orange-500 px-6 py-3 rounded-full text-sm font-semibold tracking-wide hover:bg-orange-50 transition">
                <i class="fa fa-bolt"></i>
                BUY
              </button>
            @endauth
          </div>

        </div>
      </div>

      <div class="mt-6 grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-5">
          <h2 class="text-lg font-bold text-gray-900 uppercase tracking-wide">Details:</h2>
          <p class="text-sm leading-7 text-gray-600 ">
            {{ $book->Description ?? 'รายละเอียดของหนังสือเล่มนี้ยังไม่พร้อมให้แสดงในขณะนี้' }}
          </p>
        </div>
      </div>

      <div class="mt-6">
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
      })
      .catch(console.error); // แสดง error ในกรณีที่มีปัญหา
    }
  </script>

@endsection