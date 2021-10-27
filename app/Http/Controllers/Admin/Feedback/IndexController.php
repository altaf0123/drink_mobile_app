<?php

namespace App\Http\Controllers\Admin\Feedback;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //


    public function index(){
        $feedbacks = Feedback::with('user')->latest()->paginate(8);
        return view('admin.feedback.index',compact('feedbacks'));
    }


    public function view(){

    }
}
