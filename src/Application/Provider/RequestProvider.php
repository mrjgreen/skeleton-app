<?php
namespace Application\Provider;

use League\Container\Container;
use Laminas\Diactoros\ServerRequestFactory;

class RequestProvider implements ProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app->add('request', function () {
            return ServerRequestFactory::fromGlobals(
                $_SERVER,
                $_GET,
                $_POST,
                $_COOKIE,
                $_FILES
            );
        });
    }
}