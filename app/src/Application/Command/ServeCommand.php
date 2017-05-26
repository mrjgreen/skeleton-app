<?php namespace Application\Command;

use Symfony\Component\Console\Input\InputOption;

class ServeCommand extends CommandAbstract
{
    protected function configure()
    {
        $this
            ->setName('serve')
            ->addOption('host', 'l', InputOption::VALUE_REQUIRED, "Set the host for the webserver to listen on", "0.0.0.0")
            ->addOption('port', 'p', InputOption::VALUE_REQUIRED, "Set the port for the webserver to run on", 8080)
            ->setDescription('Run the local development server')
        ;
    }

    protected function fire()
    {
        $host = $this->input->getOption('host') . ":" . $this->input->getOption('port');

        $docRoot = $this->container['paths']['public'];

        $this->success("Running server on $host");
        $this->comment("php -S $host -t " . $docRoot);

        exec("php -S $host -t " . $docRoot);
    }
}
