<?php
/**
* Archivo que contiene el trait RepositoryTrait
* @author Humberto de Jesus Flores Acuña <joy_warmgun@hotmail.com>
* @version 0.0.2
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
	* @var array $operators Contiene los diferentes operadores para realizar un where
	*/
	protected $operators = [
		'q' => '=',
		'l' => 'like',
		'nq' => '<>',
		'gt' => '>',
		'lt' => '<',
	];

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

	public function search($data = array())
	{
		$where = $this -> parseSearch($data);

		$select = new static();

		foreach ($where as $values)
		{
			$select = call_user_func_array([$select, $values[0]], $values[1]);

			if ($values[0] == 'paginate')
			{
				return $select -> each( function($item){
					$item -> translateToUser();
				});
			}
		}

		$result = $select -> get();

		return $result -> each( function($item){
			$item -> translateToUser();
		});
	}

	/**
	* Método para parsear los parametros de una busqueda y retorna un array con las funciones necesarias para realizar la consulta y sus parametros.
	* 
	* @param array $data Contiene los parametros desde la uri
	* 
	* @throws \Exception Si $data no es un array o está indefinido. 
	* 
	* @return array
	*/
	protected function parseSearch($data = null)
	{
		if ( !isset($data) OR !is_array($data) )
			$this -> throwException(__FILE__, "parseSearch: Data es de formato erroneo.", 500);

		$operators = $this -> operators;

		$functions = array();

		foreach ($operators as $operator => $value)
		{
			if ( isset($data[$operator]) )
			{
				$string = $data[$operator];

				$fields = explode(',', $string);

				foreach ($fields as $field)
				{

					// if ( strpos($field, '|') )
					if ( preg_match("/([^:]+)::([^:]+)/", $field) )
					{
						$result = explode('::', $field);
						array_push($result, $value);
						// $orWhere = array_merge($orWhere, $result);

						$functions = array_merge( $functions, [ ['orWhere', [$this -> getFieldDictionary($result[0]), $value, $result[1]]] ] );
					}
					// else if ( strpos($field, ':') )
					else if ( preg_match("/([^:]+):([^:]+)/", $field) )
					{
						$result = explode(':', $field);
						array_push($result, $value);
						// $where = array_merge($where, $result);
						$functions = array_merge( $functions, [ ['where', [$this -> getFieldDictionary($result[0]), $value, $result[1]]] ] );
					}


				}
				
			}
		}

		if ( isset($data['sort']) )
			$functions = array_merge( $functions, [ ['orderBy', explode(',', $data['sort'])] ] );
		if ( isset($data['paginate']) )
			$functions = array_merge( $functions, [ ['paginate', [ $data['paginate'] ] ] ] );

		return $functions;

	}
}