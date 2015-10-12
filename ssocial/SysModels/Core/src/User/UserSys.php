<?php

namespace Core\User;

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
}