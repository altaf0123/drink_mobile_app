<?php

namespace App\Http\Controllers\API\User;
use App\Http\Controllers\API\APIController;
use App\Http\Resources\API\UserDetails;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends APIController
{

    public function userProfile(Request  $request){
        $this->validate($request,[
            'user_id'=>'required'
        ]);
        $user = User::find($request->user_id);
        if($user){
            return $this->apiDataResponse(new UserDetails($user));
        }
        return  $this->apiErrorMessageResponse('Profile Not Found');
    }

}
