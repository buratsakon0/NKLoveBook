@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-12 px-4">
  <h1 class="text-3xl font-bold text-center text-indigo-900 mb-6 flex items-center justify-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-indigo-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 6.45A2 2 0 007.63 22h8.74a2 2 0 001.98-2.55L17 13M7 13l1.35-6.45A2 2 0 0110.37 4h3.26a2 2 0 011.98 2.55L17 13" />
    </svg>
    Cart
  </h1>

  @if(session('cart') && count(session('cart')) > 0)
    <div class="bg-white shadow-md rounded-lg border border-gray-200">
      <div class="p-4 bg-gray-100 flex items-center font-semibold text-lg border-b border-gray-200">
        <input type="checkbox" checked class="accent-orange-500 mr-2">
        All Items
      </div>

      <table class="w-full text-left border-collapse">
        <thead class="border-b border-gray-300 text-gray-600">
          <tr>
            <th class="py-3 px-6 w-1/3">Product</th>
            <th class="py-3 px-6">Price/Unit</th>
            <th class="py-3 px-6">Number</th>
            <th class="py-3 px-6">Total</th>
            <th class="py-3 px-6 text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach(session('cart') as $productId => $product)
            <tr class="border-b border-gray-200 hover:bg-gray-50">
              <td class="py-4 px-6 flex items-center space-x-4">
                <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}" class="w-24 h-auto rounded shadow-sm">
                <div>
                  <p class="font-semibold text-indigo-900">{{ $product['name'] }}</p>
                  <p class="text-sm text-gray-500 mt-1 uppercase tracking-wide">
                    {{ $product['author'] ?? 'Unknown Author' }}
                    </p>

                </div>
              </td>
              <td class="py-4 px-6">฿{{ number_format($product['price'], 2) }}</td>
              <td class="py-4 px-6">
                <div class="flex items-center justify-center border border-black rounded-full w-fit">
                  <button onclick="updateQuantity({{ $productId }}, 'decrease')" class="px-3 py-1 text-xl font-bold">−</button>
                  <span id="quantity-{{ $productId }}" class="px-4 py-1 text-lg">{{ $product['quantity'] }}</span>
                  <button onclick="updateQuantity({{ $productId }}, 'increase')" class="px-3 py-1 text-xl font-bold">+</button>
                </div>
              </td>
              <td class="py-4 px-6">฿{{ number_format($product['price'] * $product['quantity'], 2) }}</td>
              <td class="py-4 px-6 text-center">
                <form action="{{ route('cart.remove', $productId) }}" method="POST" onsubmit="return confirm('Remove this item?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-gray-600 hover:text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v1H9V4a1 1 0 011-1z"/>
                    </svg>
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="flex justify-between items-center px-6 py-4 border-t border-gray-200">
        <p class="text-gray-600">{{ count(session('cart')) }} Items</p>
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

        <a href="#" class="flex items-center bg-orange-500 text-white font-medium py-2 px-6 rounded hover:bg-orange-600 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-3.314 0-6 2.686-6 6v2h12v-2c0-3.314-2.686-6-6-6zM5 14v2a2 2 0 002 2h10a2 2 0 002-2v-2M12 8V4m0 0a4 4 0 100 8"/>
          </svg>
          Checkout
        </a>
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
