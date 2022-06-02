<?php

namespace App\Http\Resources\Panel;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'parent_id' => $this->parent_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'mobile_phone' => $this->mobile_phone,
            'status' => $this->status,
            'birt_date' => $this->birth_date,
            'phone_url' => $this->photo_url,

            $this->mergeWhen($this->isStudent(), [
                'parent' => $this->parent
            ])
        ];
    }
}
