<?php

namespace Core\Manager;

use Core\Exception\RestException;

trait ManagerTrait
{
	public function validation($field, $value)
	{

		if ( !isset($this -> rules) )
			throw new RestException(__FILE__, "validation: No existe las reglas de validación.", 500);

		$rules = $this -> rules;

		if ( !isset( $rules[$field] ) )
			throw new RestException(__FILE__, "Validation: No existe la regla de validacion".$field.".", 500, ['message' => "Validation: No existe la regla de validacion".$field."."]);

		if ( !isset($rules[$field][1]) OR $rules[$field][1] == true )
			$value = strip_tags($value);

		$validation = \Validator::make([ $field => $value ], [ $field => $rules[$field][0] ]);

		if ( $validation -> fails() )
			throw new RestException(__FILE__, "Validation: Fallo.", 500, ["message" => $validation->messages()->first($field)] );

		return $value;
			
	}

	public function insert($data)
	{
		if ( !isset($this -> dictionary) )
			throw new RestException(__FILE__, "validation: No existe el diccionario.", 500);

		$dic = $this -> dictionary;

		$insert = new static();

		foreach ($data as $field => $value)
		{
			if ( !isset( $dic[$field] ) )
				throw new RestException(__FILE__, "Validation: No existe en el diccionario la regla ".$field.".", 500, ["message" => "No existe en el diccionario la regla ".$field."."]);

			$insert -> $dic[$field] = $this -> validation( $field, $value );
		}

		$insert -> save();

		$pk = $insert -> getKeyName();

		$inserted = self::find( $insert -> $pk )->translateToUser();

		return $inserted -> toArray();

	}
}