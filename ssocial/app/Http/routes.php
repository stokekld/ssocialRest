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

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Layer\User\Admin;
use Core\User\TokenFromUser;
use Core\User\UserFromToken;
use Core\User\AuthUser;

Route::get('/', function () {
    
	

	

});

Route::post('logIn', function (Request $request) {
    
	$credentials = $request->only(['user', 'password']);

	// var_dump($credentials);

	$data = Admin::logIn($credentials);

	$token = TokenFromUser::getToken($data);

	return response()->json(compact("token"));

});


Route::post('verify', function (Request $request) {

	$headers = getallheaders();

	$token = $headers['Authorization'];

	$user = UserFromToken::getUser($token);

	$verify = AuthUser::verify($user);

	return response()->json(compact("verify"));

});



