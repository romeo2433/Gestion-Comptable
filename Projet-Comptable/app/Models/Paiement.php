<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    protected $table = 'paiements';

    protected $primaryKey = 'id_paiement';

    protected $fillable = [
        'id_facture',
        'date_paiement',
        'montant',
        'mode_paiement',
    ];

    protected $casts = [
        'date_paiement' => 'date',
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