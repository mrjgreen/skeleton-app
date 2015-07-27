<?php namespace Application\Controller;

class HomeController extends ControllerAbstract
{
    public function getIndex()
    {
        return $this->render('home/index.html');
    }
}
