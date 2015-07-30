<?php namespace Application\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegisterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text', ['required' => false])
            ->add('surname', 'text', ['required' => false])
            ->add('email', 'text', ['required' => false])
            ->add('password', 'password', ['required' => false])
            ->add('accept_terms', 'checkbox', ['required' => false, 'mapped' => false])
            ->add('accept_none', 'hidden', ['required' => false, 'mapped' => false]) // Spam-bot trap - the validation is set to fail if this is filled
            ->add('submit', 'submit', ['label' => 'Register']);
    }

    public function getName()
    {
        return 'register';
    }
}