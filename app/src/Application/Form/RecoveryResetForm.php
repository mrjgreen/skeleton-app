<?php namespace Application\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RecoveryResetForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', 'password', ['required' => false])
            ->add('submit', 'submit', array(
                'label' => 'Reset'
            ));
    }

    public function getName()
    {
        return 'reset';
    }
}