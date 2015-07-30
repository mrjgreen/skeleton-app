<?php namespace Application\Provider;

use League\Container\Container as Container;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Whoops\Run as WhoopsRun;
use Whoops\Handler\PrettyPageHandler;

class DispatchProvider implements ProviderInterface
{
    private $app;
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $this->app = $app;

        $app->invokable('dispatch', function(Request $request) use($app)
        {
            $response = $this->wrapResponse($this->dispatch($app['router'], $request));

            // Head responses should not return a content body
            $request->isMethod('head') and $response->setContent(null);

            return $response;
        });
    }

    private function wrapResponse($response)
    {
        // Ensure the response is a response instance
        if(!$response instanceof Response)
        {
            $response = is_scalar($response) ? Response::create($response) : JsonResponse::create($response);
        }

        return $response;
    }

    private function dispatch(Dispatcher $dispatcher, Request $request)
    {
        try
        {
            return $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());
        }catch (HttpRouteNotFoundException $e)
        {
            return $this->app['Application\Controller\ErrorController']->error404();
        }catch (HttpMethodNotAllowedException $e)
        {
            return $this->app['Application\Controller\ErrorController']->error405();
        }catch(\Exception $e)
        {
            return $this->app['config']['app.debug'] ?
                $this->debug($e) :
                $this->app['Application\Controller\ErrorController']->error500($e);
        }
    }

    private function debug(\Exception $e)
    {
        throw $e;

//        $whoops = (new WhoopsRun)->pushHandler(new PrettyPageHandler);
//
//        $whoops->writeToOutput(false);
//        $whoops->allowQuit(false);
//
//        return new Response($whoops->handleException($e), 500);
    }
}
