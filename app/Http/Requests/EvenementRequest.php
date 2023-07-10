<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvenementRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'libelle' => 'required|string|unique:evenements',
            'date_evenement' => 'required|date_format:Y-d-m H:i|after:now',
            'description' => 'required',
            'user_id' => 'required|exists:users,id'
        ];
    }
    public function messages()
    {
        return [
            'libelle.required' => 'Le libellé de l\'événement est requis.',
            'libelle.string' => 'Le libellé de l\'événement doit être une chaîne de caractères.',
            'libelle.unique' => 'Le libellé de l\'événement doit être unique pour chaque evenement',
            'date_evenement.required' => 'La date de l\'événement est requise.',
            'date_evenement.date_format' => 'La date de l\'événement doit être au format Y-m-d H:i.',
            'date_evenement.after' => 'La date de l\'événement doit être  apres la date actuelle.',
            'description.required' => 'La description de l\'événement est requise.',
            'user_id.required' => 'L\'identifiant de l\'utilisateur est requis.',
            'user_id.exists' => 'L\'utilisateur spécifié n\'existe pas.'
        ];
    }
}

