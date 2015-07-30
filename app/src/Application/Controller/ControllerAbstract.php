<?php namespace Application\Controller;

use Application\Controller\Traits\RequestAwareTrait;
use Application\Controller\Traits\SessionAwareTrait;
use Application\Controller\Traits\ViewAwareTrait;
use Application\Entity\User;
use Application\Form\FormHelper;
use Psr\Log\LoggerAwareTrait;

abstract class ControllerAbstract
{
    use LoggerAwareTrait;
    use RequestAwareTrait;
    use ViewAwareTrait;
    use SessionAwareTrait;

    /**
     * @var FormHelper
     */
    protected $formHelper;

    /**
     * @var User
     */
    protected $user;

    public function setUser($user)
    {
        if(!is_null($user) && !$user instanceof User)
        {
            throw new \InvalidArgumentException("Argument 1 must be a User Entity");
        }

        $this->user = $user;
    }

    public function setFormHelper(FormHelper $formHelper)
    {
        $this->formHelper = $formHelper;
    }

    public function render($view, array $data = [])
    {
        return $this->view->render($view, $data);
    }
}
