<?php namespace Application\Provider;

use Error\Handler as ErrorHandler;
use Exception;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;
use League\Container\Container as Container;
use Whoops\Run as WhoopsRun;
use Whoops\Handler\PrettyPageHandler;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Error
 *
 * @package Application\Provider
 *
 * We attach error handlers for all errors and uncaught exceptions
 * We can handle them differently depending on the type of exception
 * The catch all uses filp/whoops to give better error feedback
 */
class Error implements ProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $handler = new ErrorHandler();

        $handler->error(function(HttpRouteNotFoundException $e) use($app){
            Response::create($app['view']->render('error/404.html', array(
                'user' => $app['auth.user']
            )), 404)->send();
        });

        $handler->error(function(HttpMethodNotAllowedException $e) use($app){
            Response::create($app['view']->render('error/404.html', array(
                'user' => $app['auth.user']
            )), 404)->send();
        });

        $handler->error(function(Exception $e){
            (new WhoopsRun)
                ->pushHandler(new PrettyPageHandler)
                ->handleException($e);
        });
    }
}
