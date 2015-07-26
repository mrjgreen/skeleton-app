<?php namespace Application\Controller;

use Application\Services\Mailer;

class AdminController extends BaseController
{
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function getIndex()
    {
        return $this->render('home/admin.html');
    }
}
