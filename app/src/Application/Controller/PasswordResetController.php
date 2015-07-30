<?php namespace Application\Controller;

use Application\Form\RecoveryEmailForm;
use Application\Form\RecoveryResetForm;
use Application\Services\Mailer;
use Application\Validation\EmailValidator;
use Application\Validation\PasswordValidator;
use Phroute\Authentic\Authenticator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PasswordResetController extends ControllerAbstract
{
    /**
     * @var Authenticator
     */
    protected $authenticator;

    /**
     * @var Mailer
     */
    protected $mailer;

    /**
     * @param Authenticator $authenticator
     * @param Mailer $mailer
     */
    public function __construct(Authenticator $authenticator, Mailer $mailer)
    {
        $this->mailer = $mailer;

        $this->authenticator = $authenticator;
    }

    /**
     * @return string
     */
    public function getIndex()
    {
        return $this->renderEmail($this->getEmailForm(), (bool)$this->flash->get('recovery.reset_error'));
    }

    /**
     * @return string
     */
    public function getSent()
    {
        if(!$this->flash->get('recovery.sent'))
        {
            return new RedirectResponse('/recovery');
        }

        return $this->render('home/recovery_sent.html');
    }

    /**
     * @return string
     */
    public function postIndex()
    {
        $form = $this->getEmailForm();

        $form->handleRequest($this->request);

        if(!$this->formHelper->validate($form, new EmailValidator()))
        {
            return $this->renderEmail($form);
        }

        if($user = $this->authenticator->findUserByLogin($form->get('email')->getData()))
        {
            $code = $this->authenticator->generateResetToken($user);

            $url = sprintf($this->request->getSchemeAndHttpHost() . '/recovery/reset/%s', $this->encodeToken($user->getLogin(), $code));

            $html = $this->view->render('emails/password_reset.html', array(
                'reset_link' => $url,
                'name'  => $user->getName()
            ));

            $this->mailer->send($html, strip_tags($html), function(\Swift_Message $message) use($user){
                $message->setSubject('Password Reset')->setTo($user->getLogin(), $user->getName());
            });
        }

        $this->flash->add('recovery.sent', 1);

        return new RedirectResponse('/recovery/sent');
    }


    /**
     * @param $token
     * @return string
     */
    public function getReset($token)
    {
        return $this->renderReset($this->getResetForm());
    }

    /**
     * @param $token
     * @return string|RedirectResponse
     */
    public function postReset($token)
    {
        $form = $this->getResetForm();

        $form->handleRequest($this->request);

        if(!$this->formHelper->validate($form, new PasswordValidator()))
        {
            return $this->renderReset($form);
        }

        list($email, $code) = $this->decodeToken($token);

        $password = $form->get('password')->getData();

        if(!$this->authenticator->resetPasswordForLogin($email, $code, $password))
        {
            $this->flash->set('recovery.reset_error', 1);

            $this->authenticator->findUserByLogin($email)->setResetPasswordToken(null);

            return new RedirectResponse('/recovery');
        }

        $this->authenticator->authenticate(array(
            'email' => $email,
            'password' => $password
        ));

        return new RedirectResponse('/');
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    private function getEmailForm()
    {
        return $this->formHelper->build(new RecoveryEmailForm())->getForm();
    }

    /**
     * @param FormInterface $emailForm
     * @param bool $resetError
     * @return string
     */
    private function renderEmail(FormInterface $emailForm, $resetError = false)
    {
        return $this->render('home/forgotten_password.html', array(
            'form'  => $emailForm->createView(),
            'reset_error' => $resetError
        ));
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    private function getResetForm()
    {
        return $this->formHelper->build(new RecoveryResetForm())->getForm();
    }

    /**
     * @param FormInterface $resetForm
     * @return string
     */
    private function renderReset(FormInterface $resetForm)
    {
        return $this->render('home/password_reset.html', array(
            'form'  => $resetForm->createView(),
        ));
    }

    private function encodeToken($email, $resetCode)
    {
        return \Application\base64_url_encode(json_encode([$email, $resetCode]));
    }

    private function decodeToken($token)
    {
        return json_decode(\Application\base64_url_decode($token), true) ?: null;
    }
}
