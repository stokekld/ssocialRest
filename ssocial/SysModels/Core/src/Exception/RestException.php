<?php

namespace Core\Exception;

use Exception;
use Core\Log\Log;

/**
* 
*/
class RestException extends Exception
{
	protected $response;
	
	function __construct($file, $message, $httpCode, $response = [])
	{
		Log::addException($file, $message, $httpCode);

		$this -> code = $httpCode;
		$this -> response =  array_merge(['error' => true], $response);


        parent::__construct($message, $this -> getCode());
	}

	public function getResponse()
	{
		return $this -> response;
	}
}