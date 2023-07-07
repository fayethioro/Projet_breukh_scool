<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetNoteMaxResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'discipline' => $this->discipline->libelle,
            'evaluation' => $this->evaluation->libelle,
            'semestre' => $this->semestre->libelle,
            'note_max' => $this->note_max,
            'annee_scolaire' => $this->classe->anneeScolaire->libelle,
            'id' => $this->id
        ];
    }
}
