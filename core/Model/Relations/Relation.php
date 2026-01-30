<?php

namespace Core\Model\Relations;

use Core\Model\Model;
use Core\Database\QueryBuilder;

/**
 * Abstract Base Relation
 *
 * Provides the foundation for all model relationship types.
 * Each concrete relation must implement the get() method to
 * execute the appropriate query and return the result(s).
 */
abstract class Relation
{
    /**
     * The parent model instance that owns this relationship.
     */
    protected Model $parent;

    /**
     * The fully qualified class name of the related model.
     */
    protected string $related;

    /**
     * The foreign key used for the relationship.
     */
    protected string $foreignKey;

    /**
     * The local key on the parent model.
     */
    protected string $localKey;

    /**
     * Create a new relation instance.
     *
     * @param Model  $parent     The parent model instance
     * @param string $related    The related model class name
     * @param string $foreignKey The foreign key column
     * @param string $localKey   The local key column on the parent
     */
    public function __construct(Model $parent, string $related, string $foreignKey, string $localKey)
    {
        $this->parent = $parent;
        $this->related = $related;
        $this->foreignKey = $foreignKey;
        $this->localKey = $localKey;
    }

    /**
     * Execute the relationship query and return the result(s).
     *
     * @return mixed Single model, array of models, or null
     */
    abstract public function get(): mixed;

    /**
     * Get a new QueryBuilder instance for the related model's table.
     *
     * Uses the framework's existing database service via app('db')
     * to build queries against the related model's table.
     *
     * @return QueryBuilder
     */
    protected function newQuery(): QueryBuilder
    {
        /** @var \Core\Model\Model $instance */
        $instance = new $this->related();
        return app('db')->table($instance->getTable());
    }

    /**
     * Get the value of the parent model's local key.
     *
     * @return mixed
     */
    protected function getParentKeyValue(): mixed
    {
        return $this->parent->getAttribute($this->localKey);
    }

    /**
     * Hydrate a single database row into a related model instance.
     *
     * Sets the model's exists flag to true and stores the original
     * attributes so dirty-checking works correctly on the instance.
     *
     * @param array $attributes The database row as an associative array
     * @return Model
     */
    protected function hydrateModel(array $attributes): Model
    {
        $model = new $this->related();
        foreach ($attributes as $key => $value) {
            $model->setAttribute($key, $value);
        }
        // Mark as existing record from the database
        $reflection = new \ReflectionProperty($model, 'exists');
        $reflection->setAccessible(true);
        $reflection->setValue($model, true);

        $reflection = new \ReflectionProperty($model, 'original');
        $reflection->setAccessible(true);
        $reflection->setValue($model, $attributes);

        return $model;
    }

    /**
     * Hydrate an array of database rows into model instances.
     *
     * @param array $rows Array of associative arrays from the database
     * @return array Array of Model instances
     */
    protected function hydrateModels(array $rows): array
    {
        return array_map(fn(array $row) => $this->hydrateModel($row), $rows);
    }

    /**
     * Convert a model class name to a snake_case foreign key.
     *
     * Extracts the short class name (without namespace), converts
     * PascalCase to snake_case, and appends '_id'.
     *
     * Examples:
     *   'App\Models\User'        -> 'user_id'
     *   'App\Models\BlogPost'    -> 'blog_post_id'
     *   'App\Models\UserProfile' -> 'user_profile_id'
     *
     * @param string $className Fully qualified class name
     * @return string The inferred foreign key (e.g. 'user_id')
     */
    public static function inferForeignKey(string $className): string
    {
        // Get the short class name (e.g. 'User' from 'App\Models\User')
        $baseName = class_basename($className);

        // Convert PascalCase to snake_case
        $snakeCase = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $baseName));

        return $snakeCase . '_id';
    }

    /**
     * Get the parent model instance.
     *
     * @return Model
     */
    public function getParent(): Model
    {
        return $this->parent;
    }

    /**
     * Get the related model class name.
     *
     * @return string
     */
    public function getRelated(): string
    {
        return $this->related;
    }

    /**
     * Get the foreign key name.
     *
     * @return string
     */
    public function getForeignKey(): string
    {
        return $this->foreignKey;
    }

    /**
     * Get the local key name.
     *
     * @return string
     */
    public function getLocalKey(): string
    {
        return $this->localKey;
    }
}
