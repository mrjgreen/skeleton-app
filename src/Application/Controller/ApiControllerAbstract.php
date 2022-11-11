<?php
namespace Application\Controller;

use Application\Controller\Traits\RequestAwareTrait;

abstract class ApiControllerAbstract
{
    use RequestAwareTrait;
}