<?php

class LoginTest extends TestCase
{

	/**
	* @dataProvider credentialsProvider
	*/
	public function testLogin($credentials, $code)
    {
        $this -> json('post', 'logIn', $credentials)->assertResponseStatus( $code );

        echo $this -> response -> content()."\n";
    }

    public function credentialsProvider()
    {
    	return [
    		[ ['user' => '', 'password' => 'de5bbd7c6f5db21568d17697d2761605'], 400 ],
    		[ ['user' => 'admin', 'password' => ''], 400 ],
            [ [], 400 ],
            [ ['user' => 'hola'], 400 ],
            [ ['password' => 'mundo'], 400 ],
    		[ ['user' => 'hola', 'password' => 'mundo'], 401 ],
    		[ ['user' => 'admin', 'password' => 'de5bbd7c6f5db21568d17697d2761605'], 200 ],
    	];
    }
}
