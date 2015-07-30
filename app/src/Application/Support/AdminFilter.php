<?php namespace Application\Support;

use Application\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminFilter
{
    private $loggedInUser;

    public function __construct(User $loggedInUser)
    {
        $this->loggedInUser = $loggedInUser;
    }

    public function filter()
    {
        if(!$this->loggedInUser->isAdmin())
        {
            return new RedirectResponse('/');
        }
    }
}