<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;

class IndexController extends Controller
{


    public function content(Request $request){
        $content = Content::where('type',$request->type)->first();
        if($content){
            return view('admin.content.edit',compact('content'));
        }
        return redirect()->back()->with('error','Content Not Found');

    }



    public function saveContent(Request  $request){
        $content = Content::where('type',$request->type)->first();
        if($content){
            $content->body = $request->body;
            $content->save();
            return redirect()->back()->with('success','Content Saved');
        }
        return redirect()->back()->with('error','Content Not Saved');
    }
    //
}
