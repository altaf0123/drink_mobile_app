<?php

namespace App\Http\Controllers\API\Feedback;

use App\Http\Controllers\API\APIController;
use App\Models\Feedback;
use Illuminate\Http\Request;

class IndexController extends APIController
{
    public function feedback(Request $request)
    {
        $this->validate($request,[
            'subject'=>'required|string|max:40',
            'message'=>'required|max:150',
        ]);
        $feedback = new Feedback();
        $attachments=[];
        if($request->hasFile('attachments')){
            if(count($request->file('attachments')) > 3){
                return $this->apiErrorMessageResponse('Maximums 3 attachments are allowed');
            }
            foreach($request->file('attachments') as $attachment){
                $name = time().'.'.$attachment->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/feedbacks');
                $attachment->move($destinationPath, $name);
                $attachments[]=$name;
            }
        }
        $feedback->subject = $request->subject;
        $feedback->body = $request->message;
        $feedback->user_id = auth()->user()->id;
        $feedback->attachments = json_encode($attachments);
        $feedback->save();
        return $this->apiSuccessMessageResponse('Feedback received');
    }
}
