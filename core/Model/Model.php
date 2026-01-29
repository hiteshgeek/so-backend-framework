<?php

namespace Core\Model;

use Core\Database\QueryBuilder;

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

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
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
        $result = static::query()->insert($this->attributes);

        if ($result) {
            $this->exists = true;
            $lastId = app('db')->connection->lastInsertId();
            if ($lastId) {
                $this->setAttribute(static::$primaryKey, $lastId);
            }
        }

        return $result;
    }

    protected function performUpdate(): bool
    {
        $id = $this->getAttribute(static::$primaryKey);

        return static::query()
            ->where(static::$primaryKey, '=', $id)
            ->update($this->attributes);
    }

    public function delete(): bool
    {
        if (!$this->exists) {
            return false;
        }

        $id = $this->getAttribute(static::$primaryKey);

        return static::query()
            ->where(static::$primaryKey, '=', $id)
            ->delete();
    }

    public function toArray(): array
    {
        return $this->attributes;
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
