<?php namespace Application\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, ['required' => false])
            ->add('password', PasswordType::class, ['required' => false])
            ->add('remember_me', CheckboxType::class, ['required' => false])
            ->add('submit', SubmitType::class, array(
                'label' => 'Log In'
            ));
    }

    public function getName()
    {
        return 'login';
    }
}
