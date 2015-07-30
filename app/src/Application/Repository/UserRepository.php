<?php namespace Application\Repository;

use Application\Entity\User;
use Application\Support\Status;
use Database\Connection;

/**
 * Class UserRepository
 * @package Application\Repository
 */
class UserRepository extends RepositoryAbstract
{
    public function __construct(Connection $dbConnection)
    {
        parent::__construct($dbConnection, 'user');
    }

    /**
     * @param $rowId
     * @param array $row
     * @return User
     */
    protected function getFindIntoObject($rowId, array $row)
    {
        return new User($this);
    }

    /**
     * @param $id
     * @return User|bool
     */
    public function findById($id)
    {
        try
        {
            return parent::find($id);
        }catch (EntityNotFoundException $e)
        {
            return false;
        }
    }

    /**
     * @param $login
     * @return User
     * @throws EntityNotFoundException
     */
    public function findByLogin($login)
    {
        try
        {
            return $this->findWhere(['email' => $login]);
        }catch (EntityNotFoundException $e)
        {
            return false;
        }
    }

    /**
     * Creates a user and returns the new user object.
     *
     * @param array $credentials
     * @return User
     */
    public function registerUser(array $credentials)
    {
        $id = $this->query()->insertGetId($credentials);

        return $this->find($id);
    }

    /**
     * @return User[]
     */
    public function findAllActiveUsers()
    {
        return $this->findAllWhere(['row_status' => Status::LIVE]);
    }
}