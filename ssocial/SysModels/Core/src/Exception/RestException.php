<?php
/**
* Archivo que contiene la clase RestException
* @author Humberto de Jesus Flores Acuña <joy_warmgun@hotmail.com>
* @version 0.0.1
* @package Core\Exception
*/

namespace Core\Exception;

use Exception;
use Core\Log\Log;

/**
* Esta clase contiene la excepción personalizada.
*
* Se encarga de guardar en el log los datos importantes de la excepción para posteriormente enviarlos al usuario.
*/
class RestException extends Exception
{
	/**
	* @var array $response Contiene el array que será enviado al usuario.
	*/
	protected $response;
	
	/**
	* 
	* Contructor de la clase.
	* 
	* @param string $file Contiene el archivo donde fue lanzada la excepción.
	* @param string $message Contiene el mensaje a guardar en el log.
	* @param int $httpCode Contiene el código http a enviar al usuario.
	* @param array $response Contiene el array a ser enviado al usuario.
	* 
	*/
	function __construct($file, $message, $httpCode, $response = [])
	{
		Log::addException($file, $message, $httpCode);

		$this -> code = $httpCode;
		$this -> response =  array_merge(['error' => true, 'httpCode' => $httpCode], $response);

        parent::__construct($message, $this -> getCode());
	}

	/**
	* Método para obtener el array a ser enviado al usuario.
	*
	* @return array
	*/
	public function getResponse()
	{
		return $this -> response;
	}
}