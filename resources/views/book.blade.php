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
              <form action="{{ route('cart.add', $book->BookID) }}" method="POST">
                    @csrf
                    <input type="hidden" name="quantity" id="cartQuantity" value="1">
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
                  <button onclick="window.location.href='/login'" 
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

  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const increaseButton = document.getElementById('increase');
    const decreaseButton = document.getElementById('decrease');
    const quantityElement = document.getElementById('quantity');
    const addToCartForm = document.querySelector('form[action="{{ route('cart.add', $book->BookID) }}"]');
    const quantityInput = document.getElementById('cartQuantity');
    const quantityBuyInput = document.getElementById('cartQuantityBuy');

    if (increaseButton && quantityElement && quantityInput && quantityBuyInput) {
      increaseButton.addEventListener('click', () => {
        const currentQuantity = parseInt(quantityElement.textContent, 10);
        const newQuantity = currentQuantity + 1;

        quantityElement.textContent = newQuantity;
        quantityInput.value = newQuantity;
        quantityBuyInput.value = newQuantity;
      });
    }

    if (decreaseButton && quantityElement && quantityInput && quantityBuyInput) {
      decreaseButton.addEventListener('click', () => {
        const currentQuantity = parseInt(quantityElement.textContent, 10);
        if (currentQuantity > 1) {
          const newQuantity = currentQuantity - 1;

          quantityElement.textContent = newQuantity;
          quantityInput.value = newQuantity;
          quantityBuyInput.value = newQuantity;
        }
      });
    }

    if (addToCartForm && quantityInput) {
      addToCartForm.addEventListener('submit', (event) => {
        event.preventDefault();
        updateCart(quantityInput.value);
      });
    }
  });

  function updateCart(quantity) {
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
        const cartCount = document.getElementById('cartCount');
        if (cartCount && typeof data.cartCount !== 'undefined') {
          cartCount.textContent = data.cartCount;
        }
      })
      .catch(console.error);
  }

  function toggleWishlist(bookId) {
    const heartIcon = document.getElementById(`heart-icon-${bookId}`);
    const isInWishlist = heartIcon?.classList.contains('fa-solid');

    if (!heartIcon) {
      return;
    }

    const promise = isInWishlist ? removeFromWishlist(bookId) : addToWishlist(bookId);

    promise.then((successful) => {
      if (!successful) {
        return;
      }

      heartIcon.classList.toggle('fa-solid');
      heartIcon.classList.toggle('fa-regular');
      heartIcon.classList.toggle('text-red-500');
      heartIcon.classList.toggle('text-gray-300');
    });
  }

  function addToWishlist(bookId) {
    return wishlistRequest(`/wishlist/add/${bookId}`, 'POST', ['success', 'exists']);
  }

  function removeFromWishlist(bookId) {
    return wishlistRequest(`/wishlist/remove/${bookId}`, 'DELETE', ['success', 'not_found']);
  }

  function wishlistRequest(url, method, successStatuses = ['success']) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    if (!csrfToken) {
      console.error('CSRF token not found in document meta.');
      return Promise.resolve(false);
    }

    const hasBody = ['POST', 'PUT', 'PATCH'].includes(method.toUpperCase());

    return fetch(url, {
      method,
      credentials: 'same-origin',
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'X-Requested-With': 'XMLHttpRequest',
        ...(hasBody ? { 'Content-Type': 'application/json' } : {})
      },
      ...(hasBody ? { body: JSON.stringify({}) } : {})
    })
      .then(response => {
        if (response.redirected && response.url.includes('/login')) {
          window.location.href = response.url;
          return null;
        }

        if (response.status === 401) {
          window.location.href = '/login';
          return null;
        }

        const contentType = response.headers.get('content-type') || '';
        if (contentType.includes('application/json')) {
          return response.json();
        }

        return response.text().then(text => {
          console.warn('Unexpected wishlist response:', text);
          return null;
        });
      })
      .then(data => {
        if (!data) {
          return false;
        }

        if (successStatuses.includes(data.status)) {
          if (data.message) {
            showWishlistToast(data.message, 'success');
          }
          return true;
        }

        showWishlistToast(data.message ?? 'ไม่สามารถดำเนินการได้ กรุณาลองใหม่อีกครั้ง', 'error');
        return false;
      })
      .catch(error => {
        console.error('Wishlist request error:', error);
        showWishlistToast('เกิดข้อผิดพลาด กรุณาลองใหม่', 'error');
        return false;
      });
  }

  function showWishlistToast(message, type = 'info') {
    if (!message) {
      return;
    }

    const toast = document.createElement('div');
    toast.textContent = message;
    toast.style.position = 'fixed';
    toast.style.top = '1.5rem';
    toast.style.right = '1.5rem';
    toast.style.zIndex = '9999';
    toast.style.padding = '0.75rem 1.25rem';
    toast.style.borderRadius = '0.75rem';
    toast.style.boxShadow = '0 10px 18px rgba(15, 23, 42, 0.15)';
    toast.style.fontSize = '0.95rem';
    toast.style.fontWeight = '600';
    toast.style.color = '#ffffff';
    toast.style.transition = 'opacity 0.5s ease';

    if (type === 'success') {
      toast.style.backgroundColor = '#22c55e';
    } else if (type === 'error') {
      toast.style.backgroundColor = '#ef4444';
    } else {
      toast.style.backgroundColor = '#4f46e5';
    }

    document.body.appendChild(toast);

    setTimeout(() => {
      toast.style.opacity = '0';
    }, 2200);

    setTimeout(() => {
      toast.remove();
    }, 2700);
  }

  window.toggleWishlist = toggleWishlist;

    // Star rating functionality
    function submitRating(rating) {
      document.getElementById('rating-score').value = rating;
      document.getElementById('rating-form').submit();
    }

    // Add hover effects for clickable stars
    document.addEventListener('DOMContentLoaded', function() {
      const stars = document.querySelectorAll('#rating-stars i');
      
      stars.forEach((star, index) => {
        star.addEventListener('mouseenter', function() {
          // Highlight stars up to hovered star
          for (let i = 0; i <= index; i++) {
            stars[i].classList.remove('fa-regular');
            stars[i].classList.add('fa-solid');
            stars[i].classList.add('text-orange-500');
          }
        });
        
        star.addEventListener('mouseleave', function() {
          // Reset all stars
          stars.forEach(s => {
            s.classList.remove('fa-solid', 'text-orange-500');
            s.classList.add('fa-regular');
          });
        });
      });
    });
  </script>


@endsection
