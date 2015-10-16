<?php
/**
* Archivo que contiene el trait logInTrait
* @author Humberto de Jesus Flores Acuña <joy_warmgun@hotmail.com>
* @version 0.0.1
* @package Core\DataServices
*/

namespace Core\User\Helper;

use Core\Exception\RestException;

/**
* Este trait contiene la funcion para logueo de los usuarios del sistema.
*/
trait logInTrait
{
    /**
    * Método para verificar el logueo de un usuario.
    *
    * Si es logueo es satisfactorio retorna un arreglo con los datos del usuario.
    *
    * @param array $credentials Contiene los datos del usuario (user, password)
    * @param string $fieldId Contiene el campo de la tabla que representa el id.
    * @param string $fieldUser Contiene el campo de la tabla que representa el usuario.
    * @param string $fieldPass Contiene el campo de la tabla que representa el password.
    * @param string $type Contiene el tipo de usuario.
    *
    * @throws RestException Si $credentials no es un array.
    * @throws RestException Si falta algún argumento.
    * @throws RestException Si los argumentos son cadenas vacias.
    *
    * return array 
    *
    */
    public static function logIn($credentials, $fieldId, $fieldUser, $fieldPass, $type)
    {
        if ( !is_array($credentials) )
        	throw new RestException(__FILE__, "logIn: credentials debe ser un array.", 500);
            
        if ( !isset($credentials['user']) OR !isset($credentials['password']) )
            throw new RestException(__FILE__, "logIn: faltan argumentos en las credenciales.", 400, ['message' => 'Faltan argumentos en las credenciales.']);

        if ( $credentials['user'] == "" OR $credentials['password'] == "" )
            throw new RestException(__FILE__, "logIn: los argumentos no pueden estar vacios.", 400, ['message' => 'Los argumentos no pueden estar vacios.']);
            

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




