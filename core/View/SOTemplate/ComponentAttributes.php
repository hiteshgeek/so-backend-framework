<?php

namespace Core\View\SOTemplate;

use Stringable;
use ArrayAccess;
use IteratorAggregate;
use ArrayIterator;
use Traversable;

/**
 * Component Attributes Bag
 *
 * Manages HTML attributes for components, allowing merging, filtering,
 * and conditional class building similar to Laravel's ComponentAttributeBag.
 */
class ComponentAttributes implements ArrayAccess, IteratorAggregate, Stringable
{
    /**
     * The raw array of attributes
     */
    protected array $attributes;

    /**
     * Create a new component attributes bag
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * Get an attribute by key
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->attributes[$key] ?? $default;
    }

    /**
     * Check if an attribute exists
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->attributes);
    }

    /**
     * Set an attribute
     */
    public function set(string $key, mixed $value): self
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * Merge the given attributes with the current attributes
     *
     * Classes are merged (concatenated), other attributes are overwritten
     */
    public function merge(array $defaults = []): self
    {
        $merged = [];

        // Start with defaults
        foreach ($defaults as $key => $value) {
            $merged[$key] = $value;
        }

        // Merge in current attributes
        foreach ($this->attributes as $key => $value) {
            if ($key === 'class' && isset($merged['class'])) {
                // Concatenate classes
                $merged['class'] = trim($merged['class'] . ' ' . $value);
            } else {
                $merged[$key] = $value;
            }
        }

        return new static($merged);
    }

    /**
     * Conditionally add classes
     *
     * @param array $classes Array of classes or class => condition pairs
     */
    public function class(array $classes): self
    {
        $classList = [];

        foreach ($classes as $key => $value) {
            if (is_int($key)) {
                // Simple class name
                $classList[] = $value;
            } elseif ($value) {
                // Conditional class (class => condition)
                $classList[] = $key;
            }
        }

        $classString = implode(' ', $classList);

        if (isset($this->attributes['class'])) {
            $classString = trim($this->attributes['class'] . ' ' . $classString);
        }

        $new = clone $this;
        $new->attributes['class'] = $classString;

        return $new;
    }

    /**
     * Get only the specified attributes
     */
    public function only(array|string $keys): self
    {
        $keys = is_array($keys) ? $keys : func_get_args();

        return new static(array_intersect_key(
            $this->attributes,
            array_flip($keys)
        ));
    }

    /**
     * Get all attributes except the specified ones
     */
    public function except(array|string $keys): self
    {
        $keys = is_array($keys) ? $keys : func_get_args();

        return new static(array_diff_key(
            $this->attributes,
            array_flip($keys)
        ));
    }

    /**
     * Filter attributes using a callback
     */
    public function filter(callable $callback): self
    {
        return new static(array_filter($this->attributes, $callback, ARRAY_FILTER_USE_BOTH));
    }

    /**
     * Get attributes that start with a given prefix
     */
    public function whereStartsWith(string $prefix): self
    {
        $filtered = [];

        foreach ($this->attributes as $key => $value) {
            if (str_starts_with($key, $prefix)) {
                $filtered[$key] = $value;
            }
        }

        return new static($filtered);
    }

    /**
     * Get attributes that don't start with a given prefix
     */
    public function whereDoesntStartWith(string $prefix): self
    {
        $filtered = [];

        foreach ($this->attributes as $key => $value) {
            if (!str_starts_with($key, $prefix)) {
                $filtered[$key] = $value;
            }
        }

        return new static($filtered);
    }

    /**
     * Get the first attribute value from a list of keys
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
     * Prepend a value to an attribute
     */
    public function prepend(string $key, string $value): self
    {
        $new = clone $this;
        $new->attributes[$key] = $value . ($new->attributes[$key] ?? '');
        return $new;
    }

    /**
     * Append a value to an attribute
     */
    public function append(string $key, string $value): self
    {
        $new = clone $this;
        $new->attributes[$key] = ($new->attributes[$key] ?? '') . $value;
        return $new;
    }

    /**
     * Check if the attribute bag is empty
     */
    public function isEmpty(): bool
    {
        return empty($this->attributes);
    }

    /**
     * Check if the attribute bag is not empty
     */
    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    /**
     * Get the raw attributes array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Get all attribute keys
     */
    public function keys(): array
    {
        return array_keys($this->attributes);
    }

    /**
     * Convert to HTML attributes string
     */
    public function toHtml(): string
    {
        $html = [];

        foreach ($this->attributes as $key => $value) {
            if ($value === true) {
                // Boolean attribute
                $html[] = e($key);
            } elseif ($value !== false && $value !== null) {
                // Regular attribute
                $html[] = e($key) . '="' . e($value) . '"';
            }
        }

        return implode(' ', $html);
    }

    /**
     * Convert to string (HTML attributes)
     */
    public function __toString(): string
    {
        return $this->toHtml();
    }

    /**
     * ArrayAccess: Check if offset exists
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    /**
     * ArrayAccess: Get value at offset
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    /**
     * ArrayAccess: Set value at offset
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->attributes[$offset] = $value;
    }

    /**
     * ArrayAccess: Unset value at offset
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->attributes[$offset]);
    }

    /**
     * IteratorAggregate: Get iterator
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->attributes);
    }

    /**
     * Get the count of attributes
     */
    public function count(): int
    {
        return count($this->attributes);
    }

    /**
     * Create from an array of props and all passed attributes
     *
     * Extracts defined props and returns remaining as attributes
     */
    public static function fromProps(array $definedProps, array $allAttributes): array
    {
        $props = [];
        $attributes = [];

        // Get prop names (handle both indexed and associative arrays)
        $propNames = [];
        foreach ($definedProps as $key => $value) {
            if (is_int($key)) {
                $propNames[] = $value;
                $props[$value] = null; // Default to null
            } else {
                $propNames[] = $key;
                $props[$key] = $value; // Default value from definition
            }
        }

        // Separate props from attributes
        foreach ($allAttributes as $key => $value) {
            if (in_array($key, $propNames)) {
                $props[$key] = $value;
            } else {
                $attributes[$key] = $value;
            }
        }

        return [
            'props' => $props,
            'attributes' => new static($attributes),
        ];
    }
}
