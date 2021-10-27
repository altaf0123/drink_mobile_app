<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class LoggedInUser extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'id'=>$this->id,
            'name'=>$this->name??"",
            'email'=>$this->email,
            'dob'=>$this->date_of_birth??"",
            'height_ft'=>$this->height_feet??"",
            'height_inch'=>$this->height_inch??"",
            'weight_lbs'=>$this->weight_lbs??"",
            'phone_number'=>$this->phone_no??"",
            'country'=>$this->country??"",
            'gender'=>$this->gender??"",
            'interested_in'=>$this->interested_in??"",
            'profession'=>$this->profession??"",
            'profile_picture'=>$this->profile_picture!=null?asset('public/uploads/'.$this->profile_picture):"",
            'profile_video'=>$this->profile_video!=null?('public/uploads/'.$this->profile_video):"",
            'location_range'=>$this->location_range??"",
            'is_verified'=>$this->account_verified,
            'is_profile_complete'=>$this->is_profile_complete,
            'likes'=>isset($attributes['likes'])?json_decode($attributes['likes']->pluck('attribute_value')[0]):[],
            'dislikes'=>isset($attributes['dislikes'])?json_decode($attributes['dislikes']->pluck('attribute_value')[0]):[],
            'music'=>isset($attributes['music'])?json_decode($attributes['music']->pluck('attribute_value')[0]):[],
            'movies'=>isset($attributes['movies'])?json_decode($attributes['movies']->pluck('attribute_value')[0]):[],
            'books'=>isset($attributes['books'])?json_decode($attributes['books']->pluck('attribute_value')[0]):[],
            'tv_shows'=>isset($attributes['tv_shows'])?json_decode($attributes['tv_shows']->pluck('attribute_value')[0]):[],
            'hobbies'=>isset($attributes['hobbies'])?json_decode($attributes['hobbies']->pluck('attribute_value')[0]):[],
            'ethnicity_preferences'=>isset($attributes['ethnicity_preferences'])?json_decode($attributes['ethnicity_preferences']->pluck('attribute_value')[0]):[],
        ]

        ;
    }
}
