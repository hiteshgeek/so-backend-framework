<?php

namespace Core\UiEngine\Traits;

use Core\UiEngine\Support\CssPrefix;

/**
 * Trait for managing data-* attributes
 *
 * Provides methods for setting and managing HTML5 data attributes
 * on UI elements.
 */
trait HasDataAttributes
{
    /**
     * Data attributes collection (without data- prefix)
     *
     * @var array<string, mixed>
     */
    protected array $dataAttributes = [];

    /**
     * Set a data attribute
     *
     * @param string $name Attribute name (without data- prefix)
     * @param mixed $value
     * @return static
     */
    public function data(string $name, mixed $value): static
    {
        if ($value === null) {
            unset($this->dataAttributes[$name]);
        } else {
            $this->dataAttributes[$name] = $value;
        }

        return $this;
    }

    /**
     * Set multiple data attributes at once
     *
     * @param array<string, mixed> $data
     * @return static
     */
    public function dataAll(array $data): static
    {
        foreach ($data as $name => $value) {
            $this->data($name, $value);
        }

        return $this;
    }

    /**
     * Get a data attribute value
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getData(string $name, mixed $default = null): mixed
    {
        return $this->dataAttributes[$name] ?? $default;
    }

    /**
     * Check if a data attribute exists
     *
     * @param string $name
     * @return bool
     */
    public function hasData(string $name): bool
    {
        return isset($this->dataAttributes[$name]);
    }

    /**
     * Remove a data attribute
     *
     * @param string $name
     * @return static
     */
    public function removeData(string $name): static
    {
        unset($this->dataAttributes[$name]);
        return $this;
    }

    /**
     * Get all data attributes
     *
     * @return array<string, mixed>
     */
    public function getDataAttributes(): array
    {
        return $this->dataAttributes;
    }

    /**
     * Set all data attributes (replaces existing)
     *
     * @param array<string, mixed> $data
     * @return static
     */
    public function setDataAttributes(array $data): static
    {
        $this->dataAttributes = $data;
        return $this;
    }

    /**
     * Clear all data attributes
     *
     * @return static
     */
    public function clearDataAttributes(): static
    {
        $this->dataAttributes = [];
        return $this;
    }

    /**
     * Build data attributes for HTML output
     *
     * @return array<string, mixed> Attributes with data- prefix
     */
    public function buildDataAttributes(): array
    {
        $result = [];

        foreach ($this->dataAttributes as $name => $value) {
            $key = 'data-' . $this->kebabCase($name);

            if (is_array($value) || is_object($value)) {
                $result[$key] = json_encode($value);
            } elseif (is_bool($value)) {
                $result[$key] = $value ? 'true' : 'false';
            } else {
                $result[$key] = (string) $value;
            }
        }

        return $result;
    }

    /**
     * Build data attributes string for HTML output
     *
     * @return string
     */
    public function buildDataAttributeString(): string
    {
        $attrs = $this->buildDataAttributes();
        $parts = [];

        foreach ($attrs as $name => $value) {
            $parts[] = e($name) . '="' . e($value) . '"';
        }

        return implode(' ', $parts);
    }

    /**
     * Convert camelCase to kebab-case
     *
     * @param string $string
     * @return string
     */
    protected function kebabCase(string $string): string
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $string));
    }

    /**
     * Set data-so-* attribute (SixOrbit framework convention)
     *
     * @param string $name Attribute name (without data-so- prefix)
     * @param mixed $value
     * @return static
     */
    public function dataSo(string $name, mixed $value): static
    {
        return $this->data(CssPrefix::getPrefix() . '-' . $name, $value);
    }

    /**
     * Set data-action attribute (for JavaScript event delegation)
     *
     * @param string $action
     * @return static
     */
    public function dataAction(string $action): static
    {
        return $this->data('action', $action);
    }

    /**
     * Set data-target attribute (for JavaScript targeting)
     *
     * @param string $target CSS selector or element ID
     * @return static
     */
    public function dataTarget(string $target): static
    {
        return $this->data('target', $target);
    }

    /**
     * Set data-toggle attribute
     *
     * @param string $toggle Toggle type (modal, dropdown, collapse, etc.)
     * @return static
     */
    public function dataToggle(string $toggle): static
    {
        return $this->data('toggle', $toggle);
    }

    /**
     * Set data-dismiss attribute
     *
     * @param string $dismiss Dismiss type (modal, alert, etc.)
     * @return static
     */
    public function dataDismiss(string $dismiss): static
    {
        return $this->data('dismiss', $dismiss);
    }

    /**
     * Set data-loading attribute
     *
     * @param bool $loading
     * @return static
     */
    public function dataLoading(bool $loading = true): static
    {
        return $this->data('loading', $loading);
    }
}
