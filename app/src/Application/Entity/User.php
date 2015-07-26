<?php namespace Application\Entity;

use Application\Repository\RepositoryInterface;
use Phroute\Authentic\User\UserInterface;

class User extends EntityAbstract implements UserInterface
{

    public function __construct(RepositoryInterface $userRepository)
    {
        parent::__construct($userRepository);
    }

    public function getFirstname()
    {
        return $this->entityData['firstname'];
    }

    public function getSurname()
    {
        return $this->entityData['surname'];
    }

    public function getName()
    {
        return $this->getFirstname() . ' ' . $this->getSurname();
    }

    /**
     * Returns the user's login.
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->entityData['email'];
    }

    /**
     * Returns the user's password (hashed).
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->entityData['password'];
    }


    public function setRememberToken($token)
    {
        $this->update(array('auth_token' => $token))->save();
    }


    public function getRememberToken()
    {
        return $this->entityData['auth_token'];
    }

    public function setPassword($newPassword)
    {
        $this->update(array(
            'password'              => $newPassword,
            'reset_password_token'   => null,
        ))->save();
    }

    public function getResetPasswordToken()
    {
        return $this->entityData['reset_password_token'];
    }

    public function setResetPasswordToken($token)
    {
        $this->update(array('reset_password_token' => $token))->save();
    }

    public function onLogin()
    {
        $this->update(array('reset_password_token' => null, 'last_login' => new \DateTime()))->save();
    }

    public function isAdmin()
    {
        return (bool) $this->entityData['is_admin'];
    }
}
