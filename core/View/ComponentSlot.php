<?php

namespace Core\View;

/**
 * Manages slot content for components
 *
 * Slots allow passing content into components. Components can have:
 * - A default slot: The main content passed to the component
 * - Named slots: Additional named content areas (header, footer, etc.)
 *
 * Usage in component templates:
 *   <?= $__slot ?>                           // Render default slot
 *   <?= $__slot->get('header') ?>           // Get named slot
 *   <?php if ($__slot->has('footer')): ?>   // Check if slot exists
 */
class ComponentSlot implements \Stringable
{
    /**
     * Default slot content
     */
    protected string|callable|null $defaultSlot;

    /**
     * Named slots
     * @var array<string, string|callable>
     */
    protected array $namedSlots;

    /**
     * Create a new ComponentSlot instance
     *
     * @param string|callable|null $defaultSlot Default slot content
     * @param array $namedSlots Named slots ['name' => 'content']
     */
    public function __construct(string|callable|null $defaultSlot = null, array $namedSlots = [])
    {
        $this->defaultSlot = $defaultSlot;
        $this->namedSlots = $namedSlots;
    }

    /**
     * Render the default slot when cast to string
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Render the default slot content
     *
     * @return string
     */
    public function render(): string
    {
        if ($this->defaultSlot === null) {
            return '';
        }

        if (is_callable($this->defaultSlot)) {
            return (string) ($this->defaultSlot)();
        }

        return (string) $this->defaultSlot;
    }

    /**
     * Check if default slot has content
     *
     * @return bool
     */
    public function hasContent(): bool
    {
        if ($this->defaultSlot === null) {
            return false;
        }

        return trim($this->render()) !== '';
    }

    /**
     * Get a named slot's content
     *
     * @param string $name Slot name
     * @param string $default Default value if slot doesn't exist
     * @return string
     */
    public function get(string $name, string $default = ''): string
    {
        if (!isset($this->namedSlots[$name])) {
            return $default;
        }

        $slot = $this->namedSlots[$name];

        if (is_callable($slot)) {
            return (string) $slot();
        }

        return (string) $slot;
    }

    /**
     * Check if a named slot exists and has content
     *
     * @param string $name Slot name
     * @return bool
     */
    public function has(string $name): bool
    {
        if (!isset($this->namedSlots[$name])) {
            return false;
        }

        return trim($this->get($name)) !== '';
    }

    /**
     * Get all named slots
     *
     * @return array
     */
    public function getSlots(): array
    {
        return $this->namedSlots;
    }

    /**
     * Check if any slots (default or named) have content
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        if ($this->hasContent()) {
            return false;
        }

        foreach ($this->namedSlots as $name => $content) {
            if ($this->has($name)) {
                return false;
            }
        }

        return true;
    }
}
