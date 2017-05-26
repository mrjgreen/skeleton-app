<?php

use Symfony\Component\Debug\ErrorHandler;
// Convert errors to exceptions for the application
ErrorHandler::register();

$app = new \League\Container\Container;

/*
 *--------------------------------------------------------------------------
 * Paths
 *--------------------------------------------------------------------------
 *
 * Useful application file paths can be configured centrally, relative to
 * this directory for simple directory refactoring
 */
$app['paths'] = [
    'app'       => __DIR__,
    'vendor'    => __DIR__ . '/../vendor',
    'public'    => __DIR__ . '/../public',
    'config'    => __DIR__ . '/config.php',
    'view'      => __DIR__ . '/views',
    'storage'   => __DIR__ . '/storage',
    'routes'    => __DIR__ . '/routes.php',
    'commands'  => __DIR__ . '/commands.php',
];

/*
 *--------------------------------------------------------------------------
 * Register Services from Provider
 *--------------------------------------------------------------------------
 *
 * Boot each service provider, attaching services to
 * the dependency injection container. Some services depend on others, so
 * the boot order is important.
 */
$providers = [
    new Application\Provider\ConfigProvider,
    new Application\Provider\ViewProvider,
    new Application\Provider\LogProvider,
    new Application\Provider\RequestProvider,
    new Application\Provider\DatabaseProvider,
    new Application\Provider\SessionProvider,
    new Application\Provider\RouterProvider,
    new Application\Provider\ControllerProvider,
    new Application\Provider\DispatchProvider,
    new Application\Provider\CommandProvider,
    new Application\Provider\AuthenticationProvider,
    new Application\Provider\IpBlockerProvider,
    new Application\Provider\MailerProvider,
    new Application\Provider\FormBuilderProvider,
];

array_walk($providers, function($provider) use($app){ $provider->register($app); });

return $app;
