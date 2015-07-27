<?php namespace Application\Provider;

use Application\Command\CommandAbstract;
use Phroute\Phroute\Dispatcher;
use League\Container\Container as Container;

class CommandProvider implements ProviderInterface
{

    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app['commands'] = function() use($app){

            $commands = $this->getCommands($app['paths']['commands']);

            return array_map(function($commandName) use($app){
                return $app[$commandName]->setContainer($app);
            }, $commands);
        };
    }

    /**
     * @param string $file
     * @return array
     */
    private function getCommands($file)
    {
        return include $file;
    }
}
