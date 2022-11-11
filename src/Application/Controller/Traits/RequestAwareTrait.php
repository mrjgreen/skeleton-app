<?php
namespace Application\Controller\Traits;

use Laminas\Diactoros\ServerRequest;

trait RequestAwareTrait
{
    /**
     * @var ServerRequest
     */
    protected $request;

    /**
     * @param ServerRequest $request
     */
    public function setRequest(ServerRequest $request)
    {
        $this->request = $request;
    }
}