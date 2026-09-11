<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Journal extends Model
{
    protected $table = 'journal';

    protected $primaryKey = 'id_journal';

    protected $fillable = [
        'numero_piece',
        'date_operation',
        'libelle',
    ];

    protected $casts = [
        'date_operation' => 'date',
    ];

    public function ecritures(): HasMany
    {
        return $this->hasMany(
            Ecriture::class,
            'id_journal',
            'id_journal'
        );
    }
}