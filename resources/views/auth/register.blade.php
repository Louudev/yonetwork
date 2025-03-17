
@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen p-4 bg-gradient-to-b from-white to-gray-100">
    <div class="w-full max-w-md p-8 space-y-8 bg-white rounded-lg shadow-lg">
        <div class="flex justify-center">
            <img src="{{ asset('images/yo-network-logo.png') }}" class="h-20" alt="YoNetwork">
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf
            <h2 class="text-3xl font-bold text-center text-yonetwork-purple">Inscription</h2>

            <div class="space-y-4">
                <!-- Name Input -->
                <input type="text" name="name" placeholder="Nom complet" required
                    class="w-full pl-10 border-gray-300 focus:border-yonetwork-purple focus:ring-yonetwork-purple rounded-md">

                <!-- Email Input -->
                <input type="email" name="email" placeholder="Adresse email" required
                    class="w-full pl-10 border-gray-300 focus:border-yonetwork-purple focus:ring-yonetwork-purple rounded-md">

                <!-- Password Input -->
                <div class="relative">
                    <input type="password" name="password" placeholder="Mot de passe" required
                        class="w-full pl-10 pr-10 border-gray-300 focus:border-yonetwork-purple focus:ring-yonetwork-purple rounded-md">
                    <button type="button" class="toggle-password absolute inset-y-0 right-0 pr-3">
                        <svg class="h-5 w-5 text-gray-400"><!-- SVG Eye icon --></svg>
                    </button>
                </div>

                <!-- Confirm Password -->
                <input type="password" name="password_confirmation" placeholder="Confirmer le mot de passe" required
                    class="w-full pl-10 border-gray-300 focus:border-yonetwork-purple focus:ring-yonetwork-purple rounded-md">

                <!-- Terms Checkbox -->
                <label class="flex items-center">
                    <input type="checkbox" name="terms" required class="text-yonetwork-purple rounded">
                    <span class="ml-2 text-sm">J'accepte les termes et conditions</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-yonetwork-purple to-yonetwork-green text-white py-2 rounded-md">
                S'inscrire
            </button>

            <div class="text-center text-sm">
                <a href="{{ route('login') }}" class="text-yonetwork-purple hover:underline">
                    Vous avez déjà un compte ? Se connecter
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

<!-- resources/views/auth/register.blade.php -->
<!-- @extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-white p-4">
    <div class="w-full max-w-md p-6 border border-gray-300 rounded">
        <div class="text-center mb-6">
            <img src="{{ asset('logo.png') }}" alt="YONETWORK" class="h-16 mx-auto">
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <input id="name" class="w-full p-2 border border-gray-300" 
                       type="text" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus />
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <input id="email" class="w-full p-2 border border-gray-300" 
                       type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required />
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <input id="password" class="w-full p-2 border border-gray-300" 
                       type="password" name="password" placeholder="Password" required />
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <input id="password-confirm" class="w-full p-2 border border-gray-300" 
                       type="password" name="password_confirmation" placeholder="Confirm Password" required />
            </div>

            <div class="mb-4">
                <button type="submit" class="w-full p-2 bg-white hover:bg-gray-50 text-black border border-gray-300">
                    Register
                </button>
            </div>
        </form>
    </div>
</div>
@endsection -->