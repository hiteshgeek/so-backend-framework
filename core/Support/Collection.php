<?php

namespace Core\Support;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Traversable;

/**
 * Collection Class
 *
 * Array wrapper with useful methods
 */
class Collection implements ArrayAccess, Countable, IteratorAggregate, JsonSerializable
{
    /**
     * Collection items
     *
     * @var array
     */
    protected array $items = [];

    /**
     * Constructor
     *
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Get all items
     *
     * @return array
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * Get first item
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return mixed
     */
    public function first(?callable $callback = null, mixed $default = null): mixed
    {
        if ($callback === null) {
            return empty($this->items) ? value($default) : reset($this->items);
        }

        foreach ($this->items as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }

        return value($default);
    }

    /**
     * Get last item
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return mixed
     */
    public function last(?callable $callback = null, mixed $default = null): mixed
    {
        if ($callback === null) {
            return empty($this->items) ? value($default) : end($this->items);
        }

        return $this->filter($callback)->last(null, $default);
    }

    /**
     * Map over items
     *
     * @param callable $callback
     * @return static
     */
    public function map(callable $callback): static
    {
        $keys = array_keys($this->items);
        $items = array_map($callback, $this->items, $keys);

        return new static(array_combine($keys, $items));
    }

    /**
     * Filter items
     *
     * @param callable|null $callback
     * @return static
     */
    public function filter(?callable $callback = null): static
    {
        if ($callback === null) {
            return new static(array_filter($this->items));
        }

        return new static(array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH));
    }

    /**
     * Reduce items
     *
     * @param callable $callback
     * @param mixed $initial
     * @return mixed
     */
    public function reduce(callable $callback, mixed $initial = null): mixed
    {
        return array_reduce($this->items, $callback, $initial);
    }

    /**
     * Pluck values by key
     *
     * @param string $value
     * @param string|null $key
     * @return static
     */
    public function pluck(string $value, ?string $key = null): static
    {
        $results = [];

        foreach ($this->items as $item) {
            $itemValue = is_object($item) ? $item->$value : $item[$value];

            if ($key === null) {
                $results[] = $itemValue;
            } else {
                $itemKey = is_object($item) ? $item->$key : $item[$key];
                $results[$itemKey] = $itemValue;
            }
        }

        return new static($results);
    }

    /**
     * Check if item exists
     *
     * @param mixed $key
     * @return bool
     */
    public function has(mixed $key): bool
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Get item
     *
     * @param mixed $key
     * @param mixed $default
     * @return mixed
     */
    public function get(mixed $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, $this->items)) {
            return $this->items[$key];
        }

        return value($default);
    }

    /**
     * Push item
     *
     * @param mixed $value
     * @return static
     */
    public function push(mixed $value): static
    {
        $this->items[] = $value;

        return $this;
    }

    /**
     * Put item
     *
     * @param mixed $key
     * @param mixed $value
     * @return static
     */
    public function put(mixed $key, mixed $value): static
    {
        $this->items[$key] = $value;

        return $this;
    }

    /**
     * Check if collection is empty
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    /**
     * Check if collection is not empty
     *
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    /**
     * Get keys
     *
     * @return static
     */
    public function keys(): static
    {
        return new static(array_keys($this->items));
    }

    /**
     * Get values
     *
     * @return static
     */
    public function values(): static
    {
        return new static(array_values($this->items));
    }

    /**
     * Take first n items
     *
     * @param int $limit
     * @return static
     */
    public function take(int $limit): static
    {
        if ($limit < 0) {
            return new static(array_slice($this->items, $limit, abs($limit)));
        }

        return new static(array_slice($this->items, 0, $limit));
    }

    /**
     * Skip n items
     *
     * @param int $count
     * @return static
     */
    public function skip(int $count): static
    {
        return new static(array_slice($this->items, $count));
    }

    /**
     * Chunk collection
     *
     * @param int $size
     * @return static
     */
    public function chunk(int $size): static
    {
        if ($size <= 0) {
            return new static();
        }

        $chunks = [];

        foreach (array_chunk($this->items, $size, true) as $chunk) {
            $chunks[] = new static($chunk);
        }

        return new static($chunks);
    }

    /**
     * Sort collection
     *
     * @param callable|null $callback
     * @return static
     */
    public function sort(?callable $callback = null): static
    {
        $items = $this->items;

        if ($callback) {
            uasort($items, $callback);
        } else {
            asort($items);
        }

        return new static($items);
    }

    /**
     * Reverse collection
     *
     * @return static
     */
    public function reverse(): static
    {
        return new static(array_reverse($this->items, true));
    }

    /**
     * Merge with another collection or array
     *
     * @param mixed $items
     * @return static
     */
    public function merge(mixed $items): static
    {
        return new static(array_merge($this->items, $this->getArrayableItems($items)));
    }

    /**
     * Union with another collection or array
     *
     * @param mixed $items
     * @return static
     */
    public function union(mixed $items): static
    {
        return new static($this->items + $this->getArrayableItems($items));
    }

    /**
     * Get unique items
     *
     * @return static
     */
    public function unique(): static
    {
        return new static(array_unique($this->items, SORT_REGULAR));
    }

    /**
     * Convert items to array
     *
     * @param mixed $items
     * @return array
     */
    protected function getArrayableItems(mixed $items): array
    {
        if (is_array($items)) {
            return $items;
        }

        if ($items instanceof self) {
            return $items->all();
        }

        return (array) $items;
    }

    /**
     * Convert collection to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * Convert collection to JSON
     *
     * @param int $options
     * @return string
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Count items
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Get iterator
     *
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    /**
     * JSON serialize
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->items;
    }

    /**
     * Check if offset exists
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * Get offset
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset];
    }

    /**
     * Set offset
     *
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($offset === null) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * Unset offset
     *
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }

    /**
     * Convert to string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
