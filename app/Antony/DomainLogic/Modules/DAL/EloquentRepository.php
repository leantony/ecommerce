<?php namespace app\Antony\DomainLogic\Modules\DAL;

use app\Antony\DomainLogic\Contracts\Database\RepositoryInterface;
use Closure;
use Eloquent;
use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

abstract class EloquentRepository implements RepositoryInterface
{
    use EloquentExtensions;

    /**
     * @var App
     */
    private $app;

    /**
     * An Eloquent model maps to a table in the database
     *
     * @var Eloquent
     */
    protected $model;

    /**
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        // resolve the model class
        $this->makeModel();
    }

    /**
     * Specify the Model class name
     *
     * @return mixed
     */
    abstract public function model();

    /**
     * @return Model
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model)
            throw new InvalidArgumentException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $model;
    }

    /**
     * Retrieve all attributes in a table
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all(array $columns = ['*'])
    {
        return $this->model->all($columns);
    }

    /**
     * Updates a table
     *
     * @param $data
     * @param $id
     *
     * @return bool|int
     */
    public function update($data, $id)
    {
        // use route model binding
        if (is_null($id)) {
            return $this->model->update($data);
        }
        return $this->find($id)->update($data);
    }

    /**
     * find a model
     *
     * @param $id
     * @param array $relationships
     *
     * @param bool $throwExceptionIfNotFound
     *
     * @param array $columns
     * @return Model|\Illuminate\Support\Collection|null|static
     */
    public function find($id, $relationships = [], $throwExceptionIfNotFound = true, $columns = array('*'))
    {
        if (!$throwExceptionIfNotFound) {
            if (empty($relationships)) {
                return $this->model->find($id, $columns);
            }

            return $this->with($relationships)->find($id, $columns);

        } else {

            if (empty($relationships)) {
                return $this->model->findOrFail($id, $columns);
            }

            return $this->with($relationships)->findOrFail($id, $columns);
        }

    }

    /**
     * Retrieve a model, with its relationships
     *
     * @param array $relationships
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function with(array $relationships)
    {
        return $this->model->with($relationships);
    }

    /**
     * Deletes an id or id's from a table
     *
     * @param array $ids
     *
     * @return bool|int
     */
    public function delete($ids)
    {
        if (is_array($ids) and count($ids) == 1) {
            return $this->model->destroy($ids) == 1;
        }

        return $this->model->destroy($ids);
    }

    /**
     * Retrieve paginated data from a table
     *
     * @param array $relationships
     * @param boolean $simplePaginate
     * @param int $pages
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
    public function paginate($relationships = [], $simplePaginate = false, $pages = 10)
    {
        if (!empty($relationships)) {
            if ($simplePaginate) {
                return $this->with($relationships)->simplePaginate($pages);
            }
            return $this->with($relationships)->paginate($pages);
        }

        return $simplePaginate ? $this->model->simplePaginate($pages) : $this->model->paginate($pages);
    }

    /**
     * Retrieve a model, and relationships if they are present
     *
     * @param $relations
     * @param bool $get
     * @param bool $paginate
     * @param int $pages
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection|static|static[]
     */
    public function has($relations, $get = true, $paginate = false, $pages = 10)
    {
        if ($paginate) {
            return $this->model->has($relations)->paginate($pages);
        }
        return $get ? $this->model->has($relations)->get() : $this->model->has($relations);
    }

    /**
     * Retrieve a model, and its relationships only if they are present
     *
     * @param array $relations
     *
     * @param callable $func
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function whereHas($relations, Closure $func, $columns = ['*'])
    {
        return $this->model->whereHas($relations, $func)->get($columns);
    }

    /**
     * Find a single entity by key value
     *
     * @param string $key
     * @param null $operator
     * @param string $value
     * @param array $relationships
     *
     * @param array $columns
     * @return mixed
     */
    public function getFirstBy($key, $operator = null, $value, array $relationships = [], $columns = array('*'))
    {
        if (empty($relationships)) {
            return $this->where($key, $operator, $value)->first();
        }
        return $this->with($relationships)->where($key, $operator, $value)->get($columns)->first();
    }

    /**
     * @param $key
     * @param $operator
     * @param $value
     *
     * @param array $columns
     * @return mixed
     */
    public function where($key, $operator, $value, $columns = array('*'))
    {
        return $this->model->where($key, $operator, $value)->get($columns);
    }

    /**
     * Find many entities by key value
     *
     * @param string $key
     * @param null $operator
     * @param string $value
     * @param array $relationships
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getManyBy($key, $operator = null, $value, array $relationships = [], $columns = array('*'))
    {
        if (empty($relationships)) {
            return $this->where($key, $operator, $value);
        }
        return $this->with($relationships)->where($key, $operator, $value)->get($columns);
    }

    /**
     * Add data, if it does not exist in the db
     *
     * @param $id
     * @param $data
     *
     * @return EloquentRepository|Model
     */
    public function addIfNotExist($id, $data)
    {
        // check the id
        if (empty($id)) {
            return $this->add($data);
        }

        // attempt to find it in the db
        $existingData = $this->find($id, [], false, [$this->model->getKeyName()]);

        if (is_null($existingData)) {

            return $this->add($data);
        }

        return $existingData;
    }

    /**
     * Add data to the db
     *
     * @param $data
     *
     * @return static
     */
    public function add($data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $cols
     * @return $this
     */
    public function select(array $cols)
    {
        return $this->model->select($cols);
    }

    /**
     * @param $id
     * @param $data
     * @return bool|int
     */
    public function edit($id, $data)
    {
        return $this->update($data, $id);
    }

    /**
     * @param $id
     * @return EloquentRepository|Model|\Illuminate\Support\Collection|null|static
     */
    public function get($id)
    {
        return $this->find($id);
    }

    /**
     * @return Eloquent
     */
    public function getModel()
    {
        return $this->model;
    }
}