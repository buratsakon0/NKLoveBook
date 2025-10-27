@extends('layouts.app')

@section('content')

<section class="py-16 bg-gradient-to-r from-pink-20 to-white">
  <div class="text-center mb-10">
    <h2 class="text-3xl font-bold text-indigo-900">
      Step 2: Shipping Address
    </h2>
    <p class="text-gray-500 mt-2">
      Please provide your shipping address
    </p>
  </div>

  <div class="max-w-7xl mx-auto bg-white shadow-md rounded-xl p-6">
    <!-- แสดงข้อมูลที่อยู่ถ้ามี -->
    @if(session('shipping_address'))
      <div class="space-y-4">
        <h3 class="text-xl font-semibold text-indigo-900">Your Shipping Address:</h3>
        <p><strong>Full Name:</strong> {{ session('shipping_address')['full_name'] }}</p>
        <p><strong>Phone Number:</strong> {{ session('shipping_address')['phone_number'] }}</p>
        <p><strong>Address:</strong> {{ session('shipping_address')['address'] }}</p>

        <a href="{{ route('checkout.edit') }}" class="text-blue-500">Edit Address</a>
      </div>
    @else
      <p class="text-gray-500">You have not added a shipping address yet.</p>
      <a href="{{ route('checkout.edit') }}" class="text-blue-500">Add Shipping Address</a>
    @endif
  </div>

  <div class="mt-10 flex justify-center gap-10">
    <button onclick="window.location.href='{{ route('cart.index') }}'" class="bg-gray-200 py-2 px-6 rounded-full">Go Back to Cart</button>
    <button onclick="window.location.href='{{ route('checkout.save') }}'" class="bg-orange-500 text-white py-2 px-6 rounded-full">Next Step</button>
  </div>

</section>

@endsection
