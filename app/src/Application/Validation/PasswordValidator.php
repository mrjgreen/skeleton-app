<?php namespace Application\Validation;

class PasswordValidator extends AbstractValidator
{
    public function __construct()
    {
        $validators = array(
            'password'      => ['required', 'min:8', 'max:100'],
        );

        parent::__construct($validators);
    }
}