<?php namespace Application\Provider;

use League\Container\Container as Container;

class Request implements ProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app['request'] = function()
        {
            return \Symfony\Component\HttpFoundation\Request::createFromGlobals();
        };
    }
}
