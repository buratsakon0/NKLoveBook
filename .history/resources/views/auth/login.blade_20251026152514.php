@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-[85vh] bg-gray-50 px-6">
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden flex flex-col md:flex-row w-full max-w-5xl">

        {{-- 🌸 ภาพประกอบด้านซ้าย --}}
        <div class="hidden md:flex w-1/2 bg-gray-100 justify-center items-center">
            <img src="{{ asset('images/login-illustration.jpg') }}" alt="Login Illustration" class="w-full h-full object-cover">
        </div>

        {{-- 🪄 ฟอร์มเข้าสู่ระบบด้านขวา --}}
        <div class="w-full md:w-1/2 p-10 flex flex-col justify-center">
            <a href="{{ url()->previous() }}" class="text-sm text-gray-400 hover:text-indigo-500 mb-4 inline-flex items-center gap-1">
                <i class="fa fa-arrow-left"></i> ย้อนกลับ
            </a>

            <h2 class="text-center text-2xl font-bold text-indigo-800 mb-6">เข้าสู่ระบบ</h2>

            {{-- ข้อความ error --}}
            @if ($errors->has('login_error'))
                <div class="bg-red-100 text-red-600 p-3 rounded mb-4 text-center">
                    {{ $errors->first('login_error') }}
                </div>
            @endif

            {{-- ฟอร์มเข้าสู่ระบบ --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2 text-gray-700">ชื่อผู้ใช้หรืออีเมล</label>
                    <input
                        type="text"
                        name="Username"
                        value="{{ old('Username') }}"
                        placeholder="ชื่อผู้ใช้หรืออีเมล"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2 text-gray-700">รหัสผ่าน</label>
                    <input
                        type="password"
                        name="Password"
                        placeholder="รหัสผ่าน"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        required>
                </div>

                <button
                    type="submit"
                    class="w-full bg-indigo-700 text-white py-2 rounded-lg font-semibold hover:bg-indigo-800 transition-all duration-200">
                    เข้าสู่ระบบ
                </button>
            </form>

            <p class="text-center mt-5 text-sm text-gray-700">
                สมัครสมาชิกใหม่ <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:underline">สมัครที่นี่</a>
            </p>
        </div>
    </div>
</div>
@endsection
