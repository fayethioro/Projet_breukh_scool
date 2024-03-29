<?php

namespace App\Models;

use App\Models\Eleve;
use App\Models\Inscription;
use App\Models\Participation;
use App\Models\Semestre;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classe extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
        return $this->belongsTo(AnneeScolaire::class, 'annee_scolaire_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($classe) {
            /**
             * Récupérer l'ID de l'année scolaire active
             */
            $anneeScolaireActive = AnneeScolaire::where('status', 1)->first();

            if ($anneeScolaireActive) {
                $classe->annee_scolaire_id = $anneeScolaireActive->id;
            }
        });
    }

    public function noteMaximals()
    {
        return $this->hasMany(NoteMaximal::class);
    }

    public function inscriptions():HasMany
    {
        return $this->hasMany(Inscription::class);
    }
    public function semestre()
    {
        return $this->BelongsTo(Semestre::class);
    }

    public function disciplinesWithNotes()
    {
        return $this->noteMaximals()->with('discipline');
    }
    public function participations()
    {
        return $this->hasMany(Participation::class);
    }

    public function evenements()
    {
        return $this->belongsToMany(Evenement::class, 'participations');
    }
    public function notes()
    {
        return $this->hasManyThrough(Note::class, Inscription::class, 'classe_id', 'inscription_id');
    }
}
