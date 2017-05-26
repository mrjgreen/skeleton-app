<?php namespace Application\Provider;

use Application\Support\DummyTranslationFilters;
use League\Container\Container as Container;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;

class ViewProvider
{
    public function register(Container $app)
    {
        $app['view'] = function() use($app){

            $loader = new \Twig_Loader_Filesystem(array(
                $app['paths']['view'],
                $app['paths']['vendor'] . '/symfony/twig-bridge/Resources/views/Form',
            ));

            $twig = new \Twig_Environment($loader, array(
                'cache' => $app['config']['view.cache'] ? $app['paths']['storage'] . '/views' : false,
            ));

            $twig->addExtension(new DummyTranslationFilters());

            $formEngine = new TwigRendererEngine(array('bootstrap_3_horizontal_layout.html.twig'), $twig);

            $twig->addRuntimeLoader(new \Twig_FactoryRuntimeLoader(array(
                TwigRenderer::class => function () use ($formEngine) {
                    return new TwigRenderer($formEngine);
                },
            )));

            // add the FormExtension to Twig
            $twig->addExtension(new FormExtension());

            return $twig;
        };
    }
}
