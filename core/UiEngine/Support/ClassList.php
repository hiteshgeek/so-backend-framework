<?php

namespace Core\UiEngine\Support;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use ArrayIterator;
use Traversable;

/**
 * ClassList - A collection class for managing CSS classes
 *
 * Provides a fluent interface for adding, removing, and managing
 * CSS classes with support for conditional classes.
 */
class ClassList implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * The CSS classes array
     *
     * @var array<string>
     */
    protected array $classes = [];

    /**
     * Create a new ClassList instance
     *
     * @param string|array $classes
     */
    public function __construct(string|array $classes = [])
    {
        if (is_string($classes)) {
            $classes = $this->parseClassString($classes);
        }

        $this->classes = array_values(array_unique(array_filter($classes)));
    }

    /**
     * Create a new ClassList from string or array
     *
     * @param string|array $classes
     * @return static
     */
    public static function make(string|array $classes = []): static
    {
        return new static($classes);
    }

    /**
     * Parse a space-separated class string
     *
     * @param string $classes
     * @return array<string>
     */
    protected function parseClassString(string $classes): array
    {
        return preg_split('/\s+/', trim($classes), -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Add a CSS class
     *
     * @param string $class
     * @return static
     */
    public function add(string $class): static
    {
        $class = trim($class);

        if ($class !== '' && !$this->contains($class)) {
            $this->classes[] = $class;
        }

        return $this;
    }

    /**
     * Add multiple classes
     *
     * @param string|array $classes Space-separated string or array
     * @return static
     */
    public function addMany(string|array $classes): static
    {
        if (is_string($classes)) {
            $classes = $this->parseClassString($classes);
        }

        foreach ($classes as $class) {
            $this->add($class);
        }

        return $this;
    }

    /**
     * Remove a CSS class
     *
     * @param string $class
     * @return static
     */
    public function remove(string $class): static
    {
        $this->classes = array_values(array_filter(
            $this->classes,
            fn($c) => $c !== $class
        ));

        return $this;
    }

    /**
     * Remove multiple classes
     *
     * @param string|array $classes
     * @return static
     */
    public function removeMany(string|array $classes): static
    {
        if (is_string($classes)) {
            $classes = $this->parseClassString($classes);
        }

        foreach ($classes as $class) {
            $this->remove($class);
        }

        return $this;
    }

    /**
     * Toggle a CSS class
     *
     * @param string $class
     * @param bool|null $force Force add (true) or remove (false)
     * @return static
     */
    public function toggle(string $class, ?bool $force = null): static
    {
        if ($force === true) {
            return $this->add($class);
        }

        if ($force === false) {
            return $this->remove($class);
        }

        return $this->contains($class) ? $this->remove($class) : $this->add($class);
    }

    /**
     * Replace one class with another
     *
     * @param string $oldClass
     * @param string $newClass
     * @return static
     */
    public function replace(string $oldClass, string $newClass): static
    {
        if ($this->contains($oldClass)) {
            $this->remove($oldClass);
            $this->add($newClass);
        }

        return $this;
    }

    /**
     * Check if a class exists
     *
     * @param string $class
     * @return bool
     */
    public function contains(string $class): bool
    {
        return in_array($class, $this->classes, true);
    }

    /**
     * Alias for contains
     *
     * @param string $class
     * @return bool
     */
    public function has(string $class): bool
    {
        return $this->contains($class);
    }

    /**
     * Get all classes
     *
     * @return array<string>
     */
    public function all(): array
    {
        return $this->classes;
    }

    /**
     * Clear all classes
     *
     * @return static
     */
    public function clear(): static
    {
        $this->classes = [];
        return $this;
    }

    /**
     * Add conditional classes
     *
     * @param array<string|int, bool|string> $classes
     * @return static
     */
    public function when(array $classes): static
    {
        foreach ($classes as $class => $condition) {
            if (is_numeric($class)) {
                // Non-conditional class: ['class1', 'class2']
                $this->add($condition);
            } elseif ($condition) {
                // Conditional class: ['active' => true, 'disabled' => false]
                $this->add($class);
            }
        }

        return $this;
    }

    /**
     * Add class if condition is true
     *
     * @param string $class
     * @param bool $condition
     * @return static
     */
    public function addIf(string $class, bool $condition): static
    {
        if ($condition) {
            $this->add($class);
        }

        return $this;
    }

    /**
     * Add class if condition is false
     *
     * @param string $class
     * @param bool $condition
     * @return static
     */
    public function addUnless(string $class, bool $condition): static
    {
        if (!$condition) {
            $this->add($class);
        }

        return $this;
    }

    /**
     * Merge with another ClassList or array
     *
     * @param ClassList|array|string $classes
     * @return static
     */
    public function merge(ClassList|array|string $classes): static
    {
        if ($classes instanceof ClassList) {
            $classes = $classes->all();
        } elseif (is_string($classes)) {
            $classes = $this->parseClassString($classes);
        }

        return $this->addMany($classes);
    }

    /**
     * Filter classes by callback
     *
     * @param callable $callback fn($class) => bool
     * @return static
     */
    public function filter(callable $callback): static
    {
        return new static(array_filter($this->classes, $callback));
    }

    /**
     * Get classes that start with a prefix
     *
     * @param string $prefix
     * @return static
     */
    public function whereStartsWith(string $prefix): static
    {
        return $this->filter(fn($class) => str_starts_with($class, $prefix));
    }

    /**
     * Convert to space-separated string
     *
     * @return string
     */
    public function toString(): string
    {
        return implode(' ', array_unique($this->classes));
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
        return empty($this->classes);
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
        return isset($this->classes[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->classes[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($offset === null) {
            $this->add($value);
        } else {
            $this->classes[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->classes[$offset]);
        $this->classes = array_values($this->classes);
    }

    // ==================
    // Countable implementation
    // ==================

    public function count(): int
    {
        return count($this->classes);
    }

    // ==================
    // IteratorAggregate implementation
    // ==================

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->classes);
    }

    /**
     * Convert to array
     *
     * @return array<string>
     */
    public function toArray(): array
    {
        return $this->classes;
    }

    /**
     * Convert to JSON
     *
     * @param int $flags
     * @return string
     */
    public function toJson(int $flags = 0): string
    {
        return json_encode($this->classes, $flags);
    }
}
