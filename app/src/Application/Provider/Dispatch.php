<?php namespace Application\Provider;

use League\Container\Container as Container;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\JsonResponse;

class Dispatch implements ProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app->invokable('dispatch', function() use($app)
        {
            $request = $app['request'];

            $response = $this->wrapResponse($app['router']->dispatch($request->getMethod(), $request->getPathInfo()));

            // Attach queued cookies to the response
            array_map(array($response->headers, 'setCookie'), $app['auth.cookie']->getQueuedCookies());

            // Head responses should not return a content body
            $request->isMethod('head') and $response->setContent(null);

            $response->send();
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

}
