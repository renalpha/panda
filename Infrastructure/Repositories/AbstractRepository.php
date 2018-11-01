<?php

namespace Infrastructure\Repositories;

use Domain\Common\Entity;
use Domain\Contracts\Repository\AbstractRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AbstractRepository
 * @package Infrastructure\Repositories
 */
abstract class AbstractRepository implements AbstractRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * AbstractRepository constructor.
     * @param Entity $model
     */
    public function __construct(Entity $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->fill($attributes);
        $model->save();

        return $model;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFail($id)
    {
        $model = $this->model->findOrFail($id);

        return $model;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $model = $this->model->findOrFail($id);
        $model->delete();
        return $model;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /*
     * Get all (selected columns)
     */
    public function all($columns = ['*'])
    {
        return $this->model->all($columns);
    }

    public function select($columns = ['*'])
    {
        return $this->model->select($columns);
    }

    /*
     * Get Lists
     */
    public function lists($column = ['*'], $key = null)
    {
        return $this->model->pluck($column, $key);
    }

    /*
     * Get Lists
     */
    public function pluck($column = ['*'], $key = null)
    {
        return $this->model->pluck($column, $key);
    }

    /*
     * Get Lists
     */
    public function get($filters = null)
    {
        return $this->model->get();
    }

    /**
     * @param $amount
     * @return mixed
     */
    public function paginate($amount)
    {
        return $this->model->paginate($amount);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function search($query)
    {
        try {
            return $this->model->search($query);
        } catch (\Exception $e) {
            dd('ERROR No searchable threat has been added to this modal!');
        }
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return $this->model->first();
    }

    /**
     * @return mixed
     */
    public function firstOrFail()
    {
        return $this->model->firstOrFail();
    }

    /**
     * Check if entity has relation
     *
     * @param string $relation
     *
     * @return $this
     */
    public function has($relation)
    {
        $this->model = $this->model->has($relation);
        return $this;
    }

    /**
     * Load relations
     *
     * @param array|string $relations
     *
     * @return $this
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * Load relation with closure
     *
     * @param string $relation
     * @param closure $closure
     *
     * @return $this
     */
    public function whereHas($relation, $closure)
    {
        $this->model = $this->model->whereHas($relation, $closure);

        return $this;
    }

    /**
     * @param $column
     * @return $this
     */
    public function whereNull($column)
    {
        $this->model = $this->model->whereNull($column);
        return $this;
    }

    /**
     * @param $column
     * @return $this
     */
    public function whereNotNull($column)
    {
        $this->model = $this->model->whereNotNull($column);
        return $this;
    }

    /**
     * @param $column
     * @param string $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->model = $this->model->orderBy($column, $direction);
        return $this;
    }

    /**
     * @param $column
     * @param $condition
     * @param $value
     * @return $this
     */
    public function where($column, $condition, $value)
    {
        $this->model = $this->model->where($column, $condition, $value);
        return $this;
    }

    /**
     * @param $column
     * @param $condition
     * @param $value
     * @return $this
     */
    public function orWhere($column, $condition, $value)
    {
        $this->model = $this->model->orWhere($column, $condition, $value);
        return $this;
    }

    /**
     * @param $column
     * @param $value
     * @return $this
     */
    public function whereBetween($column, $value)
    {
        $this->model = $this->model->whereBetween($column, $value);
        return $this;
    }

    public function whereTranslation($column, $value)
    {
        $this->model = $this->model->whereTranslation($column, $value);
        return $this;
    }

    /**
     * @param $column
     * @param $value
     * @return $this
     */
    public function whereIn($column, $value)
    {
        $this->model = $this->model->whereIn($column, $value);
        return $this;
    }

    /**
     * @param $column
     * @return $this
     */
    public function groupBy($column)
    {
        $this->model = $this->model->groupBy($column);
        return $this;
    }

    /**
     * @param null $column
     * @return $this
     */
    public function distinct($column = null)
    {
        $this->model = $this->model->distinct($column);
        return $this;
    }

    /**
     * Set visible fields
     *
     * @param array $fields
     *
     * @return $this
     */
    public function visible(array $fields)
    {
        $this->model->setVisible($fields);
        return $this;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        return $this->model->getAttribute(snake_case($key));
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        return $this->model->setAttribute(snake_case($key), $value);
    }

    /**
     * @param int $state
     * @return mixed
     */
    public function active($state = 1)
    {
        return $this->model->where('active', '=', $state);
    }

    /**
     * @param int $id
     * @return int
     */
    public function findBy(int $id)
    {
        return $this->model->findBy($id);
    }
}