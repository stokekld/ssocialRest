<?php

namespace Core\DataServices\Manager;

use Core\Exception\RestException;

trait ManagerTrait
{
	public function getRule($field = "")
	{
		$rules = $this -> getRules();

		if ( $field == "" OR !isset( $rules[$field] ) )
			$this -> throwException(__FILE__, "Validation: No existe la regla de validacion $field.", 500, ['message' => "Validation: No existe la regla de validacion $field."]);

		return $rules[$field];
	}

	public function getRules()
	{
		if ( !isset($this -> rules) )
			$this -> throwException(__FILE__, "validation: No existe las reglas de validación.", 500);

		return $this -> rules;
	}

	public function validation($field, $value)
	{
		$rule = $this -> getRule($field);

		if ( !isset($rule[1]) OR $rule[1] == true )
			$value = strip_tags($value);

		$validation = \Validator::make([ $field => $value ], [ $field => $rule[0] ]);

		if ( $validation -> fails() )
		{
			$message = $validation->messages()->first($field);
			$this -> throwException(__FILE__, "Validation: $message", 400, ["message" => $message]);
		}

		return $value;
			
	}

	public function insert($data)
	{
		$pk = $this -> getKeyName();
		$dic = $this -> getDictionary();

		$insert = new static();

		foreach ($dic as $field => $value)
		{
			if ($value != $pk)
				$insert -> $value = $this -> validation( $field, (isset($data[$field])) ? $data[$field] : null );
		}

		$insert -> save();

		$inserted = self::find( $insert -> $pk )->translateToUser();

		return $inserted -> toArray();

	}

	public function del($id)
	{
		$item = $this -> find($id);

		if ( count($item) == 0 )
			return ['deleted' => true];

		return ['deleted' => $item -> delete()];
	}
}