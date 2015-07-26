<?php namespace Application\Entity;

use Application\Repository\RepositoryInterface;

abstract class EntityAbstract implements EntityInterface
{
    /**
     * @var
     */
    protected $id;

    /**
     * @var
     */
    protected $entityData;

    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @var array
     */
    protected $valuesToUpdate = array();

    /**
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $entityId
     * @param array $entityData
     */
    public function hydrate($entityId, array $entityData)
    {
        $this->id = $entityId;

        $this->entityData = $entityData;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->entityData;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function update(array $data)
    {
        $this->valuesToUpdate = $data + $this->valuesToUpdate;

        $this->entityData = $this->entityData + $this->valuesToUpdate;

        return $this;
    }

    /**
     * @return $this
     */
    public function delete()
    {
        $this->repository->delete($this->getId());
    }

    /**
     * @return $this
     */
    public function save()
    {
        $this->repository->update($this->getId(), $this->valuesToUpdate);

        return $this;
    }

    /**
     * @param $dataAttribute
     * @return mixed|null
     */
    public function get($dataAttribute)
    {
        return isset($this->entityData[$dataAttribute]) ? $this->entityData[$dataAttribute] : null;
    }

    /**
     * @return int
     */
    public function __toString()
    {
        return $this->getId();
    }
}
