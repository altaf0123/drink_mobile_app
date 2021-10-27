<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\APIController;
use App\Http\Resources\API\LoggedInUser;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OTPVerificationController extends APIController
{
    public function verifyOTP(Request $request){
        $this->validate($request,[
            'email'=>"required|email",
            'otp'=>'required',
            'device_type'=>'required|in:android,ios',
            'device_token'=>'required'
        ]);
        $user = User::where(['email'=>$request->email])->first();
        if(isset($user) && $user->account_verified){
            return $this->apiErrorMessageResponse('Account already verified');
        }
        if(isset($user) && $user->email_verified_at==null && !$user->account_verified && $user->otp===$request->otp){
            $user->otp = null;
            $user->email_verified_at = Carbon::now();
            $user->account_verified = true;
            $user->device_type = $request->device_type;
            $user->device_token = $request->device_token;
            $user->save();
            $user->tokens()->delete();
            $token =$user->createToken('authToken')->plainTextToken;
            // $loggedInUser = new LoggedInUser($user);
            return response()->json([
                'status'=>1,
                'message'=>'OTP verified',
                'data'=>$user,
                'bearer_token'=>$token
            ]);
       }
        return $this->apiErrorMessageResponse('OTP is invalid');
    }


    public function resendOTP(Request $request){
        $this->validate($request,[
            'email'=>'required|email'
        ]);
        
        $user = User::where('email',$request->email)->first();
        if($user){
            if($user->email_verified_at!=null && $user->account_verified==1){
                return $this->apiErrorMessageResponse('User is already verified');
            }else{
                $user->otp = rand(100000,999999);
                $user->save();
                Notification::send($user, new VerifyEmailNotification($user));
                return $this->apiSuccessMessageResponse('Otp sent successfully');
            }
        }
        return $this->apiErrorMessageResponse('User not registered');
    }


}
