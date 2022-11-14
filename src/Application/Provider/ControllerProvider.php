<?php
namespace Application\Provider;

use League\Container\Container;

class ControllerProvider
{
    private static $controllers = [
        \Application\Controller\HomeController::class => [],
        \Application\Controller\HealthController::class => [],
    ];

    public function register(Container $app)
    {
        foreach (self::$controllers as $controller => $ctorArgs) {
            $app->add($controller)
                ->addArguments($ctorArgs)
                ->addMethodCall('setRequest', ['request']);
        }
    }
}