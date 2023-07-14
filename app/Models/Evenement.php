<?php

namespace App\Models;

use App\Models\Participation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evenement extends Model
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function participations(): HasMany
    {
        return $this->hasMany(Participation::class);
    }
    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'participations');
    }
}
