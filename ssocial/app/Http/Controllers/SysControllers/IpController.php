<?php
namespace App\Http\Controllers\SysControllers;

use App\Http\Controllers\Controller;
use Layer\Entities\Ip;

/**
* 
*/
class IpController extends Controller
{
	
	public function add()
	{
		$data = request()->json()->all();

		$ip = new Ip;

		return response()->json($ip -> add($data), 201);
		
	}

	public function all()
	{
		$ip = new Ip;

		return $ip -> search();
	}
}