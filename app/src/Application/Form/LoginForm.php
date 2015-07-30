<?php namespace Application\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'text', ['required' => false])
            ->add('password', 'password', ['required' => false])
            ->add('remember_me', 'checkbox', ['required' => false])
            ->add('submit', 'submit', array(
                'label' => 'Log In'
            ));
    }

    public function getName()
    {
        return 'login';
    }
}