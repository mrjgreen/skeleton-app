<?php namespace Application\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RecoveryEmailForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, ['required' => false])
            ->add('submit', SubmitType::class, array(
                'label' => 'Send Reset Email'
            ));
    }

    public function getName()
    {
        return 'reset_email';
    }
}
