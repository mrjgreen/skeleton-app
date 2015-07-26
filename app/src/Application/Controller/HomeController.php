<?php namespace Application\Controller;

class HomeController extends BaseController
{
    public function getIndex()
    {
        return $this->render('home/index.html');
    }
}
