<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    protected $table = 'entreprises';

    protected $primaryKey = 'id_entreprise';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'id_utilisateur',
        'nom',
        'nom_commercial',
        'forme_juridique',
        'secteur_activite',
        'date_creation',
        'adresse',
        'ville',
        'telephone',
        'email',
        'site_web',
        'nif',
        'stat',
        'rcs',
        'nom_banque',
        'numero_compte',
        'titulaire_compte',
    ];

    protected $casts = [
        'date_creation' => 'date',
    ];
}