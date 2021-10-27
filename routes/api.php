<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DealAlert;


Route::get('deal_alert','DealAlert@deals');


Route::group(['namespace'=>'App\Http\Controllers\API'],function(){

    Route::post('/signup', 'Auth\IndexController@signUp');
    Route::post('/login', 'Auth\IndexController@login');
    Route::post('/otp-resend', 'Auth\OTPVerificationController@resendOTP');
    Route::post('/otp-verify', 'Auth\OTPVerificationController@verifyOTP');
    Route::post('/forgot-password', 'Auth\IndexController@forgotPassword');
    Route::post('/reset-password', 'Auth\IndexController@resetForgotPassword');
    Route::post('/social-auth','Auth\IndexController@socialAuth');
    Route::get('/content','Content\IndexController@getContent');
    
    Route::post('/tip','Content\IndexController@tip');
    
    
    Route::post('/deal_alert','Content\IndexController@deals');
    Route::post('/deal_alert_update','Content\IndexController@dealAlertUpdate');
    
  
    
    Route::group(['middleware'=>'auth:sanctum'],function(){
        
        Route::post('/complete-profile', 'Auth\ProfileController@completeProfile');
        Route::post('/delete-account', 'Auth\ProfileController@deleteAccount');
        Route::post('/change-password', 'Auth\IndexController@changePassword');
        Route::post('/logout','Auth\IndexController@logout');
      
        Route::post('/home','Home\IndexController@home');


        Route::get('restaurants/get','Restaurant\IndexController@getRestaurant');
        Route::get('products','Product\IndexController@products');

        Route::post('cart','Cart\IndexController@addToCart');
        Route::post('cart/remove','Cart\IndexController@removeFromCart');
        Route::post('cart/empty','Cart\IndexController@emptyCart');
        Route::get('tables','Table\IndexController@tables');
        Route::post('tables/reserve','Table\IndexController@reserveTable');
        Route::get('orders','Order\IndexController@orders');
        Route::post('orders/confirm','Order\IndexController@placeOrder');
        
        Route::group(['prefix'=>'payment','namespace'=>'Payment'],function(){
            Route::post('save-card','CardController@addCard');
            Route::post('list-cards','CardController@retrieveCards');
             Route::post('delete-card','CardController@deleteCard');
        });




    });

});
