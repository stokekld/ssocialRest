<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function getTokenAdmin()
    {
        $credentials = ['user' => 'admin', 'password' => 'de5bbd7c6f5db21568d17697d2761605'];

        $json = $this -> call('post', 'logIn', [], [], [], [], json_encode($credentials))->content();

        $array = json_decode($json, true);

        return $array['token'];
    }
}
