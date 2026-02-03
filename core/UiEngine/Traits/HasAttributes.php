<?php

namespace Core\UiEngine\Traits;

/**
 * Trait for managing HTML attributes
 *
 * Provides methods for setting, getting, and managing HTML attributes
 * on UI elements.
 */
trait HasAttributes
{
    /**
     * HTML attributes collection
     *
     * @var array<string, mixed>
     */
    protected array $attributes = [];

    /**
     * Set an HTML attribute
     *
     * @param string $name Attribute name
     * @param mixed $value Attribute value (null to remove)
     * @return static
     */
    public function attr(string $name, mixed $value): static
    {
        if ($value === null) {
            unset($this->attributes[$name]);
        } else {
            $this->attributes[$name] = $value;
        }

        return $this;
    }

    /**
     * Set multiple attributes at once
     *
     * @param array<string, mixed> $attributes
     * @return static
     */
    public function attrs(array $attributes): static
    {
        foreach ($attributes as $name => $value) {
            $this->attr($name, $value);
        }

        return $this;
    }

    /**
     * Get an attribute value
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getAttr(string $name, mixed $default = null): mixed
    {
        return $this->attributes[$name] ?? $default;
    }

    /**
     * Check if an attribute exists
     *
     * @param string $name
     * @return bool
     */
    public function hasAttr(string $name): bool
    {
        return isset($this->attributes[$name]);
    }

    /**
     * Remove an attribute
     *
     * @param string $name
     * @return static
     */
    public function removeAttr(string $name): static
    {
        unset($this->attributes[$name]);
        return $this;
    }

    /**
     * Get all attributes
     *
     * @return array<string, mixed>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Set all attributes (replaces existing)
     *
     * @param array<string, mixed> $attributes
     * @return static
     */
    public function setAttributes(array $attributes): static
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Merge attributes with existing
     *
     * @param array<string, mixed> $attributes
     * @return static
     */
    public function mergeAttributes(array $attributes): static
    {
        $this->attributes = array_merge($this->attributes, $attributes);
        return $this;
    }

    /**
     * Build attributes string for HTML output
     *
     * @param array|null $attributes Custom attributes (or use stored)
     * @return string
     */
    public function buildAttributeString(?array $attributes = null): string
    {
        $attrs = $attributes ?? $this->attributes;
        $parts = [];

        foreach ($attrs as $name => $value) {
            if ($value === false || $value === null) {
                continue; // Skip false/null attributes
            }

            if ($value === true) {
                // Boolean attribute (e.g., disabled, readonly)
                $parts[] = e($name);
            } else {
                // Regular attribute with value
                $parts[] = e($name) . '="' . e((string) $value) . '"';
            }
        }

        return implode(' ', $parts);
    }

    /**
     * Set tabindex attribute
     *
     * @param int $index
     * @return static
     */
    public function tabindex(int $index): static
    {
        return $this->attr('tabindex', $index);
    }

    /**
     * Set title attribute (tooltip)
     *
     * @param string $title
     * @return static
     */
    public function title(string $title): static
    {
        return $this->attr('title', $title);
    }

    /**
     * Set style attribute
     *
     * @param string|array $style CSS string or array of properties
     * @return static
     */
    public function style(string|array $style): static
    {
        if (is_array($style)) {
            $parts = [];
            foreach ($style as $property => $value) {
                $parts[] = "{$property}: {$value}";
            }
            $style = implode('; ', $parts);
        }

        return $this->attr('style', $style);
    }

    /**
     * Set aria attribute
     *
     * @param string $name ARIA attribute name (without aria- prefix)
     * @param mixed $value
     * @return static
     */
    public function aria(string $name, mixed $value): static
    {
        return $this->attr("aria-{$name}", $value);
    }

    /**
     * Set role attribute
     *
     * @param string $role
     * @return static
     */
    public function role(string $role): static
    {
        return $this->attr('role', $role);
    }

    /**
     * Set autofocus attribute
     *
     * @param bool $autofocus
     * @return static
     */
    public function autofocus(bool $autofocus = true): static
    {
        return $this->attr('autofocus', $autofocus);
    }

    /**
     * Set hidden attribute
     *
     * @param bool $hidden
     * @return static
     */
    public function hidden(bool $hidden = true): static
    {
        return $this->attr('hidden', $hidden);
    }
}
