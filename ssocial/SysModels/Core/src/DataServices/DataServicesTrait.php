<?php

namespace Core\DataServices;

use Core\DataServices\Manager\ManagerTrait;
use Core\DataServices\Repository\RepositoryTrait;
use Core\Exception\RestException;

trait DataServicesTrait
{
	use ManagerTrait, RepositoryTrait;

	public function getKeyDictionary($value = "")
	{
		$dic = $this -> getDictionary();

		if ( !($key = array_search($value, $dic)) )
			$this -> throwException(__FILE__, "Validation: No existe en el diccionario la regla $value.", 500, ["message" => "No existe en el diccionario la regla $value."]);

		return $key;
	}

	public function getFieldDictionary($field = "")
	{
		$dic = $this -> getDictionary();

		if ( $field == "" OR !isset( $dic[$field] ) )
			$this -> throwException(__FILE__, "insert: No existe en el diccionario la regla $field.", 500, ["message" => "No existe en el diccionario la regla $field." ]);

		return $dic[$field];
	}

	public function getDictionary()
	{
		if ( !isset($this -> dictionary) )
			$this -> throwException(__FILE__, "validation: No existe el diccionario.", 500);

		return $this -> dictionary;
	}

	public function throwException($file, $message, $httpCode, $response = [])
	{
		throw new RestException($file, $message, $httpCode, $response);
	}

}