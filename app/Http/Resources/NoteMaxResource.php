<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteMaxResource extends JsonResource
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
            'classe' => $this->classe->libelle,
            'evaluation' => $this->evaluation->libelle,
            'note_max' => $this->note_max,
            'id' => $this->id
        ];
    }
}
