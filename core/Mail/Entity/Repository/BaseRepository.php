<?php

namespace Core\Mail\Entity\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository {
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * Constructor
     *
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;        
    }

    /**
     * Get all
     *
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection {
        return $this->model->with($relations)->get($columns);
    }

    /**
     * Find by ID
     *
     * @param integer $id
     * @param array $columns
     * @param array $relations
     * @return Model|null
     */
    public function findByID(
        int $id, 
        array $columns = ['*'], 
        array $relations = []
    ): ?Model {
        return $this->model->select($columns)->with($relations)->where('id', $id)->first();
    }

    /**
     * Create a model
     *
     * @param array $payload
     * @return Model|null
     */
    public function create(array $payload): ?Model {
        $model = $this->model->create($payload);
        return $model->fresh();
    }

    /**
     * Update existing model
     *
     * @param int $id
     * @param array $payload
     * @return Model
     */
    public function update(int $id, array $payload): Model
    {
        $model = $this->findById($id);
        $model->update($payload);
        return $model->fresh();
    }

    /**
     * Delete model by id
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        return $this->findById($id)->delete();
    }    
}