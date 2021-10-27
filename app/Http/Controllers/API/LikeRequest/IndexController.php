<?php

namespace App\Http\Controllers\API\LikeRequest;

use App\Http\Controllers\API\APIController;
use App\Http\Resources\API\UserDetails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends APIController
{

    public function sendRequest(Request $request)
    {
        $this->validate($request,[
            'recipient_id'=>'required',
        ]);
        $user = Auth::user();
        if($user->id === $request->recipient_id){
            return $this->apiErrorMessageResponse('Sender and receiver can not be same');
        }
        $recipient = User::find($request->recipient_id);
        if(!isset($recipient) || !$recipient->account_verified || !$recipient->is_profile_complete){
            return $this->apiErrorMessageResponse('Invalid recipient ID');
        }
        $send_request = $user->sendRequest($recipient);
        if($send_request){
            return $this->apiSuccessMessageResponse('Request Sent');
        }
        return $this->apiErrorMessageResponse('Request Not Sent');
    }



    public function acceptRequest(Request $request){
        $this->validate($request,[
            'recipient_id'=>'required',
        ]);
        $user = Auth::user();
        $recipient = User::find($request->recipient_id);
        if(!isset($recipient) || !$recipient->account_verified || !$recipient->is_profile_complete){
            return $this->apiErrorMessageResponse('Invalid recepient ID');
        }
        $request_accepted = $user->acceptRequest($recipient);
        if($request_accepted){
            return $this->apiSuccessMessageResponse('Request Accepted');
        }
        return $this->apiErrorMessageResponse('Failed To Accept Request');

    }



    public function rejectRequest(Request $request){
        $this->validate($request,[
            'recipient_id'=>'required',
        ]);
        $user = Auth::user();
        $recipient = User::find($request->recipient_id);
        if(!isset($recipient) || !$recipient->account_verified || !$recipient->is_profile_complete){
            return $this->apiErrorMessageResponse('Invalid recipient ID');
        }
        $request_rejected = $user->denyRequest($recipient);
        if($request_rejected){
            return $this->apiSuccessMessageResponse('Request Rejected');
        }
        return $this->apiErrorMessageResponse('Failed To Reject Request');

    }


    public function mutualLikes(Request $request){
        $friends = Auth::user()->getFriends($request->offset,$request->limit);
        $mutual= UserDetails::collection($friends);
        return   $this->apiDataResponse($mutual);
    }



    public function sentLikeRequest(Request  $request){
        $this->validate($request,[
            'limit'=>'required',
            'offset'=>'required'
        ]);
        $like_requests_sent = Auth::user()->getLikeRequestsSent($request->offset,$request->limit);
        $requests = UserDetails::collection($like_requests_sent);
        return   $this->apiDataResponse($requests);
    }


    public function receivedLikeRequest(Request  $request){
        $this->validate($request,[
            'limit'=>'required',
            'offset'=>'required'
        ]);
        $like_requests_received = Auth::user()->getLikeRequestsReceived($request->offset,$request->limit);
        $requests = UserDetails::collection($like_requests_received);
        return   $this->apiDataResponse($requests);
    }


    public function cancelRequest(Request  $request){
        $this->validate($request,[
            'recipient_id'=>'required'
        ]);
        $recipient = User::find($request->recipient_id);
        if($recipient){
           $cancel_request =  Auth::user()->cancelRequest($recipient);
           if($cancel_request){
               return $this->apiSuccessMessageResponse('Request Cancelled');
           }
           return $this->apiErrorMessageResponse('Failed To Reject Request');
        }
        return $this->apiErrorMessageResponse('Invalid recipient');

    }
    //
}
