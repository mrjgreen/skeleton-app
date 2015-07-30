<?php namespace Application;

use \Phroute\Phroute\RouteCollector;

return function(RouteCollector $route){

    /**
     * Filters
     */
    $route->filter('auth', array('Application\Support\AuthFilter', 'filter'));
    $route->filter('guest', array('Application\Support\GuestFilter', 'filter'));
    $route->filter('admin', array('Application\Support\AdminFilter', 'filter'));

    $route->get('/', array('Application\Controller\HomeController', 'getIndex'));

    $route->group(array('before' => 'guest'), function() use($route){

        $route->controller('/', 'Application\Controller\LoginController');

        $route->controller('/recovery', 'Application\Controller\PasswordResetController');
    });

    $route->group(array('before' => 'auth'), function() use($route){

        $route->get('/logout', array('Application\Controller\LogoutController', 'getLogout'));

        $route->controller('/account', 'Application\Controller\AccountController');
    });
};