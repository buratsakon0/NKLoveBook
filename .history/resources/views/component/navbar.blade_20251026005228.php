<nav class="bg-gray-50 shadow-sm">
  <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
    <!-- Left: Logo -->
    <div class="flex items-center gap-3">
      <img src="{{ asset('images/newlogo.png') }}" class="w-12 h-12 rounded-full border" alt="logo">
      <span class="text-lg font-bold">น้ำข้าวรักหนังสือ</span>
    </div>

    <!-- Center: Search -->
    <div class="flex-1 mx-8">
      <input type="text" placeholder="Search Books"
        class="w-full border border-gray-200 rounded-full px-5 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-400">
    </div>

    <!-- Right: Icons -->
    <div class="flex gap-5 text-sm font-medium text-indigo-800">
      <a href="#" class="flex items-center gap-1 hover:text-indigo-500"><i class="fa fa-user"></i> ACCOUNT</a>
      <span>|</span>
      <a href="#" class="flex items-center gap-1 hover:text-indigo-500"><i class="fa fa-shopping-cart"></i> CART</a>
      <span>|</span>
      <a href="#" class="flex items-center gap-1 hover:text-indigo-500"><i class="fa fa-heart"></i> WISHLIST</a>
    </div>
  </div>

  <!-- Bottom Menu -->
  <div class="border-t">
    <div class="flex justify-center gap-10 py-[2rem] text-sm uppercase font-semibold">
      <a href="/" class="text-orange-500">Home</a>
      <span>|</span>
      <div class="relative group">
        <button>Category <i class="fa fa-chevron-down text-xs"></i></button>
        <div class="hidden group-hover:block absolute bg-white shadow-md mt-2 py-2 px-4 text-gray-700">
          <a href="#" class="block py-1 hover:text-indigo-500">Science & Technology</a>
          <a href="#" class="block py-1 hover:text-indigo-500">Art & Design</a>
          <a href="#" class="block py-1 hover:text-indigo-500">Comics / Manga</a>
        </div>
      </div>
      <span>|</span>
      <a href="/contact" class="hover:text-indigo-500">Contact Us</a>
    </div>
  </div>
</nav>
