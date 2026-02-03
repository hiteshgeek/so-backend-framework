<?php

namespace Core\UiEngine\Support;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use ArrayIterator;
use Traversable;

/**
 * AttributeBag - A collection class for managing HTML attributes
 *
 * Provides a fluent interface for managing HTML attributes with
 * support for merging, filtering, and rendering.
 */
class AttributeBag implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * The attributes array
     *
     * @var array<string, mixed>
     */
    protected array $attributes = [];

    /**
     * Create a new AttributeBag instance
     *
     * @param array<string, mixed> $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * Create a new AttributeBag from array
     *
     * @param array<string, mixed> $attributes
     * @return static
     */
    public static function make(array $attributes = []): static
    {
        return new static($attributes);
    }

    /**
     * Set an attribute
     *
     * @param string $key
     * @param mixed $value
     * @return static
     */
    public function set(string $key, mixed $value): static
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * Get an attribute
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->attributes[$key] ?? $default;
    }

    /**
     * Check if an attribute exists
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->attributes);
    }

    /**
     * Remove an attribute
     *
     * @param string $key
     * @return static
     */
    public function remove(string $key): static
    {
        unset($this->attributes[$key]);
        return $this;
    }

    /**
     * Get all attributes
     *
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return $this->attributes;
    }

    /**
     * Clear all attributes
     *
     * @return static
     */
    public function clear(): static
    {
        $this->attributes = [];
        return $this;
    }

    /**
     * Merge with another array or AttributeBag
     *
     * For 'class' attribute, values are concatenated instead of replaced.
     *
     * @param array|AttributeBag $attributes
     * @return static
     */
    public function merge(array|AttributeBag $attributes): static
    {
        if ($attributes instanceof AttributeBag) {
            $attributes = $attributes->all();
        }

        foreach ($attributes as $key => $value) {
            if ($key === 'class' && isset($this->attributes['class'])) {
                // Concatenate classes
                $this->attributes['class'] = trim($this->attributes['class'] . ' ' . $value);
            } else {
                $this->attributes[$key] = $value;
            }
        }

        return $this;
    }

    /**
     * Get attributes except specified keys
     *
     * @param array<string> $keys
     * @return static
     */
    public function except(array $keys): static
    {
        return new static(
            array_diff_key($this->attributes, array_flip($keys))
        );
    }

    /**
     * Get only specified attributes
     *
     * @param array<string> $keys
     * @return static
     */
    public function only(array $keys): static
    {
        return new static(
            array_intersect_key($this->attributes, array_flip($keys))
        );
    }

    /**
     * Filter attributes by callback
     *
     * @param callable $callback fn($value, $key) => bool
     * @return static
     */
    public function filter(callable $callback): static
    {
        return new static(
            array_filter($this->attributes, $callback, ARRAY_FILTER_USE_BOTH)
        );
    }

    /**
     * Get attributes that start with a prefix
     *
     * @param string $prefix
     * @return static
     */
    public function whereStartsWith(string $prefix): static
    {
        return $this->filter(
            fn($value, $key) => str_starts_with($key, $prefix)
        );
    }

    /**
     * Get the first attribute that exists
     *
     * @param string ...$keys
     * @return mixed
     */
    public function first(string ...$keys): mixed
    {
        foreach ($keys as $key) {
            if ($this->has($key)) {
                return $this->get($key);
            }
        }

        return null;
    }

    /**
     * Build conditional classes
     *
     * @param array<string, bool|string> $classes Map of class => condition
     * @return static
     */
    public function class(array $classes): static
    {
        $classList = [];

        foreach ($classes as $class => $condition) {
            if (is_numeric($class)) {
                // Non-conditional class
                $classList[] = $condition;
            } elseif ($condition) {
                $classList[] = $class;
            }
        }

        if (!empty($classList)) {
            $existing = $this->get('class', '');
            $this->set('class', trim($existing . ' ' . implode(' ', $classList)));
        }

        return $this;
    }

    /**
     * Convert to HTML attribute string
     *
     * @return string
     */
    public function toString(): string
    {
        $parts = [];

        foreach ($this->attributes as $key => $value) {
            if ($value === false || $value === null) {
                continue;
            }

            if ($value === true) {
                $parts[] = e($key);
            } else {
                $parts[] = e($key) . '="' . e((string) $value) . '"';
            }
        }

        return implode(' ', $parts);
    }

    /**
     * Convert to string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * Check if empty
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->attributes);
    }

    /**
     * Check if not empty
     *
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    // ==================
    // ArrayAccess implementation
    // ==================

    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->remove($offset);
    }

    // ==================
    // Countable implementation
    // ==================

    public function count(): int
    {
        return count($this->attributes);
    }

    // ==================
    // IteratorAggregate implementation
    // ==================

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->attributes);
    }

    /**
     * Iterate over each attribute with callback
     *
     * @param callable $callback fn($value, $key)
     * @return static
     */
    public function each(callable $callback): static
    {
        foreach ($this->attributes as $key => $value) {
            $callback($value, $key);
        }

        return $this;
    }

    /**
     * Map attributes with callback
     *
     * @param callable $callback fn($value, $key) => mixed
     * @return static
     */
    public function map(callable $callback): static
    {
        $result = [];

        foreach ($this->attributes as $key => $value) {
            $result[$key] = $callback($value, $key);
        }

        return new static($result);
    }

    /**
     * Convert to array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * Convert to JSON
     *
     * @param int $flags
     * @return string
     */
    public function toJson(int $flags = 0): string
    {
        return json_encode($this->attributes, $flags);
    }
}
