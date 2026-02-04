<?php

namespace Core\UiEngine\Traits;

/**
 * Trait for managing CSS classes
 *
 * Provides methods for adding, removing, and managing CSS classes
 * on UI elements with support for conditional classes.
 */
trait HasClasses
{
    /**
     * CSS classes collection
     *
     * @var array<string>
     */
    protected array $classes = [];

    /**
     * Add CSS class(es)
     *
     * @param string|array $classes Single class, space-separated string, or array
     * @return static
     */
    public function class(string|array $classes): static
    {
        if (is_string($classes)) {
            $classes = preg_split('/\s+/', trim($classes), -1, PREG_SPLIT_NO_EMPTY);
        }

        foreach ($classes as $class) {
            $this->addClass($class);
        }

        return $this;
    }

    /**
     * Add a single CSS class
     *
     * @param string $class
     * @return static
     */
    public function addClass(string $class): static
    {
        $class = trim($class);
        if ($class !== '' && !in_array($class, $this->classes, true)) {
            $this->classes[] = $class;
        }

        return $this;
    }

    /**
     * Add multiple classes at once
     *
     * @param array<string> $classes
     * @return static
     */
    public function addClasses(array $classes): static
    {
        foreach ($classes as $class) {
            $this->addClass($class);
        }

        return $this;
    }

    /**
     * Remove a CSS class
     *
     * @param string $class
     * @return static
     */
    public function removeClass(string $class): static
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
     * @param array<string> $classes
     * @return static
     */
    public function removeClasses(array $classes): static
    {
        foreach ($classes as $class) {
            $this->removeClass($class);
        }

        return $this;
    }

    /**
     * Toggle a CSS class
     *
     * @param string $class
     * @param bool|null $force Force add (true) or remove (false), or toggle (null)
     * @return static
     */
    public function toggleClass(string $class, ?bool $force = null): static
    {
        if ($force === true) {
            return $this->addClass($class);
        }

        if ($force === false) {
            return $this->removeClass($class);
        }

        return $this->hasClass($class)
            ? $this->removeClass($class)
            : $this->addClass($class);
    }

    /**
     * Check if element has a specific class
     *
     * @param string $class
     * @return bool
     */
    public function hasClass(string $class): bool
    {
        return in_array($class, $this->classes, true);
    }

    /**
     * Get all CSS classes
     *
     * @return array<string>
     */
    public function getClasses(): array
    {
        return $this->classes;
    }

    /**
     * Set all CSS classes (replaces existing)
     *
     * @param array<string> $classes
     * @return static
     */
    public function setClasses(array $classes): static
    {
        $this->classes = [];
        return $this->class($classes);
    }

    /**
     * Clear all CSS classes
     *
     * @return static
     */
    public function clearClasses(): static
    {
        $this->classes = [];
        return $this;
    }

    /**
     * Build CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        return implode(' ', array_unique($this->classes));
    }

    /**
     * Add conditional classes
     *
     * @param array<string, bool> $classes Map of class => condition
     * @return static
     */
    public function classIf(array $classes): static
    {
        foreach ($classes as $class => $condition) {
            if ($condition) {
                $this->addClass($class);
            }
        }

        return $this;
    }

    /**
     * Add class when condition is true
     *
     * @param string $class
     * @param bool $condition
     * @return static
     */
    public function addClassWhen(string $class, bool $condition): static
    {
        if ($condition) {
            $this->addClass($class);
        }

        return $this;
    }

    /**
     * Add class when condition is false
     *
     * @param string $class
     * @param bool $condition
     * @return static
     */
    public function addClassUnless(string $class, bool $condition): static
    {
        if (!$condition) {
            $this->addClass($class);
        }

        return $this;
    }

    /**
     * Replace one class with another
     *
     * @param string $oldClass
     * @param string $newClass
     * @return static
     */
    public function replaceClass(string $oldClass, string $newClass): static
    {
        $this->removeClass($oldClass);
        $this->addClass($newClass);

        return $this;
    }
}
