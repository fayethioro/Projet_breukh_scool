<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoteEleveRequest extends FormRequest
{
    public function rules()
    {
        return [
            'notes' => 'required|array',
            'notes.*.inscription_id' => 'required|integer|exists:inscriptions,id',
            'notes.*.note' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'notes.required' => 'Le champ notes est obligatoire.',
            'notes.array' => 'Le champ notes doit être un tableau.',
            'notes.*.inscription_id.required' => 'L\'ID de l\'inscription est obligatoire pour chaque note.',
            'notes.*.inscription_id.integer' => 'L\'ID de l\'inscription doit être un entier.',
            'notes.*.inscription_id.exists' => 'L\'ID de l\'inscription spécifiée est invalide.',
            'notes.*.note.required' => 'La note est obligatoire pour chaque inscription.',
            'notes.*.note.numeric' => 'La note doit être un nombre.',
        ];
    }
}
