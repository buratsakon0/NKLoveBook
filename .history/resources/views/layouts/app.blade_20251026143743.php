<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>น้ำข้าวรักหนังสือ</title>

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body class="bg-gray-50 text-gray-900">
    @include('component.navbar')

    <main>
        @yield('content')
    </main>

    @guest
    <a href="{{ route('login') }}" class="text-sm text-indigo-700 font-semibold">ACCOUNT</a>
@endguest

@auth
    <div class="flex items-center gap-3">
        <span class="text-sm font-semibold text-gray-700">
            👤 {{ Auth::user()->Username }}
        </span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-red-500 hover:text-red-700">Logout</button>
        </form>
    </div>
@endauth

</body>
</html>

