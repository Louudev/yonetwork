@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen p-4 bg-gradient-to-b from-white to-gray-100">
    <div class="w-full max-w-md p-8 space-y-8 bg-white rounded-lg shadow-lg">
        <div class="flex justify-center">
            <img src="{{ asset('images/yo-network-logo.png') }}" class="h-20" alt="YoNetwork">
        </div>

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf
            <h2 class="text-3xl font-bold text-center text-yonetwork-purple">Mot de passe oublié</h2>

            <div class="space-y-4">
                <input type="email" name="email" placeholder="Adresse email" required
                    class="w-full pl-10 border-gray-300 focus:border-yonetwork-purple focus:ring-yonetwork-purple rounded-md">
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-yonetwork-purple to-yonetwork-green text-white py-2 rounded-md">
                Réinitialiser le mot de passe
            </button>

            <div class="text-center text-sm">
                <a href="{{ route('login') }}" class="text-yonetwork-purple hover:underline">
                    Retour à la connexion
                </a>
            </div>
        </form>
    </div>
</div>
@endsection