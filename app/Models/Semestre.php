<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    use HasFactory;

    public function activer()
    {
        $this->etat = 1;
        $this->save();
    }

    public function desactiver()
    {
        $this->etat = 0;
        $this->save();
    }

    public function estActive()
    {
        return $this->etat == 1;
    }
    public function classes()
    {
        return $this->hasMany(Classe::class);
    }
}
