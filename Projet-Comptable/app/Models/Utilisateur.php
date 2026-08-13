<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    protected $table = 'utilisateurs';

    protected $primaryKey = 'id_utilisateur';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'nom',
        'email',
        'mot_de_passe',
        'role'
    ];

    protected $hidden = [
        'mot_de_passe',
    ];
}