<?php namespace Application\Controller;

use Application\Form\LoginForm;
use Application\Form\RegisterForm;
use Application\Validation\NewUserValidator;
use Application\Services\IpBlocker\IpBlocker;
use Phroute\Authentic\Authenticator;
use Phroute\Authentic\Exception\AuthenticationException;
use Phroute\Authentic\Exception\UserExistsException;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class HomeController extends ControllerAbstract
{
    /**
     * @var Authenticator
     */
    protected $authenticator;

    /**
     * @var IpBlocker
     */
    protected $ipBlocker;

    /**
     * @param Authenticator $authenticator
     * @param IpBlocker $ipBlocker
     */
    public function __construct(Authenticator $authenticator, IpBlocker $ipBlocker)
    {
        $this->authenticator = $authenticator;

        $this->ipBlocker = $ipBlocker;
    }

    /**
     * @return RedirectResponse
     */
    public function getLogout()
    {
        $this->authenticator->logout();

        $this->user = null;

        return new RedirectResponse('/login');
    }

    /**
     * @return string
     */
    public function getIndex()
    {
        return $this->renderLogin($this->getLoginForm(), $this->getRegisterForm());
    }

    /**
     * @return string|RedirectResponse
     */
    public function postLogin()
    {
        if($this->ipBlocker->isBanned())
        {
            return new RedirectResponse('/');
        }

        $loginForm = $this->getLoginForm();

        $data = $loginForm->handleRequest($this->request)->getData();

        try
        {
            $this->authenticator->authenticate($data, $this->request->get('remember'));
        }
        catch(AuthenticationException $e)
        {
            $this->ipBlocker->loginFailure();

            $loginForm->addError(new FormError('Your email address or password is incorrect'));

            return $this->renderLogin($loginForm, $this->getRegisterForm());
        }

        $this->ipBlocker->loginSuccess();

        return new RedirectResponse($this->getReturnUrl());
    }

    /**
     * @return string|RedirectResponse
     */
    public function postRegister()
    {
        $form = $this->getRegisterForm()->handleRequest($this->request);

        if(!$this->formHelper->validate($form, new NewUserValidator()))
        {
            return $this->renderLogin($this->getLoginForm(), $form);
        }

        $data = $form->getData();

        try
        {
            $this->authenticator->register($data);
        }
        catch(UserExistsException $e)
        {
            $this->ipBlocker->loginFailure();

            $form->addError(new FormError('This email address has already been registered'));

            return $this->renderLogin($this->getLoginForm(), $form);
        }

        $this->authenticator->authenticate($data);

        return new RedirectResponse($this->getReturnUrl());
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    private function getRegisterForm()
    {
        return $this->formHelper->build(new RegisterForm(), '/register')->getForm();
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    private function getLoginForm()
    {
        return $this->formHelper->build(new LoginForm(), '/login')->getForm();
    }

    /**
     * @return mixed
     */
    private function getReturnUrl()
    {
        $url = $this->session->get('login.intended', '/');

        $this->session->remove('login.intended');

        return $url;
    }

    /**
     * @param FormInterface $loginForm
     * @param FormInterface $registerForm
     * @return string
     */
    private function renderLogin(FormInterface $loginForm, FormInterface $registerForm)
    {
        return $this->render('home/login.html', array(
            'banned' => $this->ipBlocker->isBanned(),
            'register'  => $registerForm->createView(),
            'login'     => $loginForm->createView(),
        ));
    }
}
