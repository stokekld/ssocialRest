<?php
/**
* Archivo que contiene la clase TokenFromUser
* @author Humberto de Jesus Flores Acuña <joy_warmgun@hotmail.com>
* @version 0.0.1
* @package Core\User\Auth
*/

namespace Core\User\Auth;

use Core\Exception\RestException;

/**
* Esta clase contiene los métodos necesarios para tranformar el array de un usuario a token.
*/
class TokenFromUser
{

	/**
	* @var int $ttl Contiene el numero de minutos que será válido este token.
	*/
	protected $ttl = 30; // minutos

	/**
	* @var array $dataUser Contiene el arreglo del usuario a ser tranformado.
	*/
	protected $dataUser = [];

	/**
	* Constructor de la clase.
	*
	* @param array $dataUser Contiene el arreglo del usuario a ser tranformado.
	*
	* @throws RestException Si $dataUser esta vacio o indefinido.
	*/
	function __construct($dataUser = null)
	{
		if ( !isset($dataUser) OR empty($dataUser) )
			throw new RestException(__FILE__, "Class TokenFromUser: dataUser no debe de estar vacio o indefinido.", 500 );

		$this -> dataUser = $dataUser;
	}
	
	/**
	* Método estático para obtener el token
	*
	* Si la tranformacion fue un exito, retorna le token creado.
	*
	* @param array $dataUser Contiene el arreglo del usuario a ser tranformado.
	*
	* @return string
	*/
	public static function getToken($dataUser = null)
	{
		$instance = new static($dataUser);

		return $instance -> createToken();
	}

	/**
	* Método para ejecutar las funciones necesarias para crear el token.
	* 
	* @return string
	*/
	protected function createToken()
	{
		$this -> setTTL();

		return $this -> encrypt();
	}

	/**
	* Método para encriptar el json obtenido del array.
	* 
	* @return string
	*/
	protected function encrypt()
	{
		$json = $this -> createJsonFromArray();

		return \Crypt::encrypt($json);
	}

	/**
	* Método para establecer la hora de creación y los minutos válidos del token
	*/
	protected function setTTL()
	{
		$this -> dataUser['ttl'] = $this -> ttl;
		$this -> dataUser['timestamp'] = time();
	}

	/**
	* Método que crea un json a partir del array del usuario
	*/
	protected function createJsonFromArray()
	{
		return json_encode($this -> dataUser);
	}
}