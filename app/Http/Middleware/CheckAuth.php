<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!session()->has('id_utilisateur')) {
            return redirect()
                ->route('login')
                ->with('error', 'Veuillez vous connecter.');
        }

        return $next($request);
    }
}