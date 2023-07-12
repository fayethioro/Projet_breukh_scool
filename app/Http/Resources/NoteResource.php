<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
           'eleve'=>new InscriptionResource( $this->inscription),
            // 'note'=>$this->note
        ];
    }
}
