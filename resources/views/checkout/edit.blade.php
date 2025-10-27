@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-[80vh] bg-[#f8f9fa] px-4">
    <div class="bg-white shadow-xl rounded-2xl flex flex-col md:flex-row overflow-hidden w-full max-w-4xl min-h-[550px] items-stretch">
        <!-- รูปภาพทางซ้าย -->
        <div class="hidden md:flex w-1/2 bg-[#f2f2f2] justify-center items-center">
            <img
                src="{{ asset('images/shipping-address.jpg') }}"
                alt="Shipping Address Image"
                class="w-full h-full object-cover"
                style="object-position: center top;">
        </div>

        <!-- ฟอร์มด้านขวา -->
        <div class="w-full md:w-1/2 p-10 flex flex-col justify-center flex-1">
            <h2 class="text-center text-2xl font-bold text-[#2b2b7b] mb-6">
                Edit Shipping Address
            </h2>
            <p class="text-center text-gray-500 mt-2 mb-6">
                Update your shipping details
            </p>

            <!-- ฟอร์ม -->
            <form action="{{ route('checkout.save') }}" method="POST" id="shippingForm">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="full_name" class="block text-lg font-semibold">Full Name</label>
                        <input type="text" name="full_name" class="w-full p-3 border border-gray-300 rounded-lg" required placeholder="Enter your full name">
                    </div>

                    <div>
                        <label for="phone_number" class="block text-lg font-semibold">Phone Number</label>
                        <input type="text" name="phone_number" class="w-full p-3 border border-gray-300 rounded-lg" required placeholder="Enter your phone number">
                    </div>

                    <div>
                        <label for="address" class="block text-lg font-semibold">Address</label>
                        <textarea name="address" class="w-full p-3 border border-gray-300 rounded-lg" required placeholder="Enter your address"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-between gap-5">
                    <button type="button" onclick="showCancelAlert()" class="bg-gray-200 py-2 px-6 rounded-full">Cancel</button>
                    <button type="submit" class="bg-orange-500 text-white py-2 px-6 rounded-full">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // เมื่อกดปุ่ม Cancel
    function showCancelAlert() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Any unsaved changes will be lost.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3e38c1',
            cancelButtonColor: 'rgba(255, 87, 4, 1)',
            confirmButtonText: 'Yes, go back!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // ถ้าผู้ใช้กด "Yes", ไปยังหน้าต่างก่อนหน้า
                window.location.href = '{{ route('checkout') }}';
            }
        });
    }

    // เมื่อกดปุ่ม Save
    document.getElementById("shippingForm").addEventListener("submit", function(event) {
        event.preventDefault();  // หยุดการส่งฟอร์มโดยตรง
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to save your shipping address?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3e38c1',
            cancelButtonColor: 'rgba(255, 87, 4, 1)',
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // ถ้าผู้ใช้กด "Yes", ส่งฟอร์ม
                event.target.submit();
            }
        });
    });
</script>
@endsection