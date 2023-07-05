<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostAnneeScolaireRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'libelle' => [
                'required',
                'regex:/^\d{4}-\d{4}$/',
                'unique:annee_scolaires',
                function ($attribute, $value, $fail) {
                    /**
                     *  Vérifier le format de la date
                     */
                    $startDate = intval(substr($value, 0, 4));
                    $endDate = intval(substr($value, 5, 4));

                    if ($endDate !== ($startDate + 1)) {
                        $fail('Le format de la date doit être "yyyy-yyyy"
                        et la différence entre les années doit être de 1 an.');
                    }
                }
            ],
        ];
    }
}

