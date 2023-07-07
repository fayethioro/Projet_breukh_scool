<?php

namespace App\Http\Requests;

use App\Models\Classe;
use Illuminate\Foundation\Http\FormRequest;

class PostInscriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => ['required', 'email', 'unique:eleves'],
            'gender' => 'required',
            'profil' => 'required',
            'classeId' => 'required',
            'birthdayDate' => [
                'date_format:Y-m-d',
                'before_or_equal:' . date('Y-m-d', strtotime('-5 years')),
            ],
        ];
    }

    public function messages()
    {
        return [
            'firstName.required' => 'Le prénom est requis.',
            'lastName.required' => 'Le nom est requis.',
            'birthdayDate.date_format' => 'Le date de naissance doit etre de format date yyyy-mm-dd.',
            'birthdayDate.before_or_equal' => 'il faut avoir au moins 5ans .',
            'gender.required' => 'Le sexe est requis.',
            'profil.required' => 'Le profil est requis.',
            'classeId.required' => 'La classe est requise.',
            'email.required' => 'le mail est requis.',
            'email.email' => 'le mail doit etre valide.',
            'email.unique' => 'le mail doit etre unique.',
        ];
    }

    public function withValidator($validator)
{
    $validator->after(function ($validator) {
        $classeId = $this->input('classeId');

        if (!Classe::where('id', $classeId)->exists()) {
            $validator->errors()->add('classeId', 'La classe sélectionnée n\'existe pas.');
        }
    });
}
}
