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
        $profil = $this->profil == 0 ? "internant" : "externant";
        $dateNaissance = $this->date_naissance ? $this->date_naissance : "non défini";
        $lieuNaissance = $this->lieu_naissance ? $this->lieu_naissance : "non défini";
        return [
            "id" => $this->id,
            "prenom" => $this->prenom,
            'nom' => $this->nom,
            'sexe' => $this->sexe,
            'date_naissance' =>  $dateNaissance ,
            'lieu_naissace' => $lieuNaissance,
            'profil' => $profil,
        ];
    }
}
