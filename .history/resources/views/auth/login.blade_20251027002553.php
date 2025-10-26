@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-[80vh] bg-[#f8f9fa] px-4">
    <div class="bg-white shadow-xl rounded-2xl flex flex-col md:flex-row overflow-hidden w-full max-w-4xl min-h-[550px] items-stretch">

        {{-- 🌸 ภาพประกอบด้านซ้าย --}}
        <div class="hidden md:flex w-1/2 bg-[#f2f2f2] justify-center items-center">
            <img
                src="{{ asset('images/Namkhaw_love_book.gif') }}" <!-- เปลี่ยนภาพประกอบตามที่คุณต้องการ -->
                alt="Register Illustration"
                class="w-full h-full object-cover"
                style="object-position: center top;">
        </div>

        {{-- 🪄 ฟอร์มสมัครสมาชิก --}}
        <div class="w-full md:w-1/2 p-10 flex flex-col justify-center flex-1">
            <h2 class="text-center text-2xl font-bold text-[#2b2b7b] mb-6">สมัครสมาชิก</h2>

            <form id="registerForm" method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Username --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">ชื่อผู้ใช้</label>
                    <input type="text" name="Username" id="Username" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#5a56d3] focus:outline-none" required>
                    <span id="UsernameError" class="text-red-500 text-sm"></span>
                </div>

                {{-- ชื่อจริง --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">ชื่อจริง</label>
                    <input type="text" name="Fname" id="Fname" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#5a56d3] focus:outline-none" required>
                    <span id="FnameError" class="text-red-500 text-sm"></span>
                </div>

                {{-- นามสกุล --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">นามสกุล</label>
                    <input type="text" name="Lname" id="Lname" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#5a56d3] focus:outline-none" required>
                    <span id="LnameError" class="text-red-500 text-sm"></span>
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">อีเมล</label>
                    <input type="email" name="Email" id="Email" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#5a56d3] focus:outline-none" required>
                    <span id="EmailError" class="text-red-500 text-sm"></span>
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">รหัสผ่าน</label>
                    <input type="password" name="Password" id="Password" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#5a56d3] focus:outline-none" required>
                    <span id="PasswordError" class="text-red-500 text-sm"></span>
                </div>

                {{-- Confirm --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">ยืนยันรหัสผ่าน</label>
                    <input type="password" name="Password_confirmation" id="Password_confirmation" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#5a56d3] focus:outline-none" required>
                    <span id="PasswordConfirmError" class="text-red-500 text-sm"></span>
                </div>

                <button type="submit" class="w-full bg-[#3e38c1] text-white py-2 rounded-lg font-semibold hover:bg-[#2b28a0] transition-all duration-200">
                    สมัครสมาชิก
                </button>
            </form>

            <p class="text-center mt-5 text-sm text-gray-700">
                มีบัญชีอยู่แล้ว? 
                <a href="{{ route('login') }}" class="text-[#3e38c1] font-semibold hover:underline">เข้าสู่ระบบ</a>
            </p>
        </div>
    </div>
</div>
@endsection
