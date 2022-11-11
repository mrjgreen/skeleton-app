<?php
namespace Application\Provider;

use League\Container\Container;
use League\Container\Argument\Literal;
use Laminas\Diactoros\ServerRequest;

class DispatchProvider implements ProviderInterface
{
    private $app;
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $this->app = $app;

        $dispatch = function (ServerRequest $request) use ($app) {
            $response = $app->get('router')->dispatch($request);

            // Head responses should not return a content body
            // $request->getMethod() == 'head' && $response->setContent(null);

            return $response;
        };

        $app->add('dispatch', new Literal\CallableArgument($dispatch));
    }

}