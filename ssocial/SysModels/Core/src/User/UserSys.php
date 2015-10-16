<?php
/**
* Archivo que contiene la clase UserSys
* @author Humberto de Jesus Flores Acuña <joy_warmgun@hotmail.com>
* @version 0.0.1
* @package Core\User
*/

namespace Core\User;

use Illuminate\Routing\ResponseFactory as Response;

/**
* Esta clase contiene los datos de un usuario ya autentificado
*
* Debe de existir una instancia para toda la aplicación.
*/
class UserSys
{
	/**
	* Método para cargar un array a la instancia.
	*
	* @param array $user Contiene los datos del usuario a cargar.
	*/
	public function load($user = [])
	{
		foreach ($user as $key => $value) {
			$this -> $key = $value;
		}		
	}

	/**
	* Método para crear la respuesta al usuario.
	*
	* @param stdClass Contiene el motor para responder al usuario (Response)
	* @param array $data Contiene los datos a añadir a la respuesta.
	* @param int $code Contiene el código http.
	*
	*
	*/
	public function response($motor, $data, $code)
	{
		$data = array_merge( [ 'token' => $this -> token, 'httpCode' => $code ], [ 'data' => $data]);

		return $motor -> json($data, $code);
	}
}