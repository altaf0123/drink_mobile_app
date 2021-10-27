<?php

namespace App\Http\Controllers\API\Cart;

use App\Http\Controllers\API\APIController;
use App\Models\Cart;
use Illuminate\Http\Request;

class IndexController extends APIController
{
    //


    public function addToCart(Request $request){
        $this->validate($request,[
            'product_id'=>'required',
            'qty'=>'required'
        ]);
        $cart = Cart::where('user_id',auth()->user()->id)->where('product_id',$request->product_id)->first();
        
        if(!$cart){
            $cart = new Cart();
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $request->product_id;
        }
        $cart->qty = $request->qty;
        $cart->save();

        $cart = Cart::has('product')->with('product')->where('user_id',auth()->user()->id)->get();

        $cartData = $cart->map(function ($item){
            $cart_item = new \stdClass();
            $cart_item->prouct = $item->product->name;
            $cart_item->prouct_image = asset('public/uploads/products/'.$item->product->picture);
            $cart_item->qty = $item->qty;
            return $cart_item;
        });
        return $this->apiDataResponse($cartData);
    }
    
    
     public function removeFromCart(Request $request){
        $this->validate($request,[
            'product_id'=>'required',
        ]);
        $delete_item = Cart::where('user_id',auth()->user()->id)->where('product_id',$request->product_id)->delete();
        $cart = Cart::has('product')->with('product')->where('user_id',auth()->user()->id)->get();

        $cartData = $cart->map(function ($item){
            $cart_item = new \stdClass();
            $cart_item->prouct = $item->product->name;
            $cart_item->prouct_image = asset('public/uploads/products/'.$item->product->picture);
            $cart_item->qty = $item->qty;
            return $cart_item;
        });
        return $this->apiDataResponse($cartData);
    }
    
    
    
    
    public function emptyCart(Request $request){
       
        $delete_item = Cart::where('user_id',auth()->user()->id)->delete();
        $cart = Cart::has('product')->with('product')->where('user_id',auth()->user()->id)->get();
        $cartData = $cart->map(function ($item){
            $cart_item = new \stdClass();
            $cart_item->prouct = $item->product->name;
            $cart_item->prouct_image = asset('public/uploads/products/'.$item->product->picture);
            $cart_item->qty = $item->qty;
            return $cart_item;
        });
        return $this->apiDataResponse($cartData);
    }
}
