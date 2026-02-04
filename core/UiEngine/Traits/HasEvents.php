<?php

namespace Core\UiEngine\Traits;

/**
 * Trait for managing JavaScript event handlers
 *
 * Provides methods for setting event handlers that will be rendered
 * as HTML event attributes or data attributes for JS delegation.
 */
trait HasEvents
{
    /**
     * Event handlers collection
     *
     * @var array<string, string>
     */
    protected array $events = [];

    /**
     * Whether to use inline event handlers or data attributes
     *
     * @var bool
     */
    protected bool $useInlineEvents = false;

    /**
     * Set an event handler
     *
     * @param string $event Event name (click, change, blur, etc.)
     * @param string $handler JS function name or inline code
     * @return static
     */
    public function on(string $event, string $handler): static
    {
        $this->events[$event] = $handler;
        return $this;
    }

    /**
     * Set multiple event handlers at once
     *
     * @param array<string, string> $events Map of event => handler
     * @return static
     */
    public function onMany(array $events): static
    {
        foreach ($events as $event => $handler) {
            $this->on($event, $handler);
        }

        return $this;
    }

    /**
     * Remove an event handler
     *
     * @param string $event
     * @return static
     */
    public function off(string $event): static
    {
        unset($this->events[$event]);
        return $this;
    }

    /**
     * Get an event handler
     *
     * @param string $event
     * @return string|null
     */
    public function getEvent(string $event): ?string
    {
        return $this->events[$event] ?? null;
    }

    /**
     * Check if an event handler exists
     *
     * @param string $event
     * @return bool
     */
    public function hasEvent(string $event): bool
    {
        return isset($this->events[$event]);
    }

    /**
     * Get all event handlers
     *
     * @return array<string, string>
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * Clear all event handlers
     *
     * @return static
     */
    public function clearEvents(): static
    {
        $this->events = [];
        return $this;
    }

    /**
     * Set whether to use inline event handlers
     *
     * @param bool $inline
     * @return static
     */
    public function useInlineEvents(bool $inline = true): static
    {
        $this->useInlineEvents = $inline;
        return $this;
    }

    /**
     * Build event attributes for HTML output
     *
     * @return array<string, string>
     */
    public function buildEventAttributes(): array
    {
        $attrs = [];

        foreach ($this->events as $event => $handler) {
            if ($this->useInlineEvents) {
                // Inline event handlers (onclick, onchange, etc.)
                $attrs['on' . $event] = $handler;
            } else {
                // Data attributes for JS delegation
                $attrs['data-on-' . $event] = $handler;
            }
        }

        return $attrs;
    }

    /**
     * Build event attributes string for HTML output
     *
     * @return string
     */
    public function buildEventAttributeString(): string
    {
        $attrs = $this->buildEventAttributes();
        $parts = [];

        foreach ($attrs as $name => $value) {
            $parts[] = e($name) . '="' . e($value) . '"';
        }

        return implode(' ', $parts);
    }

    // ==================
    // Convenience methods for common events
    // ==================

    /**
     * Set click event handler
     *
     * @param string $handler
     * @return static
     */
    public function onClick(string $handler): static
    {
        return $this->on('click', $handler);
    }

    /**
     * Set double-click event handler
     *
     * @param string $handler
     * @return static
     */
    public function onDblClick(string $handler): static
    {
        return $this->on('dblclick', $handler);
    }

    /**
     * Set change event handler
     *
     * @param string $handler
     * @return static
     */
    public function onChange(string $handler): static
    {
        return $this->on('change', $handler);
    }

    /**
     * Set input event handler
     *
     * @param string $handler
     * @return static
     */
    public function onInput(string $handler): static
    {
        return $this->on('input', $handler);
    }

    /**
     * Set blur event handler
     *
     * @param string $handler
     * @return static
     */
    public function onBlur(string $handler): static
    {
        return $this->on('blur', $handler);
    }

    /**
     * Set focus event handler
     *
     * @param string $handler
     * @return static
     */
    public function onFocus(string $handler): static
    {
        return $this->on('focus', $handler);
    }

    /**
     * Set submit event handler (for forms)
     *
     * @param string $handler
     * @return static
     */
    public function onSubmit(string $handler): static
    {
        return $this->on('submit', $handler);
    }

    /**
     * Set keyup event handler
     *
     * @param string $handler
     * @return static
     */
    public function onKeyUp(string $handler): static
    {
        return $this->on('keyup', $handler);
    }

    /**
     * Set keydown event handler
     *
     * @param string $handler
     * @return static
     */
    public function onKeyDown(string $handler): static
    {
        return $this->on('keydown', $handler);
    }

    /**
     * Set keypress event handler
     *
     * @param string $handler
     * @return static
     */
    public function onKeyPress(string $handler): static
    {
        return $this->on('keypress', $handler);
    }

    /**
     * Set mouseenter event handler
     *
     * @param string $handler
     * @return static
     */
    public function onMouseEnter(string $handler): static
    {
        return $this->on('mouseenter', $handler);
    }

    /**
     * Set mouseleave event handler
     *
     * @param string $handler
     * @return static
     */
    public function onMouseLeave(string $handler): static
    {
        return $this->on('mouseleave', $handler);
    }

    /**
     * Set hover event handlers (enter and leave)
     *
     * @param string $enterHandler
     * @param string $leaveHandler
     * @return static
     */
    public function onHover(string $enterHandler, string $leaveHandler): static
    {
        return $this->onMouseEnter($enterHandler)->onMouseLeave($leaveHandler);
    }
}
