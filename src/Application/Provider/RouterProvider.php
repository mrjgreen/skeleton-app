<?php
namespace Application\Provider;

use Laminas\Diactoros\ResponseFactory;
use League\Route\Router;
use League\Container\Container;
use League\Route\Strategy\JsonStrategy;

class RouterProvider implements ProviderInterface
{
    public function register(Container $app)
    {
        $app->add(Router::class, function () use ($app) {

            $strategy = new JsonStrategy(new ResponseFactory);
            $strategy->setContainer($app);

            $router = new Router;
            $router->setStrategy($strategy);

            $paths = $app->get('paths');

            $collector = include $paths['routes'];

            $collector($router);

            return $router;
        });
    }

}