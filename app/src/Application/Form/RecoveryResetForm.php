<?php namespace Application\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RecoveryResetForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', PasswordType::class, ['required' => false])
            ->add('submit', SubmitType::class, array(
                'label' => 'Reset'
            ));
    }

    public function getName()
    {
        return 'reset';
    }
}
