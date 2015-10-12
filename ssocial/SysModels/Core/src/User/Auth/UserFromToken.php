<?php

namespace Core\User\Auth;

/**
* 
*/
class UserFromToken
{

	protected $token = "";
	
	function __construct($token = null)
	{
		if ( !is_string($token) )
			throw new Exception\RestException(__FILE__, "Class UserFromToken: token debe ser un string.", 500 );

		$this -> token = $token;
	}

	public static function getUser($token = null)
	{
		$instance = new static($token);

		return $instance -> createArrayFromJson();
	}

	// private

	public function decrypt()
	{
		try {
			
			return \Crypt::decrypt($this -> token);

		} catch (\Exception $e) {
			
			return false;

		}
	}

	public function createArrayFromJson()
	{
		if ( !$json = $this -> decrypt() )
			return false;

		return json_decode($json, true);
	}
}