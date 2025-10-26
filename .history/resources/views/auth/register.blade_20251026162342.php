@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-[90vh] bg-[#f8f9fa] px-4">
    <div class="bg-white shadow-lg rounded-2xl flex flex-col md:flex-row overflow-hidden w-full max-w-5xl">

        {{-- 🌸 ภาพประกอบด้านซ้าย --}}
        <div class="hidden md:flex w-1/2 bg-gray-100 justify-center items-center">
            <img
                src="{{ asset('images/login-illustration.jpg') }}"
                alt="Register Illustration"
                class="w-full h-full object-cover"
                style="object-position: center top;">
        </div>

        {{-- 🪄 ฟอร์มสมัครสมาชิก --}}
        <div class="w-full md:w-1/2 p-10 flex flex-col justify-center">
            <a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-indigo-500 mb-4 inline-flex items-center gap-1">
                <i class="fa fa-arrow-left"></i> ย้อนกลับ
            </a>

            <h2 class="text-center text-2xl font-bold text-indigo-800 mb-6">สมัครสมาชิก</h2>

            <form id="registerForm" method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Username --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">ชื่อผู้ใช้ *</label>
                    <input type="text" name="Username" id="Username"
                        placeholder="ตั้งชื่อผู้ใช้งาน"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                    <span id="UsernameError" class="text-red-500 text-sm"></span>
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">อีเมล *</label>
                    <input type="email" name="Email" id="Email"
                        placeholder="อีเมล"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                    <span id="EmailError" class="text-red-500 text-sm"></span>
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">ตั้งรหัสผ่าน *</label>
                    <input type="password" name="Password" id="Password"
                        placeholder="ตั้งรหัสผ่าน"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                    <span id="PasswordError" class="text-red-500 text-sm"></span>
                </div>

                {{-- Confirm Password --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">ยืนยันรหัสผ่าน *</label>
                    <input type="password" name="Password_confirmation" id="Password_confirmation"
                        placeholder="ยืนยันรหัสผ่าน"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                    <span id="PasswordConfirmError" class="text-red-500 text-sm"></span>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-700 text-white py-2 rounded-lg font-semibold hover:bg-indigo-800 transition-all duration-200">
                    สมัครสมาชิก
                </button>
            </form>

            <p class="text-center mt-5 text-sm text-gray-700">
                มีบัญชีแล้ว <a href="{{ route('login') }}" class="text-red-500 font-semibold hover:underline">เข้าสู่ระบบ</a>
            </p>
        </div>
    </div>
</div>

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
