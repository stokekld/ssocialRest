<?php

namespace Core\User;

/**
* 
*/
class TokenFromUser
{

	protected $ttl = 30; // minutos

	protected $dataUser = [];

	function __construct($dataUser = null)
	{
		if ( !isset($dataUser) OR empty($dataUser) )
			throw new \Exception("Class TokenFromUser: dataUser no debe de estar vacio o indefinido.");

		$this -> dataUser = $dataUser;
	}
	
	public static function getToken($dataUser = null)
	{
		$instance = new static($dataUser);

		return $instance -> createToken();
	}

	// protected

	public function createToken()
	{
		$this -> setTTL();

		return $this -> encrypt();
	}

	public function encrypt()
	{
		$json = $this -> createJsonFromArray();

		return \Crypt::encrypt($json);
	}

	public function setTTL()
	{
		$this -> dataUser['ttl'] = $this -> ttl;
		$this -> dataUser['timestamp'] = time();
	}

	public function createJsonFromArray()
	{
		return json_encode($this -> dataUser);
	}
}