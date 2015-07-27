<?php namespace Application\Provider;

use League\Container\Container as Container;

class ConfigProvider
{
    public function register(Container $app)
    {
        $app['config'] = function() use($app){

            return include $app['paths']['config'];
        };
    }
}
