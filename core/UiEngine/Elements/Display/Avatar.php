<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * Avatar - User avatar display element
 *
 * Creates SixOrbit-style avatars with support for images, initials, icons, and status indicators.
 */
class Avatar extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'avatar';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Avatar image URL
     *
     * @var string|null
     */
    protected ?string $image = null;

    /**
     * Avatar image alt text
     *
     * @var string
     */
    protected string $alt = 'Avatar';

    /**
     * Avatar initials (for text-based avatars)
     *
     * @var string|null
     */
    protected ?string $initials = null;

    /**
     * Avatar icon (Material Icons name)
     *
     * @var string|null
     */
    protected ?string $icon = null;

    /**
     * Avatar size (sm, md, lg, xl)
     *
     * @var string
     */
    protected string $size = 'md';

    /**
     * Avatar variant for colored backgrounds (primary, success, danger, etc.)
     *
     * @var string|null
     */
    protected ?string $variant = null;

    /**
     * Status indicator (online, offline, away, busy)
     *
     * @var string|null
     */
    protected ?string $status = null;

    /**
     * Avatar shape (circle, rounded, square)
     *
     * @var string
     */
    protected string $shape = 'circle';

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['image'])) {
            $this->image = $config['image'];
        }

        if (isset($config['alt'])) {
            $this->alt = $config['alt'];
        }

        if (isset($config['initials'])) {
            $this->initials = $config['initials'];
        }

        if (isset($config['icon'])) {
            $this->icon = $config['icon'];
        }

        if (isset($config['size'])) {
            $this->size = $config['size'];
        }

        if (isset($config['variant'])) {
            $this->variant = $config['variant'];
        }

        if (isset($config['status'])) {
            $this->status = $config['status'];
        }

        if (isset($config['shape'])) {
            $this->shape = $config['shape'];
        }
    }

    /**
     * Set avatar image
     *
     * @param string $url
     * @param string $alt
     * @return static
     */
    public function image(string $url, string $alt = 'Avatar'): static
    {
        $this->image = $url;
        $this->alt = $alt;
        return $this;
    }

    /**
     * Set avatar initials
     *
     * @param string $initials
     * @return static
     */
    public function initials(string $initials): static
    {
        $this->initials = strtoupper(substr($initials, 0, 2));
        return $this;
    }

    /**
     * Set avatar icon
     *
     * @param string $icon Material Icons name
     * @return static
     */
    public function icon(string $icon): static
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Set avatar size
     *
     * @param string $size sm|md|lg|xl
     * @return static
     */
    public function size(string $size): static
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Small size
     *
     * @return static
     */
    public function small(): static
    {
        return $this->size('sm');
    }

    /**
     * Large size
     *
     * @return static
     */
    public function large(): static
    {
        return $this->size('lg');
    }

    /**
     * Extra large size
     *
     * @return static
     */
    public function extraLarge(): static
    {
        return $this->size('xl');
    }

    /**
     * Set avatar variant (for colored backgrounds)
     *
     * @param string $variant
     * @return static
     */
    public function variant(string $variant): static
    {
        $this->variant = $variant;
        return $this;
    }

    /**
     * Primary variant
     *
     * @return static
     */
    public function primary(): static
    {
        return $this->variant('primary');
    }

    /**
     * Success variant
     *
     * @return static
     */
    public function success(): static
    {
        return $this->variant('success');
    }

    /**
     * Danger variant
     *
     * @return static
     */
    public function danger(): static
    {
        return $this->variant('danger');
    }

    /**
     * Warning variant
     *
     * @return static
     */
    public function warning(): static
    {
        return $this->variant('warning');
    }

    /**
     * Info variant
     *
     * @return static
     */
    public function info(): static
    {
        return $this->variant('info');
    }

    /**
     * Secondary variant
     *
     * @return static
     */
    public function secondary(): static
    {
        return $this->variant('secondary');
    }

    /**
     * Set status indicator
     *
     * @param string $status online|offline|away|busy
     * @return static
     */
    public function status(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Online status
     *
     * @return static
     */
    public function online(): static
    {
        return $this->status('online');
    }

    /**
     * Offline status
     *
     * @return static
     */
    public function offline(): static
    {
        return $this->status('offline');
    }

    /**
     * Away status
     *
     * @return static
     */
    public function away(): static
    {
        return $this->status('away');
    }

    /**
     * Busy status
     *
     * @return static
     */
    public function busy(): static
    {
        return $this->status('busy');
    }

    /**
     * Set avatar shape
     *
     * @param string $shape circle|rounded|square
     * @return static
     */
    public function shape(string $shape): static
    {
        $this->shape = $shape;
        return $this;
    }

    /**
     * Rounded shape
     *
     * @return static
     */
    public function rounded(): static
    {
        return $this->shape('rounded');
    }

    /**
     * Square shape
     *
     * @return static
     */
    public function square(): static
    {
        return $this->shape('square');
    }

    /**
     * Build the CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('avatar'));

        // Size class
        if ($this->size !== 'md') {
            $this->addClass(CssPrefix::cls('avatar', $this->size));
        }

        // Variant class (for colored backgrounds)
        if ($this->variant !== null) {
            $this->addClass(CssPrefix::cls('avatar', $this->variant));
        }

        // Status class
        if ($this->status !== null) {
            $this->addClass(CssPrefix::cls('avatar-status'));
            $this->addClass(CssPrefix::cls('avatar-status', $this->status));
        }

        // Shape class
        if ($this->shape !== 'circle') {
            $this->addClass(CssPrefix::cls('avatar', $this->shape));
        }

        return parent::buildClassString();
    }

    /**
     * Render the content
     *
     * @return string
     */
    public function renderContent(): string
    {
        // Image avatar
        if ($this->image !== null) {
            return '<img src="' . e($this->image) . '" alt="' . e($this->alt) . '">';
        }

        // Initials avatar
        if ($this->initials !== null) {
            return '<span>' . e($this->initials) . '</span>';
        }

        // Icon avatar
        if ($this->icon !== null) {
            return '<span class="material-icons">' . e($this->icon) . '</span>';
        }

        // Default: person icon
        return '<span class="material-icons">person</span>';
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        if ($this->image !== null) {
            $config['image'] = $this->image;
            $config['alt'] = $this->alt;
        }

        if ($this->initials !== null) {
            $config['initials'] = $this->initials;
        }

        if ($this->icon !== null) {
            $config['icon'] = $this->icon;
        }

        if ($this->size !== 'md') {
            $config['size'] = $this->size;
        }

        if ($this->variant !== null) {
            $config['variant'] = $this->variant;
        }

        if ($this->status !== null) {
            $config['status'] = $this->status;
        }

        if ($this->shape !== 'circle') {
            $config['shape'] = $this->shape;
        }

        return $config;
    }
}
