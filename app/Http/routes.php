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
    Route::post('bindUser'         , 'UserController@bindUser');
    Route::post('unbindUser'         , 'UserController@unbindUser');
    Route::post('addDeviceLog'         , 'DeviceController@addDeviceLog');
    Route::post('pushMsgToSingleDevice'         , 'PushController@pushMsgToSingleDevice');
    Route::post('pushMsgToAll'         , 'PushController@pushMsgToAll');
    Route::post('pushBatchUniMsg'         , 'PushController@pushBatchUniMsg');
    Route::get('getValidateCode'         , 'UserController@getValidateCode');
    Route::get('getDeviceInfo'         , 'DeviceController@getDeviceInfo');
});
