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
