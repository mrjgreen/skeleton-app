<?php namespace Application\Provider;

use League\Container\Container as Container;
use Application\Services\Mailer as AppMailer;

/**
 * Class Error
 *
 * @package Application\Provider
 *
 * We attach error handlers for all errors and uncaught exceptions
 * We can handle them differently depending on the type of exception
 * The catch all uses filp/whoops to give better error feedback
 */
class MailerProvider implements ProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app['Application\Services\Mailer'] = function () use ($app) {

            $config = $app['config'];

            $transport = $this->getTransportDriver($config['mail.driver'], $config['mail.config']);

            $mailer = new AppMailer(new \Swift_Mailer($transport), $app['Psr\Log\LoggerInterface']);

            if($config['mail.from.email'])
            {
                $mailer->alwaysFrom($config['mail.from.email'], $config['mail.from.name']);
            }

            return $mailer;
        };
    }

    private function getTransportDriver($type, array $config)
    {
        switch($type)
        {
            case 'mail':
                return new \Swift_MailTransport();
        }

        throw new \InvalidArgumentException("Unknown mail driver '$type'");
    }
}
