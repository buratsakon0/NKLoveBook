@extends('layouts.app')

@section('content')

<section class="py-16 bg-gradient-to-r from-pink-20 to-white">
  <div class="text-center mb-10">
    <h2 class="text-3xl font-bold text-indigo-900">
      Edit Shipping Address
    </h2>
    <p class="text-gray-500 mt-2">
      Update your shipping details
    </p>
  </div>

  <div class="max-w-7xl mx-auto bg-white shadow-md rounded-xl p-6">
    <form action="{{ route('checkout.save') }}" method="POST">
      @csrf
      <div class="space-y-4">
        <div>
          <label for="full_name" class="block text-lg font-semibold">Full Name</label>
          <input type="text" name="full_name" class="w-full p-3 border border-gray-300 rounded-lg" required>
        </div>

        <div>
          <label for="phone_number" class="block text-lg font-semibold">Phone Number</label>
          <input type="text" name="phone_number" class="w-full p-3 border border-gray-300 rounded-lg" required>
        </div>

        <div>
          <label for="address" class="block text-lg font-semibold">Address</label>
          <textarea name="address" class="w-full p-3 border border-gray-300 rounded-lg" required></textarea>
        </div>
      </div>

      <div class="mt-6 flex justify-between gap-5">
        <button type="button" onclick="window.location.href='{{ route('checkout') }}'" class="bg-gray-200 py-2 px-6 rounded-full">Cancel</button>
        <button type="submit" class="bg-orange-500 text-white py-2 px-6 rounded-full">Save</button>
      </div>
    </form>
  </div>
</section>

@endsection
