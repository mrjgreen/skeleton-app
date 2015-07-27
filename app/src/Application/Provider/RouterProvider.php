<?php namespace Application\Provider;

use Application\Support\RouterResolver;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\RouteCollector;
use League\Container\Container as Container;

class RouterProvider implements ProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        /*
         * We start.php by creating a route collector and then include the routes file, which will attach all our routes.
         * If we have already cached the data file we don't need to re-build the
         * regex data.
         */
        $app['router'] = function() use($app){

            $callback = function() use($app){

                $routeCollector = new RouteCollector();

                $collector = $this->getRouteCollectorCallback($app['paths']['routes']);

                $collector($routeCollector);

                return $routeCollector->getData();
            };

            $routeData = $app['config']['router.cache'] ? $this->cache($app, $callback) : $callback();

            return new Dispatcher($routeData, new RouterResolver($app));
        };
    }

    /**
     * @param Container $app
     * @param callable $callback
     * @return mixed
     */
    private function cache(Container $app, \Closure $callback)
    {
        $cacheFile = $app['paths']['storage'] . '/router_cache.dat';

        if(!is_file($cacheFile) || filemtime($app['paths']['routes']) > filemtime($cacheFile))
        {
            $data = $callback();

            file_put_contents($cacheFile, serialize($data));

            return $data;
        }

        if($cached = file_get_contents($cacheFile))
        {
            return unserialize($cached);
        }

        throw new \RuntimeException("No route data could be created");
    }

    /**
     * @param string $file
     * @return \Closure
     */
    private function getRouteCollectorCallback($file)
    {
        return include $file;
    }
}
