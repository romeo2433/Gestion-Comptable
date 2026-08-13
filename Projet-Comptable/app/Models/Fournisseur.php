<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fournisseur extends Model
{
    protected $table = 'fournisseurs';

    protected $primaryKey = 'id_fournisseur';

    protected $fillable = [
        'nom',
    ];

    public function charges(): HasMany
    {
        return $this->hasMany(
            Charge::class,
            'id_fournisseur',
            'id_fournisseur'
        );
    }
}