<?php namespace Application\Controller;

use Application\Form\AccountDetailsForm;
use Application\Validation\AccountDetailsValidator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AccountController extends ControllerAbstract
{
    /**
     * @return string
     */
    public function getIndex()
    {
        return $this->renderIndex($this->getAccountForm()->setData($this->user->toArray()));
    }


    /**
     * @return string|RedirectResponse
     */
    public function postIndex()
    {
        $form = $this->getAccountForm()->handleRequest($this->request);

        if(!$this->formHelper->validate($form, new AccountDetailsValidator()))
        {
            return $this->renderIndex($form);
        }

        $data = $form->getData();

        $this->user->update($data)->save();

        $this->flash->add('account.updated', 1);

        return new RedirectResponse('/account');
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    private function getAccountForm()
    {
        return $this->formHelper->build(new AccountDetailsForm(), '/account')->getForm();
    }

    /**
     * @param FormInterface $userForm
     * @return string
     */
    private function renderIndex(FormInterface $userForm)
    {
        return $this->render('home/account.html', array(
            'account'  => $userForm->createView(),
            'updated'  => (bool)$this->flash->get('account.updated')
        ));
    }
}
