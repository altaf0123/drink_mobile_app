<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\API\APIController;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends APIController
{



    public function products(Request $request){
        $this->validate($request,[
            'restaurant_id'=>'required',
            'category_id'=>'required'
        ]);
        $products = Product::where('cat_id',$request->category_id)->where('restaurant_id',$request->restaurant_id)->get();
        $products = ProductResource::collection($products);
        return $this->apiDataResponse($products);
    }

    //
}
