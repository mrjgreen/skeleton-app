<?php namespace Application\Provider;

use League\Container\Container as Container;
use Symfony\Component\Form\Extension\Csrf\CsrfExtension;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\SessionCsrfProvider;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Forms;

class FormBuilderProvider implements ProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app->add('Symfony\Component\Form\FormFactoryInterface', function() use($app)
        {
            $csrfSecret = $app['config']['app.csrf_secret'];

            return
                Forms::createFormFactoryBuilder()
                    ->addExtension(new HttpFoundationExtension())
                    ->addExtension(new CsrfExtension(new SessionCsrfProvider($app['session'], $csrfSecret)))
                    ->getFormFactory();
        });
    }
}
