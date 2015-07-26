<?php namespace Application\Repository;

use Application\Entity\EntityInterface;
use Database\Connection;
use Database\Query\Builder;

abstract class RepositoryAbstract implements RepositoryInterface
{
    /**
     * @var Connection
     */
    protected $dbConnection;

    protected $schema;

    protected $table;

    protected $key;

    public function __construct(Connection $dbConnection, $table, $schema = null, $key = null)
    {
        $this->dbConnection = $dbConnection;

        $this->table = $table;

        $this->key = $key ?: 'id';

        $this->schema = $schema;
    }

    /**
     * @param $id
     * @param null $columns
     * @return EntityInterface
     * @throws EntityNotFoundException
     */
    public function find($id, $columns = null)
    {
        return $this->findWhere(array($this->key => $id), $columns);
    }

    public function findIfExists($id, $columns = null)
    {
        try{
            return $this->find($id, $columns);
        }catch (EntityNotFoundException $e)
        {}
    }

    /**
     * @param array $ids
     * @param null $columns
     * @return mixed
     */
    public function findAll(array $ids, $columns = null)
    {
        return $this->findAllWhere(function(Builder $where) use($ids){
            $where->whereIn($this->key, $ids);
        }, $columns);
    }

    /**
     * @param null $where
     * @param null $columns
     * @return mixed
     * @throws EntityNotFoundException
     */
    public function findWhere($where = null, $columns = null)
    {
        $row = $this->findAllWhere($where, $columns);

        if (!count($row)) {
            throw new EntityNotFoundException("Entity does not exist in " . $this->getTable());
        }

        return reset($row);
    }

    /**
     * @param mixed $where
     * @param mixed $columns
     * @return array
     */
    public function findAllWhere($where = null, $columns = null)
    {
        return $this->convertArrayToEntity($this->getWhere($where, $columns));
    }

    /**
     * @param $where
     * @param array $columns
     * @return mixed
     */
    public function getWhere($where, $columns = null)
    {
        return $this->getWhereQuery($where, $columns)->query();
    }

    /**
     * @param $where
     * @param array $data
     * @return \PDOStatement
     */
    public function updateWhere($where, array $data)
    {
        return $this->query()->where($where)->update($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data)
    {
        return $this->updateWhere(array($this->key => $id), $data);
    }

    /**
     * @param array $data
     * @return int
     */
    public function insert(array $data)
    {
        return $this->query()->insertGetId($data);
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->query()->where($this->key, $id)->delete();
    }

    /**
     * @param string $as
     * @return string
     */
    public function getTable($as = '')
    {
        if($as)
        {
            $as = ' as ' . $as;
        }

        return ($this->schema ?  $this->schema . '.' : '') . $this->table . $as;
    }

    /**
     * @param string $as
     * @return Builder
     */
    public function query($as = '')
    {
        return $this->dbConnection->table($this->getTable($as));
    }

    /**
     * @param null $where
     * @param null $columns
     * @return Builder
     */
    protected function getWhereQuery($where = null, $columns = null)
    {
        $query = $this->query();

        if(!is_null($where))
        {
            $query->where($where);
        }

        return $query->select($this->prepColumns($columns));
    }

    /**
     * @param $data
     * @return array
     */
    protected function convertArrayToEntity($data)
    {
        $models = array();

        foreach($data as $row)
        {
            $models[] = $entityObject = $this->getFindIntoObject($row[$this->key], $row);

            $entityObject->hydrate($row[$this->key], $row);
        }

        return $models;
    }

    /**
     * @param null $columns
     * @return array
     */
    protected function prepColumns($columns = null)
    {
        if (is_null($columns))
        {
            $columns = $this->getDefaultColumns();
        }

        is_array($columns) or $columns = array($columns);

        if($columns !== array('*'))
        {
            $columns[] = $this->key;
        }

        return array_unique($columns);
    }

    protected function getDefaultColumns()
    {
        return array('*');
    }

    /**
     * @return EntityInterface
     */
    abstract protected function getFindIntoObject($rowId, array $row);
}
