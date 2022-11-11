<?php

function camelCaseToDashed($string)
{
    return strtolower(preg_replace('/([A-Z])/', '-$1', lcfirst($string)));
}

function buildControllerParameters(ReflectionMethod $method)
{
    $params = [];

    foreach ($method->getParameters() as $param) {
        $params[] = "{" . $param->getName() . "}" . ($param->isOptional() ? '?' : '');
    }

    return implode("/", $params);
}

/**
 * @param $route
 * @param $classname
 * @param array $filters
 * @return array
 */
function getRoutesForController($classname)
{
    $reflection = new ReflectionClass($classname);

    $validMethods = ["GET", "POST", "PUT", "PATCH", "DELETE", "HEAD", "OPTIONS"];

    $routes = [];

    foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
        foreach ($validMethods as $valid) {
            if (stripos($method->name, $valid) === 0) {
                $methodName = camelCaseToDashed(substr($method->name, strlen($valid)));

                $params = buildControllerParameters($method);

                if ($methodName === 'index') {
                    $methodName = "/";
                }

                $routes[] = [$valid, $methodName . $params, [$classname, $method->name]];

                break;
            }
        }
    }

    return $routes;
}