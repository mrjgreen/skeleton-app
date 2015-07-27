<?php namespace Application\Command;

class ExampleCommand extends CommandAbstract
{
    protected function configure()
    {
        $this
            ->setName('example')
            ->setDescription('Demonstrate the task runner')
        ;
    }

    protected function fire()
    {
        $this->success("Success! You've ran the example!");
    }
}
