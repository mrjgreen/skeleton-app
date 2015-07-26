<?php namespace Application\Repository;

use Application\Entity\User;
use Phroute\Authentic\User\UserRepositoryInterface;
use Database\Connection;

/**
 * Class UserRepository
 * @package Application\Repository
 */
class UserRepository extends RepositoryAbstract implements UserRepositoryInterface
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
     * @return \Application\Entity\EntityInterface|bool
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
     * @return mixed
     * @throws EntityNotFoundException
     */
    public function findByLogin($login)
    {
        try
        {
            return $this->findWhere(array(
                'email' => $login
            ));
        }catch (EntityNotFoundException $e)
        {
            return false;
        }
    }

    /**
     * Creates a user.
     *
     * @param array $credentials
     * @return \Application\Entity\EntityInterface
     */
    public function registerUser(array $credentials)
    {
        if(!$id = $this->query()->insertGetId($credentials))
        {
            throw new \RuntimeException("User not created");
        }

        return $this->find($id);
    }
}
