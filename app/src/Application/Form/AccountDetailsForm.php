<?php namespace Application\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AccountDetailsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('firstname', 'text', ['required' => false])
                ->add('surname', 'text', ['required' => false])
                ->add('country', 'text', ['required' => false])
                ->add('phone', 'text', ['required' => false])
                ->add('submit', 'submit', ['label' => 'Update Details']);
    }

    public function getName()
    {
        return 'account';
    }
}