<?php

namespace Core\Repository;

/**
* 
*/
trait RepositoryTrait
{
	
	public function translateToUser()
	{
		$attributes = $this -> attributes;
		$dic = $this -> dictionary;

		$newAttributes = [];

		foreach ($attributes as $field => $value)
		{
			if ( !($key = array_search($field, $dic)) )
				throw new RestException(__FILE__, "Validation: No existe en el diccionario la regla ".$field.".", 500, ["message" => "No existe en el diccionario la regla ".$field."."]);

			$newAttributes[$key] = $value;
		}

		$this -> attributes = $newAttributes;

		return $this;
	}
}