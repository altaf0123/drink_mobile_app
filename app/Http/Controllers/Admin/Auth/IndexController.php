<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    //


    public function login(){
        if(auth()->guard('admin')->check()) return redirect()->back();
        return view('admin.auth.login');
    }


    public function signIn(Request $request){
        $this->validate($request,[
            'email' =>'required|email',
            'password'=> 'required'
        ]);

        $credentials = ['email'=>$request->email,'password'=>$request->password,'role'=>'admin'];
        if(Auth::guard('admin')->attempt($credentials)){
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->with('error','Invalid credentials entered');
    }

    public function logout(){
        auth()->guard('admin')->logout();
        return redirect()->route('admin.login')->with('success','Logout Out!');
    }
}
