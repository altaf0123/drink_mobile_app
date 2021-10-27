<?php

namespace App\Http\Controllers\API\Content;

use App\Http\Controllers\API\APIController;
use App\Models\Content;
use App\Models\Order;

use Illuminate\Http\Request;


class IndexController extends APIController
{
    //
    public function getContent(Request $request){
        $content = Content::where('type',$request->type)->first();
        return $this->apiDataResponse($content);
    }
    
    public function deals(Request $request){
        try{
            if($request->user_id){
                $all_alerts = \DB::table('deal_alerts')
                ->join('update_deal_alert','deal_alerts.id','update_deal_alert.deal_alert_id')
                ->select("deal_alerts.id","deal_alerts.title","deal_alerts.description","update_deal_alert.is_read")
                ->where(['update_deal_alert.user_id'=>$request->user_id])
                ->orderBy('deal_alerts.id','desc')
                ->get();
                if(@$all_alerts && count($all_alerts) > 0 ) {
                    return response()->json(["status" => 1, "message" => "data retrieved successfully", "data" => $all_alerts]);
                }
                return response()->json(["status" => 1, "message" => "No any Deal alert found", "data" => []]);
            }
             return $this->apiErrorMessageResponse();
        } catch(\Exception $e) {
            return $this->apiErrorMessageResponse();
        }
    }
    
    public function dealAlertUpdate(Request $request) {
        try{
            if($request->user_id){
                $exist = \DB::table('update_deal_alert')->where(["user_id"=>$request->user_id,"is_read"=>0])->update(['is_read'=>1]);
                if($exist){
                    return $this->apiDataResponse(["message"=>"Updated"]);
                }
                return response()->json(["status" => 0, "message" => "Not Updated"]);
            }            
            return $this->apiDataResponse();            
        } catch(\Exception $e) {
            return $this->apiErrorMessageResponse();
        }
    }
    
    public function tip(Request $request){
        try {
            $order = Order::select("id","user_id")->find($request->order_id);
            if($order->id && $request->tip_amount){
                $order->tip = $request->tip_amount;
                if($order->save()){
                    return response()->json(["status" => 1, "message" => "Tip added successfully"]);
                }
                return response()->json(["status" => 0, "message" => "Not Updated"]);
            } else {
               return  $this->apiErrorMessageResponse('OrderId / Tip amount not found');     
            }
        } catch(\Exception $e) {
            return  $this->apiErrorMessageResponse('Sorry! we can not process request');
        }
    }
    
    
    
}
