<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\ClasseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NiveauResource extends JsonResource
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
            "niveau" => $this->libelle,
            "classe" => ClasseResource::collection($this->whenLoaded('classes'))
        ];
    }
}
