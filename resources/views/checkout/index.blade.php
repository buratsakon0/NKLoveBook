@extends('layouts.app')

@section('content')

<section class="py-10 bg-gray-50">
  <div class="max-w-6xl mx-auto bg-white rounded-md shadow-md border border-gray-200">
    
    <!-- Progress Bar -->
    <div class="bg-gradient-to-r from-pink-100 via-blue-50 to-green-50 py-6">
      <div class="flex justify-center items-center space-x-12 text-center text-sm font-medium text-indigo-900">
        <div>
          <div class="mx-auto w-8 h-8 flex items-center justify-center rounded-full border-2 border-indigo-900 text-indigo-900 font-semibold">1</div>
          <p class="mt-1 text-gray-700">Your Cart</p>
        </div>
        <div class="w-12 h-[1px] bg-indigo-300"></div>
        <div>
          <div class="mx-auto w-8 h-8 flex items-center justify-center rounded-full border-2 border-indigo-900 bg-indigo-900 text-white font-semibold">2</div>
          <p class="mt-1 text-indigo-900 font-semibold">Shipping</p>
        </div>
        <div class="w-12 h-[1px] bg-indigo-300"></div>
        <div>
          <div class="mx-auto w-8 h-8 flex items-center justify-center rounded-full border-2 border-indigo-300 text-indigo-300 font-semibold">3</div>
          <p class="mt-1 text-gray-400">Payment</p>
        </div>
        <div class="w-12 h-[1px] bg-indigo-300"></div>
        <div>
          <div class="mx-auto w-8 h-8 flex items-center justify-center rounded-full border-2 border-indigo-300 text-indigo-300 font-semibold">4</div>
          <p class="mt-1 text-gray-400">Complete</p>
        </div>
      </div>
    </div>

    <!-- Shipping Address Section -->
    <div class="p-10">
      <!-- Center Title -->
      <h2 class="text-2xl font-bold text-indigo-900 flex justify-center items-center mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4M4 10h16v10H4V10z" />
        </svg>
        Shipping Address
      </h2>

      <!-- Address Box -->
      <div class="border border-indigo-200 rounded-lg p-6 bg-white">
        @if(session('shipping_address'))
          <div class="text-gray-700 text-base leading-relaxed">
            <p class="mb-2">
              <strong>Address:</strong> {{ session('shipping_address')['full_name'] }} | (+66) {{ session('shipping_address')['phone_number'] }}
            </p>
            <p class="ml-20">{{ session('shipping_address')['address'] }}</p>
          </div>
          <div class="text-right mt-3">
            <a href="{{ route('checkout.edit') }}" class="text-indigo-600 font-semibold hover:underline">Edit</a>
          </div>
        @else
          <p class="text-gray-500">You have not added a shipping address yet.</p>
          <div class="text-right mt-3">
            <a href="{{ route('checkout.edit') }}" class="text-indigo-600 font-semibold hover:underline">Add Address</a>
          </div>
        @endif
      </div>

      <!-- Buttons -->
      <div class="mt-10 flex justify-center gap-6">
        <!-- Back Button -->
        <a href="{{ url('/cart') }}"
           class="flex items-center border border-orange-500 text-orange-500 font-semibold py-2 px-5 rounded-md hover:bg-orange-50 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10l-5 5m0 0l5 5m-5-5h20" />
          </svg>
          Continue Shopping
        </a>

        <!-- Next Button -->
        <a href="#"
           class="flex items-center bg-orange-500 text-white font-semibold py-2 px-6 rounded-md hover:bg-orange-600 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7l7 7-7 7" />
          </svg>
          Next Step
        </a>
      </div>
    </div>

  </div>
</section>

@endsection
