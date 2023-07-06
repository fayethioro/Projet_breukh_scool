<?php

namespace App\Http\Resources;

use App\Http\Resources\InscriptionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EleveResource extends JsonResource
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
            "prenom" => $this->prenom,
            'nom' => $this->nom,
            'sexe' => $this->sexe,
            'date_naissance' => $this->date_naissance,
            'lieu_naissace' => $this->lieu_naissace,
            'profil' => $this->profil,
            // 'inscription' => InscriptionResource::collection($this->inscriptions),

        ];
    }
}
