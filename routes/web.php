<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('welcome');
})->name('login');




Route::group(['prefix'=>'admin','namespace'=>'App\Http\Controllers\Admin'],function(){
    Route::get('/','Auth\IndexController@login')->name('admin.login');
    Route::post('/login','Auth\IndexController@signIn')->name('admin.login');


    Route::group(['middleware'=>'admin'],function(){
        Route::get('/dashboard','Dashboard\IndexController@index')->name('admin.dashboard');



        Route::group(['prefix'=>'content','namespace'=>'Content'],function() {
            Route::get('/{type}', 'IndexController@content')->name('admin.content');
            Route::post('/{type}', 'IndexController@saveContent')->name('admin.content.save');
        });


        Route::group(['prefix'=>'feedback','namespace'=>'Feedback'],function() {
            Route::get('/', 'IndexController@index')->name('admin.feedback');
            Route::post('/view{id}', 'IndexController@view')->name('admin.feedback.view');
        });


        Route::group(['prefix'=>'admin','namespace'=>'Setting'],function() {
            Route::get('/settings', 'AccountSettingController@accountSettings')->name('admin.settings.account');
            Route::post('/settings', 'AccountSettingController@saveAccountSetting')->name('admin.settings.account');
        });

        Route::post('/logout','Auth\IndexController@logout')->name('admin.logout');


    });
});
