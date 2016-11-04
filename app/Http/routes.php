<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('home', 'testController@test');
Route::get('testPush', 'Api\PushController@testPush');
Route::get('login', 'Auth\LoginController@login');
Route::group(['prefix' => 'api', 'namespace' => 'Api'], function() {

    Route::post('login'         , 'UserController@login');
    Route::post('uploadAvatar'         , 'UserController@uploadAvatar');
    Route::post('updateUserInfo'         , 'UserController@updateUserInfo');
    Route::post('register'         , 'UserController@register');
    Route::get('getValidateCode'         , 'UserController@getValidateCode');
});
