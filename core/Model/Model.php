<?php

namespace Core\Model;

use Core\Database\QueryBuilder;
use Core\Model\Relations\Relation;
use Core\Model\Relations\HasOne;
use Core\Model\Relations\HasMany;
use Core\Model\Relations\BelongsTo;
use Core\Model\Relations\BelongsToMany;

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
     * Cache for loaded relationships.
     *
     * Once a relationship is resolved via lazy-loading (e.g. $user->posts),
     * the result is stored here to avoid repeated database queries.
     */
    protected array $relationsCache = [];

    /**
     * Observer pattern support
     */
    protected static array $observers = [];
    protected static array $booted = [];

    /**
     * Indicates if the model should be timestamped.
     */
    protected bool $timestamps = true;

    /**
     * The name of the "created at" column.
     */
    const CREATED_AT = 'created_at';

    /**
     * The name of the "updated at" column.
     */
    const UPDATED_AT = 'updated_at';

    /**
     * The storage format of the model's date columns.
     */
    protected string $dateFormat = 'Y-m-d H:i:s';

    /**
     * Relations to eager load on every query.
     */
    protected array $with = [];

    /**
     * Relations to eager load for current query (instance level).
     */
    protected array $eagerLoad = [];

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
        // 1. Check the relations cache first to avoid re-querying
        if (array_key_exists($key, $this->relationsCache)) {
            return $this->relationsCache[$key];
        }

        // 2. Check if a relationship method exists for this key
        if (method_exists($this, $key)) {
            $result = $this->$key();

            if ($result instanceof Relation) {
                // Execute the relation query and cache the result
                $resolved = $result->get();
                $this->relationsCache[$key] = $resolved;
                return $resolved;
            }
        }

        // 3. Fall back to standard attribute access
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
        return static::hydrateModels($results);
    }

    /**
     * Eager load relations for a new query
     *
     * Usage: User::with('posts', 'profile')->get()
     * Usage: User::with(['posts', 'profile'])->get()
     * Usage: User::with(['posts' => fn($q) => $q->where('active', '=', 1)])->get()
     *
     * @param array|string $relations Relations to eager load
     * @return ModelQueryBuilder
     */
    public static function with(array|string $relations): ModelQueryBuilder
    {
        $relations = is_array($relations) ? $relations : func_get_args();

        $builder = new ModelQueryBuilder(static::class);
        return $builder->with($relations);
    }

    /**
     * Load relations on existing model instance
     *
     * Usage: $user->load('posts', 'profile')
     * Usage: $user->load(['posts', 'profile'])
     *
     * @param array|string $relations Relations to load
     * @return self
     */
    public function load(array|string $relations): self
    {
        $relations = is_array($relations) ? $relations : func_get_args();

        foreach ($relations as $key => $relation) {
            // Handle constraint closures
            $relationName = is_string($key) ? $key : $relation;
            $constraint = is_callable($relation) ? $relation : null;

            if (method_exists($this, $relationName)) {
                $relationInstance = $this->$relationName();

                if ($relationInstance instanceof Relation) {
                    if ($constraint) {
                        $constraint($relationInstance->getQuery());
                    }
                    $this->relationsCache[$relationName] = $relationInstance->get();
                }
            }
        }

        return $this;
    }

    /**
     * Load relation only if not already loaded
     *
     * @param array|string $relations
     * @return self
     */
    public function loadMissing(array|string $relations): self
    {
        $relations = is_array($relations) ? $relations : func_get_args();

        $toLoad = [];
        foreach ($relations as $key => $relation) {
            $relationName = is_string($key) ? $key : $relation;

            if (!$this->relationLoaded($relationName)) {
                $toLoad[$key] = $relation;
            }
        }

        if (!empty($toLoad)) {
            $this->load($toLoad);
        }

        return $this;
    }

    /**
     * Hydrate raw database results into model instances
     *
     * @param array $results Raw database results
     * @return array Array of model instances
     */
    protected static function hydrateModels(array $results): array
    {
        return array_map(function ($row) {
            $instance = new static($row);
            $instance->exists = true;
            $instance->original = $row;
            return $instance;
        }, $results);
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
        // Update timestamps
        if ($this->timestamps) {
            $this->updateTimestamps();
        }

        // Fire creating event
        $this->fireModelEvent('creating');

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
        // Update timestamps
        if ($this->timestamps) {
            $this->freshTimestamp();
        }

        // Fire updating event
        $this->fireModelEvent('updating');

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

    /**
     * Update timestamps on create
     */
    protected function updateTimestamps(): void
    {
        $time = $this->freshTimestampString();

        if (!$this->exists) {
            $this->setAttribute(static::CREATED_AT, $time);
        }

        $this->setAttribute(static::UPDATED_AT, $time);
    }

    /**
     * Update only the updated_at timestamp
     */
    protected function freshTimestamp(): void
    {
        $this->setAttribute(static::UPDATED_AT, $this->freshTimestampString());
    }

    /**
     * Get a fresh timestamp string
     */
    public function freshTimestampString(): string
    {
        return date($this->dateFormat);
    }

    /**
     * Touch the model's updated_at timestamp
     *
     * @return bool
     */
    public function touch(): bool
    {
        if (!$this->exists) {
            return false;
        }

        $this->freshTimestamp();
        return $this->save();
    }

    /**
     * Update the model without touching timestamps
     *
     * @param array $attributes
     * @return bool
     */
    public function updateQuietly(array $attributes = []): bool
    {
        $originalTimestamps = $this->timestamps;
        $this->timestamps = false;

        $this->fill($attributes);
        $result = $this->save();

        $this->timestamps = $originalTimestamps;

        return $result;
    }

    /**
     * Check if timestamps are enabled
     */
    public function usesTimestamps(): bool
    {
        return $this->timestamps;
    }

    /**
     * Get the created at column name
     */
    public function getCreatedAtColumn(): string
    {
        return static::CREATED_AT;
    }

    /**
     * Get the updated at column name
     */
    public function getUpdatedAtColumn(): string
    {
        return static::UPDATED_AT;
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

    // ==========================================
    // Relationship Methods
    // ==========================================

    /**
     * Define a one-to-one relationship.
     *
     * The foreign key resides on the related model's table, pointing back
     * to this model's local key.
     *
     * Example:
     *   // User has one Profile
     *   public function profile(): HasOne {
     *       return $this->hasOne(Profile::class);
     *       // Infers: foreign_key = 'user_id', local_key = 'id'
     *   }
     *
     * @param string      $related    Fully qualified related model class name
     * @param string|null $foreignKey Column on the related table (auto-inferred if null)
     * @param string      $localKey   Column on this model's table (default: 'id')
     * @return HasOne
     */
    protected function hasOne(string $related, ?string $foreignKey = null, string $localKey = 'id'): HasOne
    {
        $foreignKey = $foreignKey ?? Relation::inferForeignKey(static::class);

        return new HasOne($this, $related, $foreignKey, $localKey);
    }

    /**
     * Define a one-to-many relationship.
     *
     * The foreign key resides on the related model's table, pointing back
     * to this model's local key. Multiple related records may exist.
     *
     * Example:
     *   // User has many Posts
     *   public function posts(): HasMany {
     *       return $this->hasMany(Post::class);
     *       // Infers: foreign_key = 'user_id', local_key = 'id'
     *   }
     *
     * @param string      $related    Fully qualified related model class name
     * @param string|null $foreignKey Column on the related table (auto-inferred if null)
     * @param string      $localKey   Column on this model's table (default: 'id')
     * @return HasMany
     */
    protected function hasMany(string $related, ?string $foreignKey = null, string $localKey = 'id'): HasMany
    {
        $foreignKey = $foreignKey ?? Relation::inferForeignKey(static::class);

        return new HasMany($this, $related, $foreignKey, $localKey);
    }

    /**
     * Define an inverse one-to-one or one-to-many relationship.
     *
     * The foreign key resides on this (child) model's table, pointing
     * to the owner (parent) model's primary key.
     *
     * Example:
     *   // Post belongs to User
     *   public function user(): BelongsTo {
     *       return $this->belongsTo(User::class);
     *       // Infers: foreign_key = 'user_id', owner_key = 'id'
     *   }
     *
     * @param string      $related    Fully qualified related (parent) model class name
     * @param string|null $foreignKey Column on THIS model's table (auto-inferred if null)
     * @param string      $ownerKey   Column on the related (parent) table (default: 'id')
     * @return BelongsTo
     */
    protected function belongsTo(string $related, ?string $foreignKey = null, string $ownerKey = 'id'): BelongsTo
    {
        $foreignKey = $foreignKey ?? Relation::inferForeignKey($related);

        return new BelongsTo($this, $related, $foreignKey, $ownerKey);
    }

    /**
     * Define a many-to-many relationship via a pivot table.
     *
     * Both models reference each other through foreign keys stored in an
     * intermediate (pivot) table.
     *
     * Example:
     *   // User belongs to many Roles
     *   public function roles(): BelongsToMany {
     *       return $this->belongsToMany(Role::class, 'role_user');
     *       // Infers: foreign_pivot_key = 'user_id', related_pivot_key = 'role_id'
     *   }
     *
     * Pivot table auto-naming (when $pivotTable is null):
     *   The two table names (singular) are sorted alphabetically and joined
     *   with an underscore. E.g. User + Role -> 'role_user'.
     *
     * @param string      $related         Fully qualified related model class name
     * @param string|null $pivotTable      Pivot table name (auto-inferred if null)
     * @param string|null $foreignPivotKey Column on pivot for this model (auto-inferred if null)
     * @param string|null $relatedPivotKey Column on pivot for related model (auto-inferred if null)
     * @return BelongsToMany
     */
    protected function belongsToMany(
        string $related,
        ?string $pivotTable = null,
        ?string $foreignPivotKey = null,
        ?string $relatedPivotKey = null
    ): BelongsToMany {
        $foreignPivotKey = $foreignPivotKey ?? Relation::inferForeignKey(static::class);
        $relatedPivotKey = $relatedPivotKey ?? Relation::inferForeignKey($related);

        if ($pivotTable === null) {
            $pivotTable = $this->inferPivotTableName($related);
        }

        return new BelongsToMany(
            $this,
            $related,
            $pivotTable,
            $foreignPivotKey,
            $relatedPivotKey,
            static::$primaryKey
        );
    }

    /**
     * Infer the pivot table name from the two model class names.
     *
     * Takes the singular snake_case form of each model name, sorts them
     * alphabetically, and joins with an underscore.
     *
     * Examples:
     *   User + Role -> 'role_user'
     *   Post + Tag  -> 'post_tag'
     *
     * @param string $related The related model class name
     * @return string The inferred pivot table name
     */
    protected function inferPivotTableName(string $related): string
    {
        $parentBase = strtolower(preg_replace(
            '/([a-z])([A-Z])/',
            '$1_$2',
            class_basename(static::class)
        ));

        $relatedBase = strtolower(preg_replace(
            '/([a-z])([A-Z])/',
            '$1_$2',
            class_basename($related)
        ));

        // Sort alphabetically for consistent naming
        $segments = [$parentBase, $relatedBase];
        sort($segments);

        return implode('_', $segments);
    }

    /**
     * Get a cached relation value.
     *
     * @param string $key The relation name
     * @return mixed|null The cached value or null if not loaded
     */
    public function getRelation(string $key): mixed
    {
        return $this->relationsCache[$key] ?? null;
    }

    /**
     * Set a relation value in the cache manually.
     *
     * Useful for eager loading or when you want to attach pre-fetched
     * related models without triggering a database query.
     *
     * @param string $key   The relation name
     * @param mixed  $value The related model(s) to cache
     * @return self
     */
    public function setRelation(string $key, mixed $value): self
    {
        $this->relationsCache[$key] = $value;
        return $this;
    }

    /**
     * Check whether a relation has been loaded/cached.
     *
     * @param string $key The relation name
     * @return bool
     */
    public function relationLoaded(string $key): bool
    {
        return array_key_exists($key, $this->relationsCache);
    }

    /**
     * Clear all cached relations (or a specific one).
     *
     * This forces the next access to re-query the database.
     *
     * @param string|null $key Specific relation to clear, or null to clear all
     * @return self
     */
    public function clearRelations(?string $key = null): self
    {
        if ($key !== null) {
            unset($this->relationsCache[$key]);
        } else {
            $this->relationsCache = [];
        }

        return $this;
    }

    // ==========================================
    // Query & Serialization
    // ==========================================

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
