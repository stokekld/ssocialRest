<?php
/**
* Archivo que contiene el trait ManagerTrait
* @author Humberto de Jesus Flores Acuña <joy_warmgun@hotmail.com>
* @version 0.0.1
* @package Core\DataServices\Manager
*/

namespace Core\DataServices\Manager;

/**
* Este trait contiene las funciones de la capa Manager.
*
* Se encarga de validar los datos para posteriormente insertar, actualizar registros de la base.
* Tambien puede eliminar registros.
*/
trait ManagerTrait
{
	/**
	* Método para obtener las reglas de validación de la entidad.
	*
	* @throws \Exception Si no existen las reglas (500).
	*
	* @return array
	*/
	protected function getRules()
	{
		if ( !isset($this -> rules) )
			$this -> throwException(__FILE__, "getRules: No existe las reglas de validación.", 500);

		return $this -> rules;
	}

	/**
	* Método para obtener una regla especifica.
	*
	* @param string $field Contiene el nombre de la regla a obtener.
	*
	* @throws \Exception Si no existe la regla (400).
	*
	* @return string
	*/
	protected function getRule($field = "")
	{
		$rules = $this -> getRules();

		if ( $field == "" OR !isset( $rules[$field] ) )
			$this -> throwException(__FILE__, "getRule: No existe la regla de validacion $field.", 400, ['message' => "Validation: No existe la regla de validacion $field."]);

		return $rules[$field];
	}

	/**
	* Método para validar el contenido de una variable y retornarlo.
	*
	* Si existe el indice 1 en la regla y es false, no hace striptag al contenido al valor.
	*
	* @param string $field Contiene el nombre de la regla para validar.
	* @param mixed $value Contiene el valor a validar.
	*
	* @throws \Exception Si la validación no pasa (400).
	*
	* @return mixed
	*/
	protected function validation($field, $value)
	{
		$rule = $this -> getRule($field);

		if ( !isset($rule[1]) OR $rule[1] == true )
			$value = strip_tags($value);

		$validation = \Validator::make([ $field => $value ], [ $field => $rule[0] ]);

		if ( !$validation -> fails() )
			return $value;

		$message = $validation->messages()->first($field);
		$this -> throwException(__FILE__, "Validation: $message", 400, ["message" => $message]);
			
	}

	/**
	* Método para insertar datos en la base y retorna el registro creado.
	*
	* @param array $data Contiene los datos ha ser insertados.
	*
	* @return array
	*/
	public function insert($data)
	{
		$pk = $this -> getKeyName();
		$dic = $this -> getDictionary();

		$insert = new static();

		foreach ($dic as $field => $fieldDB)
		{
			if ($fieldDB != $pk)
				$insert -> $fieldDB = $this -> validation( $field, (isset($data[$field])) ? $data[$field] : null );
		}

		$insert -> save();

		return self::find( $insert -> $pk )->translateToUser() -> toArray();
	}

	public function updateByID($id, $data)
	{
		$pk = $this -> getKeyName();
		$dic = $this -> getDictionary();

		$update = $this -> findById($id);

		foreach ($data as $field => $value)
		{
			$fieldDB = $this -> getFieldDictionary($field);

			if ($fieldDB != $pk)
				$update -> $fieldDB = $this -> validation( $field, $data[$field]);
		}

		$update -> save();

		return $this -> findById($id, true);
	}

	/**
	* Método para eliminar un registro mediante su id.
	*
	* @param int $id Contiene el id del registro a eliminar.
	*
	* @return array
	*/
	public function deleteById($id)
	{
		$this -> findById($id) -> delete();
			
		return ['deleted' => true];
	}
}