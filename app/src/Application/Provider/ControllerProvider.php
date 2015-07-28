<?php namespace Application\Provider;

use League\Container\Container as Container;

class ControllerProvider
{
    protected $controllers = [
        'Application\Controller\HomeController' => [
            'Application\Repository\UserRepository'
        ],
        'Application\Controller\ErrorController' => [],
    ];

    public function register(Container $app)
    {
        foreach($this->controllers as $controller => $ctorArgs)
        {
            $app->add($controller)
                ->withArguments($ctorArgs)
                ->withMethodCall('setRequest', ['request'])
                ->withMethodCall('setView', ['view'])
                ->withMethodCall('setSession', ['session'])
            ;
        }
    }
}
