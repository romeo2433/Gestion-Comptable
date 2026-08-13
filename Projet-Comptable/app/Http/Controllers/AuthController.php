<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;

class AuthController extends Controller
{
    // Afficher le formulaire de connexion
    public function login()
    {
        return view('auth.login');
    }

    // Afficher le formulaire d'inscription
    public function register()
    {
        return view('auth.register');
    }

    // Inscription
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'email' => 'required|email|unique:utilisateurs,email',
            'mot_de_passe' => 'required|min:4',
            //'role' => 'required'
        ]);

        Utilisateur::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'mot_de_passe' => $request->mot_de_passe,
            'role' => 'caissier'
        ]);

        return redirect()->route('login')
            ->with('success', 'Compte créé avec succès.');
    }

    // Vérification de la connexion
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'mot_de_passe' => 'required'
        ]);

        $utilisateur = Utilisateur::where('email', $request->email)->first();

        if (!$utilisateur) {
            return back()->with('error', 'Email incorrect.');
        }

        // Vérification sans Hash
        if ($utilisateur->mot_de_passe != $request->mot_de_passe) {
            return back()->with('error', 'Mot de passe incorrect.');
        }

        session([
            'utilisateur' => $utilisateur
        ]);
        return redirect()->route('dashboard');
    }

    // Déconnexion
    public function logout()
    {
        session()->forget('utilisateur');

        return redirect()->route('login');
    }
}