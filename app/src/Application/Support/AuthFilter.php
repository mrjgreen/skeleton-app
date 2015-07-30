<?php namespace Application\Support;

use Phroute\Authentic\Authenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AuthFilter
{
    private $authenticator;

    private $session;

    private $request;

    public function __construct(Authenticator $authenticator, Request $request, SessionInterface $session)
    {
        $this->authenticator = $authenticator;

        $this->request = $request;

        $this->session = $session;
    }

    public function filter()
    {
        if(!$this->authenticator->check())
        {
            $this->session->set('login.intended', $this->request->getRequestUri());

            return new RedirectResponse('/login');
        }
    }
}