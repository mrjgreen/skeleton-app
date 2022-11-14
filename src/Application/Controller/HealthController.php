<?php
namespace Application\Controller;

use Laminas\Diactoros\Response\JsonResponse;
use League\Route\Http\Exception\BadRequestException;


class HealthController extends ApiControllerAbstract
{
    public function getHealth()
    {
        return new JsonResponse(["ok" => true]);
    }

    public function getException()
    {
        throw new BadRequestException("Error");
    }
}