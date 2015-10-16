<?php
namespace App\Http\Controllers\SysControllers;

use App\Http\Controllers\Controller;
use Layer\Entities\Ip;

/**
* Datos provenientes del usuario
*
* ipp: ip en formato xxx.xxx.xxx.xxx
*/
class IpController extends Controller
{

	protected $ip;
	protected $user;

	function __construct()
	{
		$this -> ip = new Ip;
		$this -> user = \App::make('UserSys');
	}
	
	public function add()
	{
		$data = request()->json()->all();

		return $this -> user -> response( response(), $this -> ip -> insert($data), 201);		
	}

	public function all()
	{
		return $this -> user -> response( response(), $this -> ip -> allThem(), 200 );
	}

	public function delete($id)
	{
		return $this -> user -> response( response(), $this -> ip -> deleteById($id), 200 ); 
	}
}