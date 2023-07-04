<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnneeScolaire extends Model
{
    use HasFactory;
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
    protected $table = 'annee_scolaires';
    public function activer()
{
    $this->status = 1;
    $this->save();
}

public function desactiver()
{
    $this->status = 0;
    $this->save();
}

public function estActive()
{
    return $this->status == 1;
}

}
