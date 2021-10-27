<?php
namespace App\Http\Services;
class APIResponse{
    public function apiMessageResponse($message='success',$status=1,$data=[])
    {
        return response()->json(["status" => $status, "message" => $message, "data" => $data]);
    }

    public function apiSuccessMessageResponse($message='success',$data=[])
    {
        return response()->json(["status" => 1, "message" => $message, "data" => $data]);
    }

    public function apiErrorMessageResponse($message='failed',$data=[])
    {
        return response()->json(["status" => 0, "message" => $message, "data" => $data]);
    }

    public function apiDataResponse($data=[],$message='success'){
        if(count($data)>0){
            return response()->json(["status" => 1, "message" => $message, "data" => $data]);
        }else{
            return response()->json(["status" => 0, "message" => "No data Found", "data" => $data]);
        }
    }
}

