<!DOCTYPE html>
<html lang="th">
<head>
    <!-- Google Font: Itim -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
    body {
         font-family: "Mitr", sans-serif;
    }
    </style>

    <title>น้ำข้าวรักหนังสือ</title>

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body class="bg-gray-50 text-gray-900">
    @include('component.navbar')

    <main>
        @yield('content')
    </main>

    

</body>
</html>
