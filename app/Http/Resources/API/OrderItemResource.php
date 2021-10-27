<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'id'=>$this->product->id,
            'name'=>$this->product->name,
            'picture'=>asset('public/uploads/products/'.$this->product->picture),
            'price'=>$this->price,
            'qty'=>$this->qty,
            

        ];
    }
}
