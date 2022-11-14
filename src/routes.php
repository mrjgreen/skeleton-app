<?php

use Application\Controller\HealthController;
use League\Route\Router;
use \Application\Controller\ApiController;

return function (Router $router) {

    $routes = [
        ...getRoutesForController(HealthController::class),
        ...getRoutesForController(ApiController::class, "/api")
    ];

    foreach($routes as $route) {
        $router->map(...$route);
    }
};