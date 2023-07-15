<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPutRequest extends FormRequest
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
            "nomComplet" => "sometimes|required",
            'email' => ['sometimes','required', 'email','regex:/^[a-z][a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', 'unique:users'],

        ];
    }

    public function messages(){
        return [
            "nomComplet.required" => "le nom est requis !",
            'email.requis' => "Le mail est requis.",
            'email.email' => 'le mail doit etre valide.',
             'email.regex' => 'le mail doit etre valide.',
             'email.unique' => 'ce email existe dejas.',
        ];
    }
}
