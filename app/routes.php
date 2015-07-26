<?php namespace Application;

use \Phroute\Phroute\RouteCollector;

return function(RouteCollector $route){

    /**
     * Filters
     */
    $route->filter('auth', array('Application\Support\AuthFilter', 'filter'));
    $route->filter('guest', array('Application\Support\GuestFilter', 'filter'));


    /**
     * Routes
     */
    $route->controller('/', 'Application\Controller\HomeController');


    $route->group(array('before' => 'auth'), function() use($route){

        $route->controller('/admin', 'Application\Controller\AdminController');
    });
};