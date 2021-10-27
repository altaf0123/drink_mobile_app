<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountSettingController extends Controller
{
    //

    public function accountSettings(){
        return view('admin.settings.account');
    }


    public function saveAccountSetting(Request $request){
        $rules=[
            'current_password'=>'required',
            'new_password'=>'required|min:8',
            'new_password_confirmation'=>'same:new_password'
        ];
        $this->validate($request,$rules);
        $user = User::find(Auth::guard('admin')->user()->id);
        if (Hash::check($request->input('current_password'), $user->password)) {
            $user->password = bcrypt($request->input('new_password'));
            $upd = $user->save();
            if($upd){
                return redirect()->back()->with('success', 'Successfully changed password!');
            }else{
                return redirect()->back()->with('error','Something went wrong');
            }
        }else{
            return redirect()->back()->with('error','Invalid Current Password');
        }
    }
}
