<?php namespace app\Antony\DomainLogic\Contracts\Database;

interface RepositoryInterface
{

    /**
     * @param array $relationships
     *
     * @return mixed
     */
    public function with(array $relationships);

    /**
     * @param array $relationships
     * @param bool $simplePaginate
     * @param int $pages
     * @return mixed
     */
    public function paginate($relationships = [], $simplePaginate = false, $pages = 10);

    /**
     * @param array $columns
     * @return mixed
     */
    public function all(array $columns = ['*']);

    /**
     * Allows an object to be added to the database
     *
     * @param array $data object properties, encapsulated in an array
     */
    public function add($data);

    /**
     * Allows an object to be added to the database, only if it doesnt exist there
     * @param mixed $id The object key, e.g a primary key value
     * @param array $data The attributes of the object to be added
     */
    public function addIfNotExist($id, $data);

    /**
     * @param $id
     * @param array $relationships
     *
     * @param bool $throwExceptionIfNotFound
     *
     * @param array $columns
     * @return mixed
     */
    public function find($id, $relationships = [], $throwExceptionIfNotFound = true, $columns = ['*']);

    /**
     * @param $key
     * @param $operator
     * @param $value
     *
     * @param array $columns
     * @return mixed
     */
    public function where($key, $operator, $value, $columns = ['*']);

    /**
     * @param $data
     * @param $id
     *
     * @return mixed
     */
    public function update($data, $id);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function delete($ids);
}