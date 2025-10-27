@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-12 px-4">
  <h1 class="text-3xl font-bold text-center text-indigo-900 mb-6 flex items-center justify-center gap-2">
    <svg width="50px" height="50px" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg"><path d="M25 39.7l-.6-.5C11.5 28.7 8 25 8 19c0-5 4-9 9-9 4.1 0 6.4 2.3 8 4.1 1.6-1.8 3.9-4.1 8-4.1 5 0 9 4 9 9 0 6-3.5 9.7-16.4 20.2l-.6.5zM17 12c-3.9 0-7 3.1-7 7 0 5.1 3.2 8.5 15 18.1 11.8-9.6 15-13 15-18.1 0-3.9-3.1-7-7-7-3.5 0-5.4 2.1-6.9 3.8L25 17.1l-1.1-1.3C22.4 14.1 20.5 12 17 12z"/></svg>
    wishlist
  </h1>

  @if(!empty($cart))
    <div class="bg-white shadow-md rounded-lg border border-gray-200">
    

      <table class="w-full text-left border-collapse">
        <thead class="border-b border-gray-300 text-gray-600">
          <tr>
            <th class="py-3 px-6 w-1/3">Product</th>
            <th class="py-3 px-6">Price/Unit</th>
    
          </tr>
        </thead>
        <tbody>
          @foreach($cart as $productId => $product)
            <tr class="border-b border-gray-200 hover:bg-gray-50">
              <td class="py-4 px-6 flex items-center space-x-4">
                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-24 h-auto rounded shadow-sm">
                <div>
                  <p class="font-semibold text-indigo-900">{{ $product['name'] }}</p>
                  <p class="text-sm text-gray-500 mt-1 uppercase tracking-wide">
                    {{ $product['author'] ?? 'Unknown Author' }}
                    </p>

                </div>
              </td>
              <td class="py-4 text-right">฿{{ number_format($product['price'], 2) }}</td>

            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="flex justify-between items-center px-6 py-4 border-t border-gray-200">
        <p class="text-gray-600">{{ count($cart) }} Items</p>
        <div class="text-right">
          <span class="text-xl font-semibold text-gray-900">฿{{ number_format($totalPrice, 2) }}</span>
        </div>
      </div>

      <div class="flex justify-end items-center gap-4 px-6 py-4 border-t border-gray-200">
        <button onclick="window.location.href='{{ route('home') }}'" class="flex items-center border border-orange-500 text-orange-500 font-medium py-2 px-6 rounded hover:bg-orange-50 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 3v18m0-18l18 18"/>
          </svg>
          Continue Shopping
        </button>

        <div class="flex justify-end items-center gap-4 px-6 py-4 border-t border-gray-200">
  @auth
        <!-- ถ้า login แล้วจะให้แสดงปุ่ม Checkout -->
        <a href="{{ route('checkout') }}" class="flex items-center bg-orange-500 text-white font-medium py-2 px-6 rounded hover:bg-orange-600 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-3.314 0-6 2.686-6 6v2h12v-2c0-3.314-2.686-6-6-6zM5 14v2a2 2 0 002 2h10a2 2 0 002-2v-2M12 8V4m0 0a4 4 0 100 8"/>
          </svg>
          Checkout
        </a>
      @else
        <!-- ถ้ายังไม่ได้ login แสดงปุ่มให้ไปหน้า login -->
        <a href="{{ route('login') }}" class="flex items-center bg-orange-500 text-white font-medium py-2 px-6 rounded hover:bg-orange-600 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-3.314 0-6 2.686-6 6v2h12v-2c0-3.314-2.686-6-6-6zM5 14v2a2 2 0 002 2h10a2 2 0 002-2v-2M12 8V4m0 0a4 4 0 100 8"/>
          </svg>
          Login to Checkout
        </a>
      @endauth
    </div>
      </div>
    </div>
  @else
    <p class="mt-6 text-center text-lg text-gray-600">Your cart is empty.</p>
  @endif
</div>

<script>
  function updateQuantity(productId, action) {
    const quantityElement = document.getElementById('quantity-' + productId);
    let currentQuantity = parseInt(quantityElement.textContent);

    if (action === 'increase') currentQuantity++;
    else if (action === 'decrease' && currentQuantity > 1) currentQuantity--;

    quantityElement.textContent = currentQuantity;

    const formData = new FormData();
    formData.append('action', action);
    formData.append('productId', productId);
    formData.append('quantity', currentQuantity);

    fetch(`{{ route('cart.update', ['productId' => ':id']) }}`.replace(':id', productId), {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) window.location.reload();
    });
  }
</script>
@endsection
