<?php namespace Application\Provider;

use Application\Support\DummyTranslationFilters;
use League\Container\Container as Container;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;

class View
{
    public function register(Container $app)
    {
        $app['view'] = function() use($app){

            $loader = new \Twig_Loader_Filesystem(array(
                $app['paths']['view'],
            ));

            $twig = new \Twig_Environment($loader, array(
                'cache' => $app['config']['view.cache'] ? $app['paths']['storage'] . '/views' : null,
            ));

            return $twig;
        };
    }
}
