<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'nomComplet' => 'required',
            'email' => ['required', 'email', 'regex:/^[a-z][a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', 'unique:users'],
            'password' => 'required|confirmed|min:4',
            'role' => [Rule::in(['ADMIN', 'PARENT', 'PROF', 'ATTACHE'])],
        ];
    }
    /**
     * Convertir la valeur en majuscules
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'role' => strtoupper($this->role),
        ]);
    }
    public function messages()
    {
        return [
            'nomComplet.required' => "le nom est requis.",
            'email.requis' => "Le mail est requis.",
            'email.email' => 'le mail doit etre valide.',
            'email.regex' => 'le mail doit etre valide.',
            'email.unique' => 'ce email existe dejas.',
            'role.in' => 'Le role n\'est pas valide.',
            'password' => 'Le mot de passe est requis.',
            'password.comfirmed' => 'Les deux mots de passe ne correspondent pas.',
            'password.min' => 'Le mot de passe doit avoir au moins 4 caracteres',
        ];
    }
}
