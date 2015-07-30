<?php namespace Application\Validation;

class AccountDetailsValidator extends AbstractValidator
{
    public function __construct()
    {
        $validators = array(
            'firstname'     => ['required', 'max:100'],
            'surname'       => ['required', 'max:100'],
        );

        parent::__construct($validators);
    }
}