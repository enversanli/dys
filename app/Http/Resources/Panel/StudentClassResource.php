<?php

namespace App\Http\Resources\Panel;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentClassResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this-> name,
            'creator' => $this->creator,
            'teacher' => $this->teacher,
            'description' => $this->description,
            'association' => $this->association,
            'students_count' => $this->students_count,
            'created_at' => $this->created_at,
        ];
    }
}
