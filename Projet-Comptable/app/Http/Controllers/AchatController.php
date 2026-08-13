<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Log;

class AchatController extends Controller
{
    public function index()
    {
        $achats = DB::table('factures as f')
            ->leftJoin(
                'fournisseurs as fo',
                'f.id_fournisseur',
                '=',
                'fo.id_fournisseur'
            )
            ->leftJoin(
                'comptes as c',
                'f.id_compte_charge',
                '=',
                'c.id_compte'
            )
            ->leftJoin(
                'tva as t',
                'f.id_tva',
                '=',
                't.id_tva'
            )
            ->leftJoin(
                'comptes as ct',
                't.id_compte',
                '=',
                'ct.id_compte'
            )
            ->leftJoin(
                'paiements as p',
                'f.id_facture',
                '=',
                'p.id_facture'
            )
            ->select(
                'f.id_facture',
                'f.numero_facture',
                'f.date_facture',
                'f.fichier_facture',
                'fo.nom as nom_fournisseur',
                DB::raw(
                    "CONCAT(c.numero_compte, ' - ', c.intitule)
                     as compte_charge"
                ),
                'f.montant_ttc as montant_total',
                'f.montant_tva as tva',
                DB::raw(
                    "CONCAT(ct.numero_compte, ' - ', ct.intitule)
                     as compte_tva"
                ),
                DB::raw(
                    'COALESCE(SUM(p.montant), 0) as paiement'
                )
            )
            ->groupBy(
                'f.id_facture',
                'f.numero_facture',
                'f.date_facture',
                'f.fichier_facture',
                'fo.nom',
                'c.numero_compte',
                'c.intitule',
                'f.montant_ttc',
                'f.montant_tva',
                'ct.numero_compte',
                'ct.intitule'
            )
            ->orderByDesc('f.date_facture')
            ->get();

        return view('achats.index', compact('achats'));
    }


    public function upload(Request $request)
    {
        $request->validate([
            'facture' => [
                'required',
                'file',
                'max:10240',
            ],
        ]);

        $fichier = $request->file('facture');

        // Enregistrer le fichier
        $chemin = $fichier->store('factures', 'public');

        // Vérifier l'extension
        $extension = strtolower($fichier->getClientOriginalExtension());

        try {

            /*
            |--------------------------------------------------------------------------
            | 1. EXTRACTION DU TEXTE
            |--------------------------------------------------------------------------
            */

            if ($extension === 'pdf') {

                $parser = new Parser();

                $pdf = $parser->parseFile(
                    storage_path('app/public/' . $chemin)
                );

                $texte = $pdf->getText();

            } else {

                $texte = '';
            }

            // Log du texte brut pour debug (à désactiver / passer en debug en prod)
            Log::info('Texte extrait facture', [
                'fichier' => $chemin,
                'texte' => $texte,
            ]);

            /*
            |--------------------------------------------------------------------------
            | 2. VÉRIFICATION
            |--------------------------------------------------------------------------
            */

            if (empty(trim($texte))) {

                return redirect()
                    ->route('achats.index')
                    ->with('error',
                        'Impossible de lire le contenu de cette facture. '
                        . 'Elle est peut-être scannée ou contient uniquement une image.'
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | 3. EXTRACTION DES INFORMATIONS
            |--------------------------------------------------------------------------
            */

            $numeroFacture = $this->extraireNumeroFacture($texte);

            $dateFacture = $this->extraireDate($texte);

            $montantHT = $this->extraireMontantHT($texte);

            $montantTVA = $this->extraireTVA($texte);

            $montantTTC = $this->extraireTTC($texte);

            /*
            |--------------------------------------------------------------------------
            | 3bis. VÉRIFICATION DE COHÉRENCE HT + TVA = TTC
            |--------------------------------------------------------------------------
            | Si un des 3 montants est manquant mais que les 2 autres sont connus,
            | on peut le déduire. Ca rattrape les cas où une seule regex a échoué.
            */

            if ($montantHT !== null && $montantTVA !== null && $montantTTC === null) {
                $montantTTC = round($montantHT + $montantTVA, 2);
            } elseif ($montantHT !== null && $montantTTC !== null && $montantTVA === null) {
                $montantTVA = round($montantTTC - $montantHT, 2);
            } elseif ($montantTVA !== null && $montantTTC !== null && $montantHT === null) {
                $montantHT = round($montantTTC - $montantTVA, 2);
            }

            /*
            |--------------------------------------------------------------------------
            | 4. FOURNISSEUR
            |--------------------------------------------------------------------------
            */

            $fournisseurNom = $this->extraireFournisseur($texte);

            /*
            |--------------------------------------------------------------------------
            | 5. CRÉER OU RÉCUPÉRER LE FOURNISSEUR
            |--------------------------------------------------------------------------
            */

            $idFournisseur = null;

            if ($fournisseurNom) {

                $fournisseur = DB::table('fournisseurs')
                    ->where('nom', $fournisseurNom)
                    ->first();

                if ($fournisseur) {

                    $idFournisseur = $fournisseur->id_fournisseur;

                } else {

                    $idFournisseur = DB::table('fournisseurs')
                        ->insertGetId([
                            'nom' => $fournisseurNom
                        ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 6. STATUT SELON LA QUALITÉ DE L'EXTRACTION
            |--------------------------------------------------------------------------
            | Si des champs critiques n'ont pas pu être extraits, on marque la
            | facture pour vérification manuelle plutôt que de l'insérer comme
            | si tout allait bien avec des 0 silencieux.
            */

            $champsManquants = [];

            if (!$numeroFacture) $champsManquants[] = 'numero_facture';
            if (!$dateFacture)   $champsManquants[] = 'date_facture';
            if ($montantTTC === null) $champsManquants[] = 'montant_ttc';
            if (!$fournisseurNom) $champsManquants[] = 'fournisseur';

            $statut = empty($champsManquants)
                ? 'En attente'
                : 'A verifier';

            /*
            |--------------------------------------------------------------------------
            | 7. ENREGISTRER LA FACTURE
            |--------------------------------------------------------------------------
            */

            $idFacture = DB::table('factures')->insertGetId([

                'numero_facture' => $numeroFacture,

                'fichier_facture' => $chemin,

                'id_fournisseur' => $idFournisseur,

                'id_compte_charge' => null,

                'id_tva' => null,

                'date_facture' => $dateFacture,

                'date_echeance' => null,

                'montant_ht' => $montantHT ?? 0,

                'montant_tva' => $montantTVA ?? 0,

                'montant_ttc' => $montantTTC ?? 0,

                'statut' => $statut,

                'created_at' => now(),

                'updated_at' => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | 8. MESSAGE
            |--------------------------------------------------------------------------
            */

            if (!empty($champsManquants)) {

                return redirect()
                    ->route('achats.index')
                    ->with(
                        'warning',
                        'Facture importée mais certaines informations n\'ont pas '
                        . 'pu être lues automatiquement (' . implode(', ', $champsManquants) . '). '
                        . 'Merci de vérifier / compléter manuellement.'
                    );
            }

            return redirect()
                ->route('achats.index')
                ->with(
                    'success',
                    'Facture importée et informations extraites avec succès.'
                );

        } catch (\Exception $e) {

            Log::error('Erreur extraction facture : ' . $e->getMessage());

            return redirect()
                ->route('achats.index')
                ->with(
                    'error',
                    'Une erreur est survenue lors de la lecture de la facture.'
                );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | EXTRACTEURS
    |--------------------------------------------------------------------------
    */

    private function extraireNumeroFacture($texte)
    {
        // Gère "N° Facture :", "N°Facture:", "No Facture :", "N° facture", avec ou sans ':'
        if (preg_match(
            '/N[°o]\s*Facture\s*:?\s*([A-Z0-9\-\/]+)/iu',
            $texte,
            $matches
        )) {
            return trim($matches[1]);
        }

        return null;
    }

    private function extraireDate($texte)
    {
        // Accepte "Date :", "Date facture :", avec espaces variables, jj/mm/aaaa
        if (preg_match(
            '/(?:^|\n)\s*Date(?:\s+de\s+facture| facture)?\s*:?\s*(\d{1,2}\/\d{1,2}\/\d{4})/iu',
            $texte,
            $matches
        )) {
            try {
                return \Carbon\Carbon::createFromFormat(
                    'd/m/Y',
                    trim($matches[1])
                )->format('Y-m-d');

            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }

    private function extraireMontantHT($texte)
    {
        // Le ':' est optionnel, et on capture aussi les décimales (virgule/point)
        if (preg_match(
            '/Total\s*HT\s*\(?Ar\)?\s*:?\s*\t*([\d\s.,]+)/iu',
            $texte,
            $matches
        )) {
            return $this->convertirMontant($matches[1]);
        }

        return null;
    }

    private function extraireTVA($texte)
    {
        // Le taux de TVA n'est plus figé à 20%
        if (preg_match(
            '/TVA\s*\d{1,2}(?:[.,]\d+)?\s*%\s*\(?Ar\)?\s*:?\s*\t*([\d\s.,]+)/iu',
            $texte,
            $matches
        )) {
            return $this->convertirMontant($matches[1]);
        }

        return null;
    }

    private function extraireTTC($texte)
    {
        if (preg_match(
            '/Total\s*TTC\s*\(?Ar\)?\s*:?\s*\t*([\d\s.,]+)/iu',
            $texte,
            $matches
        )) {
            return $this->convertirMontant($matches[1]);
        }

        return null;
    }

    private function convertirMontant($montant)
    {
        $montant = trim($montant);

        $montant = str_replace(' ', '', $montant);

        // Retire un éventuel séparateur insécable copié depuis le PDF
        $montant = str_replace("\xc2\xa0", '', $montant);

        /*
         * Exemple :
         * 1.500.000,00
         */

        if (
            str_contains($montant, ',') &&
            str_contains($montant, '.')
        ) {

            $derniereVirgule = strrpos($montant, ',');
            $dernierPoint = strrpos($montant, '.');

            if ($derniereVirgule > $dernierPoint) {

                $montant = str_replace('.', '', $montant);
                $montant = str_replace(',', '.', $montant);

            } else {

                $montant = str_replace(',', '', $montant);
            }

        } elseif (str_contains($montant, ',')) {

            $montant = str_replace(',', '.', $montant);

        } else {

            /*
             * Exemple :
             * 1.500.000
             */

            if (substr_count($montant, '.') > 1) {
                $montant = str_replace('.', '', $montant);
            }
        }

        return (float) $montant;
    }

    private function extraireFournisseur($texte)
    {
        // Cas 1 : "NOM FOURNISSEUR FACTURE DE VENTE" sur la même ligne
        // (le nom du fournisseur précède le titre du document)
        if (preg_match(
            '/^(.+?)\s+FACTURE\s+DE\s+VENTE/imu',
            $texte,
            $matches
        )) {
            return trim($matches[1]);
        }

        // Cas 2 (fallback) : "FACTURE DE VENTE" suivi du nom sur la ligne suivante
        if (preg_match(
            '/FACTURE\s+DE\s+VENTE\s*\R([^\r\n]+)/iu',
            $texte,
            $matches
        )) {
            return trim($matches[1]);
        }

        return null;
    }

    private function extraireLignes($texte)
    {
        $lignes = [];

        $pattern = '/^(.+?)\t(\d+)\t([\d\s]+)\t([\d\s]+)$/m';

        preg_match_all($pattern, $texte, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {

            $lignes[] = [
                'designation' => trim($match[1]),
                'quantite' => (int) $match[2],
                'prix_unitaire' => $this->convertirMontant($match[3]),
                'montant' => $this->convertirMontant($match[4]),
            ];
        }

        return $lignes;
    }
}