<?php namespace Application\Provider;

use Config\Loader\FileLoader;
use Config\Repository;
use League\Container\Container as Container;

class Config
{
    public function register(Container $app)
    {
        $app['config'] = function() use($app){

            return new Repository(new FileLoader($app['paths']['config']));
        };
    }
}
