<?php namespace Application\Command;

use Symfony\Component\Console\Input\InputOption;

class ServeCommand extends CommandAbstract
{
    protected function configure()
    {
        $this
            ->setName('serve')
            ->addOption('port', 'p', InputOption::VALUE_REQUIRED, "Set the port for the webserver to run on", 8080)
            ->setDescription('Run the local development server')
        ;
    }

    protected function fire()
    {
        $host = "localhost:" . $this->input->getOption('port');

        $docRoot = $this->container['paths']['public'];

        $this->success("Running server on $host");
        $this->comment("php -S $host -t " . $docRoot);

        exec("php -S $host -t " . $docRoot);
    }
}
