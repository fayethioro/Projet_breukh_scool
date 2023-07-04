<?php

namespace App\Models;

use App\Models\Niveau;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'nomComplet',
    //     'email',
    //     'password',

    // ];


    protected $guarded =
    [
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function anneeScolaire()
    {
        return $this->belongsTo(AnneeScolaire::class, 'id_annee_scolaire');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($classe) {
            // Récupérer l'ID de l'année scolaire active
            $anneeScolaireActive = AnneeScolaire::where('status', 1)->first();

            if ($anneeScolaireActive) {
                $classe->annee_scolaire_id = $anneeScolaireActive->id;
            }
        });
    }
}
