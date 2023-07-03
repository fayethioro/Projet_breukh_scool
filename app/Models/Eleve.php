<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    use HasFactory;

    protected $guarded =
    [
        'id',
    ];
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($eleve) {
            if ($eleve->profil === 0) {
                $eleve->code = static::getNextCode();
            }
            // elseif ($eleve->profil === 1) {
            //     $eleve->code = null;
            // }
        });
    }

    private static function getNextCode()
    {
        /**
         * récupérer le dernier élève avec un profil égal à 0, trié par ordre
         *  décroissant du champ "code", et retourne le premier résultat.
         */
        $lastEleve = static::where('profil', 0)->orderByDesc('code')->first();

        if ($lastEleve) {
            return $lastEleve->code + 1;
        }

        return 1;
    }
}



  






