<?php

use Laminas\Diactoros\ServerRequest;
use League\Route\Router;
use League\Container\Container;
use Psr\Http\Message\ResponseInterface;

class TestCase extends PHPUnit\Framework\TestCase
{
    private Container $app;

    public function setUp(): void
    {
        $this->app = include __DIR__ . '/../src/app.php';
    }

    public function call(string $method, string $uri): ResponseInterface
    {
        $request = new ServerRequest(method: $method, uri: $uri);

        return $this->app->get(Router::class)->dispatch($request);
    }
}