<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LigneFacture extends Model
{
    protected $table = 'ligne_factures';

    protected $primaryKey = 'id_ligne';

    protected $fillable = [
        'id_facture',
        'designation',
        'quantite',
        'prix_unitaire',
        'montant',
    ];

    protected $casts = [
        'prix_unitaire' => 'decimal:2',
        'montant' => 'decimal:2',
    ];

    public function facture(): BelongsTo
    {
        return $this->belongsTo(
            Facture::class,
            'id_facture',
            'id_facture'
        );
    }
}