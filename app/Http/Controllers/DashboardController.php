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
        | Filtre département
        |--------------------------------------------------------------------------
        */

        $departementSelectionne = request('departement');

        /*
        |--------------------------------------------------------------------------
        | Liste des départements
        |--------------------------------------------------------------------------
        */

        $departements = collect();

        if ($role === 'admin') {

            $departements = DB::table('departements')
                ->orderBy('nom')
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Nombre de caissiers
        |--------------------------------------------------------------------------
        */

        $nombreCaissiers = 0;

        if ($role === 'admin') {

            $requeteCaissiers = DB::table('utilisateurs as u')
                ->where('u.role', 'caissier');

            /*
            | Filtre département
            */

            if (!empty($departementSelectionne)) {

                $requeteCaissiers->where(
                    'u.id_departement',
                    $departementSelectionne
                );
            }

            $nombreCaissiers = $requeteCaissiers->count();
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


        /*
        |--------------------------------------------------------------------------
        | Gestion des droits
        |--------------------------------------------------------------------------
        */

        if ($role === 'admin') {

            /*
            | L'admin ne voit pas les indépendants
            */

            $facturesBase->where(
                'u.role',
                '!=',
                'independant'
            );


            /*
            | Filtre département
            */

            if (!empty($departementSelectionne)) {

                $facturesBase->where(
                    'u.id_departement',
                    $departementSelectionne
                );
            }

        } else {

            /*
            | Caissier et indépendant :
            | uniquement leurs propres factures
            */

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


        /*
        |--------------------------------------------------------------------------
        | Droits
        |--------------------------------------------------------------------------
        */

        if ($role === 'admin') {

            $impayees->where(
                'u.role',
                '!=',
                'independant'
            );


            /*
            | Filtre département
            */

            if (!empty($departementSelectionne)) {

                $impayees->where(
                    'u.id_departement',
                    $departementSelectionne
                );
            }

        } else {

            $impayees->where(
                'f.id_utilisateur',
                $idUtilisateur
            );
        }


        $nombreImpayees = $impayees
            ->havingRaw(
                'total_paye < f.montant_ttc'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Graphique ADMIN
        |--------------------------------------------------------------------------
        */

        $labelsGraphique = [];

        $ventesCaissiers = [];
        $achatsCaissiers = [];

        $ventesIndependants = [];
        $achatsIndependants = [];


        if ($role === 'admin') {

            /*
            |--------------------------------------------------------------------------
            | 12 derniers mois
            |--------------------------------------------------------------------------
            */

            $dateDebut = Carbon::now()
                ->startOfMonth()
                ->subMonths(11);

            $dateFin = Carbon::now()
                ->endOfMonth();


            /*
            |--------------------------------------------------------------------------
            | Requête graphique
            |--------------------------------------------------------------------------
            */

            $facturesGraphique = DB::table('factures as f')

                ->join(
                    'utilisateurs as u',
                    'f.id_utilisateur',
                    '=',
                    'u.id_utilisateur'
                )

                ->whereIn(
                    'u.role',
                    ['caissier', 'independant']
                )

                ->whereIn(
                    'f.type',
                    ['vente', 'achat']
                )

                ->whereBetween(
                    'f.created_at',
                    [
                        $dateDebut,
                        $dateFin
                    ]
                );


            /*
            |--------------------------------------------------------------------------
            | Filtre département pour le graphique
            |--------------------------------------------------------------------------
            */

            if (!empty($departementSelectionne)) {

                $facturesGraphique->where(
                    'u.id_departement',
                    $departementSelectionne
                );
            }


            $facturesGraphique = $facturesGraphique

                ->select(
                    DB::raw(
                        'YEAR(f.created_at) as annee'
                    ),

                    DB::raw(
                        'MONTH(f.created_at) as mois'
                    ),

                    'u.role',

                    'f.type',

                    DB::raw(
                        'COUNT(f.id_facture) as total'
                    )
                )

                ->groupBy(
                    DB::raw(
                        'YEAR(f.created_at)'
                    ),

                    DB::raw(
                        'MONTH(f.created_at)'
                    ),

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

                $date = $dateDebut
                    ->copy()
                    ->addMonths($i);

                $annee = $date->year;
                $mois = $date->month;


                /*
                | Label
                */

                $labelsGraphique[] =
                    $date->translatedFormat('M Y');


                /*
                | Valeurs par défaut
                */

                $ventesCaissiers[] = 0;
                $achatsCaissiers[] = 0;

                $ventesIndependants[] = 0;
                $achatsIndependants[] = 0;


                /*
                |--------------------------------------------------------------------------
                | Recherche des données du mois
                |--------------------------------------------------------------------------
                */

                foreach ($facturesGraphique as $facture) {

                    if (
                        (int) $facture->annee === $annee
                        &&
                        (int) $facture->mois === $mois
                    ) {

                        /*
                        | Caissier - Vente
                        */

                        if (
                            $facture->role === 'caissier'
                            &&
                            $facture->type === 'vente'
                        ) {

                            $ventesCaissiers[$i] =
                                (int) $facture->total;
                        }


                        /*
                        | Caissier - Achat
                        */

                        elseif (
                            $facture->role === 'caissier'
                            &&
                            $facture->type === 'achat'
                        ) {

                            $achatsCaissiers[$i] =
                                (int) $facture->total;
                        }


                        /*
                        | Indépendant - Vente
                        */

                        elseif (
                            $facture->role === 'independant'
                            &&
                            $facture->type === 'vente'
                        ) {

                            $ventesIndependants[$i] =
                                (int) $facture->total;
                        }


                        /*
                        | Indépendant - Achat
                        */

                        elseif (
                            $facture->role === 'independant'
                            &&
                            $facture->type === 'achat'
                        ) {

                            $achatsIndependants[$i] =
                                (int) $facture->total;
                        }
                    }
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Nom du département sélectionné
        |--------------------------------------------------------------------------
        */

        $nomDepartementSelectionne = null;

        if (
            $role === 'admin'
            &&
            !empty($departementSelectionne)
        ) {

            $nomDepartementSelectionne = DB::table('departements')
                ->where(
                    'id_departement',
                    $departementSelectionne
                )
                ->value('nom');
        }


        /*
        |--------------------------------------------------------------------------
        | Envoi vers la vue
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard.index',
            compact(

                'nombreCaissiers',

                'nombreFacturesVente',

                'nombreFacturesAchat',

                'nombreImpayees',

                'labelsGraphique',

                'ventesCaissiers',

                'achatsCaissiers',

                'ventesIndependants',

                'achatsIndependants',

                'departements',

                'departementSelectionne',

                'nomDepartementSelectionne'
            )
        );
    }
}