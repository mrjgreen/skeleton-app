<?php namespace Application\Provider;

use League\Container\Container as Container;

class ViewProvider
{
    public function register(Container $app)
    {
        $app['view'] = function() use($app){

            $loader = new \Twig_Loader_Filesystem([
                $app['paths']['view'],
            ]);

            $twig = new \Twig_Environment($loader, [
                'cache' => $app['config']['view.cache'] ? $app['paths']['storage'] . '/views' : null,
            ]);

            return $twig;
        };
    }
}
