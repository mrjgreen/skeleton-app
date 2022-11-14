<?php
namespace Application\Provider;

use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use League\Container\Container;
use League\Route\Strategy\JsonStrategy;
use Laminas\Diactoros\ResponseFactory;

class RouterProvider implements ProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app->add('router', function () use ($app) {

            $appStrategy = (new ApplicationStrategy)->setContainer($app);

            $router = (new Router)->setStrategy($appStrategy);

            $paths = $app->get('paths');

            $collector = include $paths['routes'];

            $collector($router);

            return $router;
        });
    }

}