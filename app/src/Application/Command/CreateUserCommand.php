<?php namespace Application\Command;

use Phroute\Authentic\Authenticator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateUserCommand extends Command
{
    private $authenticator;

    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('user:create')
            ->setDescription('Register a new user')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getHelper('question');

        $email = $questionHelper->ask($input, $output, new Question("<info>Enter the users email address: </info>"));

        $passwordQuestion = new Question("<info>Enter the password for user '$email': </info>");

        $passwordQuestion->isHidden();
        $passwordQuestion->isHiddenFallback();

        $password = $questionHelper->ask($input, $output, $passwordQuestion);

        $user = $this->authenticator->register(array(
            'email' => $email,
            'password' => $password
        ));

        $id = $user->getId();

        $output->writeln("<info>Success! User '$email' has been created with ID '$id'</info>");
    }
}
