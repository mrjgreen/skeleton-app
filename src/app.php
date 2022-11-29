<?php

use League\Container\Argument\Literal;
use League\Container\Container;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\ErrorHandler\DebugClassLoader;

Debug::enable();
DebugClassLoader::disable();

require __DIR__ . '/helpers.php';

$app = new Container;

/*
 *--------------------------------------------------------------------------
 * Paths
 *--------------------------------------------------------------------------
 *
 * Useful application file paths can be configured centrally, relative to
 * this directory for simple directory refactoring
 */
$app->add('paths', new Literal\ArrayArgument([
    'app' => __DIR__,
    'config' => __DIR__ . '/config.php',
    'routes' => __DIR__ . '/routes.php',
]));

/*
 *--------------------------------------------------------------------------
 * Register Services from Provider
 *--------------------------------------------------------------------------
 *
 * Boot each service provider, attaching services to
 * the dependency injection container. Some services depend on others, so
 * the boot order is important.
 */
$providers = array(
    new Application\Provider\ConfigProvider,
    new Application\Provider\RouterProvider,
    new Application\Provider\ControllerProvider,
);

array_walk($providers, fn($provider) => $provider->register($app));

return $app;