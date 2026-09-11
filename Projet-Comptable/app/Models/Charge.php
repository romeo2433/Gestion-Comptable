<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Charge extends Model
{
    protected $table = 'charges';

    protected $primaryKey = 'id_charge';

    protected $fillable = [
        'id_compte',
        'id_fournisseur',
        'date_charge',
        'montant',
        'description',
    ];

    protected $casts = [
        'date_charge' => 'date',
        'montant' => 'decimal:2',
    ];

    public function compte(): BelongsTo
    {
        return $this->belongsTo(
            Compte::class,
            'id_compte',
            'id_compte'
        );
    }

    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(
            Fournisseur::class,
            'id_fournisseur',
            'id_fournisseur'
        );
    }
}