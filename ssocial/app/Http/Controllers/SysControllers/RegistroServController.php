<?php

namespace App\Http\Controllers\SysControllers;

use App\Http\Controllers\Controller;
use Layer\Entities\Registro;
use Layer\User\Servicio;

/**
* 
*/
class RegistroServController extends Controller
{
	
	protected $registro;
	protected $user;
	protected $id;
	protected $servicio;

	function __construct()
	{
		$this -> registro = new Registro;
		$this -> user = \App::make('UserSys');
		$this -> id = $this -> user -> data['id_serv'];
		$this -> servicio = (new Servicio) -> findById($this -> id);
	}

	private function status()
	{
		$reg = $this -> registro;

		$getReg = $reg -> where("id_serv", $this -> id) -> where("reg_fin", "00:00:00")->get();

		$count = $getReg->count();

		if ($count == 0)
			return 1;	// initiable
		else
			return $getReg;	// endable
	}

	public function getStatus()
	{
		$status = $this -> status();

		if ($status === 1)
			return $this -> user -> response( response(), ["status" => "bootable"], 200);
		else
		{
			$result = $status->first()->translateToUser();

			return $this -> user -> response( response(), $result, 200);
		}

	}
	
	public function ini()
	{
		$status = $this -> status();

		if ( $status !== 1 )
			return;

		$reg = $this -> registro;

		$data["idServ"] = $this -> id;
		$data["regIni"] = date("Y-m-d H:i:00");
		$data["regFin"] = null;
		$data["regAct"] = null;
		$data["regVal"] = 0;

		$result = $reg -> insert($data);

		return $this -> user -> response( response(), $result, 201);
	}

	public function fin()
	{
		$status = $this -> status();

		if ( $status === 1 )
			return;

		$fromUser = request()->json()->all();

		$data["regFin"] = date("Y-m-d H:i:00");
		$data["regAct"] = @$fromUser["regAct"];

		$result = $status->first();

		$id = $result -> id_registro;

		$time = (strtotime($data["regFin"]) - strtotime($result -> reg_inicio)) / (60 * 60);

		if ($time < 8)
			$data["regVal"] = 1;


		$result -> updateByID($id, $data);

		return $this -> user -> response( response(), $result->findById($id, true), 201);

	}
}