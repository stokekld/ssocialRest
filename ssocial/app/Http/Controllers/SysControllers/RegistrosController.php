<?php

namespace App\Http\Controllers\SysControllers;

use App\Http\Controllers\Controller;
use Layer\Entities\Registro;
use Layer\User\Servicio;

/**
* 
*/
class RegistrosController extends Controller
{
	
	function __construct()
	{
		$this -> registro = new Registro;
		$this -> user = \App::make('UserSys');
		// $this -> servicio = (new Servicio) -> findById($this -> id);
	}

	public function all($id)
	{
		$servicio = (new Servicio) -> findById($id);

		$registros = $servicio -> registros();

		return $this -> user -> response( response(), $registros, 200);
	}

	public function update($idS, $idR)
	{
		$servicio = (new Servicio) -> findById($idS);

		$registro = $servicio -> existReg($idR);

		if (!$registro)
			$this -> throwException(__FILE__, "findById: No existe el elemento.", 404, ['message' => "No existe el elemento."]);

		$data = request()->json()->all();
		
		return $this -> user -> response( response(), $this -> registro -> updateByID($idR, $data), 200);
	}

	public function delete($idS, $idR)
	{
		$servicio = (new Servicio) -> findById($idS);

		$registro = $servicio -> existReg($idR);

		if (!$registro)
			$this -> throwException(__FILE__, "findById: No existe el elemento.", 404, ['message' => "No existe el elemento."]);

		return $this -> user -> response( response(), $this -> registro -> deleteById($idR), 200 ); 
	}
}