<?php namespace Application\Provider;

use League\Container\Container as Container;


interface ProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app);
}
