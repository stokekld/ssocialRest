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

use Layer\User\Admin;
use Core\User\TokenFromUser;
use Core\User\UserFromToken;
use Core\User\AuthUser;

Route::get('/', function () {
    
	

	

});

Route::post('logIn', function (Request $request) {
    
	$credentials = $request->only(['user', 'password']);

	$data = Admin::logIn($credentials);

	$token = TokenFromUser::getToken($data);

	echo $token."\n\n";

	$user = UserFromToken::getUser("eyJpdiI6IkpQVVwvV2JldHNPZWhRZnpqQ1JDb09nPT0iLCJ2YWx1ZSI6IkpHN004V1FTakRRUUZ6NmRSaFpKbFRBRVJtZUNcL0Q4SkRwbkIwNVUzNEZKNWVvc3ZGeGhwek83eWMySXJSWk80Slwvakp2V0krZWpwbzdPYzJMQVBlWHI3VUgxaW1SbE1UV0RVaW9aRTVQMWtTMTVKZU1UU2c3YmYxckpOTG1LN3RWWVhIXC9sOFwvSnB5MVNKQTdObjV0RzdIbU04RVUwS3JlVVpwSE0xdVFEc0Q5YkhvVzZscStMb2VOSnlkYW5PYmJKT3kxeDdpMVJWYmVpcTMrYkRBYXVGbndDS2lcL0ErVEZGVGdXUlo0Y2FsYz0iLCJtYWMiOiI1OThiODExNDUxZWE5ZTFkZDIxOTRmZjRhZDBmNjE1YjcwN2EwODdkYmZlYWIyNmYzODUzY2U4YjJkMWU1OTA2In0=");

	var_dump($user);

	$verify = AuthUser::verify($user);

	var_dump($verify);

});
