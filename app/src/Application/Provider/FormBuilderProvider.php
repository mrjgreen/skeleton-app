<?php namespace Application\Provider;

use League\Container\Container as Container;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Csrf\CsrfExtension;
use Symfony\Component\Security\Csrf\TokenStorage\SessionTokenStorage;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;
use Symfony\Component\Security\Csrf\CsrfTokenManager;

class FormBuilderProvider implements ProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app['Symfony\Component\Form\FormFactoryInterface'] = function() use($app)
        {
            //$csrfSecret = $app['config']['app.csrf_secret'];

            // create a Session object from the HttpFoundation component
            $csrfManager = new CsrfTokenManager(
              new UriSafeTokenGenerator(),
              new SessionTokenStorage($app['session'])
            );

            return
                Forms::createFormFactoryBuilder()
                    ->addExtension(new HttpFoundationExtension())
                    ->addExtension(new CsrfExtension($csrfManager))
                    ->getFormFactory();
        };
    }
}
