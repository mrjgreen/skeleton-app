<?php namespace Application\Validation;

use Validation\Factory;

class AbstractValidator implements ValidatorInterface
{
    /**
     * @var array
     */
    private $rules;

    /**
     * @param array $rules
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * @param array $data
     * @return array
     */
    public function validate(array $data)
    {
        $factory = new Factory();

        $validator = $factory->make($data, $this->rules);

        if($validator->fails())
        {
            return $validator->errors();
        }
    }
}