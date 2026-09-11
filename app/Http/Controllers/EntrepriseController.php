<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntrepriseController extends Controller
{
    /**
     * ---------------------------------------------------------------
     * CREATION DE L'ENTREPRISE
     * ---------------------------------------------------------------
     */
    public function create()
    {
        // Vérifier que l'utilisateur est connecté
        if (!session('id_utilisateur')) {
            return redirect()->route('login');
        }

        // Seul un indépendant peut créer son entreprise
        if (session('role') !== 'independant') {
            return redirect()->route('dashboard');
        }

        // Vérifier s'il possède déjà une entreprise
        $entreprise = DB::table('entreprises')
            ->where('id_utilisateur', session('id_utilisateur'))
            ->first();

        if ($entreprise) {
            return redirect()->route('entreprises.edit');
        }

        return view('entreprise.create');
    }


    /**
     * ---------------------------------------------------------------
     * ENREGISTRER UNE NOUVELLE ENTREPRISE
     * ---------------------------------------------------------------
     */
    public function store(Request $request)
    {
        // Vérifier la connexion
        if (!session('id_utilisateur')) {
            return redirect()->route('login');
        }

        // Vérifier le rôle
        if (session('role') !== 'independant') {
            abort(403);
        }

        // Validation
        $request->validate([
            'nom' => 'required|string|max:255',
            'forme_juridique' => 'required|string|max:100',
            'secteur_activite' => 'required|string|max:255',
            'adresse' => 'required|string|max:500',
            'ville' => 'required|string|max:100',
            'telephone' => 'required|string|max:50',

            'nom_commercial' => 'nullable|string|max:255',
            'date_creation' => 'nullable|date',
            'email' => 'nullable|email|max:255',
            'site_web' => 'nullable|string|max:255',
            'nif' => 'nullable|string|max:100',
            'stat' => 'nullable|string|max:100',
            'rcs' => 'nullable|string|max:100',
            'nom_banque' => 'nullable|string|max:255',
            'numero_compte' => 'nullable|string|max:255',
            'titulaire_compte' => 'nullable|string|max:255',
        ]);

        // Vérifier qu'il n'existe pas déjà une entreprise
        $existe = DB::table('entreprises')
            ->where('id_utilisateur', session('id_utilisateur'))
            ->exists();

        if ($existe) {
            return redirect()
                ->route('entreprises.edit')
                ->with('error', 'Vous avez déjà enregistré votre entreprise.');
        }

        // Enregistrer l'entreprise
        DB::table('entreprises')->insert([
            'id_utilisateur' => session('id_utilisateur'),

            'nom' => $request->nom,
            'nom_commercial' => $request->nom_commercial,
            'forme_juridique' => $request->forme_juridique,
            'secteur_activite' => $request->secteur_activite,
            'date_creation' => $request->date_creation,
            'adresse' => $request->adresse,
            'ville' => $request->ville,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'site_web' => $request->site_web,
            'nif' => $request->nif,
            'stat' => $request->stat,
            'rcs' => $request->rcs,
            'nom_banque' => $request->nom_banque,
            'numero_compte' => $request->numero_compte,
            'titulaire_compte' => $request->titulaire_compte,

            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Les informations de votre entreprise ont été enregistrées avec succès.'
            );
    }


    /**
     * ---------------------------------------------------------------
     * AFFICHER / MODIFIER L'ENTREPRISE
     * ---------------------------------------------------------------
     */
    public function edit()
    {
        // Vérifier la connexion
        if (!session('id_utilisateur')) {
            return redirect()->route('login');
        }

        $idUtilisateur = session('id_utilisateur');
        $role = session('role');

        /*
        |--------------------------------------------------------------------------
        | INDEPENDANT
        |--------------------------------------------------------------------------
        |
        | L'indépendant voit uniquement sa propre entreprise.
        |
        */

        if ($role === 'independant') {

            $entreprise = DB::table('entreprises')
                ->where('id_utilisateur', $idUtilisateur)
                ->first();

        } else {

            /*
            |--------------------------------------------------------------------------
            | ADMIN
            |--------------------------------------------------------------------------
            |
            | L'admin voit l'entreprise principale.
            |
            */

            $entreprise = DB::table('entreprises')
                ->first();
        }

        // Aucune entreprise trouvée
        if (!$entreprise) {

            if ($role === 'independant') {
                return redirect()
                    ->route('entreprises.create')
                    ->with(
                        'info',
                        'Veuillez d’abord enregistrer les informations de votre entreprise.'
                    );
            }

            return redirect()
                ->route('dashboard')
                ->with(
                    'error',
                    'Aucune entreprise n\'a encore été enregistrée.'
                );
        }

        return view(
            'entreprise.edit',
            compact('entreprise')
        );
    }


    /**
     * ---------------------------------------------------------------
     * METTRE À JOUR L'ENTREPRISE
     * ---------------------------------------------------------------
     */
    public function update(Request $request)
    {
        // Vérifier la connexion
        if (!session('id_utilisateur')) {
            return redirect()->route('login');
        }

        $idUtilisateur = session('id_utilisateur');
        $role = session('role');

        /*
        |--------------------------------------------------------------------------
        | Seuls admin et indépendant peuvent modifier
        |--------------------------------------------------------------------------
        */

        if (!in_array($role, ['admin', 'independant'])) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier ces informations.');
        }

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'forme_juridique' => 'required|string|max:100',
            'secteur_activite' => 'required|string|max:255',
            'adresse' => 'required|string|max:500',
            'ville' => 'required|string|max:100',
            'telephone' => 'required|string|max:50',

            'nom_commercial' => 'nullable|string|max:255',
            'date_creation' => 'nullable|date',
            'email' => 'nullable|email|max:255',
            'site_web' => 'nullable|url|max:255',
            'nif' => 'nullable|string|max:100',
            'stat' => 'nullable|string|max:100',
            'rcs' => 'nullable|string|max:100',
            'nom_banque' => 'nullable|string|max:255',
            'numero_compte' => 'nullable|string|max:255',
            'titulaire_compte' => 'nullable|string|max:255',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Trouver l'entreprise
        |--------------------------------------------------------------------------
        */

        if ($role === 'independant') {

            $entreprise = DB::table('entreprises')
                ->where('id_utilisateur', $idUtilisateur)
                ->first();

        } else {

            $entreprise = DB::table('entreprises')
                ->first();
        }

        if (!$entreprise) {
            abort(404, 'Entreprise introuvable.');
        }

        /*
        |--------------------------------------------------------------------------
        | Mise à jour
        |--------------------------------------------------------------------------
        */

        DB::table('entreprises')
            ->where('id_entreprise', $entreprise->id_entreprise)
            ->update([
                'nom' => $validated['nom'],
                'nom_commercial' => $validated['nom_commercial'] ?? null,
                'forme_juridique' => $validated['forme_juridique'],
                'secteur_activite' => $validated['secteur_activite'],
                'date_creation' => $validated['date_creation'] ?? null,
                'adresse' => $validated['adresse'],
                'ville' => $validated['ville'],
                'telephone' => $validated['telephone'],
                'email' => $validated['email'] ?? null,
                'site_web' => $validated['site_web'] ?? null,
                'nif' => $validated['nif'] ?? null,
                'stat' => $validated['stat'] ?? null,
                'rcs' => $validated['rcs'] ?? null,
                'nom_banque' => $validated['nom_banque'] ?? null,
                'numero_compte' => $validated['numero_compte'] ?? null,
                'titulaire_compte' => $validated['titulaire_compte'] ?? null,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('entreprises.edit')
            ->with(
                'success',
                'Les informations de l’entreprise ont été mises à jour avec succès.'
            );
    }
}