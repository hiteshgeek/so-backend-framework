<?php

namespace Core\View;

use Core\View\SOTemplate\ComponentAttributes;

/**
 * Base class for class-based components
 *
 * Class-based components provide more control than anonymous components,
 * allowing for complex logic, computed properties, and custom rendering.
 *
 * Usage:
 *   class Card extends Component
 *   {
 *       protected function defaults(): array
 *       {
 *           return ['title' => null, 'shadow' => true];
 *       }
 *
 *       public function render(): string
 *       {
 *           return '<div class="card">' . $this->slot->render() . '</div>';
 *       }
 *   }
 *
 * With attributes:
 *   class Button extends Component
 *   {
 *       public function render(): string
 *       {
 *           return '<button ' . $this->attributes->merge(['class' => 'btn']) . '>'
 *               . $this->slot->render()
 *               . '</button>';
 *       }
 *   }
 */
abstract class Component
{
    /**
     * Component properties (defined props)
     */
    protected array $props = [];

    /**
     * Component attributes (extra attributes passed but not defined as props)
     */
    protected ComponentAttributes $attributes;

    /**
     * Slot content handler
     */
    protected ComponentSlot $slot;

    /**
     * Create a new component instance
     *
     * @param array $props Component properties
     * @param array $attributes Extra attributes (not defined as props)
     */
    public function __construct(array $props = [], array $attributes = [])
    {
        // Separate defined props from extra attributes
        $extracted = $this->extractPropsAndAttributes($props, $attributes);

        $this->props = array_merge($this->defaults(), $extracted['props']);
        $this->attributes = $extracted['attributes'];
        $this->slot = new ComponentSlot();
        $this->mount();
    }

    /**
     * Extract props from attributes based on defined prop names
     *
     * @param array $allData All passed data
     * @param array $extraAttributes Pre-separated attributes
     * @return array{props: array, attributes: ComponentAttributes}
     */
    protected function extractPropsAndAttributes(array $allData, array $extraAttributes = []): array
    {
        // Get defined prop names from defaults
        $definedProps = array_keys($this->defaults());

        // Also check for explicit props definition
        if (property_exists($this, 'definedProps')) {
            $definedProps = array_merge($definedProps, (array) $this->definedProps);
        }

        $props = [];
        $attributes = $extraAttributes;

        foreach ($allData as $key => $value) {
            if (in_array($key, $definedProps, true)) {
                $props[$key] = $value;
            } else {
                $attributes[$key] = $value;
            }
        }

        return [
            'props' => $props,
            'attributes' => new ComponentAttributes($attributes),
        ];
    }

    /**
     * Default prop values
     *
     * Override this method to define default values for props.
     *
     * @return array
     */
    protected function defaults(): array
    {
        return [];
    }

    /**
     * Called after construction - for initialization logic
     *
     * Override this method to perform setup after props are assigned.
     *
     * @return void
     */
    protected function mount(): void
    {
        // Override in child classes
    }

    /**
     * Set the default slot content
     *
     * @param string|callable|null $content
     * @return void
     */
    public function setSlot(string|callable|null $content): void
    {
        $namedSlots = $this->slot->getSlots();
        $this->slot = new ComponentSlot($content, $namedSlots);
    }

    /**
     * Set named slots
     *
     * @param array $slots Named slots
     * @return void
     */
    public function setSlots(array $slots): void
    {
        $defaultContent = $this->slot->hasContent() ? $this->slot->render() : null;
        $this->slot = new ComponentSlot($defaultContent, $slots);
    }

    /**
     * Get a prop value
     *
     * @param string $name Prop name
     * @param mixed $default Default value if prop doesn't exist
     * @return mixed
     */
    protected function prop(string $name, mixed $default = null): mixed
    {
        return $this->props[$name] ?? $default;
    }

    /**
     * Check if a prop exists
     *
     * @param string $name Prop name
     * @return bool
     */
    protected function hasProp(string $name): bool
    {
        return array_key_exists($name, $this->props);
    }

    /**
     * Get all props
     *
     * @return array
     */
    protected function props(): array
    {
        return $this->props;
    }

    /**
     * Get the attributes bag
     *
     * @return ComponentAttributes
     */
    public function getAttributes(): ComponentAttributes
    {
        return $this->attributes;
    }

    /**
     * Set the attributes bag
     *
     * @param ComponentAttributes|array $attributes
     * @return void
     */
    public function setAttributes(ComponentAttributes|array $attributes): void
    {
        if (is_array($attributes)) {
            $this->attributes = new ComponentAttributes($attributes);
        } else {
            $this->attributes = $attributes;
        }
    }

    /**
     * Escape a value for HTML output
     *
     * @param mixed $value
     * @return string
     */
    protected function e(mixed $value): string
    {
        if ($value === null) {
            return '';
        }
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Build HTML attributes from an array
     *
     * @param array $attributes
     * @return string
     */
    protected function attributes(array $attributes): string
    {
        $html = [];

        foreach ($attributes as $key => $value) {
            if ($value === null || $value === false) {
                continue;
            }

            if ($value === true) {
                $html[] = $this->e($key);
            } else {
                $html[] = $this->e($key) . '="' . $this->e($value) . '"';
            }
        }

        return implode(' ', $html);
    }

    /**
     * Render the component
     *
     * This method must be implemented by child classes.
     *
     * @return string Rendered HTML
     */
    abstract public function render(): string;
}
