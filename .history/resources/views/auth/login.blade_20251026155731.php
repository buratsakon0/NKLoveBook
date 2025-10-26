@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-[90vh] bg-[#f8f9fa] px-4">
    <div class="bg-white shadow-xl rounded-2xl flex flex-col md:flex-row overflow-hidden w-full max-w-4xl">

        {{-- 🌸 ภาพประกอบด้านซ้าย --}}
        <div class="hidden md:flex w-1/2 bg-[#f2f2f2] justify-center items-center">
            <img
                src="{{ asset('images/login-illustration.jpg') }}"
                alt="Login Illustration"
                class="w-full h-full object-cover"
                style="object-position: center top;">
        </div>

        {{-- 🪄 ฟอร์มเข้าสู่ระบบ --}}
        <div class="w-full md:w-1/2 p-10 flex flex-col justify-center">
            

            <h2 class="text-center text-2xl font-bold text-[#2b2b7b] mb-6">เข้าสู่ระบบ</h2>

            @if ($errors->has('login_error'))
                <div class="bg-red-100 text-red-600 p-3 rounded mb-4 text-center">
                    {{ $errors->first('login_error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Username --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2 text-gray-700">ชื่อผู้ใช้หรืออีเมล</label>
                    <input
                        type="text"
                        name="Username"
                        value="{{ old('Username') }}"
                        placeholder="ชื่อผู้ใช้หรืออีเมล"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#5a56d3] focus:outline-none"
                        required>
                </div>

                {{-- Password --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2 text-gray-700">รหัสผ่าน</label>
                    <input
                        type="password"
                        name="Password"
                        placeholder="รหัสผ่าน"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#5a56d3] focus:outline-none"
                        required>
                </div>

                <button
                    type="submit"
                    class="w-full bg-[#3e38c1] text-white py-2 rounded-lg font-semibold hover:bg-[#2b28a0] transition-all duration-200">
                    เข้าสู่ระบบ
                </button>
            </form>

            <p class="text-center mt-5 text-sm text-gray-700">
                สมัครสมาชิกใหม่ <a href="{{ route('register') }}" class="text-[#3e38c1] font-semibold hover:underline">สมัครที่นี่</a>
            </p>
        </div>
    </div>
</div>
@endsection
