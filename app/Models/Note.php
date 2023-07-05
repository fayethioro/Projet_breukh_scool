<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
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

    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }

    /**
     * Obtient la note maximale associée à la note.
     */
    public function noteMaximal()
    {
        return $this->belongsTo(NoteMaximal::class);
    }
}
