@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-[90vh] bg-[#f8f9fa] px-14 ">
    <div class="bg-white shadow-xl rounded-2xl flex flex-col md:flex-row overflow-hidden w-full max-w-4xl">

        <div class="hidden md:flex w-1/2 bg-[#f2f2f2] justify-center items-center">
            <img
                src="{{ asset('images/Namkhaw_love_book.gif') }}"
                alt="Register Illustration"
                class="w-full h-full object-cover"
                style="object-position: center top;">
        </div>

        <div class="w-full md:w-1/2 p-10 flex flex-col justify-center">
            <h2 class="text-center text-2xl font-bold text-[#2b2b7b] mb-6">สมัครสมาชิก</h2>

            <form id="registerForm" method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Username --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">ชื่อผู้ใช้ *</label>
                    <input 
                        type="text" 
                        name="Username" 
                        id="Username" 
                        placeholder="ตั้งชื่อผู้ใช้งาน"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#5a56d3] focus:outline-none">
                    <span id="UsernameError" class="text-red-500 text-sm"></span>
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">อีเมล *</label>
                    <input 
                        type="email" 
                        name="Email" 
                        id="Email" 
                        placeholder="อีเมล"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#5a56d3] focus:outline-none">
                    <span id="EmailError" class="text-red-500 text-sm"></span>
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">ตั้งรหัสผ่าน *</label>
                    <input 
                        type="password" 
                        name="Password" 
                        id="Password" 
                        placeholder="ตั้งรหัสผ่าน"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#5a56d3] focus:outline-none">
                    <span id="PasswordError" class="text-red-500 text-sm"></span>
                </div>

                {{-- Confirm Password --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">ยืนยันรหัสผ่าน *</label>
                    <input 
                        type="password" 
                        name="Password_confirmation" 
                        id="Password_confirmation" 
                        placeholder="ยืนยันรหัสผ่าน"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#5a56d3] focus:outline-none">
                    <span id="PasswordConfirmError" class="text-red-500 text-sm"></span>
                </div>

                {{-- ปุ่มสมัครสมาชิก --}}
                <button 
                    type="submit"
                    class="w-full bg-[#3e38c1] text-white py-2 rounded-lg font-semibold hover:bg-[#2b28a0] transition-all duration-200">
                    สมัครสมาชิก
                </button>
            </form>

            {{-- ลิงก์เข้าสู่ระบบ --}}
            <p class="text-center mt-5 text-sm text-gray-700">
                มีบัญชีอยู่แล้ว? 
                <a href="{{ route('login') }}" class="text-red-500 font-semibold hover:underline">เข้าสู่ระบบ</a>
            </p>
        </div>
    </div>
</div>

{{-- ตรวจสอบข้อมูลซ้ำ --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const username = document.getElementById('Username');
    const email = document.getElementById('Email');
    const password = document.getElementById('Password');
    const confirm = document.getElementById('Password_confirmation');

    // ตรวจ username ซ้ำ
    username.addEventListener('input', async () => {
        const res = await fetch(`/api/check-username?Username=${username.value}`);
        const data = await res.json();
        document.getElementById('UsernameError').textContent =
            data.exists ? 'ชื่อผู้ใช้นี้ถูกใช้แล้ว' : '';
    });

    // ตรวจ email ซ้ำ
    email.addEventListener('input', async () => {
        const res = await fetch(`/api/check-email?Email=${email.value}`);
        const data = await res.json();
        document.getElementById('EmailError').textContent =
            data.exists ? 'อีเมลนี้ถูกใช้แล้ว' : '';
    });

    // ตรวจ password
    password.addEventListener('input', () => {
        document.getElementById('PasswordError').textContent =
            password.value.length < 6 ? 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร' : '';
    });

    // ตรวจยืนยันรหัสผ่าน
    confirm.addEventListener('input', () => {
        document.getElementById('PasswordConfirmError').textContent =
            confirm.value !== password.value ? 'รหัสผ่านไม่ตรงกัน' : '';
    });
});
</script>
@endsection
