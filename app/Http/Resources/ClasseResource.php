<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClasseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "classe" => $this->libelle,
            'annee_scolaire' => $this->anneeScolaire->libelle,
            'semestre' => $this->semestre->libelle,
            "eleves" =>InscriptionResource::collection( $this->whenLoaded('inscriptions'))
        ];
    }
}
