<?php

namespace Core\UiEngine\Contracts;

/**
 * Base interface for all UI elements
 *
 * Defines the core contract that all elements must implement,
 * including rendering, attribute management, and configuration.
 */
interface ElementInterface
{
    /**
     * Get the element type identifier
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Get the element ID
     *
     * @return string|null
     */
    public function getId(): ?string;

    /**
     * Set the element ID
     *
     * @param string $id
     * @return static
     */
    public function id(string $id): static;

    /**
     * Add CSS class(es) to the element
     *
     * @param string|array $classes
     * @return static
     */
    public function class(string|array $classes): static;

    /**
     * Add a single CSS class
     *
     * @param string $class
     * @return static
     */
    public function addClass(string $class): static;

    /**
     * Remove a CSS class
     *
     * @param string $class
     * @return static
     */
    public function removeClass(string $class): static;

    /**
     * Check if element has a class
     *
     * @param string $class
     * @return bool
     */
    public function hasClass(string $class): bool;

    /**
     * Set an HTML attribute
     *
     * @param string $name
     * @param mixed $value
     * @return static
     */
    public function attr(string $name, mixed $value): static;

    /**
     * Get an attribute value
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getAttr(string $name, mixed $default = null): mixed;

    /**
     * Set a data attribute (data-*)
     *
     * @param string $name
     * @param mixed $value
     * @return static
     */
    public function data(string $name, mixed $value): static;

    /**
     * Get a data attribute value
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getData(string $name, mixed $default = null): mixed;

    /**
     * Conditionally apply changes
     *
     * @param bool $condition
     * @param callable $callback
     * @return static
     */
    public function when(bool $condition, callable $callback): static;

    /**
     * Render the element to HTML
     *
     * @return string
     */
    public function render(): string;

    /**
     * Convert element configuration to array
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Convert element configuration to JSON
     *
     * @return string
     */
    public function toJson(): string;

    /**
     * Create a new element instance from configuration
     *
     * @param array $config
     * @return static
     */
    public static function make(array $config = []): static;
}
