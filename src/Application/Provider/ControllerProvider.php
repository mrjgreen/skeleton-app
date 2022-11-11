<?php
namespace Application\Provider;

use League\Container\Container;

class ControllerProvider
{
    private static $controllers = [
        'Application\Controller\HomeController' => [],
        'Application\Controller\ErrorController' => [],
    ];

    public static function controllers()
    {
        return array_keys(self::$controllers);
    }

    public function register(Container $app)
    {
        foreach (self::$controllers as $controller => $ctorArgs) {
            $app->add($controller)
                ->addArguments($ctorArgs)
                ->addMethodCall('setRequest', ['request']);
        }
    }
}