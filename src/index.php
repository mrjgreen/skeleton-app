<?php declare(strict_types=1);
use Laminas\Diactoros\ServerRequestFactory;
use League\Route\Router;

if (php_sapi_name() == 'cli-server') {

    // This allows us to emulate Apache's "mod_rewrite" from the built-in PHP web server.
    $uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

    if ($uri !== '/' and is_file(__DIR__ . $uri)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/app.php';

/*
 *--------------------------------------------------------------------------
 * Dispatch the Route
 *--------------------------------------------------------------------------
 *
 * Dispatch the route to the correct controller and return the response.
 * NB. If the request had a method HEAD we correctly remove the response
 * body sending only the headers.
 *
 * We then send the response to the browser
 */
$response = $app->get(Router::class)->dispatch(ServerRequestFactory::fromGlobals());

(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);