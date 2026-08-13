<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Compte extends Model
{
    protected $table = 'comptes';

    protected $primaryKey = 'id_compte';

    protected $fillable = [
        'numero_compte',
        'intitule',
        'classe',
    ];

    public function charges(): HasMany
    {
        return $this->hasMany(
            Charge::class,
            'id_compte',
            'id_compte'
        );
    }

    public function ecritures(): HasMany
    {
        return $this->hasMany(
            Ecriture::class,
            'id_compte',
            'id_compte'
        );
    }
}