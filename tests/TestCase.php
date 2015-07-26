<?php

class TestCase extends PHPUnit_Framework_TestCase
{
    private $app;

    public function setUp()
    {
        $this->app = include __DIR__ . '/../app/app.php';
    }

    public function call($method, $route)
    {
        return $this->app['router']->dispatch($method, $route);
    }
}
