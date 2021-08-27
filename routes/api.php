<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::post('mark-conversation', 'API\UserController@mark_conversation');
Route::post('add-emotion', 'API\UserController@add_emotion');
Route::post('get-user-stats', 'API\UserController@get_user_stats');



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



 
Route::middleware('auth:api')->group(function () {
	
    Route::post('profile', 'API\UserController@details');
 	Route::post('update-profile','API\UserController@update_profile');
 	
    

});