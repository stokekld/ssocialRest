<?php
/**
* Archivo que contiene el trait DataServicesTrait
* @author Humberto de Jesus Flores Acuña <joy_warmgun@hotmail.com>
* @version 0.0.1
* @package Core\DataServices
*/

namespace Core\DataServices;

use Core\DataServices\Manager\ManagerTrait;
use Core\DataServices\Repository\RepositoryTrait;
use Core\Exception\RestException;

/**
* Este trait contiene las funciones de las capas Repository y Manager
* 
* Se encarga de unir las funciones de las dos capas ademas de proveer funciones en común
*
*/
trait DataServicesTrait
{
	use ManagerTrait, RepositoryTrait;

	/**
	* Método para obtener el diccionario de la entidad.
	*
	* @throws \Exception Si no existe el diccionario.
	* 
	* @return array
	*/
	public function getDictionary()
	{
		if ( !isset($this -> dictionary) )
			$this -> throwException(__FILE__, "validation: No existe el diccionario.", 500);

		return $this -> dictionary;
	}

	/**
	* Método para obtener la clave de una valor específico del diccionario.
	*
	* @param string $value Contiene el valor a buscar en el diccionario.
	*
	* @throws \Exception Si no existe el valor.
	*
	* @return string
	*/
	public function getKeyDictionary($value = "")
	{
		$dic = $this -> getDictionary();

		if ( !($key = array_search($value, $dic)) )
			$this -> throwException(__FILE__, "Validation: No existe en el diccionario la regla $value.", 500, ["message" => "No existe en el diccionario la regla $value."]);

		return $key;
	}


	// public function getFieldDictionary($field = "")
	// {
	// 	$dic = $this -> getDictionary();

	// 	if ( $field == "" OR !isset( $dic[$field] ) )
	// 		$this -> throwException(__FILE__, "insert: No existe en el diccionario la regla $field.", 500, ["message" => "No existe en el diccionario la regla $field." ]);

	// 	return $dic[$field];
	// }


	/**
	* Método para traducir los nombre de los campos de la base de datos 
	* a los conocidos por el usuario.
	*
	* @return self
	*/
	public function translateToUser()
	{
		$attributes = $this -> attributes;

		$newAttributes = [];

		foreach ($attributes as $field => $value)
		{
			$key = $this -> getKeyDictionary($field);

			$newAttributes[$key] = $value;
		}

		$this -> attributes = $newAttributes;

		return $this;
	}

	/**
	* Método para lanzar una excepción
	*
	* @param string $file Contiene el archivo donde fue lanzada la excepción.
	* @param string $message Contiene el mensaje a guardar en el log.
	* @param int $httpCode Contiene el código http a enviar al usuario.
	* @param array $response Contiene el array a ser enviado al usuario.
	*
	*/
	public function throwException($file, $message, $httpCode, $response = [])
	{
		throw new RestException($file, $message, $httpCode, $response);
	}

}




