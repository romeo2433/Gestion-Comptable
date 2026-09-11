<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Afficher la page de connexion
    |--------------------------------------------------------------------------
    */
    public function login()
    {
        return view('auth.login');
    }


    /*
    |--------------------------------------------------------------------------
    | Afficher la page d'inscription
    |--------------------------------------------------------------------------
    */
    public function register()
    {
        return view('auth.register');
    }


    /*
    |--------------------------------------------------------------------------
    | Enregistrer un nouvel utilisateur
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email',
            'mot_de_passe' => 'required|string|min:4',
            'role' => 'required|in:caissier,independant',
        ]);

        $idUtilisateur = DB::table('utilisateurs')->insertGetId([
            'nom' => $request->nom,
            'email' => $request->email,
            'mot_de_passe' => $request->mot_de_passe,
            'role' => $request->role,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Connecter automatiquement l'utilisateur
        session([
            'id_utilisateur' => $idUtilisateur,
            'nom' => $request->nom,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        // Indépendant → informations entreprise
        if ($request->role === 'independant') {
            return redirect()->route('entreprise.create');
        }

        // Caissier → connexion/dashboard
        return redirect()
            ->route('login')
            ->with('success', 'Compte caissier créé avec succès.');
    }
    /*
    |--------------------------------------------------------------------------
    | Connexion
    |--------------------------------------------------------------------------
    */
    public function authenticate(Request $request)
    {
        // Validation
        $request->validate([
            'email' => 'required|email',
            'mot_de_passe' => 'required',
        ]);
    
    
        // Rechercher l'utilisateur avec son email
        $utilisateur = Utilisateur::where(
            'email',
            $request->email
        )->first();
    
    
        /*
        |--------------------------------------------------------------------------
        | Vérifier l'email
        |--------------------------------------------------------------------------
        */
        if (!$utilisateur) {
    
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Email incorrect.');
        }
    
    
        /*
        |--------------------------------------------------------------------------
        | Vérifier si le compte est désactivé
        |--------------------------------------------------------------------------
        */
        if ($utilisateur->statut !== 'actif') {
    
            return back()
                ->withInput($request->only('email'))
                ->with(
                    'error',
                    'Votre compte est désactivé. Veuillez contacter l’administrateur.'
                );
        }
    
    
        /*
        |--------------------------------------------------------------------------
        | Vérifier le mot de passe
        |--------------------------------------------------------------------------
        |
        | Pour le moment, nous gardons ton système sans Hash.
        |
        */
        if ($utilisateur->mot_de_passe != $request->mot_de_passe) {
    
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Mot de passe incorrect.');
        }
    
    
        /*
        |--------------------------------------------------------------------------
        | Régénérer la session
        |--------------------------------------------------------------------------
        */
        $request->session()->regenerate();
    
    
        /*
        |--------------------------------------------------------------------------
        | Enregistrer les informations dans la session
        |--------------------------------------------------------------------------
        */
        session([
            'id_utilisateur' => $utilisateur->id_utilisateur,
    
            'nom' => $utilisateur->nom,
    
            'email' => $utilisateur->email,
    
            'role' => $utilisateur->role,
        ]);
    
    
        /*
        |--------------------------------------------------------------------------
        | Redirection
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | Déconnexion
    |--------------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        /*
        | Supprimer les informations de l'utilisateur
        | de la session.
        */
        $request->session()->forget([
            'id_utilisateur',
            'nom',
            'email',
            'role',
        ]);


        /*
        | Invalider complètement la session.
        */
        $request->session()->invalidate();


        /*
        | Générer un nouveau token CSRF.
        */
        $request->session()->regenerateToken();


        /*
        | Retourner vers la page de connexion.
        */
        return redirect()
            ->route('login')
            ->with('success', 'Vous êtes déconnecté.');
    }
}