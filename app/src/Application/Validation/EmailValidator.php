<?php namespace Application\Validation;

class EmailValidator extends AbstractValidator
{
    public function __construct()
    {
        $validators = array(
            'email'         => ['required', 'email', 'max:100'],
        );

        parent::__construct($validators);
    }
}