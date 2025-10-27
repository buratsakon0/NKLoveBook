@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-[80vh] bg-[#f8f9fa] px-4">
    <div class="bg-white shadow-xl rounded-2xl flex flex-col md:flex-row overflow-hidden w-full max-w-5xl min-h-[580px] items-stretch">

        {{-- Illustration panel --}}
        <div class="hidden md:flex w-1/2 bg-[#f2f2f2] justify-center items-center">
            <img
                src="{{ asset('images/Namkhaw_love_book.gif') }}"
                alt="Register Illustration"
                class="w-full h-full object-cover"
                style="object-position: center top;">
        </div>

        {{-- Form panel --}}
        <div class="w-full md:w-1/2 p-10 flex flex-col justify-center flex-1 bg-white">
            <h2 class="text-center text-2xl font-bold text-[#2b2b7b] mb-2">สมัครสมาชิก</h2>
            <p class="text-center text-sm text-gray-500 mb-8">สร้างบัญชีของคุณเพื่อเข้าถึงร้านหนังสือของน้ำข้าว</p>

            <form id="registerForm" method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Username --}}
                    <div>
                        <label for="Username" class="block text-sm font-semibold text-gray-700 mb-2">ชื่อผู้ใช้</label>
                        <input type="text" name="Username" id="Username"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#5a56d3] focus:outline-none"
                               placeholder="Username">
                        <p id="UsernameError" class="mt-1 text-xs text-red-500"></p>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="Email" class="block text-sm font-semibold text-gray-700 mb-2">อีเมล</label>
                        <input type="email" name="Email" id="Email"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#5a56d3] focus:outline-none"
                               placeholder="you@example.com">
                        <p id="EmailError" class="mt-1 text-xs text-red-500"></p>
                    </div>

                    {{-- First name --}}
                    <div>
                        <label for="Fname" class="block text-sm font-semibold text-gray-700 mb-2">ชื่อจริง</label>
                        <input type="text" name="Fname" id="Fname"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#5a56d3] focus:outline-none"
                               placeholder="ชื่อจริงของคุณ">
                        <p id="FnameError" class="mt-1 text-xs text-red-500"></p>
                    </div>

                    {{-- Last name --}}
                    <div>
                        <label for="Lname" class="block text-sm font-semibold text-gray-700 mb-2">นามสกุล</label>
                        <input type="text" name="Lname" id="Lname"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#5a56d3] focus:outline-none"
                               placeholder="นามสกุลของคุณ">
                        <p id="LnameError" class="mt-1 text-xs text-red-500"></p>
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label for="Password" class="block text-sm font-semibold text-gray-700 mb-2">รหัสผ่าน</label>
                    <input type="password" name="Password" id="Password"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#5a56d3] focus:outline-none"
                           placeholder="อย่างน้อย 6 ตัวอักษร">
                    <p id="PasswordError" class="mt-1 text-xs text-red-500"></p>
                </div>

                {{-- Confirm password --}}
                <div>
                    <label for="Password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">ยืนยันรหัสผ่าน</label>
                    <input type="password" name="Password_confirmation" id="Password_confirmation"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#5a56d3] focus:outline-none"
                           placeholder="ยืนยันรหัสผ่านอีกครั้ง">
                    <p id="PasswordConfirmError" class="mt-1 text-xs text-red-500"></p>
                </div>

                <button type="submit"
                        class="w-full bg-[#3e38c1] text-white py-2.5 rounded-lg font-semibold hover:bg-[#2b28a0] transition-all duration-200">
                    สมัครสมาชิก
                </button>
            </form>

            <p class="text-center mt-6 text-sm text-gray-600">
                มีบัญชีแล้วใช่ไหม?
                <a href="{{ route('login') }}" class="text-[#3e38c1] font-semibold hover:underline">เข้าสู่ระบบที่นี่</a>
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

    const usernameError = document.getElementById('UsernameError');
    const emailError = document.getElementById('EmailError');
    const passwordError = document.getElementById('PasswordError');
    const confirmError = document.getElementById('PasswordConfirmError');

    username.addEventListener('input', async () => {
        if (!username.value.trim()) {
            usernameError.textContent = 'กรุณากรอกชื่อผู้ใช้';
            return;
        }
        const res = await fetch(`/api/check-username?Username=${encodeURIComponent(username.value)}`);
        const data = await res.json();
        usernameError.textContent = data.exists ? 'ชื่อผู้ใช้นี้ถูกใช้แล้ว' : '';
    });

    email.addEventListener('input', async () => {
        if (!email.value.trim()) {
            emailError.textContent = 'กรุณากรอกอีเมล';
            return;
        }
        const res = await fetch(`/api/check-email?Email=${encodeURIComponent(email.value)}`);
        const data = await res.json();
        emailError.textContent = data.exists ? 'อีเมลนี้ถูกใช้แล้ว' : '';
    });

    password.addEventListener('input', () => {
        passwordError.textContent =
            password.value.length < 6 ? 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร' : '';
    });

    confirm.addEventListener('input', () => {
        confirmError.textContent =
            confirm.value !== password.value ? 'รหัสผ่านไม่ตรงกัน' : '';
    });
});
</script>
@endsection
