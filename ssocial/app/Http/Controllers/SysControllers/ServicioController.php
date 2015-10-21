<?php

namespace App\Http\Controllers\SysControllers;

use App\Http\Controllers\Controller;
use Layer\User\Servicio;

/**
* 
*/
class ServicioController extends Controller
{
	
	protected $servicio;
	protected $user;

	function __construct()
	{
		$this -> servicio = new Servicio;
		$this -> user = \App::make('UserSys');
	}
	
	public function add()
	{
		$data = request()->json()->all();

		return $this -> user -> response( response(), $this -> servicio -> insert($data), 201);		
	}

	public function one($id)
	{
		return $this -> user -> response( response(), $this -> servicio -> findById($id, true), 200 );
	}

	public function all()
	{
		$data = request()->all();

		if ( empty($data) )
			return $this -> user -> response( response(), $this -> servicio -> allThem(), 200 );
		else
			return $this -> user -> response( response(), $this -> servicio -> search($data), 200 );
	}

	public function update($id)
	{
		$data = request()->json()->all();
		
		return $this -> user -> response( response(), $this -> servicio -> updateByID($id, $data), 200);		
	}

	public function delete($id)
	{
		return $this -> user -> response( response(), $this -> servicio -> deleteById($id), 200 ); 
	}
}