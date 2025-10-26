@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<div class="container mx-auto my-12 px-4">
    <h2 class="text-3xl font-bold text-center mb-6 text-indigo-900">น้ำข้าวรักหนังสือ</h2>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <img src="{{ asset('images/Namkhaw_love_book.gif') }}" alt="Books" class="w-full h-72 object-cover">

        <div class="p-8">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Address</h3>
            <p class="text-blue-700 mb-6">
                49, Ta Khian Luean, Muang Nakhon Sawan, Nakhon Sawan, 60000
            </p>

            <h3 class="text-xl font-semibold mb-4 text-gray-800">Telephone</h3>
            <p class="text-blue-700 mb-6">(+66) 088-2547374</p>

            <h3 class="text-xl font-semibold mb-4 text-gray-800">E-Mail</h3>
            <p class="text-blue-700">NamkhawLoveBook@Gmail.Com</p>
        </div>
    </div>
</div>
@endsection
