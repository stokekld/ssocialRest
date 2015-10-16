<?php

$ip = "";
for ($i=0; $i < 3; $i++)
	$ip .= rand(0, 255).".";
$ip .= rand(0, 255);



define("__IP", $ip);

/**
* 
*/
class IpTest extends TestCase
{

	/**
	* @dataProvider ipAddProvider
	*/
	public function testAddIp($data, $code)
	{
		$token = $this -> getTokenAdmin();

		$this -> json('post', 'ip', $data, ['Authorization' => $token])->assertResponseStatus( $code );

		echo $this -> response -> content()."\n";

	}

	/**
	* @dataProvider ipDelProvider
	*/
	public function testDelIp($id, $code)
	{
		$token = $this -> getTokenAdmin();

		$this -> json('delete', 'ip/$id', [], ['Authorization' => $token])->assertResponseStatus( $code );

		echo $this -> response -> content()."\n";
	}

	public function ipAddProvider()
	{
		return [
			[ [], 400 ],
			[ ['ipp' => 'holamundo'], 400 ],
			[ ['ipp' => 0], 400 ],
			[ ['ipp' => __IP], 201 ],
			[ ['ipp' => __IP], 409 ],
		];
	}

	public function ipDelProvider()
	{
		return [
			[ 0, 404 ],
			[ "", 404 ],
			[ true, 404 ],
		];
	}
}