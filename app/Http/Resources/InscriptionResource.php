<?php

namespace App\Http\Resources;

use App\Http\Resources\EleveResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InscriptionResource extends JsonResource
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
            "eleve" => new EleveResource($this->eleve),
            "date_inscription" => $this->date_inscription
        ];
    }
}
