<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EvenementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'auditeur' => $this->user->nomComplet,
            "titreEvenement" =>$this->libelle,
            "dateEvenement" => $this->date_evenement,
            "description"   =>$this->description
        ];
    }
}
