<?php
namespace Application\Controller;

use Laminas\Diactoros\Response\JsonResponse;


class ApiController extends ApiControllerAbstract
{
    public function getIndex()
    {
        return new JsonResponse(["ok" => true]);
    }

}