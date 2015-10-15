<?php

namespace App\Http\Controllers\SysControllers;

use App\Http\Controllers\Controller;
use Layer\User\Admin;
use Core\User\Auth\TokenFromUser;
use Core\Exception\RestException;

/**
* 
* Datos necesarios en el request:
* user: nombre de usuario.
* password: contraseña del usuario.
*/
class LogController extends Controller
{
	
	public function logIn()
	{
		$credentials = request()->json()->all();

		$data = Admin::logIn($credentials, "id_admin", "admin_user", "admin_pass", "admin");

		if( !$data )
			throw new RestException(__FILE__, "El usuario/password no es correcto.", 401, ["message" => "El usuario/password no es correcto."]);

		$token = TokenFromUser::getToken($data);

		return response()->json(compact("token"), 200);
	}
}