<?php namespace Application\Support;

use Phroute\Authentic\Authenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;

class GuestFilter
{
    private $authenticator;

    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    public function filter()
    {
        if($this->authenticator->check())
        {
            return new RedirectResponse('/');
        }
    }
}