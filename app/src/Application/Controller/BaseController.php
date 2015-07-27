<?php namespace Application\Controller;

use Application\Controller\Traits\RequestAwareTrait;
use Application\Controller\Traits\SessionAwareTrait;
use Application\Controller\Traits\ViewAwareTrait;
use Psr\Log\LoggerAwareTrait;

class BaseController
{
    use LoggerAwareTrait;
    use RequestAwareTrait;
    use ViewAwareTrait;
    use SessionAwareTrait;

    public function render($view, array $data = array())
    {
        return $this->view->render($view, $data);
    }
}
