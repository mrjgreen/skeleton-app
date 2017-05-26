<?php namespace Application\Provider;

use League\Container\Container as Container;

class ControllerProvider
{
    protected $controllers = [
        'Application\Controller\HomeController' => [],

        'Application\Controller\LoginController' => [
            'Phroute\Authentic\Authenticator',
            'Application\Services\IpBlocker\IpBlocker',
        ],

        'Application\Controller\LogoutController' => [
            'Phroute\Authentic\Authenticator',
        ],

        'Application\Controller\PasswordResetController' => [
            'Phroute\Authentic\Authenticator',
            'Application\Services\Mailer',
        ],

        'Application\Controller\AccountController' => [],
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
                //->withMethodCall('setFormHelper', ['Application\Form\FormHelper'])
            ;
        }
    }
}
