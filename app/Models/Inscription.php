<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];
    public function eleve()
    {
        return $this->belongsTo(Eleve::class, 'eleve_id');
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classe');
    }

    public function anneeScolaire()
    {
        return $this->belongsTo(AnneeScolaire::class, 'annee_scolaire_id');
    }
}
