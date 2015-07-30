<?php namespace Application\Controller;

use Phroute\Authentic\Authenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LogoutController extends ControllerAbstract
{
    /**
     * @var Authenticator
     */
    protected $authenticator;

    /**
     * @param Authenticator $authenticator
     */
    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    /**
     * @return RedirectResponse
     */
    public function getLogout()
    {
        $this->authenticator->logout();

        $this->user = null;

        return new RedirectResponse('/login');
    }
}
