<?php namespace Application\Controller\Traits;

trait ViewAwareTrait
{
    /**
     * @var \Twig_Environment
     */
    protected $view;

    /**
     * @param \Twig_Environment $view
     */
    public function setView(\Twig_Environment $view)
    {
        $this->view = $view;
    }
}
