<?php namespace Application\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RecoveryEmailForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'text', ['required' => false])
            ->add('submit', 'submit', array(
                'label' => 'Send Reset Email'
            ));
    }

    public function getName()
    {
        return 'reset_email';
    }
}