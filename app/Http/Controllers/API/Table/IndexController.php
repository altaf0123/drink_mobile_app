<?php

namespace App\Http\Controllers\API\Table;

use App\Http\Controllers\API\APIController;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\TableResource;
use App\Models\Reservation;
use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\UserCard;
use Illuminate\Support\Facades\DB;

class IndexController extends APIController
{


    public function tables(Request $request){
        $this->validate($request,['restaurant_id'=>'required']);
        $tables = Table::where('restaurant_id',$request->restaurant_id)->get();
        $tables = TableResource::collection($tables);
        return $this->apiDataResponse($tables);
    }


    public function reserveTable(Request $request){
        $this->validate($request,[
            'table_id'=>'required',
            'date_time'=>'required',
             'card_id'=>'required'
        ]);

        $table = Table::with('reservations')->find($request->table_id);
        if(!$table){
            return $this->apiErrorMessageResponse('not found');
        }

        $booking_time = Carbon::parse($request->date_time);
        $booking_from = $booking_time->format('Y-m-d H:i:s');
        $booking_to = $booking_time->addHour()->format('Y-m-d H:i:s');
        $check_reservation = Reservation::whereBetween('time_to',[$booking_from,$booking_to])->first();
        if($check_reservation){
            return  $this->apiErrorMessageResponse('This table is already booked for specified time');
        }
        
   
        if($this->chargeCustomer($request->card_id, $table->price)){
            $reserve_table = new Reservation();
            $reserve_table->user_id = auth()->user()->id;
            $reserve_table->table_id = $request->table_id;
            $reserve_table->time_from = $booking_from;
            $reserve_table->time_to = $booking_to;
            $reserve_table->status = 'un_confirmed';
            $reserve_table->price = $table->price;
            $reserve_table->card_id = $request->card_id;
            $reserve_table->save();
            return  $this->apiSuccessMessageResponse('table has been reserved');
        }else{
             return  $this->apiErrorMessageResponse('Payment failed');
        }
    
    }
    
    
    public function chargeCustomer($card_id,$amount){
        $stripe = new \Stripe\StripeClient('sk_test_51H0UoCJELxddsoRYdF40WwR8HUvA8U5wgUNqQwDCweZT4TnbAuIGINVtVWAItPMcSoMOighLxdZR1Jjl8vdUwldb00EMPAVgIE');
        $customer = $stripe->customers->retrieve(
            auth()->user()->stripe_cus_id
        );
        $card  = UserCard::where('id',$card_id)->where('user_id',auth()->user()->id)->first();
        if(!$card){
            return  false;
        }
        
        
        try{
            $payment_source = $stripe->customers->retrieveSource(
                auth()->user()->stripe_cus_id,
                $card->token,
            );
            $charge = $stripe->charges->create([
                'customer'=>auth()->user()->stripe_cus_id,
                'amount'=>$amount*100,
                'currency'=>'USD',
                'source'=>$payment_source
            ]);
            return true;
            
            
        }catch(\Exception $e){
            return ['status'=>0,'message'=>$e->getMessage()];
        }
        
        

        
    }
}
