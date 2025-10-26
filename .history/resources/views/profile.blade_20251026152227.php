@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow">
    <div class="flex flex-col items-center mb-6">
        <h2 class="mt-3 text-lg text-indigo-600 font-semibold">✨ ยินดีต้อนรับ ✨</h2>
    </div>

    <div class="border border-blue-400 rounded-xl p-6">
        <h3 class="text-lg font-bold text-blue-700 mb-4 border-b pb-2">ข้อมูลบัญชี</h3>

        <div class="space-y-2 text-gray-700">
            <p><strong>ชื่อผู้ใช้:</strong> {{ $user->Username }}</p>
            <p><strong>อีเมล:</strong> {{ $user->Email }}</p>
            <p><strong>ชื่อ-นามสกุล:</strong> {{ $user->Fname ?? '-' }} {{ $user->Lname ?? '-' }}</p>
            <p><strong>วันที่สมัคร:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
        </div>

        <div class="mt-6 flex justify-end gap-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                    ออกจากระบบ
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
