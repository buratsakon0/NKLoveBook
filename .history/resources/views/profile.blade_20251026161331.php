@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex justify-center items-center bg-gradient-to-b from-indigo-50 to-white py-10 px-4">
    <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-xl border border-indigo-100">
        
        {{-- 🌸 ส่วนหัว --}}
        <div class="text-center mb-8">
            <div class="relative inline-block">
                <img 
                    src="{{ asset('images/default-profile.png') }}" 
                    alt="Profile Picture"
                    class="w-28 h-28 rounded-full border-4 border-indigo-200 shadow-sm object-cover mx-auto">
                <span class="absolute -bottom-1 right-0 bg-green-400 w-4 h-4 rounded-full border-2 border-white"></span>
            </div>
            <h2 class="text-2xl font-bold text-indigo-700 mt-4">{{ $user->Username }}</h2>
            <p class="text-gray-500 text-sm mt-1">✨ ยินดีต้อนรับสู่ น้ำข้าวรักหนังสือ ✨</p>
        </div>

        {{-- 🧾 ข้อมูลบัญชี --}}
        <div class="border border-indigo-200 rounded-xl p-6 bg-indigo-50/40">
            <h3 class="text-lg font-bold text-indigo-800 mb-4 border-b border-indigo-200 pb-2">
                ข้อมูลบัญชี
            </h3>

            <div class="space-y-3 text-gray-700 text-[15px]">
                <p><strong class="text-indigo-700">ชื่อผู้ใช้:</strong> {{ $user->Username }}</p>
                <p><strong class="text-indigo-700">อีเมล:</strong> {{ $user->Email }}</p>
                <p><strong class="text-indigo-700">ชื่อ-นามสกุล:</strong> {{ $user->Fname ?? '-' }} {{ $user->Lname ?? '-' }}</p>
                <p><strong class="text-indigo-700">วันที่สมัคร:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        {{-- 🚪 ปุ่มออกจากระบบ --}}
        <div class="mt-8 flex justify-center">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white px-6 py-2.5 rounded-lg font-medium shadow-md transition duration-200 ease-in-out">
                    <i class="fa fa-sign-out-alt mr-1"></i> ออกจากระบบ
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
