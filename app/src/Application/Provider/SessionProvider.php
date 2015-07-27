<?php namespace Application\Provider;

use League\Container\Container as Container;
use Symfony\Component\HttpFoundation\Session\Session;

class SessionProvider implements ProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app['session'] = function() use($app){
            $session = new Session();

            $session->setName($app['config']['session.name']);

            return $session;
        };
    }
}
