<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tva extends Model
{
    protected $table = 'tva';

    protected $primaryKey = 'id_tva';

    protected $fillable = [
        'taux',
        'montant',
        'type_tva',
        'id_compte',
    ];

    protected $casts = [
        'taux' => 'decimal:2',
        'montant' => 'decimal:2',
    ];
    public function compte()
    {
        return $this->belongsTo(
            Compte::class,
            'id_compte',
            'id_compte'
        );
    }
}