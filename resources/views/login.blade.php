@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen p-4 bg-gradient-to-b from-white to-gray-100">
    <div class="w-full max-w-md p-8 space-y-8 bg-white rounded-lg shadow-lg">
        <div class="flex justify-center">
            <img src="{{ asset('images/yo-network-logo.png') }}" class="h-20" alt="YoNetwork">
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <h2 class="text-3xl font-bold text-center text-yonetwork-purple">Connexion</h2>

            <div class="space-y-4">
                <!-- Email Input -->
                <div class="relative">
                    <input type="email" name="email" placeholder="Adresse email"
                        class="w-full pl-10 border-gray-300 focus:border-yonetwork-purple focus:ring-yonetwork-purple rounded-md" required>
                    <!-- Icône User -->
                </div>

                <!-- Password Input -->
                <div class="relative">
                    <input type="password" id="password" name="password" placeholder="Mot de passe"
                        class="w-full pl-10 pr-10 border-gray-300 focus:border-yonetwork-purple focus:ring-yonetwork-purple rounded-md" required>
                    <button type="button" class="toggle-password absolute inset-y-0 right-0 pr-3">
                        <svg class="h-5 w-5 text-gray-400"><!-- SVG Eye icon --></svg>
                    </button>
                </div>

                <!-- Remember Me -->
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="text-yonetwork-purple rounded">
                    <span class="ml-2 text-sm">Se souvenir de moi</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-yonetwork-purple to-yonetwork-green text-white py-2 rounded-md">
                Se connecter
            </button>

            <div class="flex justify-between text-sm">
                <a href="{{ route('password.request') }}" class="text-yonetwork-purple hover:underline">
                    Mot de passe oublié ?
                </a>
                <a href="{{ route('register') }}" class="text-yonetwork-purple hover:underline">
                    Créer un compte
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


















<!-- resources/views/auth/login.blade.php -->
<!-- @extends('layouts.app')
@section('content')
    <div class="min-h-screen flex items-center justify-center bg-white p-4">
        <div class="w-full max-w-md border border-gray-300 p-8">
            <div class="text-center mb-10">
                <h1 class="text-2xl font-bold tracking-wider">YONETWORK</h1>
            </div>

            <!- Login Form -->
            <!-- <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                Email Field
                <div class="relative">
                    <input id="email" class="w-full p-2 border border-gray-300 focus:outline-none focus:border-gray-500" type="email" name="email" value="{{ old('email') }}" required autofocus />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                Password Field
                <div class="relative">
                    <input id="password" class="w-full p-2 border border-gray-300 focus:outline-none focus:border-gray-500" type="password" name="password" required />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                Remember Me
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 border-gray-300 rounded" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember_me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                </div>

                <!- Login Button -->
                <!-- <div>
                    <button type="submit" class="w-full p-2 bg-white hover:bg-gray-50 text-black font-medium border border-gray-300 shadow focus:outline-none">
                        Log In
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endsection('content')   -->
<!-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'YONETWORK') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center bg-white p-4">
        <div class="w-full max-w-md border border-gray-300 p-8">
             Your login form content here -->
        <!-- </div>
    </div>
</body>
</html> -->