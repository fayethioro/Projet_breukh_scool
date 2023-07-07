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
            'note_max' => $this->noteMaximal->note_max,
            'classe' => $this->noteMaximal->classe_id,
            'discipline' => $this->noteMaximal->discipline_id,
            'evaluation' => $this->noteMaximal->evaluation_id,
            'note'=>$this->note
        ];
    }
}
