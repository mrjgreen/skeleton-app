<?php
namespace Application\Provider;

use Laminas\Diactoros\ResponseFactory;
use League\Route\Router;
use League\Container\Container;
use League\Route\Strategy\JsonStrategy;

class RouterProvider implements ProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app->add(Router::class, function () use ($app) {

            $responseFactory = new ResponseFactory;

            $strategy = (new JsonStrategy($responseFactory))->setContainer($app);

            $router = (new Router)->setStrategy($strategy);

            $paths = $app->get('paths');

            $collector = include $paths['routes'];

            $collector($router);

            return $router;
        });
    }

}