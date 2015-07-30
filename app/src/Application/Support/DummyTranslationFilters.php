<?php namespace Application\Support;

class DummyTranslationFilters extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('trans', array($this, 'transFilter')),
            new \Twig_SimpleFilter('transChoice', array($this, 'transFilter')),
        );
    }

    public function transFilter($value)
    {
        return $value;
    }

    public function getName()
    {
        return 'dummy_translation';
    }
}