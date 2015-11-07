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
    
	
	echo "Bienvenido";
	

});

Route::post('logIn', ['uses' => 'SysControllers\LogController@logIn']);

Route::group(['middleware' => 'auth.user'], function(){

	Route::get('ip', ['middleware' => 'authorize.user:admin', 'uses' => 'SysControllers\IpController@all']);
	Route::post('ip', ['middleware' => 'authorize.user:admin', 'uses' => 'SysControllers\IpController@add']);
	Route::delete('ip/{id}', ['middleware' => 'authorize.user:admin', 'uses' => 'SysControllers\IpController@delete']);

	Route::get('servicio', ['middleware' => 'authorize.user:admin', 'uses' => 'SysControllers\ServicioController@all']);
	Route::get('servicio/{id}', ['middleware' => 'authorize.user:admin', 'uses' => 'SysControllers\ServicioController@one']);
	Route::post('servicio', ['middleware' => 'authorize.user:admin', 'uses' => 'SysControllers\ServicioController@add']);
	Route::put('servicio/{id}', ['middleware' => 'authorize.user:admin', 'uses' => 'SysControllers\ServicioController@update']);	//falta
	Route::delete('servicio/{id}', ['middleware' => 'authorize.user:admin', 'uses' => 'SysControllers\ServicioController@delete']);

	Route::get('servicio/{id}/registros', ['middleware' => 'authorize.user:admin', 'uses' => 'SysControllers\RegistrosController@all']);
	Route::put('servicio/{idS}/registros/{idR}', ['middleware' => 'authorize.user:admin', 'uses' => 'SysControllers\RegistrosController@update']);
	Route::delete('servicio/{idS}/registros/{idR}', ['middleware' => 'authorize.user:admin', 'uses' => 'SysControllers\RegistrosController@delete']);

	Route::get('servicio/current/who', ['middleware' => 'authorize.user:servicio', 'uses' => 'SysControllers\RegistroServController@who']);
	Route::get('servicio/current/status', ['middleware' => 'authorize.user:servicio', 'uses' => 'SysControllers\RegistroServController@getStatus']);
	Route::post('servicio/current/inicio', ['middleware' => 'authorize.user:servicio', 'uses' => 'SysControllers\RegistroServController@ini']);
	Route::post('servicio/current/fin', ['middleware' => 'authorize.user:servicio', 'uses' => 'SysControllers\RegistroServController@fin']);	
	Route::get('servicio/current/ownregistros', ['middleware' => 'authorize.user:servicio', 'uses' => 'SysControllers\RegistroServController@all']);
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