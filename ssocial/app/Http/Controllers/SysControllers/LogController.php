<?php

namespace App\Http\Controllers\SysControllers;

use App\Http\Controllers\Controller;
use Layer\User\Admin;
use Layer\User\Servicio;
use Core\User\Auth\TokenFromUser;
use Core\Exception\RestException;
use Layer\Entities\Ip;

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

		if ( $token = $this -> responseToken($data) ) return $token;

		$data = Servicio::logIn($credentials, "id_serv", "serv_user", "serv_pass", "servicio");

		if ( $token = $this -> responseToken($data) ) return $token;

		throw new RestException(__FILE__, "El usuario/password no es correcto.", 403, ["message" => "El usuario/password no es correcto."]);
	}

	private function responseToken($data)
	{
		if (is_array($data))
		{
			if ($data['type'] == 'servicio')
			{
				$servicio = Servicio::find($data['data']['id_serv']);

				if (!$servicio -> serv_activo)
					throw new RestException(__FILE__, "Sin acceso a la plataforma.", 403, ["message" => "Sin acceso a la plataforma."]);

				$ips = [];

				(new Ip) -> allThem() -> each(function($item, $key) use (&$ips){
					array_push($ips, $item -> ipp);
				});

				if ( !in_array($_SERVER['REMOTE_ADDR'], $ips) )
					throw new RestException(__FILE__, "Ip desconocida.", 403, ["message" => "Ip desconocida."]);
			}

			$token = TokenFromUser::getToken($data);
			$type = $data['type'];

			return response()->json(compact("token", "type"), 200);
		}

		return null;
	}
}