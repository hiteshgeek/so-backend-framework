<?php

namespace Core\Model;

use Core\Database\QueryBuilder;
use Core\Model\Relations\Relation;

/**
 * Model Query Builder
 *
 * Wraps QueryBuilder with model-specific functionality like eager loading.
 */
class ModelQueryBuilder
{
    /**
     * The model class being queried
     */
    protected string $model;

    /**
     * The underlying query builder
     */
    protected QueryBuilder $query;

    /**
     * Relations to eager load
     */
    protected array $eagerLoad = [];

    /**
     * Create a new model query builder
     *
     * @param string $model The model class name
     */
    public function __construct(string $model)
    {
        $this->model = $model;
        $this->query = $model::query();
    }

    /**
     * Set relations to eager load
     *
     * @param array $relations
     * @return self
     */
    public function with(array $relations): self
    {
        foreach ($relations as $key => $value) {
            if (is_numeric($key)) {
                // Simple relation name
                $this->eagerLoad[$value] = null;
            } else {
                // Relation name with constraint closure
                $this->eagerLoad[$key] = $value;
            }
        }

        return $this;
    }

    /**
     * Add a where clause
     */
    public function where(string $column, string $operator, $value): self
    {
        $this->query->where($column, $operator, $value);
        return $this;
    }

    /**
     * Add an or where clause
     */
    public function orWhere(string $column, string $operator, $value): self
    {
        $this->query->orWhere($column, $operator, $value);
        return $this;
    }

    /**
     * Add a where in clause
     */
    public function whereIn(string $column, array $values, string $boolean = 'and'): self
    {
        $this->query->whereIn($column, $values, $boolean);
        return $this;
    }

    /**
     * Add a where null clause
     */
    public function whereNull(string $column, string $boolean = 'and'): self
    {
        $this->query->whereNull($column, $boolean);
        return $this;
    }

    /**
     * Add a where not null clause
     */
    public function whereNotNull(string $column, string $boolean = 'and'): self
    {
        $this->query->whereNotNull($column, $boolean);
        return $this;
    }

    /**
     * Add ordering
     */
    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->query->orderBy($column, $direction);
        return $this;
    }

    /**
     * Order by latest
     */
    public function latest(string $column = 'created_at'): self
    {
        $this->query->orderBy($column, 'DESC');
        return $this;
    }

    /**
     * Order by oldest
     */
    public function oldest(string $column = 'created_at'): self
    {
        $this->query->orderBy($column, 'ASC');
        return $this;
    }

    /**
     * Limit results
     */
    public function limit(int $limit): self
    {
        $this->query->limit($limit);
        return $this;
    }

    /**
     * Offset results
     */
    public function offset(int $offset): self
    {
        $this->query->offset($offset);
        return $this;
    }

    /**
     * Take N records
     */
    public function take(int $count): self
    {
        return $this->limit($count);
    }

    /**
     * Skip N records
     */
    public function skip(int $count): self
    {
        return $this->offset($count);
    }

    /**
     * Execute query and get all results
     *
     * @return array Array of model instances
     */
    public function get(): array
    {
        $results = $this->query->get();
        $models = $this->hydrateModels($results);

        // Eager load relations
        if (!empty($this->eagerLoad) && !empty($models)) {
            $this->eagerLoadRelations($models);
        }

        return $models;
    }

    /**
     * Get the first result
     *
     * @return Model|null
     */
    public function first(): ?Model
    {
        $result = $this->query->first();

        if (!$result) {
            return null;
        }

        $model = $this->hydrateModel($result);

        // Eager load relations for single model
        if (!empty($this->eagerLoad)) {
            $this->eagerLoadRelations([$model]);
        }

        return $model;
    }

    /**
     * Find by primary key
     *
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        $modelClass = $this->model;
        $result = $this->query->find($id, $modelClass::$primaryKey ?? 'id');

        if (!$result) {
            return null;
        }

        $model = $this->hydrateModel($result);

        if (!empty($this->eagerLoad)) {
            $this->eagerLoadRelations([$model]);
        }

        return $model;
    }

    /**
     * Get count of results
     */
    public function count(string $column = '*'): int
    {
        return $this->query->count($column);
    }

    /**
     * Check if any results exist
     */
    public function exists(): bool
    {
        return $this->query->exists();
    }

    /**
     * Paginate results
     *
     * @param int $perPage
     * @param int $page
     * @return array
     */
    public function paginate(int $perPage = 15, int $page = 1): array
    {
        $result = $this->query->paginate($perPage, $page);

        // Hydrate models
        $models = $this->hydrateModels($result['data']);

        // Eager load relations
        if (!empty($this->eagerLoad) && !empty($models)) {
            $this->eagerLoadRelations($models);
        }

        $result['data'] = $models;

        return $result;
    }

    /**
     * Hydrate a single model instance
     *
     * @param array $row
     * @return Model
     */
    protected function hydrateModel(array $row): Model
    {
        $modelClass = $this->model;
        $instance = new $modelClass($row);
        $instance->exists = true;
        $instance->original = $row;
        return $instance;
    }

    /**
     * Hydrate multiple model instances
     *
     * @param array $rows
     * @return array
     */
    protected function hydrateModels(array $rows): array
    {
        return array_map(fn($row) => $this->hydrateModel($row), $rows);
    }

    /**
     * Eager load relations for a collection of models
     *
     * @param array $models
     * @return void
     */
    protected function eagerLoadRelations(array $models): void
    {
        foreach ($this->eagerLoad as $relation => $constraint) {
            $this->eagerLoadRelation($models, $relation, $constraint);
        }
    }

    /**
     * Eager load a single relation
     *
     * @param array $models
     * @param string $relationName
     * @param callable|null $constraint
     * @return void
     */
    protected function eagerLoadRelation(array $models, string $relationName, ?callable $constraint): void
    {
        if (empty($models)) {
            return;
        }

        // Get the first model to access the relation definition
        $firstModel = $models[0];

        if (!method_exists($firstModel, $relationName)) {
            return;
        }

        // Get the relation instance
        $relation = $firstModel->$relationName();

        if (!$relation instanceof Relation) {
            return;
        }

        // Perform eager loading based on relation type
        $relationType = class_basename(get_class($relation));

        switch ($relationType) {
            case 'HasOne':
            case 'HasMany':
                $this->eagerLoadHasRelation($models, $relation, $relationName, $constraint);
                break;

            case 'BelongsTo':
                $this->eagerLoadBelongsTo($models, $relation, $relationName, $constraint);
                break;

            case 'BelongsToMany':
                $this->eagerLoadBelongsToMany($models, $relation, $relationName, $constraint);
                break;
        }
    }

    /**
     * Eager load HasOne/HasMany relations
     */
    protected function eagerLoadHasRelation(array $models, Relation $relation, string $relationName, ?callable $constraint): void
    {
        // Get local key values from all parent models
        $localKey = $relation->getLocalKey();
        $foreignKey = $relation->getForeignKey();
        $relatedClass = $relation->getRelatedClass();

        $keys = [];
        foreach ($models as $model) {
            $key = $model->getAttribute($localKey);
            if ($key !== null) {
                $keys[] = $key;
            }
        }

        if (empty($keys)) {
            return;
        }

        // Query related models
        $query = $relatedClass::query()->whereIn($foreignKey, array_unique($keys));

        if ($constraint) {
            $constraint($query);
        }

        $results = $query->get();
        $relatedModels = [];

        foreach ($results as $row) {
            $relatedModel = new $relatedClass($row);
            $relatedModel->exists = true;
            $relatedModel->original = $row;

            $fkValue = $row[$foreignKey] ?? null;
            if ($fkValue !== null) {
                $relatedModels[$fkValue][] = $relatedModel;
            }
        }

        // Attach to parent models
        $isHasOne = str_contains(get_class($relation), 'HasOne');

        foreach ($models as $model) {
            $key = $model->getAttribute($localKey);
            $related = $relatedModels[$key] ?? [];

            $model->setRelation($relationName, $isHasOne ? ($related[0] ?? null) : $related);
        }
    }

    /**
     * Eager load BelongsTo relations
     */
    protected function eagerLoadBelongsTo(array $models, Relation $relation, string $relationName, ?callable $constraint): void
    {
        $foreignKey = $relation->getForeignKey();
        $ownerKey = $relation->getOwnerKey();
        $relatedClass = $relation->getRelatedClass();

        // Get foreign key values from all child models
        $keys = [];
        foreach ($models as $model) {
            $key = $model->getAttribute($foreignKey);
            if ($key !== null) {
                $keys[] = $key;
            }
        }

        if (empty($keys)) {
            return;
        }

        // Query related (parent) models
        $query = $relatedClass::query()->whereIn($ownerKey, array_unique($keys));

        if ($constraint) {
            $constraint($query);
        }

        $results = $query->get();
        $relatedModels = [];

        foreach ($results as $row) {
            $relatedModel = new $relatedClass($row);
            $relatedModel->exists = true;
            $relatedModel->original = $row;

            $keyValue = $row[$ownerKey] ?? null;
            if ($keyValue !== null) {
                $relatedModels[$keyValue] = $relatedModel;
            }
        }

        // Attach to child models
        foreach ($models as $model) {
            $key = $model->getAttribute($foreignKey);
            $model->setRelation($relationName, $relatedModels[$key] ?? null);
        }
    }

    /**
     * Eager load BelongsToMany relations
     */
    protected function eagerLoadBelongsToMany(array $models, Relation $relation, string $relationName, ?callable $constraint): void
    {
        $pivotTable = $relation->getPivotTable();
        $foreignPivotKey = $relation->getForeignPivotKey();
        $relatedPivotKey = $relation->getRelatedPivotKey();
        $localKey = $relation->getLocalKey();
        $relatedClass = $relation->getRelatedClass();

        // Get local key values
        $keys = [];
        foreach ($models as $model) {
            $key = $model->getAttribute($localKey);
            if ($key !== null) {
                $keys[] = $key;
            }
        }

        if (empty($keys)) {
            return;
        }

        // Get pivot data
        $pivotQuery = app('db')->table($pivotTable)
            ->whereIn($foreignPivotKey, array_unique($keys));

        $pivotResults = $pivotQuery->get();

        // Get unique related IDs
        $relatedIds = [];
        $pivotMap = [];

        foreach ($pivotResults as $pivot) {
            $foreignId = $pivot[$foreignPivotKey] ?? null;
            $relatedId = $pivot[$relatedPivotKey] ?? null;

            if ($foreignId !== null && $relatedId !== null) {
                $relatedIds[] = $relatedId;
                $pivotMap[$foreignId][] = $relatedId;
            }
        }

        if (empty($relatedIds)) {
            foreach ($models as $model) {
                $model->setRelation($relationName, []);
            }
            return;
        }

        // Query related models
        $relatedQuery = $relatedClass::query()->whereIn('id', array_unique($relatedIds));

        if ($constraint) {
            $constraint($relatedQuery);
        }

        $relatedResults = $relatedQuery->get();
        $relatedModels = [];

        foreach ($relatedResults as $row) {
            $relatedModel = new $relatedClass($row);
            $relatedModel->exists = true;
            $relatedModel->original = $row;

            $relatedModels[$row['id']] = $relatedModel;
        }

        // Attach to parent models
        foreach ($models as $model) {
            $key = $model->getAttribute($localKey);
            $relatedIdsList = $pivotMap[$key] ?? [];

            $attached = [];
            foreach ($relatedIdsList as $relatedId) {
                if (isset($relatedModels[$relatedId])) {
                    $attached[] = $relatedModels[$relatedId];
                }
            }

            $model->setRelation($relationName, $attached);
        }
    }

    /**
     * Forward calls to the underlying query builder
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call(string $method, array $parameters): mixed
    {
        $result = $this->query->$method(...$parameters);

        // If the result is a QueryBuilder, return this for chaining
        if ($result instanceof QueryBuilder) {
            return $this;
        }

        return $result;
    }
}
