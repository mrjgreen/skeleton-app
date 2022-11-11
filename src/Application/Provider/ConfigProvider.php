<?php
namespace Application\Provider;

use League\Container\Container;

class ConfigProvider
{
    public function register(Container $app)
    {
        $app->add('config', function () use ($app) {

            $paths = $app->get('paths');

            return include $paths['config'];
        });
    }
}