<?php

namespace Core\UiEngine\Elements;

use Core\UiEngine\Contracts\ContainerInterface;
use Core\UiEngine\Contracts\ElementInterface;
use Core\UiEngine\Support\ElementFactory;

/**
 * ContainerElement - Abstract base class for container elements
 *
 * Extends Element with container functionality for managing
 * child elements, including rows, columns, forms, cards, etc.
 */
abstract class ContainerElement extends Element implements ContainerInterface
{
    /**
     * Child elements
     *
     * @var array<ElementInterface>
     */
    protected array $children = [];

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        // Process children from config
        if (isset($config['children']) && is_array($config['children'])) {
            foreach ($config['children'] as $childConfig) {
                if ($childConfig instanceof ElementInterface) {
                    $this->add($childConfig);
                } elseif (is_array($childConfig)) {
                    $this->add(ElementFactory::create($childConfig));
                }
            }
        }
    }

    /**
     * Get all child elements
     *
     * @return array<ElementInterface>
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * Add a child element
     *
     * @param ElementInterface|array $element Element instance or config array
     * @return static
     */
    public function add(ElementInterface|array $element): static
    {
        if (is_array($element)) {
            $element = ElementFactory::create($element);
        }

        $this->children[] = $element;
        return $this;
    }

    /**
     * Replace content with raw HTML (clears existing children)
     *
     * @param string $html Raw HTML content
     * @return static
     */
    public function html(string $html): static
    {
        // Clear existing children (replace behavior)
        $this->children = [];

        // Create RawHtml element using ElementFactory to avoid circular dependency
        $element = ElementFactory::create([
            'type' => 'rawhtml',
            'innerHTML' => $html
        ]);
        $this->children[] = $element;
        return $this;
    }

    /**
     * Append raw HTML content
     *
     * @param string $html Raw HTML content
     * @return static
     */
    public function appendHtml(string $html): static
    {
        // Create RawHtml element using ElementFactory to avoid circular dependency
        $element = ElementFactory::create([
            'type' => 'rawhtml',
            'innerHTML' => $html
        ]);
        $this->children[] = $element;
        return $this;
    }

    /**
     * Prepend raw HTML content
     *
     * @param string $html Raw HTML content
     * @return static
     */
    public function prependHtml(string $html): static
    {
        // Create RawHtml element using ElementFactory to avoid circular dependency
        $element = ElementFactory::create([
            'type' => 'rawhtml',
            'innerHTML' => $html
        ]);
        array_unshift($this->children, $element);
        return $this;
    }

    /**
     * Add multiple child elements
     *
     * @param array<ElementInterface|array> $elements
     * @return static
     */
    public function addMany(array $elements): static
    {
        foreach ($elements as $element) {
            $this->add($element);
        }

        return $this;
    }

    /**
     * Prepend a child element
     *
     * @param ElementInterface|array $element
     * @return static
     */
    public function prepend(ElementInterface|array $element): static
    {
        if (is_array($element)) {
            $element = ElementFactory::create($element);
        }

        array_unshift($this->children, $element);
        return $this;
    }

    /**
     * Insert element at specific position
     *
     * @param int $index
     * @param ElementInterface|array $element
     * @return static
     */
    public function insertAt(int $index, ElementInterface|array $element): static
    {
        if (is_array($element)) {
            $element = ElementFactory::create($element);
        }

        array_splice($this->children, $index, 0, [$element]);
        return $this;
    }

    /**
     * Remove a child element by index or ID
     *
     * @param int|string $indexOrId Element index or ID
     * @return static
     */
    public function remove(int|string $indexOrId): static
    {
        if (is_int($indexOrId)) {
            // Remove by index
            if (isset($this->children[$indexOrId])) {
                array_splice($this->children, $indexOrId, 1);
            }
        } else {
            // Remove by ID
            $this->children = array_filter(
                $this->children,
                fn($child) => $child->getId() !== $indexOrId
            );
            $this->children = array_values($this->children);
        }

        return $this;
    }

    /**
     * Remove child at index
     *
     * @param int $index
     * @return static
     */
    public function removeAt(int $index): static
    {
        if (isset($this->children[$index])) {
            array_splice($this->children, $index, 1);
        }

        return $this;
    }

    /**
     * Check if container has children
     *
     * @return bool
     */
    public function hasChildren(): bool
    {
        return !empty($this->children);
    }

    /**
     * Get the number of children
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->children);
    }

    /**
     * Clear all children
     *
     * @return static
     */
    public function clear(): static
    {
        $this->children = [];
        return $this;
    }

    /**
     * Find a child element by ID
     *
     * @param string $id
     * @return ElementInterface|null
     */
    public function find(string $id): ?ElementInterface
    {
        foreach ($this->children as $child) {
            if ($child->getId() === $id) {
                return $child;
            }

            // Recursively search in container children
            if ($child instanceof ContainerInterface) {
                $found = $child->find($id);
                if ($found !== null) {
                    return $found;
                }
            }
        }

        return null;
    }

    /**
     * Find all children matching a callback
     *
     * @param callable $callback fn(ElementInterface) => bool
     * @return array<ElementInterface>
     */
    public function findAll(callable $callback): array
    {
        $found = [];

        foreach ($this->children as $child) {
            if ($callback($child)) {
                $found[] = $child;
            }

            // Recursively search in container children
            if ($child instanceof ContainerInterface) {
                $found = array_merge($found, $child->findAll($callback));
            }
        }

        return $found;
    }

    /**
     * Find child by name (for form elements)
     *
     * @param string $name
     * @return ElementInterface|null
     */
    public function findByName(string $name): ?ElementInterface
    {
        return $this->findFirst(
            fn($el) => $el instanceof FormElement && $el->getName() === $name
        );
    }

    /**
     * Find first child matching a callback
     *
     * @param callable $callback
     * @return ElementInterface|null
     */
    public function findFirst(callable $callback): ?ElementInterface
    {
        foreach ($this->children as $child) {
            if ($callback($child)) {
                return $child;
            }

            if ($child instanceof ContainerInterface) {
                $found = $child->findFirst($callback);
                if ($found !== null) {
                    return $found;
                }
            }
        }

        return null;
    }

    /**
     * Get all form elements (recursively)
     *
     * @return array<FormElement>
     */
    public function getFormElements(): array
    {
        return $this->findAll(fn($el) => $el instanceof FormElement);
    }

    /**
     * Get child at index
     *
     * @param int $index
     * @return ElementInterface|null
     */
    public function getChildAt(int $index): ?ElementInterface
    {
        return $this->children[$index] ?? null;
    }

    /**
     * Get first child
     *
     * @return ElementInterface|null
     */
    public function first(): ?ElementInterface
    {
        return $this->children[0] ?? null;
    }

    /**
     * Get last child
     *
     * @return ElementInterface|null
     */
    public function last(): ?ElementInterface
    {
        $count = count($this->children);
        return $count > 0 ? $this->children[$count - 1] : null;
    }

    /**
     * Map over children
     *
     * @param callable $callback fn(ElementInterface, int) => mixed
     * @return array
     */
    public function map(callable $callback): array
    {
        return array_map($callback, $this->children, array_keys($this->children));
    }

    /**
     * Execute callback for each child
     *
     * @param callable $callback fn(ElementInterface, int)
     * @return static
     */
    public function each(callable $callback): static
    {
        foreach ($this->children as $index => $child) {
            $callback($child, $index);
        }

        return $this;
    }

    /**
     * Filter children
     *
     * @param callable $callback fn(ElementInterface) => bool
     * @return static
     */
    public function filter(callable $callback): static
    {
        $this->children = array_values(array_filter($this->children, $callback));
        return $this;
    }

    /**
     * Render all children
     *
     * @return string
     */
    public function renderChildren(): string
    {
        $html = '';

        foreach ($this->children as $child) {
            $html .= $child->render();
        }

        return $html;
    }

    /**
     * Render the content between tags (returns children HTML)
     *
     * @return string
     */
    public function renderContent(): string
    {
        $content = parent::renderContent();
        return $content . $this->renderChildren();
    }

    /**
     * Convert to array including children
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        if (!empty($this->children)) {
            $config['children'] = array_map(
                fn($child) => $child->toArray(),
                $this->children
            );
        }

        return $config;
    }

    /**
     * Export validation rules from all form elements
     *
     * @return array<string, array>
     */
    public function exportValidation(): array
    {
        $rules = [];

        foreach ($this->getFormElements() as $element) {
            if ($element->hasRules() && $element->getName() !== null) {
                $rules[$element->getName()] = $element->exportValidation();
            }
        }

        return $rules;
    }

    /**
     * Set values on form elements from data array
     *
     * @param array $data Map of name => value
     * @return static
     */
    public function fill(array $data): static
    {
        foreach ($this->getFormElements() as $element) {
            $name = $element->getName();
            if ($name !== null && array_key_exists($name, $data)) {
                $element->value($data[$name]);
            }
        }

        return $this;
    }

    /**
     * Set errors on form elements from errors array
     *
     * @param array $errors Map of name => error message(s)
     * @return static
     */
    public function setErrors(array $errors): static
    {
        foreach ($this->getFormElements() as $element) {
            $name = $element->getName();
            if ($name !== null && isset($errors[$name])) {
                $error = is_array($errors[$name]) ? $errors[$name][0] : $errors[$name];
                $element->error($error);
            }
        }

        return $this;
    }

    /**
     * Get values from all form elements
     *
     * @return array<string, mixed>
     */
    public function getValues(): array
    {
        $values = [];

        foreach ($this->getFormElements() as $element) {
            $name = $element->getName();
            if ($name !== null) {
                $values[$name] = $element->getValue();
            }
        }

        return $values;
    }

    /**
     * Debug output
     *
     * @return array
     */
    public function __debugInfo(): array
    {
        return array_merge(parent::__debugInfo(), [
            'children' => $this->children,
            'childCount' => count($this->children),
        ]);
    }
}
