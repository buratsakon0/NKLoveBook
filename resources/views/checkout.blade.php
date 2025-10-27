@extends('layouts.app')

@section('content')
  <div class="container mx-auto mt-12 px-4">
    <h1 class="text-3xl font-bold text-center text-indigo-900 mb-6">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-indigo-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 6.45A2 2 0 007.63 22h8.74a2 2 0 001.98-2.55L17 13M7 13l1.35-6.45A2 2 0 0110.37 4h3.26a2 2 0 011.98 2.55L17 13" />
      </svg>
      Checkout
    </h1>

    <form action="{{ route('checkout.submit') }}" method="POST">
      @csrf
      <!-- ที่อยู่สำหรับจัดส่ง -->
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-700">Shipping Address</h3>
        <div class="mt-4">
          <input type="text" name="address" class="w-full border border-gray-300 p-3 rounded-lg" placeholder="Enter shipping address" required>
        </div>
      </div>

      <!-- ปุ่ม Continue to Payment -->
      <div class="mt-6 text-right">
        <button type="submit" class="bg-orange-500 text-white px-6 py-3 rounded-full text-sm font-semibold tracking-wide shadow hover:bg-orange-600 transition">
          Continue to Payment
        </button>
      </div>
    </form>
  </div>
@endsection
