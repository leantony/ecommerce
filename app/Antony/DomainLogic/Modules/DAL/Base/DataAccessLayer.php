<?php namespace app\Antony\DomainLogic\Modules\DAL\Base;

use app\Antony\DomainLogic\Contracts\Database\RepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

abstract class DataAccessLayer
{
    /**
     * The repository
     *
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * data results of a CRUD operation
     *
     * @var mixed
     */
    protected $dataResult;

    /**
     * Object name that will be displayed in the redirect msg
     * Not currently in use
     *
     * @var string
     */
    protected $objectName;

    /**
     * @param RepositoryInterface $layer
     */
    public function __construct(RepositoryInterface $layer)
    {
        $this->repository = $layer;
    }

    /**
     * Provides a commonly used implementation for a creation operation
     *
     * @param $data
     *
     * @return mixed
     */
    public function create($data)
    {
        $this->dataResult = $this->repository->add($data);

        return $this->dataResult;

    }

    /**
     * Ok, this presents a commonly used implementation of a SELECT procedure
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
    abstract public function get();

    /**
     * Provides a commonly used implementation for an edit operation
     *
     * @param $id
     * @param $data
     *
     * @return mixed
     */
    public function edit($id, $data)
    {
        $this->dataResult = $this->repository->update($data, $id);

        return $this->dataResult;
    }

    /**
     * Provides a commonly used implementation for a find by ID operation
     *
     * @param $id
     *
     * @return mixed
     */
    public function retrieve($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Provides a commonly used implementation for a delete operation
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id)
    {
        $this->dataResult = $this->repository->delete([$id]);

        return $this->dataResult;

    }

    /**
     * Retrieves the name of the set object
     *
     * @return mixed
     */
    public function getObjectName()
    {
        return str_singular($this->objectName);
    }

    /**
     * Sets the name of the model class that will be used in the redirect messages
     *
     * @param $name
     */
    public function setObjectName($name)
    {
        $this->objectName = str_singular($name);
    }

    /**
     * Paginates a collection. For simple pagination, one can override this function
     *
     * a little help from http://laravelsnippets.com/snippets/custom-data-pagination
     *
     * @param Collection $data
     * @param int $perPage
     * @param Request $request
     * @param null $page
     *
     * @return LengthAwarePaginator
     */
    public function paginateCollection(Collection $data, $perPage, Request $request, $page = null)
    {
        $pg = $request->get('page');

        $page = $page ? (int)$page * 1 : (isset($pg) ? (int)$request->get('page') * 1 : 1);
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator($data->splice($offset, $perPage), $data->count(), $perPage, Paginator::resolveCurrentPage(), ['path' => Paginator::resolveCurrentPath(),]);
    }

    /**
     * Returns the results of a CRUD operation
     * Some operations like DELETE return a boolean, so for now, this method would simply crash
     *
     * @param bool $json
     *
     * @return mixed
     */
    public function getDataResult($json = false)
    {
        return $json ? $this->dataResult->toJson() : $this->dataResult;
    }
}