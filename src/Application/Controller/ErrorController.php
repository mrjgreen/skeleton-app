<?php
namespace Application\Controller;

use Laminas\Diactoros\Response\JsonResponse;

class ErrorController extends ApiControllerAbstract
{
    public function getError404()
    {
        return new JsonResponse("error", 404);
    }

    public function getError405()
    {
        return new JsonResponse("error", 405);
    }

    public function getError500(\Exception $e = null)
    {
        return new JsonResponse("error", 500);
    }
}