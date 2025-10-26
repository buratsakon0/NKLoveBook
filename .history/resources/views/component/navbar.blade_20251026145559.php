@php
  use App\Models\Category;
  $categories = Category::all();
@endphp

@once
  <style>
    .nav-category {
      position: relative;
      display: inline-block;
    }
    .nav-category__toggle {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      padding: 0.2rem 0;
      border: 0;
      background: transparent;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.22em;
      font-size: 0.9rem;
      color: #dd4f2f;
      cursor: pointer;
      transition: color 0.2s ease;
    }
    .nav-category__toggle:focus-visible {
      outline: 2px solid #f26d3d;
      outline-offset: 4px;
    }
    .nav-category:hover .nav-category__toggle,
    .nav-category:focus-within .nav-category__toggle {
      color: #f26d3d;
    }
    .nav-category__menu {
      position: absolute;
      top: 100%;
      left: 50%;
      transform: translateX(-50%);
      width: 15rem;
      display: none;
      background: #fff5e9;
      border: 1px solid #f2c6a6;
      border-radius: 8px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
      padding-bottom: 0.5rem;
      z-index: 40;
    }
    .nav_item:hover {
      color: #f26d3d;
    }
    .nav-category:hover .nav-category__menu,
    .nav-category:focus-within .nav-category__menu {
      display: block;
    }
    .nav-category__top-strip {
      height: 4px;
      background: #b280d6;
      border-top-left-radius: 8px;
      border-top-right-radius: 8px;
    }
    .nav-category__notch {
      position: absolute;
      top: -12px;
      right: 1.5rem;
      width: 0;
      height: 0;
      border-left: 12px solid transparent;
      border-right: 12px solid transparent;
      border-bottom: 12px solid #fff5e9;
      filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
    }
    .nav-category__list {
      list-style: none;
      margin: 0;
      padding: 0;
    }
    .nav-category__item {
      border-top: 1px solid #f2c6a6;
    }
    .nav-category__item:first-child {
      border-top: none;
    }
    .nav-category__link {
      width: 100%;
      border: 0;
      background: transparent;
      display: block;
      padding: 0.95rem 1.75rem;
      text-decoration: none;
      color: #d65032;
      font-size: 0.92rem;
      font-weight: 500;
      letter-spacing: 0.08em;
      transition: background-color 0.15s ease, color 0.15s ease;
    }
    .nav-category__link:hover,
    .nav-category__link:focus {
      background: #ffffff;
      color: #f26d3d;
    }
  </style>
@endonce

<nav class="bg-white shadow-md">
  <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
    <!-- Left: Logo -->
    <div class="flex items-center gap-3">
      <img src="{{ asset('images/newlogo.png') }}" class="w-12 h-12" alt="logo">
      <span class="text-lg font-bold">น้ำข้าวรักหนังสือ</span>
    </div>

    <!-- Center: Search -->
    <div class="flex-1 mx-8">
      <input
        type="text"
        placeholder="Search Books"
        style="background-color: #f6f6f6;"
        class="w-full border border-gray-200 rounded-full px-5 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-400">
    </div>

    <!-- Right: Icons -->
    <div class="flex gap-5 text-sm font-medium text-indigo-800">
      @guest
    <a href="{{ route('login') }}" class="text-sm text-indigo-700 font-semibold">ACCOUNT</a>
@endguest

@auth
    <!-- login แล้ว-->
    <a href="{{ route('profile') }}" class="text-indigo-600 font-semibold">
        {{ Auth::user()->Username }}
    </a>
@else
    <!-- ยังไม่ login -->
    <a href="{{ route('login') }}" class="text-indigo-600 font-semibold">
        ACCOUNT
    </a>
@endauth


      <span>|</span>
      <a href="#" class="flex items-center gap-1 hover:text-indigo-500"><i class="fa fa-shopping-cart"></i> CART</a>
      <span>|</span>
      <a href="#" class="flex items-center gap-1 hover:text-indigo-500"><i class="fa fa-heart"></i> WISHLIST</a>
    </div>
  </div>

  <!-- Bottom Menu -->
  <div class="border-t">
    <div class="flex justify-center gap-10 py-[2rem] text-sm uppercase font-semibold">
      <a href="/" class="nav_item hover:text-[#ED553B]">Home</a>
      <span>|</span>

      <!-- Dropdown Category -->
      <div class="nav-category">
        <button class="uppercase font-semibold nav_item">
          Category <i class="fa fa-chevron-down" style="font-size: 0.55rem;"></i>
        </button>
        <div class="nav-category__menu">
          <span class="nav-category__notch"></span>
          <div class="nav-category__top-strip"></div>
          <ul class="nav-category__list">
            @foreach ($categories as $cat)
              <li class="nav-category__item">
                <a href="{{ route('category.show', $cat->CategoryID) }}" class="nav-category__link">
                  {{ $cat->CategoryName }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      </div>

      <span>|</span>
      <a href="/contact" class="nav_item hover:text-[#ED553B]">Contact Us</a>
    </div>
  </div>
</nav>
