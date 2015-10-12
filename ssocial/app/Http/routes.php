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
    
	
	echo "hola";
	

});

Route::post('logIn', ['uses' => 'SysControllers\LogController@logIn']);

Route::post('verify', ['middleware' => 'auth.user', function(){


	echo "entro";

	$userSys = App::make('UserSys');

	var_dump($userSys);
}]);


// Route::post('verify', function (Request $request) {

// 	// $headers = getallheaders();

// 	// $token = $headers['Authorization'];

// 	// $user = UserFromToken::getUser($token);

// 	// $verify = AuthUser::verify($user);

// 	// return response()->json(compact("verify"));

// });



