<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
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
            'table_name'=>$this->table_name,
            'seating_capacity'=>$this->seating_capacity,
            'price'=>$this->price,
            'description'=>$this->description??"",
            "picture"=>asset('public/uploads/tables/'.$this->picture)
//            'status'=>''
        ];
    }
}
