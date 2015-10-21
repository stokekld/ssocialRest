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
    
	
	var_dump(response());
	

});

Route::post('logIn', ['uses' => 'SysControllers\LogController@logIn']);

Route::group(['middleware' => 'auth.user'], function(){

	Route::post('ip', ['uses' => 'SysControllers\IpController@add']);
	Route::get('ip', ['uses' => 'SysControllers\IpController@all']);
	Route::delete('ip/{id}', ['uses' => 'SysControllers\IpController@delete']);

	Route::get('servicio', ['uses' => 'SysControllers\ServicioController@all']);
	Route::get('servicio/{id}', ['uses' => 'SysControllers\ServicioController@one']);
	Route::post('servicio', ['uses' => 'SysControllers\ServicioController@add']);
	Route::put('servicio/{id}', ['uses' => 'SysControllers\ServicioController@update']);	//falta
	Route::delete('servicio/{id}', ['uses' => 'SysControllers\ServicioController@delete']);

	Route::get('servicio/current/registros', ['uses' => 'SysControllers\RegistrosController@all']);
	Route::post('servicio/current/registros', ['uses' => 'SysControllers\RegistrosController@add']);
});






use Core\Log\Log;
Event::listen('illuminate.query', function($query, $bindings, $time, $name)
{

	$data = [
		"time" => $time,
		"query" => $query,
		"bindings" => $bindings
	];

	Log::addDebug($name, $data );
});