<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $role = session('role');
        $idUtilisateur = session('id_utilisateur');

        if (!$idUtilisateur) {
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | Nombre de caissiers
        |--------------------------------------------------------------------------
        */
        $nombreCaissiers = 0;

        if ($role === 'admin') {
            $nombreCaissiers = DB::table('utilisateurs')
                ->where('role', 'caissier')
                ->count();
        }

        /*
        |--------------------------------------------------------------------------
        | Base de la requête des factures
        |--------------------------------------------------------------------------
        */
        $facturesBase = DB::table('factures as f')
            ->join(
                'utilisateurs as u',
                'f.id_utilisateur',
                '=',
                'u.id_utilisateur'
            );

        if ($role === 'admin') {

            // L'admin ne voit pas les factures des indépendants
            $facturesBase->where('u.role', '!=', 'independant');

        } else {

            // Caissier et indépendant voient uniquement leurs factures
            $facturesBase->where(
                'f.id_utilisateur',
                $idUtilisateur
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Nombre de factures de vente
        |--------------------------------------------------------------------------
        */
        $nombreFacturesVente = (clone $facturesBase)
            ->where('f.type', 'vente')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Nombre de factures d'achat
        |--------------------------------------------------------------------------
        */
        $nombreFacturesAchat = (clone $facturesBase)
            ->where('f.type', 'achat')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Factures impayées
        |--------------------------------------------------------------------------
        */
        $impayees = DB::table('factures as f')
            ->leftJoin(
                'paiements as p',
                'f.id_facture',
                '=',
                'p.id_facture'
            )
            ->join(
                'utilisateurs as u',
                'f.id_utilisateur',
                '=',
                'u.id_utilisateur'
            )
            ->select(
                'f.id_facture',
                'f.montant_ttc'
            )
            ->selectRaw(
                'COALESCE(SUM(p.montant), 0) as total_paye'
            )
            ->groupBy(
                'f.id_facture',
                'f.montant_ttc'
            );

        if ($role === 'admin') {

            $impayees->where(
                'u.role',
                '!=',
                'independant'
            );

        } else {

            $impayees->where(
                'f.id_utilisateur',
                $idUtilisateur
            );
        }

        $nombreImpayees = $impayees
            ->havingRaw('total_paye < f.montant_ttc')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Graphique ADMIN
        |--------------------------------------------------------------------------
        |
        | On compte uniquement les factures.
        | Aucun montant n'est récupéré.
        |
        */
        $labelsGraphique = [];
        $ventesCaissiers = [];
        $achatsCaissiers = [];
        $ventesIndependants = [];
        $achatsIndependants = [];

        if ($role === 'admin') {

            // 12 derniers mois
            $dateDebut = Carbon::now()
                ->startOfMonth()
                ->subMonths(11);

            $dateFin = Carbon::now()
                ->endOfMonth();


            /*
            |--------------------------------------------------------------------------
            | Récupération des factures pour le graphique
            |--------------------------------------------------------------------------
            */

            $facturesGraphique = DB::table('factures as f')
            ->join(
                'utilisateurs as u',
                'f.id_utilisateur',
                '=',
                'u.id_utilisateur'
            )
            ->whereIn('u.role', ['caissier', 'independant'])
            ->whereIn('f.type', ['vente', 'achat'])
            ->select(
                DB::raw('YEAR(f.created_at) as annee'),
                DB::raw('MONTH(f.created_at) as mois'),
                'u.role',
                'f.type',
                DB::raw('COUNT(f.id_facture) as total')
            )
            ->groupBy(
                DB::raw('YEAR(f.created_at)'),
                DB::raw('MONTH(f.created_at)'),
                'u.role',
                'f.type'
            )
            ->orderBy('annee')
            ->orderBy('mois')
            ->get();


            /*
            |--------------------------------------------------------------------------
            | Préparation des 12 mois
            |--------------------------------------------------------------------------
            */

            for ($i = 0; $i < 12; $i++) {

                $date = $dateDebut->copy()->addMonths($i);

                $annee = $date->year;
                $mois = $date->month;

                $labelsGraphique[] = $date->translatedFormat('M Y');

                $ventesCaissiers[] = 0;
                $achatsCaissiers[] = 0;
                $ventesIndependants[] = 0;
                $achatsIndependants[] = 0;


                /*
                |--------------------------------------------------------------------------
                | Chercher les données du mois
                |--------------------------------------------------------------------------
                */

                foreach ($facturesGraphique as $facture) {

                    if (
                        (int) $facture->annee === $annee &&
                        (int) $facture->mois === $mois
                    ) {

                        if (
                            $facture->role === 'caissier' &&
                            $facture->type === 'vente'
                        ) {

                            $ventesCaissiers[$i] = (int) $facture->total;

                        } elseif (
                            $facture->role === 'caissier' &&
                            $facture->type === 'achat'
                        ) {

                            $achatsCaissiers[$i] = (int) $facture->total;

                        } elseif (
                            $facture->role === 'independant' &&
                            $facture->type === 'vente'
                        ) {

                            $ventesIndependants[$i] = (int) $facture->total;

                        } elseif (
                            $facture->role === 'independant' &&
                            $facture->type === 'achat'
                        ) {

                            $achatsIndependants[$i] = (int) $facture->total;
                        }
                    }
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Envoi vers la vue
        |--------------------------------------------------------------------------
        */

        return view('dashboard.index', compact(

            'nombreCaissiers',

            'nombreFacturesVente',

            'nombreFacturesAchat',

            'nombreImpayees',

            'labelsGraphique',

            'ventesCaissiers',

            'achatsCaissiers',

            'ventesIndependants',

            'achatsIndependants'

        ));
    }
}