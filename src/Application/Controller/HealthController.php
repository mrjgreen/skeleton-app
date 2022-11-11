<?php
namespace Application\Controller;

use Laminas\Diactoros\Response\JsonResponse;

class HealthController extends ApiControllerAbstract
{
    public function getHealth()
    {
        // Can check dependencies here if needed
        return ["ok" => true];
    }

    public function getException()
    {
        throw new \Exception("Error");
    }
}