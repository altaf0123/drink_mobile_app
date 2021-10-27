<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Category;
class RestaurantResource extends JsonResource
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
            'name'=>$this->name,
            'address'=>$this->address,
            'distance'=>round($this->distance,3) . 'miles away',
            'lat'=>$this->lat,
            'long'=>$this->long,
            'images'=>RestaurantImageResource::collection($this->whenLoaded('images')),
            'categories'=>Category::select('id','title','type')->get()->groupBy('type')
        ];
    }
}
