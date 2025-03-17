<!-- resources/views/auth/login.blade.php -->
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-white p-4">
    <div class="w-full max-w-md p-6 border border-gray-300 rounded">
        <div class="text-center mb-6">
            <img src="{{ asset('logo.png') }}" alt="YONETWORK" class="h-16 mx-auto">
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <input id="email" class="w-full p-2 border border-gray-300" 
                       type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus />
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
                <label class="flex items-center">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="mr-2">
                    <span>Remember me</span>
                </label>
            </div>

            <div class="mb-4">
                <button type="submit" class="w-full p-2 bg-white hover:bg-gray-50 text-black border border-gray-300">
                    Log In
                </button>
            </div>

            <div class="text-center">
                <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">
                    Forgot Your Password?
                </a>
            </div>
        </form>
    </div>
</div>
@endsection