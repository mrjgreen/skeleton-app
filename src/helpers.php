<?php
use League\Route\RouteGroup;
use League\Route\Router;

function camelCaseToDashed($string)
{
    return strtolower(preg_replace('/([A-Z])/', '-$1', lcfirst($string)));
}

function buildControllerParameters(ReflectionMethod $method)
{
    $params = "";

    foreach ($method->getParameters() as $param) {
        $params .= "/{" . $param->getName() . "}" . ($param->isOptional() ? '?' : '');
    }

    return $params;
}

function getRoutesForController(string $classname, string $prefix = null)
{
    $reflection = new ReflectionClass($classname);

    $httpMethods = ["GET", "POST", "PUT", "PATCH", "DELETE", "HEAD", "OPTIONS"];

    $routes = [];

    foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
        foreach ($httpMethods as $httpMethod) {
            if (stripos($method->name, $httpMethod) === 0) {
                $methodName = camelCaseToDashed(substr($method->name, strlen($httpMethod)));

                $params = buildControllerParameters($method);

                if ($methodName === 'index') {
                    $methodName = "";
                }

                $route = $prefix . "/" . $methodName . $params;

                $routes[] = [$httpMethod, $route, [$classname, $method->name]];

                break;
            }
        }
    }

    return $routes;
}