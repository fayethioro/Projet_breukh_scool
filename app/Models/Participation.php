<?php

namespace App\Models;

use App\Models\Classe;
use App\Models\Evenement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participation extends Model
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
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'libelle'  => Str::lower('libelle'),
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
    public function evenement()
    {
        return $this->belongsTo(Evenement::class);
    }
}
