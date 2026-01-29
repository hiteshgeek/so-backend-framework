<?php

namespace Core\Model;

use Core\Database\QueryBuilder;

/**
 * Get all traits used by a class recursively
 */
if (!function_exists('class_uses_recursive')) {
    function class_uses_recursive($class): array
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $results = [];

        foreach (array_reverse(class_parents($class)) ?: [] as $parent) {
            $results = array_merge($results, class_uses_recursive($parent));
        }

        foreach (class_uses($class) ?: [] as $trait) {
            $results[$trait] = $trait;
            $results = array_merge($results, class_uses_recursive($trait));
        }

        return array_unique($results);
    }
}

/**
 * Base Model Class
 */
abstract class Model
{
    protected static string $table = '';
    protected static string $primaryKey = 'id';
    protected array $attributes = [];
    protected array $original = [];
    protected array $fillable = [];
    protected array $guarded = ['id'];
    protected bool $exists = false;

    /**
     * Observer pattern support
     */
    protected static array $observers = [];
    protected static array $booted = [];

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->fill($attributes);
    }

    /**
     * Boot the model and its traits
     */
    protected function bootIfNotBooted(): void
    {
        $class = static::class;

        if (!isset(static::$booted[$class])) {
            static::$booted[$class] = true;
            static::boot();
            static::bootTraits();
        }
    }

    /**
     * Boot the model (override in child classes if needed)
     */
    protected static function boot(): void
    {
        // Can be overridden by child classes
    }

    /**
     * Boot all traits used by the model
     */
    protected static function bootTraits(): void
    {
        $class = static::class;

        foreach (class_uses_recursive($class) as $trait) {
            $method = 'boot' . class_basename($trait);

            if (method_exists($class, $method)) {
                forward_static_call([$class, $method]);
            }
        }
    }

    /**
     * Register an observer with the model
     */
    public static function observe($class): void
    {
        $instance = new $class();

        if (!isset(static::$observers[static::class])) {
            static::$observers[static::class] = [];
        }

        static::$observers[static::class][] = $instance;
    }

    /**
     * Fire an event to all registered observers
     */
    protected function fireModelEvent(string $event): void
    {
        if (!isset(static::$observers[static::class])) {
            return;
        }

        foreach (static::$observers[static::class] as $observer) {
            if (method_exists($observer, $event)) {
                $observer->$event($this);
            }
        }
    }

    public function fill(array $attributes): self
    {
        foreach ($attributes as $key => $value) {
            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            }
        }

        return $this;
    }

    protected function isFillable(string $key): bool
    {
        if (!empty($this->fillable) && !in_array($key, $this->fillable)) {
            return false;
        }

        if (!empty($this->guarded) && in_array($key, $this->guarded)) {
            return false;
        }

        return true;
    }

    public function setAttribute(string $key, mixed $value): void
    {
        // Check for mutator
        $mutator = 'set' . str_replace('_', '', ucwords($key, '_')) . 'Attribute';

        if (method_exists($this, $mutator)) {
            $this->$mutator($value);
        } else {
            $this->attributes[$key] = $value;
        }
    }

    public function getAttribute(string $key): mixed
    {
        // Check for accessor
        $accessor = 'get' . str_replace('_', '', ucwords($key, '_')) . 'Attribute';

        if (method_exists($this, $accessor)) {
            return $this->$accessor($this->attributes[$key] ?? null);
        }

        return $this->attributes[$key] ?? null;
    }

    public function __get(string $key): mixed
    {
        return $this->getAttribute($key);
    }

    public function __set(string $key, mixed $value): void
    {
        $this->setAttribute($key, $value);
    }

    public static function query(): QueryBuilder
    {
        return app('db')->table(static::$table);
    }

    public static function all(): array
    {
        $results = static::query()->get();
        return array_map(fn($row) => new static($row), $results);
    }

    public static function find(int $id): ?static
    {
        $result = static::query()->find($id, static::$primaryKey);

        if ($result) {
            $instance = new static($result);
            $instance->exists = true;
            $instance->original = $result;
            return $instance;
        }

        return null;
    }

    public static function where(string $column, string $operator, $value): QueryBuilder
    {
        return static::query()->where($column, $operator, $value);
    }

    public static function create(array $attributes): static
    {
        $model = new static($attributes);
        $model->save();
        return $model;
    }

    public function save(): bool
    {
        if ($this->exists) {
            return $this->performUpdate();
        }

        return $this->performInsert();
    }

    protected function performInsert(): bool
    {
        // Filter out null values before insert (let database use defaults)
        $attributes = array_filter($this->attributes, fn($value) => $value !== null);

        $result = static::query()->insert($attributes);

        if ($result) {
            $this->exists = true;
            $lastId = app('db')->lastInsertId();
            if ($lastId) {
                $this->setAttribute(static::$primaryKey, $lastId);
            }
            $this->original = $this->attributes;

            // Fire created event
            $this->fireModelEvent('created');
        }

        return $result;
    }

    protected function performUpdate(): bool
    {
        $id = $this->getAttribute(static::$primaryKey);

        $result = static::query()
            ->where(static::$primaryKey, '=', $id)
            ->update($this->attributes);

        if ($result) {
            // Fire updated event
            $this->fireModelEvent('updated');
            $this->original = $this->attributes;
        }

        return $result;
    }

    public function delete(): bool
    {
        if (!$this->exists) {
            return false;
        }

        $id = $this->getAttribute(static::$primaryKey);

        $result = static::query()
            ->where(static::$primaryKey, '=', $id)
            ->delete();

        if ($result) {
            // Fire deleted event
            $this->fireModelEvent('deleted');
            $this->exists = false;
        }

        return $result;
    }

    /**
     * Get the attributes that have been changed
     */
    public function getDirty(): array
    {
        $dirty = [];

        foreach ($this->attributes as $key => $value) {
            if (!array_key_exists($key, $this->original)) {
                $dirty[$key] = $value;
            } elseif ($value !== $this->original[$key]) {
                $dirty[$key] = $value;
            }
        }

        return $dirty;
    }

    /**
     * Get the original attributes
     */
    public function getOriginal(): array
    {
        return $this->original;
    }

    /**
     * Get all attributes
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Get the query builder for this model
     */
    public function getQueryBuilder(): QueryBuilder
    {
        return static::query();
    }

    public function toArray(): array
    {
        return $this->attributes;
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * Get the table name for the model
     */
    public function getTable(): string
    {
        return static::$table;
    }

    /**
     * Get the primary key for the model
     */
    public function getPrimaryKey(): string
    {
        return static::$primaryKey;
    }

    /**
     * Get the database connection
     */
    public function getConnection()
    {
        $dbService = app('db');
        if (!$dbService) {
            throw new \RuntimeException("Database service not found");
        }
        if (!isset($dbService->connection)) {
            throw new \RuntimeException("Database connection property not found");
        }
        return $dbService->connection;
    }

    /**
     * Handle dynamic static method calls (for query scopes)
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public static function __callStatic(string $method, array $parameters)
    {
        // Check if it's a scope method
        $scopeMethod = 'scope' . ucfirst($method);

        if (method_exists(static::class, $scopeMethod)) {
            // Create a new instance to call the scope
            $instance = new static();

            // Get the query builder
            $query = static::query();

            // Call the scope method
            return $instance->$scopeMethod($query, ...$parameters);
        }

        // If not a scope, try to call on query builder
        return static::query()->$method(...$parameters);
    }

    /**
     * Apply scope to query builder
     *
     * @param string $scope
     * @param mixed ...$parameters
     * @return QueryBuilder
     */
    public static function scope(string $scope, ...$parameters): QueryBuilder
    {
        $query = static::query();
        $scopeMethod = 'scope' . ucfirst($scope);

        if (method_exists(static::class, $scopeMethod)) {
            $instance = new static();
            return $instance->$scopeMethod($query, ...$parameters);
        }

        return $query;
    }
}
