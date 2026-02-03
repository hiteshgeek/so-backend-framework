<?php

namespace Core\UiEngine\Elements;

use Core\UiEngine\Contracts\ElementInterface;
use Core\UiEngine\Contracts\RenderableInterface;
use Core\UiEngine\Support\CssPrefix;
use Core\UiEngine\Traits\HasAttributes;
use Core\UiEngine\Traits\HasClasses;
use Core\UiEngine\Traits\HasDataAttributes;
use Core\UiEngine\Traits\Renderable;

/**
 * Element - Abstract base class for all UI elements
 *
 * Provides the foundation for all UI elements with support for
 * HTML attributes, CSS classes, data attributes, and rendering.
 */
abstract class Element implements ElementInterface, RenderableInterface
{
    use HasAttributes, HasClasses, HasDataAttributes, Renderable;

    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'element';

    /**
     * HTML tag name for this element
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Element ID
     *
     * @var string|null
     */
    protected ?string $id = null;

    /**
     * Original configuration array
     *
     * @var array
     */
    protected array $config = [];

    /**
     * Text content (for simple elements)
     *
     * @var string|null
     */
    protected ?string $content = null;

    /**
     * Element types that require JavaScript initialization
     *
     * @var array
     */
    protected static array $jsInitTypes = [
        'modal', 'dropdown', 'tooltip', 'popover', 'toast',
        'tabs', 'accordion', 'collapse', 'carousel', 'select',
        'autocomplete', 'date-picker', 'time-picker', 'dropzone',
        'otp-input', 'slider', 'rating', 'context-menu',
    ];

    /**
     * Create a new Element instance
     *
     * @param array $config Configuration array
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->initializeFromConfig($config);
    }

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        // ID
        if (isset($config['id'])) {
            $this->id = $config['id'];
        }

        // CSS classes
        if (isset($config['class'])) {
            $this->class($config['class']);
        }

        // HTML attributes
        if (isset($config['attributes']) && is_array($config['attributes'])) {
            $this->setAttributes($config['attributes']);
        }

        // Data attributes
        if (isset($config['data']) && is_array($config['data'])) {
            $this->setDataAttributes($config['data']);
        }

        // Content
        if (isset($config['content'])) {
            $this->content = $config['content'];
        }
    }

    /**
     * Create a new instance from configuration
     *
     * @param array $config
     * @return static
     */
    public static function make(array $config = []): static
    {
        return new static($config);
    }

    /**
     * Get the element type identifier
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get the element ID
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set the element ID
     *
     * @param string $id
     * @return static
     */
    public function id(string $id): static
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the HTML tag name
     *
     * @return string
     */
    public function getTagName(): string
    {
        return $this->tagName;
    }

    /**
     * Set the HTML tag name
     *
     * @param string $tag
     * @return static
     */
    public function tag(string $tag): static
    {
        $this->tagName = $tag;
        return $this;
    }

    /**
     * Set text content
     *
     * @param string $content
     * @return static
     */
    public function content(string $content): static
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get text content
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Conditional fluent method
     *
     * @param bool $condition
     * @param callable $callback Receives $this when condition is true
     * @param callable|null $fallback Receives $this when condition is false
     * @return static
     */
    public function when(bool $condition, callable $callback, ?callable $fallback = null): static
    {
        if ($condition) {
            $callback($this);
        } elseif ($fallback !== null) {
            $fallback($this);
        }

        return $this;
    }

    /**
     * Conditional fluent method (inverse of when)
     *
     * @param bool $condition
     * @param callable $callback
     * @return static
     */
    public function unless(bool $condition, callable $callback): static
    {
        return $this->when(!$condition, $callback);
    }

    /**
     * Check if this element requires JavaScript initialization
     *
     * Override in subclasses to enable/disable JS initialization
     *
     * @return bool
     */
    public function requiresJsInit(): bool
    {
        return in_array($this->type, static::$jsInitTypes, true);
    }

    /**
     * Get the configuration for JavaScript initialization
     *
     * Override in subclasses to provide element-specific configuration
     *
     * @return array|null
     */
    public function getJsInitConfig(): ?array
    {
        return null;
    }

    /**
     * Gather all attributes including auto-initialization attributes
     *
     * @return array<string, mixed>
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = [];

        // ID
        if ($this->id !== null) {
            $attrs['id'] = $this->id;
        }

        // CSS classes
        if (method_exists($this, 'buildClassString')) {
            $classString = $this->buildClassString();
            if ($classString !== '') {
                $attrs['class'] = $classString;
            }
        }

        // Regular HTML attributes
        if (method_exists($this, 'getAttributes')) {
            $attrs = array_merge($attrs, $this->getAttributes());
        }

        // Data attributes
        if (method_exists($this, 'buildDataAttributes')) {
            $attrs = array_merge($attrs, $this->buildDataAttributes());
        }

        // Event attributes
        if (method_exists($this, 'buildEventAttributes')) {
            $attrs = array_merge($attrs, $this->buildEventAttributes());
        }

        // Auto-initialization attributes for JS
        if ($this->requiresJsInit()) {
            $attrs[CssPrefix::data('ui-init')] = $this->type;

            $initConfig = $this->getJsInitConfig();
            if ($initConfig !== null) {
                $attrs[CssPrefix::data('ui-config')] = json_encode($initConfig);
            }
        }

        return $attrs;
    }

    /**
     * Render the content between tags
     *
     * Override in subclasses to provide specific content
     *
     * @return string
     */
    public function renderContent(): string
    {
        if ($this->content !== null) {
            return e($this->content);
        }

        return '';
    }

    /**
     * Get the original configuration
     *
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Clone the element
     *
     * @return static
     */
    public function clone(): static
    {
        return clone $this;
    }

    /**
     * Deep clone handler
     */
    public function __clone(): void
    {
        // Clone mutable objects if needed
    }

    /**
     * Debug output
     *
     * @return array
     */
    public function __debugInfo(): array
    {
        return [
            'type' => $this->type,
            'tagName' => $this->tagName,
            'id' => $this->id,
            'classes' => $this->classes,
            'attributes' => $this->attributes,
            'dataAttributes' => $this->dataAttributes,
            'content' => $this->content,
        ];
    }
}
