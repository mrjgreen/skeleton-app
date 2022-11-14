<?php
namespace Application\Provider;

use League\Container\Container;
use League\Container\Argument\Literal;
use Laminas\Diactoros\ServerRequest;

class DispatchProvider implements ProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $dispatch = function (ServerRequest $request) use ($app) {
            return $app->get('router')->dispatch($request);
        };

        $app->add('dispatch', new Literal\CallableArgument($dispatch));
    }
}