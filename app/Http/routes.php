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
Route::get('login', function () {
    return view('ace.index');
});
Route::get('home', 'testController@test');
Route::get('testPush', 'Api\PushController@testPush');
Route::get('login', 'Auth\LoginController@login');
Route::get('admin/login'         , 'AdminController@login');
Route::get('admin/postLogin'         , 'AdminController@postLogin');
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function() {
    Route::get('index'         , 'AdminController@index');
    Route::get('userInfoIndex'         , 'AdminController@userInfoIndex');
    Route::get('suggestionIndex'         , 'AdminController@suggestionIndex');
    Route::get('appIndex'         , 'AdminController@appIndex');
    Route::get('defriend'         , 'AdminController@defriend');
    Route::post('uploadApp'         , 'AdminController@uploadApp');
});
Route::group(['prefix' => 'api', 'namespace' => 'Api'], function() {

    Route::post('login'         , 'UserController@login');
    Route::post('uploadAvatar'         , 'UserController@uploadAvatar');
    Route::post('updateUserInfo'         , 'UserController@updateUserInfo');
    Route::post('updatePassword'         , 'UserController@updatePassword');
    Route::post('addSuggestion'         , 'UserController@addSuggestion');
    Route::post('register'         , 'UserController@register');
    Route::post('bindUser'         , 'UserController@bindUser');
    Route::get('getBindUser'         , 'UserController@getBindUser');
    Route::post('unbindUser'         , 'UserController@unbindUser');
    Route::post('addDeviceLog'         , 'DeviceController@addDeviceLog');
    Route::post('pushMsgToSingleDevice'         , 'PushController@pushMsgToSingleDevice');
    Route::post('pushMsgToAll'         , 'PushController@pushMsgToAll');
    Route::post('pushBatchUniMsg'         , 'PushController@pushBatchUniMsg');
    Route::get('getValidateCode'         , 'UserController@getValidateCode');
    Route::get('checkDownload'         , 'UserController@checkDownload');
    Route::get('agreement'         , 'UserController@Agreement');  
    Route::get('getDeviceInfo'         , 'DeviceController@getDeviceInfo');
    Route::get('getDeviceInfoAndroid'         , 'DeviceController@getDeviceInfoAndroid');
    Route::get('getDeviceInfoFreAndroid'         , 'DeviceController@getDeviceInfoFreAndroid');
});


