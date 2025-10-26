@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-8 rounded-xl shadow">
    <h2 class="text-center text-2xl font-bold text-indigo-700 mb-6">สมัครสมาชิก</h2>

    {{-- ✅ ส่วนแสดงข้อความเตือน --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">ชื่อผู้ใช้</label>
            <input type="text" name="Username" value="{{ old('Username') }}" class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">ชื่อจริง</label>
            <input type="text" name="Fname" value="{{ old('Fname') }}" class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">นามสกุล</label>
            <input type="text" name="Lname" value="{{ old('Lname') }}" class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">อีเมล</label>
            <input type="email" name="Email" value="{{ old('Email') }}" class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">รหัสผ่าน</label>
            <input type="password" name="Password" class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">ยืนยันรหัสผ่าน</label>
            <input type="password" name="Password_confirmation" class="w-full border rounded-lg px-3 py-2">
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
            สมัครสมาชิก
        </button>
    </form>
</div>
@endsection
