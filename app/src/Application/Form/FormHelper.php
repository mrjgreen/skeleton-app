<?php namespace Application\Form;

use Application\Validation\ValidatorInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class FormHelper
{
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function build(AbstractType $form, $action = null, $method = 'post')
    {
        $form->buildForm($builder = $this->formFactory->createNamedBuilder($form->getName()), array());

        if($action)
        {
            $builder->setAction($action);
        }

        $builder->setMethod($method);

        return $builder;
    }

    public function validateAll(FormInterface $form, array $validators)
    {
        $result = true;

        foreach($validators as $validator)
        {
            $result = $result && $this->validate($form, $validator);
        }

        return $result;
    }

    public function validate(FormInterface $form, ValidatorInterface $validator)
    {
        // Get all data, mapped or unmapped
        $errors = $validator->validate(array_map(function(FormInterface $form){
            return $form->getData();
        }, $form->all()));

        if(count($errors) === 0)
        {
            return true;
        }

        foreach($errors as $key => $error)
        {
            $el = $form->get($key);

            foreach($error as $e)
            {
                $el->addError(new FormError($e));
            }
        }

        return false;
    }
}