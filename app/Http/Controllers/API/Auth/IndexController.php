<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\API\Auth\SignUpRequest;
use App\Http\Resources\API\LoggedInUser;
use App\Http\Resources\API\UserDetails;
use App\Models\User;
use App\Notifications\PasswordResetNotification;
use App\Notifications\VerifyEmailNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class IndexController extends APIController
{
    public function signUp(SignUpRequest $request){
        
        $email = User::where('email',$request->email)->first();
        if($email){
             if(!$email->account_verified && $email->email_verified_at==null){
                $email->otp = rand(100000,999999);
                $email->save();
                $email->notify(new VerifyEmailNotification($email));
                return $this->apiSuccessMessageResponse('We have sent OTP verification code at your email address');
             }
             return $this->apiErrorMessageResponse('User already exists with this email');
        }
        $user = new User();
        $user->otp = rand(100000,999999);
        // $user->otp = 123456;
        $user->email =$request->email;
        $user->password= bcrypt($request->password);
        $user->save();
        $user->notify(new VerifyEmailNotification($user));
        if($user){
            return $this->apiSuccessMessageResponse('We have sent OTP verification code at your email address');
        }else{
            return $this->apiErrorMessageResponse('Something Went Wrong');
        }
    }

    public function login(LoginRequest $request){
        $authenticate_user  = Auth::attempt(['email'=>$request->email,'password'=>$request->password]);
        if($authenticate_user){
            $user = Auth::user();
            if($user->account_verified && $user->email_verified_at!=null){
                $user->device_type = $request->device_type;
                $user->device_token = $request->device_token;
                $user->save();
                $user->tokens()->delete();
                $token =$user->createToken('authToken')->plainTextToken;
                $user->token = $token;
                $loggedInUser = $user;
                return response()->json([
                    'status'=>1,
                    'message'=>'Login Successfull',
                    'data'=>$loggedInUser,
                    'bearer_token'=>$token
                ]);
            }else{
                $user->otp = rand(100000,999999);
                $user->save();
                $user->notify(new VerifyEmailNotification($user));
                return $this->apiSuccessMessageResponse('We have sent OTP verification code at your email address',new LoggedInUser($user));
            }
        }
        return $this->apiErrorMessageResponse('Invalid Credentials Entered');
    }

    public function changePassword(Request $request){
        $this->validate($request,[
            'old_password'=>'required',
            'new_password'=>'required|min:8'
        ]);
        $hashedPassword = Auth::user()->password;

        if (Hash::check($request->old_password , $hashedPassword )) {
            if (!Hash::check($request->new_password , $hashedPassword)) {
                $user = Auth::user();
                $user->password = bcrypt($request->new_password);
                $user->save();
                return $this->apiSuccessMessageResponse('Password updated');
            }else{
                return $this->apiErrorMessageResponse('New password can not be same as the old password!');
            }
        }
        return $this->apiErrorMessageResponse('Old Password Is Incorrect');
    }



    public function forgotPassword(Request $request){
        $this->validate($request,[
            'email'=>'required|email'
        ]);
        $user = User::where('email',$request->email)->first();
        if($user){
            if($user->is_social){
                return $this->apiErrorMessageResponse('Password can not be changed because this account is registered using social media platform.');
            }
            if($user->email_verified_at===null || !$user->account_verified){
                return $this->apiErrorMessageResponse('You need to verify your account first');
            }
            $token = rand(100000,999999);
            DB::table('password_resets')->where('email', $user->email)->insert([
                'email'=>$user->email,
                'token'=> $token,
                'created_at'=>Carbon::now()
            ]);
            $user->notify(new PasswordResetNotification($token));
            return $this->apiSuccessMessageResponse('Password reset otp has been sent to your email address');
        }
        return $this->apiErrorMessageResponse('Invalid Email');

    }


    public function resetForgotPassword(Request $request){
        $this->validate($request,[
            'otp'=>'required',
            'new_password'=>'required|min:8',
            'email'=>'required|email'
        ]);
        $check_otp = DB::table('password_resets')->where(['token'=>$request->otp,'email'=>$request->email])->first();
        if($check_otp){
            $totalDuration = Carbon::parse($check_otp->created_at)->diffInHours(Carbon::now());
            if($totalDuration > 1){
                return $this->apiErrorMessageResponse('OTP Expired');
            }
            $user = User::where('email',$check_otp->email)->first();
            $user->password = bcrypt($request->new_password);
            $user->save();
            DB::table('password_resets')->where(['token'=>$request->otp,'email'=>$request->email])->delete();
            return $this->apiSuccessMessageResponse('Password updated');
        }
        return $this->apiErrorMessageResponse('Invalid OTP');

    }

    public function updateLocation(Request $request){
        $user = Auth::user();
        $user->lat = $request->lat;
        $user->long = $request->long;
        $user->save();
        return $this->apiSuccessMessageResponse('Location Updated');
    }

    public function socialAuth(Request $request){
        $this->validate($request,[
            'access_token'=>'required',
            'provider'=>'required|in:google,facebook,apple,phone',
            'device_type'=>'required|in:android,ios',
            'device_token'=>'required',
        ]);
        try{
            if ($request->provider == "phone" || $request->provider == "apple") {
                $user = User::where('social_token',$request->access_token)->first();
                if(!$user){
                    $user = new User();
                    $user->social_token = $request->access_token;
                }
                $user->is_social = 1;
                if(!$user->account_verified){
                    $user->account_verified = 1;
                    // $user->email_verified_at = Carbon::now();
                }
                $user->device_type = $request->device_type;
                $user->device_token = $request->device_token;
                $user->save();

                $user = User::where('id',$user ->id)->first();

                $user->tokens()->delete();
                $token =$user->createToken('authToken')->plainTextToken;
                $user->token = $token;
                $loggedInUser = $user;     

                return response()->json([
                    'status'=>1,
                    'message'=>'Login Successful',
                    'data'=>$loggedInUser,
                    'bearer_token'=>$token
                ]);           
                // dd($request->provider);
            }

            else{
                $providerUser  = Socialite::driver($request->provider)->userFromToken($request->access_token);
                $provider_email = $providerUser->getEmail();
                $user = User::where('email',$provider_email)->first();
                if(!$user){
                    $user = new User();
                    $user->email = $providerUser->getEmail();
                    $user->name = $providerUser->getName();
                }
                $user->is_social = 1;
                if(!$user->account_verified){
                    $user->account_verified = 1;
                    $user->email_verified_at = Carbon::now();
                }
                $user->device_type = $request->device_type;
                $user->device_token = $request->device_token;
                $user->save();

                $user = User::where('id',$user ->id)->first();

                $user->tokens()->delete();
                $token =$user->createToken('authToken')->plainTextToken;
                $user->token = $token;
                $loggedInUser = $user;
                return response()->json([
                    'status'=>1,
                    'message'=>'Login Successful',
                    'data'=>$loggedInUser,
                    'bearer_token'=>$token
                ]);

            }                

        }catch (\Exception $e){
            // dd('exc');
            
            return response()->json([
                'status'=>0,
//                'message'=>'Login Failed',
                'message'=>$e->getMessage(),
            ]);
        }
    }
    
    
    
    
    public function logout(){
        $user = Auth::user();
        $user->tokens()->delete();
        $user->device_type = null;
        $user->device_token = null;
        $user->save();
        return $this->apiSuccessMessageResponse('Logged Out');
    }
}
