<?php namespace Application\Provider;

use League\Container\Container as Container;

class Controllers
{
    protected $controllers = [
        'Application\Controller\HomeController' => [],

        // If you need dependencies in your controller, you can do it here
        'Application\Controller\AdminController' => [
            'Application\Services\Mailer',
        ],
    ];

    public function register(Container $app)
    {
        foreach($this->controllers as $controller => $ctorArgs)
        {
            $app->add($controller)
                ->withArguments($ctorArgs)
                ->withMethodCall('setUser', ['auth.user'])
                ->withMethodCall('setRequest', ['request'])
                ->withMethodCall('setView', ['view'])
                ->withMethodCall('setSession', ['session'])
            ;
        }
    }
}
