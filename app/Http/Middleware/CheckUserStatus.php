<?php

namespace App\Http\Middleware; // Namespace correct

use Closure;
use Illuminate\Http\Request;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status != 1) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Votre compte est bloqué.']);
        }

        return $next($request);
    }
}