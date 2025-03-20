<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        if (Auth::check()) {
            // Si déjà connecté, éviter la boucle
            if (Auth::user()->isAdmin()) {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/teleconseiller/dashboard');
            }
        }
        
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Vérifier que l'authentification a réussi
        if (Auth::check()) {
            // Rediriger en fonction du rôle de l'utilisateur
            $role = Auth::user()->role; // Récupérer directement le rôle
            // Récupérer les identifiants
    $credentials = $request->only('email', 'password');

    // Tenter de connecter l'utilisateur
    if (Auth::attempt($credentials)) {
        // Vérifier si le compte est actif
        if (Auth::user()->status != 1) {
            Auth::logout(); // Déconnecter l'utilisateur bloqué
            return redirect()->route('login')
                ->withErrors(['email' => 'Votre compte est bloqué. Contactez l\'administrateur.']);
        }

        // Rediriger l'utilisateur actif
        return redirect()->intended('/teleconseiller/dashboard');
    }

            if ($role === 'admin') {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/teleconseiller/dashboard');
            }
        }
        
        // Si l'authentification a échoué d'une manière ou d'une autre
        return redirect('/login')->withErrors(['email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.']);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
