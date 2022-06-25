<?php

namespace App\Http\Resources\Panel;

use App\Support\DTOs\Dues\DuesDTO;
use Illuminate\Http\Resources\Json\JsonResource;

class DuesResource extends JsonResource
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
            'year' => $this->year,
            'month' => $this->month,
            'month_translated' => $this->numberToMonth($this->month),
            'fee' => $this->fee,
            'approved_at' => $this->approved_at,
            'status' => $this->status,
        ];
    }

    private function numberToMonth($month){
        return __('dues.' . $month);
    }
}
