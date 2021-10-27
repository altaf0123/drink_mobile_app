<?php

namespace App\Http\Resources\API;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'date'=>Carbon::parse($this->created_at)->format('Y-m-d'),
            'total'=>$this->grand_total,
            'items'=>OrderItemResource::collection($this->whenLoaded('items')),
            'card'=>$this->card,
            'receipt'=>$this->payment_response?json_decode($this->payment_response): new \stdClass
        ];
    }
}
