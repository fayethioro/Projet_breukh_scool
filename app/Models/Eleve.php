<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Eleve extends Model
{
    use HasFactory; use SoftDeletes;

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
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($eleve) {
            if ($eleve->profil === 0) {
                $eleve->code = self::getNextCode($eleve);
            }
        });
    }

    protected static function getNextCode($eleve)
    {
        $eleves = self::where('profil', 0)
                      ->where('etat', 1)
                      ->orderBy('code', 'asc')
                      ->get();

        $code = 1;

        foreach ($eleves as $e) {
            if ($e->code != $code) {
                break;
            }
            $code++;
        }

        return $code;
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }





}










