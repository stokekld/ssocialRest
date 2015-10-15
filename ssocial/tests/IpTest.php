<?php

/**
* 
*/
class IpTest extends TestCase
{	

	/**
	* @dataProvider ipProvider
	*/
	public function testAddIp($data, $code)
	{
		$token = $this -> getTokenAdmin();

		$this -> json('post', 'ip', $data, ['Authorization' => $token])->assertResponseStatus( $code );

		echo $this -> response -> content()."\n";
	}

	public function ipProvider()
	{
		$ip = "";
		for ($i=0; $i < 3; $i++)
			$ip .= rand(0, 255).".";
		$ip .= rand(0, 255);


		return [
			[ [], 400 ],
			[ ['ipp' => 'holamundo'], 400 ],
			[ ['ipp' => 0], 400 ],
			[ ['ipp' => $ip], 201 ],
			[ ['ipp' => $ip], 409 ],
		];
	}
}