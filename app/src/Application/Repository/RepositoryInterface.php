<?php namespace Application\Repository;


interface RepositoryInterface
{
    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * @param $id
     */
    public function delete($id);

    /**
     * @param array $array
     * @return int
     */
    public function insert(array $array);
}