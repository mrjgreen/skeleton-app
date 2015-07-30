<?php namespace Application;

use \Phroute\Phroute\RouteCollector;

return function(RouteCollector $route){

    /**
     * Filters
     */
    $route->filter('auth', array('Application\Support\AuthFilter', 'filter'));
    $route->filter('guest', array('Application\Support\GuestFilter', 'filter'));
    $route->filter('admin', array('Application\Support\AdminFilter', 'filter'));



    $route->group(array('before' => 'guest'), function() use($route){

        $route->post('/register', array('Application\Controller\HomeController', 'postRegister'));

        $route->get('/register', array('Application\Controller\HomeController', 'getRegister'));

        $route->post('/login', array('Application\Controller\HomeController', 'postLogin'));

        $route->get('/', array('Application\Controller\HomeController', 'getIndex'));

        $route->controller('/recovery', 'Application\Controller\PasswordResetController');
    });

    $route->group(array('before' => 'auth'), function() use($route){

        $route->get('/logout', array('Application\Controller\HomeController', 'getLogout'));

        $route->controller('/account', 'Application\Controller\AccountController');
    });
};