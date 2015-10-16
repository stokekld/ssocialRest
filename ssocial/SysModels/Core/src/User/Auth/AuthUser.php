<?php
/**
* Archivo que contiene la clase AuthUser
* @author Humberto de Jesus Flores Acuña <joy_warmgun@hotmail.com>
* @version 0.0.1
* @package Core\User\Auth
*/

namespace Core\User\Auth;

use Core\Exception\RestException;

/**
* Esta clase contiene los metodos necesarios para verificar si un arreglo contiene los datos de un usuario.
*/
class AuthUser
{
	/**
	* @var array $dataUser Contiene el arreglo con el que trabajará.
	*/
	protected $dataUser = [];
	
	/**
	* Constructor de la clase.
	*
	* @param array $dataUser Contiene el arreglo con el que trabajará.
	*
	* @throws RestException Si $dataUser esta vacio o indefinido.
	*/
	function __construct($dataUser = null)
	{
		if ( !isset($dataUser) OR empty($dataUser) )
			throw new RestException(__FILE__, "Class AuthUser: dataUser no debe de estar vacio o indefinido.", 500);

		$this -> dataUser = $dataUser;
	}

	/**
	* Método estético para verificar el arreglo.
	*
	* Se debe pasar el arreglo del usuario, si el usuario es válido retorna un nuevo token.
	*
	* @param array $dataUser Contiene el arreglo con el que trabajará.
	*
	* @return string
	*
	*/
	public static function verify($dataUser = null)
	{
		$instance = new static($dataUser);

		if (!$instance -> checkStructure())
			return false;

		if (!$instance -> onTime())
			return false;

		if (!$instance -> exists())
			return false;

		return TokenFromUser::getToken( $instance -> dataUser );
	}

	/**
	* Método que evalua la estructura del array del usuario.
	*
	* @return boolean
	*
	*/
	public function checkStructure()
	{
		$array = $this -> dataUser;

		if ( !isset($array["data"]) OR  !isset($array["table"]) OR  !isset($array["type"]) OR  !isset($array["ttl"]) OR  !isset($array["timestamp"]) )
			return false;

		return true;
	}

	/**
	* Método que evalua el tiempo trascurrido desde la creación de este array.
	*
	* @return boolean
	*
	*/
	public function onTime()
	{
		$ttl = $this -> dataUser['ttl'];
		$timestamp = $this -> dataUser['timestamp'];

		if (time() > $timestamp + 60 * $ttl)
			return false;

		return true;
	}

	/**
	* Método que evalua si el usuario existe en la base.
	*
	* @return boolean
	*
	*/
	public function exists()
	{
		$table = $this -> dataUser['table'];
		$data = $this -> dataUser['data'];

		$results = \DB::table($table)->where($data)->get();

		if (count($results) !== 1)
			return false;

		return true;
	}


}