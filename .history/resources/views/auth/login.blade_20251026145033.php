@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-8 rounded-xl shadow">
    <h2 class="text-center text-2xl font-bold text-indigo-700 mb-6">เข้าสู่ระบบ</h2>

    {{-- 🟥 แสดงข้อความ error กรณี login ไม่สำเร็จ --}}
    @if ($errors->has('login_error'))
        <div class="bg-red-100 text-red-600 p-3 rounded mb-4 text-center">
            {{ $errors->first('login_error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">ชื่อผู้ใช้</label>
            <input type="text" name="Username" value="{{ old('Username') }}" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">รหัสผ่าน</label>
            <input type="password" name="Password" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        <button class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
            เข้าสู่ระบบ
        </button>
    </form>

    <p class="text-center mt-4 text-sm">
        ยังไม่มีบัญชี? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">สมัครที่นี่</a>
    </p>
</div>
@endsection
