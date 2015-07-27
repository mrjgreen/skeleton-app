<?php namespace Application\Support;

use Phroute\Authentic\Authenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AuthFilter
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function filter()
    {
        if(!$this->session->get('user'))
        {
            return new RedirectResponse('/login');
        }
    }
}