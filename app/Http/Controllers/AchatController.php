<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Gemini\Laravel\Facades\Gemini;
use Gemini\Data\Blob;
use Gemini\Enums\MimeType;
use Smalot\PdfParser\Parser;


class AchatController extends Controller
{
    public function index()
    {
        // Récupérer l'utilisateur depuis la session
        $idUtilisateur = session('id_utilisateur');
        $role = session('role');

        // Vérifier qu'un utilisateur est connecté
        if (!$idUtilisateur) {
            return redirect()->route('login')
                ->with('error', 'Veuillez vous connecter.');
        }
         // Filtre département
        $departementSelectionne = request('departement');

        $query = DB::table('factures as f')
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
            ->leftJoin(
                'utilisateurs as u',
                'f.id_utilisateur',
                '=',
                'u.id_utilisateur'
            )
            ->leftJoin(
                'departements as d',
                'f.id_departement',
                '=',
                'd.id_departement'
            )

            // NE GARDER QUE LES ACHATS — sans ce filtre, les futures
            // ventes (type='vente') apparaîtraient aussi dans cette liste.
            ->where('f.type', 'achat')

            ->select(
                'f.id_facture',
                'f.id_utilisateur',
                'f.numero_facture',
                'f.date_facture',
                'f.fichier_facture',

                'fo.nom as nom_fournisseur',
                'u.nom as nom_utilisateur',
                'd.nom as nom_departement',

                DB::raw(
                    "CONCAT(c.numero_compte, ' - ', c.intitule) as compte_charge"
                ),

                'f.montant_ttc as montant_total',
                'f.montant_tva as tva',

                DB::raw(
                    "CONCAT(ct.numero_compte, ' - ', ct.intitule) as compte_tva"
                ),

                // Total des paiements
                DB::raw(
                    'COALESCE(SUM(p.montant), 0) as paiement'
                ),

                // Mode de paiement
                DB::raw(
                    'MAX(p.mode_paiement) as mode_paiement'
                )
            )

            // ADMIN      : voit toutes les factures, SAUF celles des
            //              utilisateurs "independant"
            // CAISSIER   : voit uniquement ses propres factures
            // INDEPENDANT: voit uniquement ses propres factures
            //              (personne d'autre, admin y compris, ne les voit)
            ->when(
                $role === 'admin',
                function ($query) use ($departementSelectionne) {
            
                    $query->where(function ($q) {
                        $q->where('u.role', '!=', 'independant')
                          ->orWhereNull('u.role');
                    });
            
                    // Filtre département
                    if (!empty($departementSelectionne)) {
            
                        $query->where(
                            'f.id_departement',
                            $departementSelectionne
                        );
                    }
                },
                function ($query) use ($idUtilisateur) {
                    $query->where(
                        'f.id_utilisateur',
                        $idUtilisateur
                    );
                }
            )

            ->groupBy(
                'f.id_facture',
                'f.id_utilisateur',
                'f.numero_facture',
                'f.date_facture',
                'f.fichier_facture',
                'fo.nom',
                'c.numero_compte',
                'c.intitule',
                'f.montant_ttc',
                'f.montant_tva',
                'ct.numero_compte',
                'ct.intitule',
                'd.nom',
                'u.nom'
            )

            ->orderByDesc('f.date_facture');
        $departements = collect();
            if ($role === 'admin') {
                $departements = DB::table('departements')
                    ->orderBy('nom')
                    ->get();
            }

        $achats = $query->get();

        return view(
            'achats.index',
            compact(
                'achats',
                'departements',
                'departementSelectionne'
            )
        );
    }

    public function upload(Request $request)
    {
        $request->validate([
            'facture' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:10240',
            ],
        ]);

        $idUtilisateur = session('id_utilisateur');
        $idDepartement = session('id_departement');

        if (!$idUtilisateur) {
            return redirect()
                ->route('login')
                ->with('error', 'Votre session a expiré. Veuillez vous reconnecter.');
        }

        $fichier = $request->file('facture');
        $chemin = $fichier->store('factures', 'public');
        $fullPath = storage_path('app/public/' . $chemin);
        $extension = strtolower($fichier->getClientOriginalExtension());

        // ----------------------------------------------------------------------
        // TENTATIVE 1 : EXTRACTION VIA GEMINI API
        // ----------------------------------------------------------------------
        $donneesGemini = $this->extraireAvecGemini($fullPath, $extension);

        if ($donneesGemini) {
            try {
                $idFacture = $this->enregistrerFactureComplete(
                    $donneesGemini,
                    $chemin,
                    $idUtilisateur,
                    $idDepartement
                );

                return redirect()
                    ->route('achats.index')
                    ->with('success', 'Facture analysée et enregistrée avec succès via Gemini API !');

            } catch (\Exception $e) {
                Log::error(
                    'Erreur lors de l\'enregistrement des données Gemini : '
                    . $e->getMessage()
                );

                // Seulement si l'enregistrement Gemini échoue réellement,
                // on passe au système classique.
            }
        }

        // ----------------------------------------------------------------------
        // FALLBACK : ANCIEN SYSTÈME (SMALOT / REGEX)
        // ----------------------------------------------------------------------
        Log::warning('Gemini n\'a pas pu extraire la facture. Passage au système classique (Regex).');

        try {
            $texte = '';
            if ($extension === 'pdf') {
                $parser = new Parser();
                $pdf = $parser->parseFile($fullPath);
                $texte = $pdf->getText();
            }

            if (empty(trim($texte))) {
                return redirect()
                    ->route('achats.index')
                    ->with('error', 'Impossible de lire le contenu de la facture (Fichier scanné ou image non lisible par l\'ancien système).');
            }

            $numeroFacture = $this->extraireNumeroFacture($texte);
            $dateFacture = $this->extraireDate($texte);
            $montantHT = $this->extraireMontantHT($texte);
            $montantTVA = $this->extraireTVA($texte);
            $montantTTC = $this->extraireTTC($texte);

            // Remplissage cohérence
            if ($montantHT !== null && $montantTVA !== null && $montantTTC === null) {
                $montantTTC = round($montantHT + $montantTVA, 2);
            } elseif ($montantHT !== null && $montantTTC !== null && $montantTVA === null) {
                $montantTVA = round($montantTTC - $montantHT, 2);
            } elseif ($montantTVA !== null && $montantTTC !== null && $montantHT === null) {
                $montantHT = round($montantTTC - $montantTVA, 2);
            }

            $fournisseurNom = $this->extraireFournisseur($texte);
            $idFournisseur = $this->obtenirOuCreerFournisseur($fournisseurNom);

            $champsManquants = [];
            if (!$numeroFacture) $champsManquants[] = 'numero_facture';
            if (!$dateFacture)   $champsManquants[] = 'date_facture';
            if ($montantTTC === null) $champsManquants[] = 'montant_ttc';
            if (!$fournisseurNom) $champsManquants[] = 'fournisseur';

            $statut = empty($champsManquants) ? 'Terminer' : 'A verifier';

            DB::table('factures')->insertGetId([
                'type'             => 'achat',
                'id_departement'   => $idDepartement,
                'numero_facture'   => $numeroFacture,
                'fichier_facture'  => $chemin,
                'id_utilisateur'   => $idUtilisateur,
                'id_fournisseur'   => $idFournisseur,
                'id_compte_charge' => null,
                'id_tva'           => null,
                'date_facture'     => $dateFacture,
                'date_echeance'    => null,
                'montant_ht'       => $montantHT ?? 0,
                'montant_tva'      => $montantTVA ?? 0,
                'montant_ttc'      => $montantTTC ?? 0,
                'statut'           => $statut,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            if (!empty($champsManquants)) {
                return redirect()
                    ->route('achats.index')
                    ->with('warning', 'Ancien système utilisé : informations partielles (' . implode(', ', $champsManquants) . '). À vérifier manuellement.');
            }

            return redirect()
                ->route('achats.index')
                ->with('success', 'Facture traitée avec succès via le système classique.');

        } catch (\Exception $e) {
            Log::error('Erreur extraction facture : ' . $e->getMessage());

            return redirect()
                ->route('achats.index')
                ->with('error', 'Erreur survenue lors de l\'analyse de la facture.');
        }
    }

    /**
     * Traitement de l'image/PDF via l'API Gemini. Gemini détermine lui-même
     * le compte de charge (numéro + intitulé) selon la nature de la dépense,
     * en s'appuyant sur sa connaissance du Plan Comptable Général.
     */
    private function extraireAvecGemini(string $filePath, string $extension): ?array
    {
        try {
            $mimeType = match ($extension) {
                'pdf' => MimeType::APPLICATION_PDF,
                'png' => MimeType::IMAGE_PNG,
                'jpg', 'jpeg' => MimeType::IMAGE_JPEG,
                default => MimeType::APPLICATION_PDF,
            };

            $fileBlob = new Blob(
                mimeType: $mimeType,
                data: base64_encode(file_get_contents($filePath))
            );

            $prompt = <<<PROMPT
Tu es un expert comptable spécialisé dans la lecture de factures et le Plan
Comptable Général (PCG) malgache.

Analyse le document joint et extrait rigoureusement les informations sous la forme d'un objet JSON STRICT respectant exactement cette structure :

{
  "fournisseur": "Nom de l'entreprise qui vend/émet la facture (généralement en en-tête/logo). Attention : ne pas confondre avec le client, souvent introduit par 'Doit à', 'Facturé à' ou similaire.",
  "numero_facture": "Numéro unique de la facture",
  "date_facture": "Date d'émission au format YYYY-MM-DD",
  "date_echeance": "Date limite de paiement au format YYYY-MM-DD ou null",
  "montant_ht": 0.00,
  "montant_tva": 0.00,
  "montant_ttc": 0.00,
  "tva_taux": 0.00,
  "tva_type": "TVA déductible",
  "compte_tva_numero": "445600",
  "compte_tva_intitule": "TVA déductible",
  "compte_tva_confiance": "haute",
  "compte_charge_numero": "Le numéro de compte du PCG (classe 6, ex: 601, 606, 613, 622) le plus pertinent pour cette dépense",
  "compte_charge_intitule": "L'intitulé standard du PCG correspondant à ce numéro (ex: 'Achats de marchandises')",
  "compte_charge_confiance": "haute, moyenne ou basse — ton niveau de certitude sur ce choix de compte",
  "produits": [
    {
      "designation": "Nom du produit ou description de la prestation",
      "quantite": 1,
      "prix_unitaire": 0.00,
      "montant": 0.00
    }
  ]
}

Règles importantes pour compte_charge_numero / compte_charge_intitule :
1. Utilise EXACTEMENT la nomenclature standard du PCG (classe 6 = charges).
   Exemples courants : 601 Achats de matières premières, 602 Achats stockés
   - autres approvisionnements, 604 Achats d'études et prestations de
   services, 606 Achats non stockés de matières et fournitures,
   607 Achats de marchandises, 611 Sous-traitance générale,
   613 Locations, 615 Entretien et réparations, 616 Primes d'assurances,
   622 Rémunérations d'intermédiaires et honoraires, 625 Déplacements,
   missions et réceptions, 626 Frais postaux et de télécommunications,
   628 Divers.
2. Utilise toujours le même numéro et le même intitulé (mot pour mot) pour
   une même nature de dépense, afin de ne pas créer de doublons.
3. Si tu n'arrives vraiment pas à déterminer un compte pertinent, mets
   compte_charge_numero et compte_charge_intitule à null.

Autres règles :
1. Réponds UNIQUEMENT le JSON brut sans balises Markdown (ex: pas de ```json ... ```).
2. Pour les montants, utilise des nombres décimaux avec un point (ex: 150.50).
3. Si un champ n'est pas présent ou incertain, mets null.

Règles pour la TVA :

1. Identifie le taux de TVA indiqué sur la facture.
2. Identifie le montant total de TVA.
3. Détermine le type de TVA applicable à cette facture.
4. Détermine le compte comptable correspondant à la TVA.
5. Pour une facture d'achat, la TVA est généralement une TVA déductible si elle est récupérable.
6. Donne le numéro et l'intitulé du compte TVA correspondant.
7. Le compte TVA doit être cohérent avec le plan comptable utilisé dans l'application.
8. Si le compte TVA ne peut pas être déterminé avec suffisamment de certitude, retourne null.
9. Ne crée jamais un numéro de compte arbitraire simplement pour remplir le champ.
10. Le taux, le montant TVA et le compte TVA doivent être cohérents avec la facture.
PROMPT;

            $response = Gemini::generativeModel(model: 'gemini-3.6-flash')->generateContent([$prompt, $fileBlob]);
            $jsonText = trim($response->text());

            Log::info('Réponse brute Gemini', ['texte' => $jsonText]);

            // Nettoyage au cas où Gemini ajoute des balises Markdown
            $jsonText = preg_replace('/^```json\s*/i', '', $jsonText);
            $jsonText = preg_replace('/^```\s*/i', '', $jsonText);
            $jsonText = preg_replace('/\s*```$/i', '', $jsonText);

            $data = json_decode(trim($jsonText), true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
                return $data;
            }

            Log::error('Gemini réponse non JSON valide : ' . $jsonText);
            return null;

        } catch (\Exception $e) {
            Log::error('Erreur Gemini API : ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Enregistrer en base de données les éléments retournés par Gemini.
     * Le compte de charge proposé par Gemini est créé automatiquement s'il
     * n'existe pas encore (même logique que pour le fournisseur).
     */
    private function enregistrerFactureComplete(array $data, string $cheminFichier, int $idUtilisateur, ?int $idDepartement): int
    {
        return DB::transaction(function () use ($data, $cheminFichier, $idUtilisateur, $idDepartement) {

            // 1. Fournisseur
            $idFournisseur = $this->obtenirOuCreerFournisseur($data['fournisseur'] ?? null);

            if ($idFournisseur === null) {
                throw new \Exception(
                    'Impossible de déterminer le fournisseur de la facture.'
                );
            }

            // 2. Compte de charge — récupéré ou créé automatiquement
            $idCompteCharge = $this->obtenirOuCreerCompte(
                $data['compte_charge_numero'] ?? null,
                $data['compte_charge_intitule'] ?? null
            );

            // 2bis. Compte TVA
            $idCompteTva = $this->obtenirOuCreerCompteTva(
                $data['compte_tva_numero'] ?? null,
                $data['compte_tva_intitule'] ?? null
            );

            // 2ter. Créer l'enregistrement TVA
            $idTva = null;
            $montantTva = $data['montant_tva'] ?? 0;

            if ($montantTva > 0) {
                $idTva = DB::table('tva')->insertGetId([
                    'taux'       => $data['tva_taux'] ?? 0,
                    'montant'    => $montantTva,
                    'type_tva'   => $data['tva_type'] ?? 'TVA déductible',
                    'id_compte'  => $idCompteTva,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Si aucun compte n'a pu être déterminé/créé, ou si la confiance
            // de Gemini n'est pas "haute", on marque la facture à vérifier.
            $confianceCharge = $data['compte_charge_confiance'] ?? null;
            $confianceTva = $data['compte_tva_confiance'] ?? null;

            $statut = (
                $idCompteCharge !== null &&
                $confianceCharge === 'haute' &&
                (
                    $montantTva <= 0 ||
                    (
                        $idCompteTva !== null &&
                        $confianceTva === 'haute'
                    )
                )
            )
                ? 'Terminer'
                : 'A verifier';

            // 3. Facture
            $idFacture = DB::table('factures')->insertGetId([
                'type'             => 'achat', 
                'id_departement'   => $idDepartement,
                'numero_facture'   => $data['numero_facture'] ?? 'INCONNU',
                'fichier_facture'  => $cheminFichier,
                'id_utilisateur'   => $idUtilisateur,
                'id_fournisseur'   => $idFournisseur,
                'id_compte_charge' => $idCompteCharge,
                'id_tva'           => $idTva,

                'date_facture'     => $data['date_facture'] ?? now()->format('Y-m-d'),
                'date_echeance'    => $data['date_echeance'] ?? null,

                'montant_ht'       => $data['montant_ht'] ?? 0,
                'montant_tva'      => $data['montant_tva'] ?? 0,
                'montant_ttc'      => $data['montant_ttc'] ?? 0,

                'statut'           => $statut,

                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            // 3bis. Paiement (créé automatiquement à l'import)
            // NB : le montant payé correspond au TTC (montant réellement dû),
            // pas au HT — sinon la facture apparaît "payée" alors qu'il
            // manque le montant de la TVA.
            DB::table('paiements')->insert([
                'id_facture'    => $idFacture,
                'date_paiement' => $data['date_facture'] ?? now()->format('Y-m-d'),
                'montant'       => $data['montant_ttc'] ?? 0,
                'mode_paiement' => 'Espèces',
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            // 4. Lignes de facture
            if (!empty($data['produits']) && is_array($data['produits'])) {
                foreach ($data['produits'] as $produit) {
                    $prixUnitaire = $produit['prix_unitaire'] ?? 0;
                    $quantite = $produit['quantite'] ?? 1;
                    $montant = $produit['montant'] ?? ($quantite * $prixUnitaire);

                    DB::table('ligne_factures')->insert([
                        'id_facture'    => $idFacture,
                        'designation'   => substr($produit['designation'] ?? 'Article', 0, 200),
                        'quantite'      => $quantite,
                        'prix_unitaire' => $prixUnitaire,
                        'montant'       => $montant,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ]);
                }
            }

            return $idFacture;
        });
    }

    /**
     * Récupère ou crée un compte comptable. Utilisé pour le compte de
     * charge comme pour le compte de TVA (les deux stockent les comptes
     * dans la même table "comptes").
     */
    private function obtenirOuCreerCompte(?string $numeroCompte, ?string $intitule, string $intituleParDefaut = 'A completer'): ?int
    {
        if (empty($numeroCompte)) {
            return null;
        }

        $numeroCompte = trim($numeroCompte);

        $compte = DB::table('comptes')
            ->where('numero_compte', $numeroCompte)
            ->first();

        if ($compte) {
            return $compte->id_compte;
        }

        // La classe comptable correspond au premier chiffre du numéro
        // (ex: 607 -> classe 6). On sécurise avec un intitulé par défaut
        // si Gemini ne l'a pas fourni.
        $classe = (int) substr($numeroCompte, 0, 1);

        return DB::table('comptes')->insertGetId([
            'numero_compte' => $numeroCompte,
            'intitule'      => $intitule ?: $intituleParDefaut,
            'classe'        => $classe,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }

    private function obtenirOuCreerCompteTva(?string $numeroCompte, ?string $intitule): ?int
    {
        return $this->obtenirOuCreerCompte($numeroCompte, $intitule, 'TVA');
    }

    /**
     * Helper pour éviter la répétition sur la création de fournisseur
     */
    private function obtenirOuCreerFournisseur(?string $nom): ?int
    {
        if (empty($nom)) return null;

        $fournisseur = DB::table('fournisseurs')
            ->where('nom', $nom)
            ->first();

        if ($fournisseur) {
            return $fournisseur->id_fournisseur;
        }

        return DB::table('fournisseurs')->insertGetId([
            'nom'        => $nom,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ANCIENS EXTRACTEURS (REGEX / SMALOT) — utilisés en fallback uniquement
    |--------------------------------------------------------------------------
    */

    private function extraireNumeroFacture($texte)
    {
        if (preg_match('/N[°o]\s*Facture\s*:?\s*([A-Z0-9\-\/]+)/iu', $texte, $matches)) {
            return trim($matches[1]);
        }
        return null;
    }

    private function extraireDate($texte)
    {
        if (preg_match('/(?:^|\n)\s*Date(?:\s+de\s+facture| facture)?\s*:?\s*(\d{1,2}\/\d{1,2}\/\d{4})/iu', $texte, $matches)) {
            try {
                return \Carbon\Carbon::createFromFormat('d/m/Y', trim($matches[1]))->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }

    private function extraireMontantHT($texte)
    {
        if (preg_match('/Total\s*HT\s*\(?Ar\)?\s*:?\s*\t*([\d\s.,]+)/iu', $texte, $matches)) {
            return $this->convertirMontant($matches[1]);
        }
        return null;
    }

    private function extraireTVA($texte)
    {
        if (preg_match('/TVA\s*\d{1,2}(?:[.,]\d+)?\s*%\s*\(?Ar\)?\s*:?\s*\t*([\d\s.,]+)/iu', $texte, $matches)) {
            return $this->convertirMontant($matches[1]);
        }
        return null;
    }

    private function extraireTTC($texte)
    {
        if (preg_match('/Total\s*TTC\s*\(?Ar\)?\s*:?\s*\t*([\d\s.,]+)/iu', $texte, $matches)) {
            return $this->convertirMontant($matches[1]);
        }
        return null;
    }

    private function convertirMontant($montant)
    {
        $montant = trim($montant);
        $montant = str_replace(' ', '', $montant);
        $montant = str_replace("\xc2\xa0", '', $montant);

        if (str_contains($montant, ',') && str_contains($montant, '.')) {
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
            if (substr_count($montant, '.') > 1) {
                $montant = str_replace('.', '', $montant);
            }
        }

        return (float) $montant;
    }

    private function extraireFournisseur($texte)
    {
        if (preg_match('/^(.+?)\s+FACTURE\s+DE\s+VENTE/imu', $texte, $matches)) {
            return trim($matches[1]);
        }

        if (preg_match('/FACTURE\s+DE\s+VENTE\s*\R([^\r\n]+)/iu', $texte, $matches)) {
            return trim($matches[1]);
        }

        return null;
    }

    public function show($id)
    {
        $achat = DB::table('factures as f')
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
                'utilisateurs as u',
                'f.id_utilisateur',
                '=',
                'u.id_utilisateur'
            )
            ->where('f.id_facture', $id)
            ->where('f.type', 'achat') // <-- ajouté : ne pas exposer une vente via cette route
            // ADMIN      : accès à toutes les factures, SAUF celles des
            //              utilisateurs "independant"
            // CAISSIER /
            // INDEPENDANT: accès uniquement à ses propres factures
            ->when(
                session('role') === 'admin',
                function ($query) {
                    $query->where(function ($q) {
                        $q->where('u.role', '!=', 'independant')
                          ->orWhereNull('u.role');
                    });
                },
                function ($query) {
                    $query->where(
                        'f.id_utilisateur',
                        session('id_utilisateur')
                    );
                }
            )
            ->select(
                'f.*',
                'fo.nom as nom_fournisseur',
                DB::raw("CONCAT(c.numero_compte, ' - ', c.intitule) as compte_charge"),
                DB::raw("CONCAT(ct.numero_compte, ' - ', ct.intitule) as compte_tva")
            )
            ->first();

        if (!$achat) {
            abort(404);
        }

        // Récupérer les paiements
        $paiements = DB::table('paiements')
            ->where('id_facture', $id)
            ->get();

        // Récupérer les lignes de facture
        $lignes = DB::table('ligne_factures')
            ->where('id_facture', $id)
            ->get();

        return view('achats.show', compact(
            'achat',
            'paiements',
            'lignes'
        ));
    }

    public function preview($id)
    {
        $achat = DB::table('factures')
            ->where('id_facture', $id)
            ->where('type', 'achat') // <-- ajouté
            ->first();
    
        if (!$achat) {
            abort(404, 'Facture introuvable');
        }
    
        if (!$achat->fichier_facture) {
            abort(404, 'Aucun fichier associé');
        }
    
        $path = storage_path(
            'app/public/' . $achat->fichier_facture
        );
    
        if (!file_exists($path)) {
            abort(404, 'Fichier introuvable : ' . $path);
        }
    
        return response()->file($path);
    }

    public function updatePaiement(Request $request, $id)
    {
        $idUtilisateur = session('id_utilisateur');
        $role = session('role');

        if (!$idUtilisateur) {
            return redirect()
                ->route('login')
                ->with('error', 'Veuillez vous connecter.');
        }

        $request->validate([
            'mode_paiement' => [
                'required',
                'in:Espèces,Chèque,Virement,Carte bancaire,Mobile Money'
            ],
        ]);

        // Vérifier que la facture appartient à l'utilisateur
        $facture = DB::table('factures')
            ->where('id_facture', $id)
            ->where('type', 'achat') // <-- ajouté
            ->first();

        if (!$facture) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Sécurité des rôles
        |--------------------------------------------------------------------------
        |
        | Admin : peut modifier les paiements des factures visibles.
        | Caissier : uniquement ses propres factures.
        | Indépendant : uniquement ses propres factures.
        |
        */

        if (
            $role !== 'admin' &&
            $facture->id_utilisateur != $idUtilisateur
        ) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier ce paiement.');
        }

        /*
        |--------------------------------------------------------------------------
        | Modifier le mode de paiement
        |--------------------------------------------------------------------------
        */

        DB::table('paiements')
            ->where('id_facture', $id)
            ->update([
                'mode_paiement' => $request->mode_paiement,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('achats.index')
            ->with('success', 'Mode de paiement modifié avec succès.');
    }

    public function destroy($id)
    {
        // Seul l'administrateur peut supprimer
        //if (session('role') !== 'admin') {
          //  abort(403);
        //}

        $facture = DB::table('factures')
            ->where('id_facture', $id)
            ->where('type', 'achat') // <-- ajouté : ce contrôleur ne supprime que des achats
            ->first();

        if (!$facture) {
            abort(404);
        }

        DB::transaction(function () use ($id, $facture) {

            // Supprimer les lignes de facture
            DB::table('ligne_factures')
                ->where('id_facture', $id)
                ->delete();

            // Supprimer les paiements
            DB::table('paiements')
                ->where('id_facture', $id)
                ->delete();

            // Supprimer la facture
            DB::table('factures')
                ->where('id_facture', $id)
                ->delete();

            // Supprimer le fichier
            if ($facture->fichier_facture) {

                $path = storage_path(
                    'app/public/' . $facture->fichier_facture
                );

                if (file_exists($path)) {
                    unlink($path);
                }
            }
        });

        return redirect()
            ->route('achats.index')
            ->with('success', 'Facture supprimée avec succès.');
    }
}