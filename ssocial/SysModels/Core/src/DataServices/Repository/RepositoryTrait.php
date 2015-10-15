<?php

namespace Core\DataServices\Repository;


use Core\Exception\RestException;
/**
* 
*/
trait RepositoryTrait
{
	
	public function translateToUser()
	{
		$attributes = $this -> attributes;

		$newAttributes = [];

		foreach ($attributes as $field => $value)
		{
			$key = $this -> getKeyDictionary($field);

			$newAttributes[$key] = $value;
		}

		$this -> attributes = $newAttributes;

		return $this;
	}

	public function one($id)
	{
		$item = $this -> find($id);

		if ( count($item) == 0 )
			return [];

		return $item -> translateToUser()->toArray();
	}
}