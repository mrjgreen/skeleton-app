<?php

use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var League\Container\Container
     */
    private $app;

    /**
     * @var Phroute\Phroute\Dispatcher
     */
    private $router;

    public function setUp()
    {
        $this->app = include __DIR__ . '/../app/app.php';

        // We can't use real sessions so we need to override the container's session with a mock session
        $this->app->singleton('session', new Session(new MockArraySessionStorage()));

        $this->router = $this->app['router'];
    }

    /**
     * @param $method string
     * @param $route string
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function call($method, $route)
    {
        return $this->app->call('dispatch', [Request::create($route, $method)]);
    }
}
