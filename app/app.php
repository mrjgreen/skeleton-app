<?php

use Symfony\Component\Debug\ErrorHandler;
// Convert errors to exceptions for the application
ErrorHandler::register();

$app = new \League\Container\Container;

$app['path.public'] = __DIR__ . '/../public';

$app['config'] = function() use($app){
    return include __DIR__ . '/config.php';
};

$app['request'] = function()
{
    return \Symfony\Component\HttpFoundation\Request::createFromGlobals();
};

$app['view'] = function() use($app){

    return new \Twig_Environment(new \Twig_Loader_Filesystem([__DIR__ . '/views']));
};

/*
* We start.php by creating a route collector and then include the routes file, which will attach all our routes.
* If we have already cached the data file we don't need to re-build the
* regex data.
*/
$app['router'] = function() use($app){

    $routeCollector = new \Phroute\Phroute\RouteCollector();

    /**
     * Filters
     */
    $routeCollector->filter('auth', array('Application\Support\AuthFilter', 'filter'));

    /**
     * Routes
     */
    $routeCollector->controller('/', 'Application\Controller\HomeController');


    return new \Phroute\Phroute\Dispatcher($routeCollector->getData(), new \Application\Support\RouterResolver($app));
};

$app->invokable('dispatch', function(\Symfony\Component\HttpFoundation\Request $request) use($app)
{
    $response = $app['router']->dispatch($request->getMethod(), $request->getPathInfo());

    $response instanceof \Symfony\Component\HttpFoundation\Response or
        $response = \Symfony\Component\HttpFoundation\Response::create($response);

    // Head responses should not return a content body
    $request->isMethod('head') and $response->setContent(null);

    return $response;
});


$controllers = [
    'Application\Controller\HomeController',
    'Application\Controller\ErrorController',
];

array_map(function($controller) use($app){
    $app->add($controller)
        ->withMethodCall('setRequest', ['request'])
        ->withMethodCall('setView', ['view'])
        ->withMethodCall('setSession', ['session'])
    ;
}, $controllers);

array_walk($providers, function($provider) use($app){ $provider->register($app); });

return $app;