<?php

namespace Core\UiEngine\Contracts;

/**
 * Interface for container elements (form, card, row, column, etc.)
 *
 * Containers can hold child elements and manage their layout.
 */
interface ContainerInterface extends ElementInterface
{
    /**
     * Get child elements
     *
     * @return array<ElementInterface>
     */
    public function getChildren(): array;

    /**
     * Add a child element
     *
     * @param ElementInterface|array $child Element instance or config array
     * @return static
     */
    public function add(ElementInterface|array $child): static;

    /**
     * Add multiple children at once
     *
     * @param array $children Array of elements or config arrays
     * @return static
     */
    public function addMany(array $children): static;

    /**
     * Remove a child element by index or ID
     *
     * @param int|string $indexOrId
     * @return static
     */
    public function remove(int|string $indexOrId): static;

    /**
     * Check if container has children
     *
     * @return bool
     */
    public function hasChildren(): bool;

    /**
     * Get count of children
     *
     * @return int
     */
    public function count(): int;

    /**
     * Clear all children
     *
     * @return static
     */
    public function clear(): static;

    /**
     * Find a child element by ID
     *
     * @param string $id
     * @return ElementInterface|null
     */
    public function find(string $id): ?ElementInterface;

    /**
     * Find all children matching a callback
     *
     * @param callable $callback fn(ElementInterface) => bool
     * @return array<ElementInterface>
     */
    public function findAll(callable $callback): array;

    /**
     * Find first child matching a callback
     *
     * @param callable $callback fn(ElementInterface) => bool
     * @return ElementInterface|null
     */
    public function findFirst(callable $callback): ?ElementInterface;

    /**
     * Find all form elements (recursively)
     *
     * @return array<FormElementInterface>
     */
    public function getFormElements(): array;

    /**
     * Render children to HTML
     *
     * @return string
     */
    public function renderChildren(): string;
}
