<?php

use Application\Controller\ApiController;
use Application\Controller\HealthController;
use League\Route\Router;

return function (Router $router) {

    $router->get("/health", [HealthController::class, "getHealth"]);
    $router->get("/exception", [HealthController::class, "getException"]);
    $router->get("/api", [ApiController::class, "getIndex"]);

};