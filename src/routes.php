<?php

use Application\Provider\ControllerProvider;
use League\Route\Router;

return function (Router $router) {

    foreach (ControllerProvider::controllers() as $controller) {
        $routes = getRoutesForController($controller);

        foreach ($routes as $route) {
            $router->map(...$route);
        }
    }
};