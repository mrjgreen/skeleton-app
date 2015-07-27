<?php namespace Application;

use \Phroute\Phroute\RouteCollector;

return function(RouteCollector $route){

    /**
     * Filters
     */
    $route->filter('auth', array('Application\Support\AuthFilter', 'filter'));


    /**
     * Routes
     */
    $route->controller('/', 'Application\Controller\HomeController');
};