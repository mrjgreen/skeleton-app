<?php namespace Application\Provider;

use League\Container\Container as Container;

class Session implements ProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app->singleton('session', 'Symfony\Component\HttpFoundation\Session\Session');
    }
}
