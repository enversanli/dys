<?php

namespace App\Http\Resources\Panel;

use Illuminate\Http\Resources\Json\JsonResource;

class UserRoleResource extends JsonResource
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
            'key' => $this->key,
            'name' => $this->name,
            'translated' => $this->translateName($this->key),
            'create_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    private function translateName($key){
        $key = 'userRole.'. $key;
        return __($key);

    }
}
