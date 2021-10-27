<?php

namespace App\Http\Controllers\API\Auth;
use App\Http\Controllers\API\APIController;
use App\Http\Requests\Api\Auth\CompleteProfile;
use App\Http\Resources\API\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class ProfileController extends APIController
{

    public function completeProfile(CompleteProfile $request){
        $user = Auth::user();
        $user->name             = $request->name;
        // $user->gender           = $request->gender;
        // $user->location_range   = $request->location_range;
        // $user->date_of_birth    = $request->date_of_birth;
        

        if($request->hasFile('profile_picture')){
            $user->uploadMedia($request->file('profile_picture'),'profile_picture');
        }
        
        // elseif (empty($request->file('profile_picture'))) {
        //     $imageName = null;
        // }
        
        $user->is_profile_complete    = 1;
        $user->save();
        return $this->apiSuccessMessageResponse('Profile Completed', $user);
    }
    
    
    
    public function deleteAccount(Request $request){
        $user = Auth::user();
     
        $user->device_type = null;
        $user->device_token = null;
        $user->profile_picture = null;
        $user->is_profile_complete    = 0;
        $user->social_token    = null;
        $user->social_type    = null;
        $user->deleted_at    = Carbon::now();
        $user->save();
        $user->tokens()->delete();
        return $this->apiSuccessMessageResponse('Account deleted');
    }
}