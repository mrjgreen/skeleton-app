<?php namespace Application\Controller;

use Application\Repository\UserRepository;

class HomeController extends ControllerAbstract
{
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getIndex()
    {
        return $this->render('home/index.html');
    }

    public function postRegisterNewUser()
    {
        $exampleUser = [
            'email'     => 'test@example.com',
            'password'  => password_hash('foobar', PASSWORD_DEFAULT),
            'firstname' => 'Joe',
            'surname'   => 'Green',
        ];

        $userObj = $this->userRepository->registerUser($exampleUser);

        return $userObj->toArray();
    }

    public function getListUsers()
    {
        return $this->userRepository->findAllActiveUsers();
    }
}
