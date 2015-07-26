<?php

$app = new \League\Container\Container;

/*
 *--------------------------------------------------------------------------
 * Paths
 *--------------------------------------------------------------------------
 *
 * Useful application file paths can be configured centrally, relative to
 * this directory for simple directory refactoring
 */
$app['paths'] = array(
    'app'       => __DIR__,
    'public'    => __DIR__ . '/../public',
    'config'    => __DIR__ . '/config',
    'view'      => __DIR__ . '/views',
    'storage'   => __DIR__ . '/storage',
    'routes'    => __DIR__ . '/routes.php',
    'vendor'    => __DIR__ . '/../vendor',
);

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
    new Application\Provider\Config,
    new Application\Provider\View,
    new Application\Provider\Log,
    new Application\Provider\Error,
    new Application\Provider\Request,
    new Application\Provider\Session,
    new Application\Provider\Router,
    new Application\Provider\Database,
    new Application\Provider\Controllers,
    new Application\Provider\Authentication,
    new Application\Provider\Dispatch,
    new Application\Provider\Mailer,
);

array_walk($providers, function($provider) use($app){ $provider->register($app); });

return $app;