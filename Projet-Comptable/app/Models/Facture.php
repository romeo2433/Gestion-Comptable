<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facture extends Model
{
    protected $table = 'factures';

    protected $primaryKey = 'id_facture';

    protected $fillable = [
        'numero_facture',
        'id_fournisseur',
        'id_compte_charge',
        'id_tva',
        'date_facture',
        'date_echeance',
        'montant_ht',
        'montant_tva',
        'montant_ttc',
        'statut',
    ];

    protected $casts = [
        'date_facture' => 'date',
        'date_echeance' => 'date',
        'montant_ht' => 'decimal:2',
        'montant_tva' => 'decimal:2',
        'montant_ttc' => 'decimal:2',
    ];

    public function fournisseur()
    {
        return $this->belongsTo(
            Fournisseur::class,
            'id_fournisseur',
            'id_fournisseur'
        );
    }
    
    public function compteCharge()
    {
        return $this->belongsTo(
            Compte::class,
            'id_compte_charge',
            'id_compte'
        );
    }
    
    public function tva()
    {
        return $this->belongsTo(
            Tva::class,
            'id_tva',
            'id_tva'
        );
    }
    
    public function paiements()
    {
        return $this->hasMany(
            Paiement::class,
            'id_facture',
            'id_facture'
        );
    }
}