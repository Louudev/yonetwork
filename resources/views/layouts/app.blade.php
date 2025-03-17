<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>YoNetwork</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @yield('content')
</body>
</html>






<!-- resources/views/layouts/app.blade.php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>YONETWORK</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-white">
    <div class="min-h-screen">
        <!- Only show login/register links at the top, no back arrow -->
        <!-- <nav class="py-2 px-4 flex justify-end">
            @if (Route::has('login') && Route::current()->getName() != 'login')
                <a href="{{ route('login') }}" class="mr-4">Login</a>
            @endif
            @if (Route::has('register') && Route::current()->getName() != 'register')
                <a href="{{ route('register') }}">Register</a>
            @endif
        </nav>

        <main>
            @yield('content')
        </main>
    </div>
</body>
</html> --> 