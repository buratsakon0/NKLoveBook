@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-8 rounded-xl shadow">
    <h2 class="text-center text-2xl font-bold text-indigo-700 mb-6">สมัครสมาชิก</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label class="block text-sm font-semibold mb-2">ชื่อผู้ใช้</label>
            <input type="text" name="Username" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block text-sm font-semibold mb-2">ชื่อจริง</label>
            <input type="text" name="Fname" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block text-sm font-semibold mb-2">นามสกุล</label>
            <input type="text" name="Lname" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block text-sm font-semibold mb-2">อีเมล</label>
            <input type="email" name="Email" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label class="block text-sm font-semibold mb-2">รหัสผ่าน</label>
            <input type="password" name="Password" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">ยืนยันรหัสผ่าน</label>
            <input type="password" name="Password_confirmation" class="w-full border rounded-lg px-3 py-2" required>
        </div>

        <button class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">สมัครสมาชิก</button>
    </form>

    <p class="text-center mt-4 text-sm">มีบัญชีแล้ว? 
        <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">เข้าสู่ระบบ</a>
    </p>
</div>
@endsection
