<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostDisciplineRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'libelle' => 'required|unique:disciplines',
            'code' => 'nullable'
        ];
    }
    public function messages()
    {
        return [
            'libelle.required' => 'le libelle est requis.',
            'libelle.unique' => 'le libelle doit  etre unique.',
        ];
    }
}
