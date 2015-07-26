<?php namespace Application\Controller\Traits;

use Symfony\Component\HttpFoundation\Request;

trait RequestAwareTrait
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }
}
