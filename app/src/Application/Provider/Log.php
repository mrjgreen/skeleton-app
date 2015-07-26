<?php namespace Application\Provider;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use League\Container\Container as Container;

class Log
{
    public function register(Container $app)
    {
        $app['Psr\Log\LoggerInterface'] = function() use($app){
            return new Logger(new StreamHandler(fopen('php://stdout', 'w')));
        };
    }
}
