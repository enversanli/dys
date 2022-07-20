<?php

namespace App\Http\Resources\Panel;

use Illuminate\Http\Resources\Json\JsonResource;

class DailyAttendanceResource extends JsonResource
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
            'date' => $this->date,
            'status' => $this->status,
            'at_lesson' => $this->at_lesson,
            'user' => $this->whenLoaded('user'),
            'lesson' => $this->whenLoaded('lesson'),
            'processedBy' => $this->whenLoaded('processedBy'),
        ];
    }
}
