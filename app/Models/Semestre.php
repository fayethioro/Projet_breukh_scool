<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    use HasFactory;
    protected $guarded =
    [
        'id',
    ];
    protected $dates = ['deleted_at'];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $events = [
        'updated',
    ];
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

    public static function boot()
{
    parent::boot();
     static::updating(function ($semestre) {
        if ($semestre->status == 1) {
            self::where('status', 1)->where('id', '!=', $semestre->id)
                    ->update(['status' => 0]);
        }
    });
}
}
