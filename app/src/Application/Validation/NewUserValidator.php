<?php namespace Application\Validation;

class NewUserValidator extends AbstractValidator
{
    public function __construct()
    {
        $validators = array(
            'email'         => ['required', 'email', 'max:100'],
            'password'      => ['required', 'min:8', 'max:100'],
            'firstname'     => ['required', 'max:100'],
            'surname'       => ['required', 'max:100'],
            'accept_terms'  => ['accepted'],
            'accept_none'   => ['max:0'], // Spam-bot trap - its a hidden field so should be empty
        );

        parent::__construct($validators);
    }
}