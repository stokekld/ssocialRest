<?php

namespace Core\User;

use Illuminate\Routing\ResponseFactory as Response;

/**
* 
*/
class UserSys
{
	public function load($user)
	{
		foreach ($user as $key => $value) {
			$this -> $key = $value;
		}		
	}

	public function response($motor, $data, $code)
	{
		 $data = array_merge( [ 'token' => $this -> token ], [ 'data' => $data]);

		return $motor -> json($data, $code);
	}
}