<?php namespace Application\Controller;

use Application\Entity\User;
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

    /**
     * This is just an example... obviously we don't delete the user in a real app!
     *
     * @return array
     */
    public function postRegisterNewUser()
    {
        $exampleUser = [
            'email'     => 'test@example.com',
            'password'  => password_hash('foobar', PASSWORD_DEFAULT),
            'firstname' => 'Joe',
            'surname'   => 'Green',
        ];

        if($user = $this->userRepository->findByLogin($exampleUser['email']))
        {
            $user->delete();
        }

        $userObj = $this->userRepository->registerUser($exampleUser);

        return $userObj->toArray();
    }
}
