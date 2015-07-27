<?php namespace Application\Provider;

use League\Container\Container;
use Symfony\Component\HttpFoundation\Request;

class RequestProvider implements ProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app['request'] = function()
        {
            return Request::createFromGlobals();
        };
    }
}
