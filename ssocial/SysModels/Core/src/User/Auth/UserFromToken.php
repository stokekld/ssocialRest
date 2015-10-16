<?php
/**
* Archivo que contiene la clase UserFromToken
* @author Humberto de Jesus Flores Acuña <joy_warmgun@hotmail.com>
* @version 0.0.1
* @package Core\User\Auth
*/

namespace Core\User\Auth;

use Core\Exception\RestException;

/**
* Esta clase contiene los métodos necesarios para transformar un token a un array de usuario.
*/
class UserFromToken
{
	/**
	* @var string $token Contiene el token conel que se trabajará.
	*/
	protected $token = "";
	
	/**
	* Constructor de la clase.
	* 
	* @param string $token Contiene el token con el que se trabajará.
	* 
	* @throws RestException si el token no es un string .
	*/
	function __construct($token = null)
	{
		if ( !is_string($token) )
			throw new RestException(__FILE__, "Class UserFromToken: token debe ser un string.", 500 );

		$this -> token = $token;
	}

	/**
	* Método estático para transformar un token a un array de usuario.
	* 
	* @param string $token Contiene el token con el que se trabajará.
	* 
	* @return array
	* 
	*/
	public static function getUser($token = null)
	{
		$instance = new static($token);

		return $instance -> createArrayFromJson();
	}

	// private
	/**
	* Método para desencriptar el token.
	*
	* Si no lo logra devolvera false.
	* 
	* @return string|boolean
	*/
	public function decrypt()
	{
		try {
			
			return \Crypt::decrypt($this -> token);

		} catch (\Exception $e) {
			
			return false;

		}
	}

	/**
	* Método para crear un array de usuario a partir de un json
	*
	* @return array
	*/
	public function createArrayFromJson()
	{
		if ( !$json = $this -> decrypt() )
			return false;

		return json_decode($json, true);
	}
}