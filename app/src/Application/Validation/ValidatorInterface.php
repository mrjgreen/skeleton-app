<?php namespace Application\Validation;

interface ValidatorInterface
{
    /**
     * @param array $data
     * @return array
     */
    public function validate(array $data);
}