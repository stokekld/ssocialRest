<?php

class PruebasTest extends TestCase
{
	public function testPrueba()
    {
        $response = $this->call('POST', 'logIn', [], [], [], [], '{"user":"admin","password":"de5bbd7c6f5db21568d17697d2761605"}');

        echo $response->content();
    }
}
