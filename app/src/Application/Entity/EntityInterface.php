<?php namespace Application\Entity;

interface EntityInterface
{
    /**
     * @param $entityId
     * @param array $entityData
     */
    public function hydrate($entityId, array $entityData);

    /**
     * @return int
     */
    public function getId();

    /**
     * @param $dataAttribute
     * @return mixed
     */
    public function get($dataAttribute);

    /**
     * @return mixed
     */
    public function toArray();
}
