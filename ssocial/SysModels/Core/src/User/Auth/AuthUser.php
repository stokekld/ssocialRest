<?php

namespace Core\User\Auth;
/**
* 
*/
class AuthUser
{
	protected $dataUser = [];
	
	function __construct($dataUser = null)
	{
		if ( !isset($dataUser) OR empty($dataUser) )
			throw new \Exception("Class AuthUser: dataUser no debe de estar vacio o indefinido.");

		$this -> dataUser = $dataUser;
	}

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

	public function checkStructure()
	{
		$array = $this -> dataUser;

		if ( !isset($array["data"]) OR  !isset($array["table"]) OR  !isset($array["type"]) OR  !isset($array["ttl"]) OR  !isset($array["timestamp"]) )
			return false;

		return true;
	}

	public function onTime()
	{
		$ttl = $this -> dataUser['ttl'];
		$timestamp = $this -> dataUser['timestamp'];

		if (time() > $timestamp + 60 * $ttl)
			return false;

		return true;
	}

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