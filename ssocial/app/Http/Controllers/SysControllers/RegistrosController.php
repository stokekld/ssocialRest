<?php

namespace App\Http\Controllers\SysControllers;

use App\Http\Controllers\Controller;
use Layer\Entities\Registro;

/**
* 
*/
class RegistrosController extends Controller
{
	
	protected $registro;
	protected $user;

	function __construct()
	{
		$this -> registro = new Registro;
		$this -> user = \App::make('UserSys');
	}
	
	public function add()
	{
		$data = request()->json()->all();

		return $this -> user -> response( response(), $this -> registro -> insert($data), 201);		
	}

	public function one($id)
	{
		// return $this -> user -> response( response(), $this -> registro -> findById($id, true), 200 );
	}

	public function all()
	{

		var_dump($this -> user);
		// $data = request()->all();

		// if ( empty($data) )
		// 	return $this -> user -> response( response(), $this -> registro -> allThem(), 200 );
		// else
		// 	return $this -> user -> response( response(), $this -> registro -> search($data), 200 );
	}

	public function update($id)
	{
		// $data = request()->json()->all();
		
		// return $this -> user -> response( response(), $this -> registro -> updateByID($id, $data), 200);		
	}

	public function delete($id)
	{
		// return $this -> user -> response( response(), $this -> registro -> deleteById($id), 200 ); 
	}
}