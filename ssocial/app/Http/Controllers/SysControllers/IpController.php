<?php
namespace App\Http\Controllers\SysControllers;

use App\Http\Controllers\Controller;
use Layer\Entities\Ip;

/**
* 
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

		return $this -> user -> response( response(), $this -> ip -> add($data), 201);		
	}

	public function all()
	{
		$ip = new Ip;

		return $this -> user -> response( response(), $this -> ip -> all() -> toArray(), 200 );
	}

	public function one($id)
	{
		return $this -> user -> response( response(), $this -> ip -> one($id), 200 ); 
	}

	public function del($id)
	{
		return $this -> user -> response( response(), $this -> ip -> del($id), 200 ); 
	}
}