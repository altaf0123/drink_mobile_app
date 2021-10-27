<?php

namespace App\Http\Resources\API;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserInfo extends JsonResource
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
            'name'=>$this->name??"",
            'profile_picture'=>asset('public/uploads/'.$this->profile_picture),
            'country'=>$this->country??"",
            'profession'=>$this->profession??"",
            'like_request_status'=>Auth::user()->getFriendShipStatus(User::find($this->id))
        ];
    }
}
