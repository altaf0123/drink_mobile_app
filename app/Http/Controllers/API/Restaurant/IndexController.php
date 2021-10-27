<?php

namespace App\Http\Controllers\API\Restaurant;

use App\Http\Controllers\API\APIController;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class IndexController extends APIController
{

    public function getRestaurant(Request $request){
        $this->validate($request,[
            'id'=>'required'
        ]);
        if(!auth()->user()->lat || !auth()->user()->long || !auth()->user()->location_range){
            return $this->apiErrorMessageResponse('User\'s coordinates not found');
        }
        $lat = auth()->user()->lat;
        $long = auth()->user()->long;
        $radius = auth()->user()->location_range;
        $restaurant = Restaurant::with('images')->select('*')->selectRaw("(
            6371* acos (
            cos ( radians(restaurants.lat) )
            * cos( radians( $lat ) )
            * cos( radians( $long ) - radians(restaurants.long) )
            + sin ( radians(restaurants.lat) )
            * sin( radians( $lat ) )
          )
        ) AS distance")->find($request->id);
        if(!$restaurant){
            return $this->apiErrorMessageResponse('Not found');
        }
        $restaurant = new RestaurantResource($restaurant);
        return  $this->apiDataResponse($restaurant);
    }



}
