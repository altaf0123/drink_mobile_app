<?php

namespace App\Http\Controllers\API\Order;

use App\Http\Controllers\API\APIController;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends APIController
{


    public function orders(){
        $orders = Order::with(['items','card'=>function($query){
             $query->withTrashed()->select('id','brand','exp_month','exp_year','last_four');
        }])->where('user_id',auth()->user()->id)->get();
        $orders = OrderResource::collection($orders);
        return $this->apiDataResponse($orders);
    }



        public function deals(){
            return response()->json("ok done");
            //
            $this->validate($request,[
                'card_id'=>'required'
            ]);
        }


    public function placeOrder(Request $request){
        $this->validate($request,[
            'card_id'=>'required'
        ]);

        $stripe = new \Stripe\StripeClient(
            'sk_test_51H0UoCJELxddsoRYdF40WwR8HUvA8U5wgUNqQwDCweZT4TnbAuIGINVtVWAItPMcSoMOighLxdZR1Jjl8vdUwldb00EMPAVgIE'
        );
        $customer = $stripe->customers->retrieve(
            auth()->user()->stripe_cus_id
        );
        $card  = UserCard::where('id',$request->card_id)->where('user_id',auth()->user()->id)->first();
        if(!$card){
            return  $this->apiErrorMessageResponse('Invalid card');
        }
        $payment_source = $stripe->customers->retrieveSource(
            auth()->user()->stripe_cus_id,
            $card->token
        );
        $sub_total=0;
        DB::beginTransaction();
        try{
            $cart_items= Cart::with('product')->where('user_id',auth()->user()->id)->get();
            $order = new Order();
            $order->user_id = auth()->user()->id;
            $order->order_status = 'pending';
            $order->payment_status = 'unpaid';
            $order->save();
            foreach ($cart_items as $item){
                $order_item = new OrderItem();
                $order_item->order_id = $order->id;
                $order_item->item_id = $item->product_id;
                $order_item->qty = $item->qty;
                $order_item->price = $item->product->price;
                $order_item->save();
                $sub_total+=    $item->qty*($item->product->price);
            }
            $charge = $stripe->charges->create([
                'customer'=>auth()->user()->stripe_cus_id,
                'amount'=>$sub_total*100,
                'currency'=>'USD',
                'source'=>$payment_source
            ]);
            $order->grand_total = $sub_total;
            $order->payment_status = 'paid';
            $order->card_id = $request->card_id;
            $order->payment_response = json_encode($charge);
            $order->save();
            Cart::where('user_id',auth()->user()->id)->delete();
            DB::commit();
            return $this->apiDataResponse($charge);
        }catch (\Exception $exception){
            DB::rollBack();
            return  $this->apiErrorMessageResponse($exception->getMessage());
        }

    }
    public function chargeCustomer(){

    }




    //
}
