<?php namespace Application\Controller\Traits;

use Symfony\Component\HttpFoundation\Session\Session;

trait SessionAwareTrait
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @var \Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface
     */
    protected $flash;

    /**
     * @param Session $session
     */
    public function setSession(Session $session)
    {
        $this->session = $session;

        $this->flash = $this->session->getFlashBag();
    }
}
