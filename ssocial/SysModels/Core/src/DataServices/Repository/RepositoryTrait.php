<?php
/**
* Archivo que contiene el trait RepositoryTrait
* @author Humberto de Jesus Flores Acuña <joy_warmgun@hotmail.com>
* @version 0.0.1
* @package Core\DataServices\Repository
*/

namespace Core\DataServices\Repository;

/**
* Este trait contiene las funciones de la capa Repository
*
* Se encarga de obtener registros de la base y dependiendo de la situación, servirlos.
*/
trait RepositoryTrait
{
	/**
	* Método para obtener todos los registros ya traducidos;
	*/
	public function allThem()
	{
		return $this -> all() -> each( function($item){
			$item -> translateToUser();
		});
	}

	/**
	* Método para encontrar un registro por su id
	* 
	* @param int $id Contiene el id del registro a buscar.
	* @param boolean $translate Si es true retorna el registro encontrado traducido y en formato array, de lo contrario lo retorna como objeto.
	* 
	* @throws \Exception Si no existe el elemento o el id es 0
	*
	* @return self|array
	*/
	public function findById($id, $translate = false)
	{
		settype($id, 'integer');

		$item = $this -> find($id);

		if ($id == 0 OR count($item) == 0 )
			$this -> throwException(__FILE__, "findById: No existe el elemento.", 404, ['message' => "No existe el elemento."]);

		if ($translate)
			return $item -> translateToUser()->toArray();
			
		return $item;
	}
}