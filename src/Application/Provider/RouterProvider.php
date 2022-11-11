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
        $responseFactory = new ResponseFactory();
        $jsonStrategy = new JsonStrategy($responseFactory);

        /*
         * We start php by creating a route collector and then include the routes file, which will attach all our routes.
         */
        $app->add('router', function () use ($app, $jsonStrategy) {

            $appStrategy = (new ApplicationStrategy)->setContainer($app);

            $router = (new Router)
                ->setStrategy($appStrategy)
                ->setStrategy($jsonStrategy);

            $paths = $app->get('paths');

            $collector = include $paths['routes'];

            $collector($router);

            return $router;
        });
    }

}