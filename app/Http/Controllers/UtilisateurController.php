<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UtilisateurController extends Controller
{
    /**
     * Afficher la liste des utilisateurs
     */
    public function index()
    {
        $utilisateurs = DB::table('utilisateurs')
            ->orderBy('nom')
            ->get();

        return view('utilisateurs.index', compact('utilisateurs'));
    }


    /**
     * Formulaire d'ajout
     */
    public function create()
    {
        return view('utilisateurs.create');
    }


    /**
     * Enregistrer un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:150',

            'email' => [
                'required',
                'email',
                'max:100',
                'unique:utilisateurs,email',
            ],

            'mot_de_passe' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                'in:admin,caissier,independant',
            ],
        ], [
            'nom.required' => 'Le nom est obligatoire.',

            'email.required' => 'L’adresse email est obligatoire.',
            'email.email' => 'L’adresse email doit être valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',

            'mot_de_passe.required' => 'Le mot de passe est obligatoire.',
            'mot_de_passe.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'mot_de_passe.confirmed' => 'Les mots de passe ne correspondent pas.',

            'role.required' => 'Le rôle est obligatoire.',
            'role.in' => 'Le rôle sélectionné est invalide.',
        ]);

        DB::table('utilisateurs')->insert([
            'nom' => trim($request->nom),
            'email' => strtolower(trim($request->email)),
            'mot_de_passe' => Hash::make($request->mot_de_passe),
            'role' => $request->role,
            'statut' => 'actif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('utilisateurs.index')
            ->with('success', 'Utilisateur ajouté avec succès.');
    }


    /**
     * Formulaire de modification
     */
    public function edit($id)
    {
        $utilisateur = DB::table('utilisateurs')
            ->where('id_utilisateur', $id)
            ->first();

        if (!$utilisateur) {
            return redirect()
                ->route('utilisateurs.index')
                ->with('error', 'Utilisateur introuvable.');
        }

        return view('utilisateurs.edit', compact('utilisateur'));
    }


    /**
     * Modifier un utilisateur
     */
    public function update(Request $request, $id)
    {
        $utilisateur = DB::table('utilisateurs')
            ->where('id_utilisateur', $id)
            ->first();

        if (!$utilisateur) {
            return redirect()
                ->route('utilisateurs.index')
                ->with('error', 'Utilisateur introuvable.');
        }

        $request->validate([
            'nom' => 'required|string|max:150',

            'email' => [
                'required',
                'email',
                'max:100',
                'unique:utilisateurs,email,' . $id . ',id_utilisateur',
            ],

            'role' => [
                'required',
                'in:admin,caissier,independant',
            ],

            'mot_de_passe' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'nom.required' => 'Le nom est obligatoire.',

            'email.required' => 'L’adresse email est obligatoire.',
            'email.email' => 'L’adresse email doit être valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',

            'role.required' => 'Le rôle est obligatoire.',
            'role.in' => 'Le rôle sélectionné est invalide.',

            'mot_de_passe.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'mot_de_passe.confirmed' => 'Les mots de passe ne correspondent pas.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Empêcher l'admin de modifier son propre rôle
        |--------------------------------------------------------------------------
        */

        $idConnecte = session('id_utilisateur');

        if ((int) $id === (int) $idConnecte) {
            $role = $utilisateur->role;
        } else {
            $role = $request->role;
        }

        $donnees = [
            'nom' => trim($request->nom),
            'email' => strtolower(trim($request->email)),
            'role' => $role,
            'updated_at' => now(),
        ];

        /*
        |--------------------------------------------------------------------------
        | Changer le mot de passe seulement s'il est renseigné
        |--------------------------------------------------------------------------
        */

        if ($request->filled('mot_de_passe')) {
            $donnees['mot_de_passe'] = Hash::make(
                $request->mot_de_passe
            );
        }

        DB::table('utilisateurs')
            ->where('id_utilisateur', $id)
            ->update($donnees);

        return redirect()
            ->route('utilisateurs.index')
            ->with('success', 'Utilisateur modifié avec succès.');
    }


    /**
     * Activer / désactiver un utilisateur
     */
    public function toggleStatut($id)
    {
        $utilisateur = DB::table('utilisateurs')
            ->where('id_utilisateur', $id)
            ->first();

        if (!$utilisateur) {
            return redirect()
                ->route('utilisateurs.index')
                ->with('error', 'Utilisateur introuvable.');
        }

        /*
        |--------------------------------------------------------------------------
        | Empêcher l'admin de désactiver son propre compte
        |--------------------------------------------------------------------------
        */

        if ((int) $id === (int) session('id_utilisateur')) {
            return redirect()
                ->route('utilisateurs.index')
                ->with('error', 'Vous ne pouvez pas désactiver votre propre compte.');
        }

        $nouveauStatut = $utilisateur->statut === 'actif'
            ? 'desactive'
            : 'actif';

        DB::table('utilisateurs')
            ->where('id_utilisateur', $id)
            ->update([
                'statut' => $nouveauStatut,
                'updated_at' => now(),
            ]);

        $message = $nouveauStatut === 'actif'
            ? 'Utilisateur activé avec succès.'
            : 'Utilisateur désactivé avec succès.';

        return redirect()
            ->route('utilisateurs.index')
            ->with('success', $message);
    }


    /**
     * Supprimer un utilisateur
     */
    public function destroy($id)
    {
        /*
        |--------------------------------------------------------------------------
        | Empêcher la suppression de son propre compte
        |--------------------------------------------------------------------------
        */

        if ((int) $id === (int) session('id_utilisateur')) {
            return redirect()
                ->route('utilisateurs.index')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $utilisateur = DB::table('utilisateurs')
            ->where('id_utilisateur', $id)
            ->first();

        if (!$utilisateur) {
            return redirect()
                ->route('utilisateurs.index')
                ->with('error', 'Utilisateur introuvable.');
        }

        /*
        |--------------------------------------------------------------------------
        | Vérifier si l'utilisateur possède des factures
        |--------------------------------------------------------------------------
        */

        $aDesFactures = DB::table('factures')
            ->where('id_utilisateur', $id)
            ->exists();

        if ($aDesFactures) {
            return redirect()
                ->route('utilisateurs.index')
                ->with(
                    'error',
                    'Impossible de supprimer cet utilisateur car il possède des factures enregistrées. Désactivez plutôt son compte.'
                );
        }

        DB::table('utilisateurs')
            ->where('id_utilisateur', $id)
            ->delete();

        return redirect()
            ->route('utilisateurs.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
}