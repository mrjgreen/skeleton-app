<?php namespace Application\Provider;

use Application\Support\AdminFilter;
use Application\Support\AuthFilter;
use Phroute\Authentic\Authenticator;
use Phroute\Authentic\NamedPersistence;
use Phroute\Authentic\Persistence\CookieProxy;
use League\Container\Container;
use Phroute\Authentic\Persistence\SymfonySession;

class Authentication
{
    public function register(Container $app)
    {
        $app['auth.cookie'] = function() use($app){

            return new CookieProxy($app['request']->cookies->all());
        };

        $app['auth.user'] = function() use($app){

            return $app['Phroute\Authentic\Authenticator']->getUser();
        };

        $app['Application\Support\AuthFilter'] = function() use($app)
        {
            return new AuthFilter(
                $app['Phroute\Authentic\Authenticator'],
                $app['request'],
                $app['session']
                );
        };

        $app['Phroute\Authentic\Authenticator'] = function() use($app){

            session_start();

            $auth = new Authenticator(
                $app['Application\Repository\UserRepository'],
                new NamedPersistence('auth.user', new SymfonySession($app['session'])),
                new NamedPersistence('auth_remember', $app['auth.cookie'])
            );

            return $auth;
        };
    }
}