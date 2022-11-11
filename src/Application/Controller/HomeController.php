<?php
namespace Application\Controller;

class HomeController extends ApiControllerAbstract
{
    public function getIndex()
    {
        return [
            "ok" => true
        ];
    }
}