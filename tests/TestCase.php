<?php

use Laminas\Diactoros\ServerRequest;
use League\Route\Router;
use League\Container\Container;
use Psr\Http\Message\ResponseInterface;

class TestCase extends PHPUnit\Framework\TestCase
{
    private Container $app;

    private Router $router;

    public function setUp(): void
    {
        $this->app = include __DIR__ . '/../src/app.php';

        $this->router = $this->app->get('router');
    }

    public function call(string $method, string $uri): ResponseInterface
    {
        $dispatch = $this->app->get('dispatch');
        return $dispatch(new ServerRequest(method: $method, uri: $uri));
    }
}