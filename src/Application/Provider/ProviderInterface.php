<?php
namespace Application\Provider;

use League\Container\Container;


interface ProviderInterface
{
    public function register(Container $app);
}