<?php

namespace Core\Exception;

use Exception;

/**
* 
*/
class RestException extends Exception
{
	protected $response;
	
	function __construct($file, $message, $httpCode, $response = [])
	{
		$this -> code = $httpCode;
		$this -> response =  array_merge(['error' => true], $response);

        parent::__construct($message, $this -> getCode());
	}

	public function getResponse()
	{
		return $this -> response;
	}
}