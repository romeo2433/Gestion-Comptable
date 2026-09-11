<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier que l'utilisateur est connecté
        if (!session()->has('id_utilisateur')) {
            return redirect()->route('login');
        }

        // Vérifier que l'utilisateur est administrateur
        if (session('role') !== 'admin') {
            abort(403, 'Accès interdit.');
        }

        return $next($request);
    }
}