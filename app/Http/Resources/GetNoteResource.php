<?php

namespace App\Http\Resources;

use App\Http\Resources\InscriptionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetNoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "eleve" =>new InscriptionResource($this->notes),
        ];
    }
}
