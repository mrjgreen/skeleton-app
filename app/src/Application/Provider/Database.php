<?php namespace Application\Provider;

use League\Container\Container as Container;
use Database\ConnectionResolver;

class Database
{
    public function register(Container $app)
    {
        $app['Database\ConnectionResolver'] = function() use($app){

            $resolver = new ConnectionResolver($app['config']['database.connections']);

            $resolver->setDefaultConnection($app['config']['database.default']);

            return $resolver;
        };

        // Default connection
        $app['Database\Connection'] = function() use($app){

            return $app['Database\ConnectionResolver']->connection();
        };
    }
}
