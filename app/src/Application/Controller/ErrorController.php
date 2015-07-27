<?php namespace Application\Controller;

use Symfony\Component\HttpFoundation\Response;

class ErrorController extends BaseController
{
    public function error404()
    {
        return new Response($this->render('error/404.html'), 404);
    }

    public function error405()
    {
        return new Response($this->render('error/404.html'), 405);
    }

    public function error500(\Exception $e = null)
    {
        return new Response($this->render('error/500.html'), 500);
    }
}
