<?php
namespace Application\Controller;

use Laminas\Diactoros\Response;

class HomeController extends ApiControllerAbstract
{
    public function getIndex()
    {
        return [
            "ok" => true
        ];
    }

    public function getError(string $a, string $b)
    {
        return [
            "ok" => true
        ];
    }

    public function getFoo(string $a, string $b)
    {
        return [
            "ok" => true
        ];
    }
}