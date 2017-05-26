<?php namespace Application\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class RegisterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, ['required' => false])
            ->add('surname', TextType::class, ['required' => false])
            ->add('email', TextType::class, ['required' => false])
            ->add('password', PasswordType::class, ['required' => false])
            ->add('accept_terms', CheckboxType::class, ['required' => false, 'mapped' => false])
            ->add('accept_none', HiddenType::class, ['required' => false, 'mapped' => false]) // Spam-bot trap - the validation is set to fail if this is filled
            ->add('submit', SubmitType::class, ['label' => 'Register']);
    }

    public function getName()
    {
        return 'register';
    }
}
