<?php namespace Application\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AccountDetailsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('firstname', TextType::class, ['required' => false])
                ->add('surname', TextType::class, ['required' => false])
                ->add('submit', SubmitType::class, ['label' => 'Update Details']);
    }

    public function getName()
    {
        return 'account';
    }
}
