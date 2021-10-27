<?php

namespace App\Http\Controllers\API\Home;

use App\Http\Controllers\API\APIController;

use App\Http\Resources\API\RestaurantResource;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends APIController
{



    public function home(Request $request){
        $this->validate($request,[
            //'address'=>'required',
            'lat'=>'required',
            'long'=>'required',
            'radius'=>'required'
        ]);
        $lat = $request->lat;
        $long = $request->long;
        $radius = $request->radius;
        $user = Auth::user();
        $user->updateLocation($request);
        $restaurants = Restaurant::with('images')->select('*')->selectRaw("(
            6371* acos (
            cos ( radians(restaurants.lat) )
            * cos( radians( $lat ) )
            * cos( radians( $long ) - radians(restaurants.long) )
            + sin ( radians(restaurants.lat) )
            * sin( radians( $lat ) )
          )
        ) AS distance")
            ->having('distance', '<', $radius)->get();
        $restaurants = RestaurantResource::collection($restaurants);
        return $this->apiDataResponse($restaurants);
    }


}
