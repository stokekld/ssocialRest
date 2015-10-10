<?php

namespace Core\User;

use Core\Exception;

trait logInTrait
{
    public static function logIn($credentials, $fieldId, $fieldUser, $fieldPass, $type)
    {
        if ( !is_array($credentials) )
            throw new \Exception("logIn: credentials debe ser un array.");
        	

        if ( !isset($credentials['user']) OR !isset($credentials['password']) )
        	throw new Exception\RestException(__FILE__, "logIn: faltan argumentos en las credenciales.", 404);
            

    	$obj = new static();

    	$results = $obj->select([$fieldId, $fieldUser, $fieldPass])->where([$fieldUser => $credentials['user'], $fieldPass => $credentials['password'] ])->get();

    	if ($results->count() != 1)
    		return false;

    	$data = [
			"data" => $results->first()->toArray(),
			"table" => $obj->getTable(),
			"type" => $type,
    	];

    	return $data;
    }
}