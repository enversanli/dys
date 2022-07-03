<?php

namespace App\Http\Resources\Panel;

use Carbon\Carbon;
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'email' => $this->email,
            'mobile_phone' => $this->mobile_phone,
            'status' => $this->status,
            'birth_date' => $this->birth_date ? Carbon::make($this->birth_date)->format('Y-m-d') : null,
            'photo_url' => $this->photo_url,
            'association' => $this->association,
            'role' => $this->role,
            $this->mergeWhen($this->isStudent(), [
                'parent' => $this->whenLoaded('parent'),
                'class' => $this->whenLoaded('class'),
                'parent_id' => $this->parent_id,
            ]),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
