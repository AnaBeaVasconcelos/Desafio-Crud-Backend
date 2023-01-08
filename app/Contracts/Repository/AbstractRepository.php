<?php

namespace App\Contracts\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    /**
     * @var Model|Builder
     */
    protected $model;
    protected static $instance;

    /**
     * AbstractRepository constructor.
     * Necessário usar o setModel()
     * para informar qual model será vinculado
     * ao Repository
     */
    public abstract function __construct();

    public function __call($method, $attr)
    {
        return call_user_func_array([$this->model, $method], $attr);
    }

    protected function setModel($model)
    {
        $this->model = $model;
    }

    protected function getModel()
    {
        return $this->model;
    }

    /**
     * @param array $attributes
     * @return Builder|Model
     */
    public function create(array $attributes = [])
    {
        return $this->getModel()
            ::create($attributes);
    }

    /**
     * @param array $attributes
     * @return bool
     */
    public function createMany(array $attributes): bool
    {
        return $this->getModel()
            ::insert($attributes);
    }

    /**
     * @param $id
     * @param array $columns
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function find($id, array $columns = ['*'])
    {
        return $this->getModel()
            ::find($id, $columns);
    }

    /**
     * @param Model $model
     * @param array $attributes
     * @param array $options
     * @return bool
     */
    public function update(Model $model, array $attributes = [], array $options = []): bool
    {
        return $model
            ::update($attributes, $options);
    }

    /**
     * @param Model $model
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Model $model): ?bool
    {
        return $model->delete();
    }

    /**
     * @param $id
     * @param $column
     * @param int $amount
     * @param array $extra
     * @return int
     */
    public function increment($id, $column, int $amount = 1, array $extra = []): int
    {
        return $this->getModel()
            ::find($id)
            ->increment($column, $amount, $extra);
    }

    /**
     * @param $id
     * @param $column
     * @param int $amount
     * @param array $extra
     * @return int
     */
    public function decrement($id, $column, int $amount = 1, array $extra = []): int
    {
        return $this->getModel()
            ::find($id)
            ->decrement($column, $amount, $extra);
    }

    /**
     * @return Collection|Model[]
     */
    public function all()
    {
        return $this->getModel()
            ::all();
    }

    /**
     * @return Collection|Model[]
     */
    public function getAllPaginate($perPage = null)
    {
        return $this->getModel()
            ::paginate($perPage);
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function save(Model $model): bool
    {
        return $model->save();
    }

    /**
     * @param array $attributes
     * @param array $values
     * @return Builder|Model
     */
    public function firstOrCreate(array $attributes, array $values = [])
    {
        return $this->getModel()
            ::firstOrCreate($attributes, $values);
    }

    /**
     * @param $id
     * @param array $values
     * @param string $primaryKey
     * @return int
     */
    public function updateById($id, array $values, string $primaryKey = 'id'): int
    {
        return $this->getModel()
            ::where($primaryKey, $id)
            ->update($values);
    }

    public function findByUuid(string $uuid, string $uuidKey = 'uuid')
    {
        return $this->getModel()
            ::where($uuidKey, $uuid)
            ->first();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function listAllToSelect(): \Illuminate\Support\Collection
    {
        return $this->getModel()
            ::get(['id', 'name']);
    }
}
