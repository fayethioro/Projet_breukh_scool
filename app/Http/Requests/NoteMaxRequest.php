<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoteMaxRequest extends FormRequest
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
            'discipline_id' => 'required|exists:disciplines,id',
            'evaluation_id' => 'required|exists:evaluations,id',
            'semestre_id' => 'required|exists:semestres,id',
            'note_max' => 'required|integer',

        ];
    }
    public function messages()
    {
        return [
            'discipline_id.required' => 'id du discipline est requis.',
            'evaluation_id.required' => 'id de evaluation est requis.',
            'semestre_id.required' => 'id du semestre est requis.',
            'note_max.required' => 'Le note max est requis.',
            'note_max.interger' => 'Le note max doit etre un entier.',

        ];
    }
}
