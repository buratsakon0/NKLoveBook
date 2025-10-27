@extends('layouts.app')

@section('content')
<div class="container mx-auto my-10">
    <!-- หัวข้อของหน้า Wishlist -->
    <h2 class="text-2xl font-bold text-indigo-900 mb-6">My Wishlist</h2>

    <!-- ตรวจสอบว่า Wishlist ว่างหรือไม่ -->
    @if($wishlists->isEmpty())
        <div class="text-center text-gray-500">
            <p>ไม่มีสินค้าที่คุณได้เพิ่มลงใน Wishlist</p>
        </div>
    @else
        <!-- แสดงรายการ Wishlist -->
        @foreach($wishlists as $wishlist)
            <div class="wishlist-item flex justify-between items-center mb-4" id="wishlist-item-{{ $wishlist->book->id }}">
                <div class="flex items-center">
                    <!-- แสดงภาพหนังสือ -->
                    <img src="{{ asset('images/' . $wishlist->book->cover_image) }}" alt="{{ $wishlist->book->BookName }}" class="w-24 h-32 object-cover mr-4">
                    <div>
                        <!-- ชื่อหนังสือ -->
                        <span class="block text-lg font-semibold text-gray-800">{{ $wishlist->book->BookName }}</span>
                        <!-- ราคา -->
                        <span class="block text-gray-500">฿{{ number_format($wishlist->book->Price, 2) }}</span>
                    </div>
                </div>
                <div class="flex gap-4">
                    <!-- ปุ่มเพิ่มลงในตะกร้า -->
                    <button 
                        onclick="addToCart({{ $wishlist->book->id }})" 
                        class="bg-indigo-600 text-white py-1 px-4 rounded hover:bg-indigo-700">
                        Add to Cart
                    </button>
                    <!-- ปุ่มลบออกจาก Wishlist -->
                    <button 
                        onclick="removeFromWishlist({{ $wishlist->book->id }})" 
                        class="text-red-500">
                        <i class="fa fa-trash"></i> Remove
                    </button>
                </div>
            </div>
        @endforeach
    @endif
</div>

<script>
    // ฟังก์ชันเพิ่มสินค้าลงในตะกร้า
    function addToCart(bookId) {
        fetch(`/cart/add/${bookId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Added to cart!');
            }
        });
    }

    // ฟังก์ชันลบสินค้าจาก Wishlist
    function removeFromWishlist(bookId) {
        fetch(`/wishlist/remove/${bookId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // ลบรายการจากหน้า
                const item = document.getElementById(`wishlist-item-${bookId}`);
                if (item) {
                    item.remove();  // ลบรายการออกจาก DOM
                }
                alert('Removed from wishlist!');
            }
        });
    }
</script>

@endsection
