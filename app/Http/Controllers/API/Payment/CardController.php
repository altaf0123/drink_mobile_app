<?php

namespace App\Http\Controllers\API\Payment;

use App\Http\Controllers\API\APIController;
use App\Http\Controllers\Controller;
use App\Models\UserCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends APIController
{

    public function addCard(Request $request){
        $this->validate($request,[
            'source_token'=>'required'
        ]);
        $stripe = new \Stripe\StripeClient(
            'sk_test_51H0UoCJELxddsoRYdF40WwR8HUvA8U5wgUNqQwDCweZT4TnbAuIGINVtVWAItPMcSoMOighLxdZR1Jjl8vdUwldb00EMPAVgIE'
        );
        $stripe_customer_id = auth()->user()->stripe_cus_id;
        if(!auth()->user()->stripe_cus_id){
            $customer  = $stripe->customers->create([
                'name'=>auth()->user()->name,
            ]);
            $user = Auth::user();
            $user->stripe_cus_id = $customer->id;
            $user->save();
            $stripe_customer_id = $customer->id;
        }
       try{
           $source = $stripe->customers->createSource(
               $stripe_customer_id,
               ['source' => $request->source_token]
           );
       }catch (\Exception $exception){
            return  $this->apiErrorMessageResponse($exception->getMessage());
       }
        $card = UserCard::where('finger_print',$source->fingerprint)->where('user_id',auth()->user()->id)->first();
        if(!$card){
            $card = new UserCard();
            $card->user_id = auth()->user()->id;
            $card->finger_print =$source->fingerprint;
        }
        $card->brand = $source->brand;
        $card->exp_month = $source->exp_month;
        $card->exp_year = $source->exp_year;
        $card->last_four = $source->last4;
        $card->token = $source->id;
        $card->save();
        return  $this->apiSuccessMessageResponse('card saved');
    }



    public function retrieveCards(){
        $stripe = new \Stripe\StripeClient(
            'sk_test_51H0UoCJELxddsoRYdF40WwR8HUvA8U5wgUNqQwDCweZT4TnbAuIGINVtVWAItPMcSoMOighLxdZR1Jjl8vdUwldb00EMPAVgIE'
        );
        $cards = UserCard::select('id','brand','exp_month','exp_year','last_four')->where('user_id',auth()->user()->id)->get();
        return  $this->apiDataResponse($cards);
    }
    
    
    
    public function deleteCard(Request $request){
        $this->validate($request,[
            'card_id'=>'required'
        ]);
        $stripe = new \Stripe\StripeClient(
            'sk_test_51H0UoCJELxddsoRYdF40WwR8HUvA8U5wgUNqQwDCweZT4TnbAuIGINVtVWAItPMcSoMOighLxdZR1Jjl8vdUwldb00EMPAVgIE'
        );
        $stripe_customer_id = auth()->user()->stripe_cus_id;
        $card = UserCard::where('id',$request->card_id)->where('user_id',auth()->user()->id)->first();
        if(!$card){
            return  $this->apiErrorMessageResponse('Card not found');
        }
          try{
              $source = $stripe->customers->deleteSource(
                  $stripe_customer_id,
                  $card->token
              );
               $card = UserCard::where('id',$request->card_id)->delete();
          }catch (\Exception $exception){
                return  $this->apiErrorMessageResponse($exception->getMessage());
          }
        return  $this->apiSuccessMessageResponse('card deleted');
    }




}
