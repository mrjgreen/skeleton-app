<?php
namespace Application\Provider;

use League\Container\Container;


interface ProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app);
}