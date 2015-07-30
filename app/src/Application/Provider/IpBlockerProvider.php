<?php namespace Application\Provider;

use League\Container\Container;
use Application\Services\IpBlocker\IpBlocker;

class IpBlockerProvider {

    public function register(Container $app)
    {
        $app['Application\Services\IpBlocker\IpBlocker'] = function() use($app){

            return new IpBlocker(
                $app['request']->getClientIp(),
                $app['Application\Repository\IpBlacklistRepository'],
                $app['config']['auth.max_attempts'],
                $app['config']['auth.ban_period_minutes']
            );
        };
    }
}