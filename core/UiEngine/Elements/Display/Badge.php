<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * Badge - Badge/tag display element
 *
 * Creates SixOrbit-style badges for labels, counts, and status indicators.
 */
class Badge extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'badge';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'span';

    /**
     * Badge text
     *
     * @var string|null
     */
    protected ?string $text = null;

    /**
     * Badge variant
     *
     * @var string
     */
    protected string $variant = 'primary';

    /**
     * Soft style (light background)
     *
     * @var bool
     */
    protected bool $soft = false;

    /**
     * Pill style (rounded)
     *
     * @var bool
     */
    protected bool $pill = false;

    /**
     * Badge size (sm, lg)
     *
     * @var string|null
     */
    protected ?string $size = null;

    /**
     * Badge icon
     *
     * @var string|null
     */
    protected ?string $icon = null;

    /**
     * Dot style (no text, just colored dot)
     *
     * @var bool
     */
    protected bool $dot = false;

    /**
     * Label text (displayed after dot badge)
     *
     * @var string|null
     */
    protected ?string $label = null;

    /**
     * Link URL (makes badge clickable)
     *
     * @var string|null
     */
    protected ?string $href = null;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['text'])) {
            $this->text = $config['text'];
        }

        if (isset($config['variant'])) {
            $this->variant = $config['variant'];
        }

        if (isset($config['soft'])) {
            $this->soft = (bool) $config['soft'];
        }

        if (isset($config['pill'])) {
            $this->pill = (bool) $config['pill'];
        }

        if (isset($config['size'])) {
            $this->size = $config['size'];
        }

        if (isset($config['icon'])) {
            $this->icon = $config['icon'];
        }

        if (isset($config['dot'])) {
            $this->dot = (bool) $config['dot'];
        }

        if (isset($config['label'])) {
            $this->label = $config['label'];
        }

        if (isset($config['href'])) {
            $this->href = $config['href'];
            $this->tagName = 'a';
        }
    }

    /**
     * Set badge text
     *
     * @param string $text
     * @return static
     */
    public function text(string $text): static
    {
        $this->text = $text;
        return $this;
    }

    /**
     * Set badge variant
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
     * Secondary variant
     *
     * @return static
     */
    public function secondary(): static
    {
        return $this->variant('secondary');
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
     * Light variant
     *
     * @return static
     */
    public function light(): static
    {
        return $this->variant('light');
    }

    /**
     * Dark variant
     *
     * @return static
     */
    public function dark(): static
    {
        return $this->variant('dark');
    }

    /**
     * Enable pill style
     *
     * @param bool $pill
     * @return static
     */
    public function pill(bool $pill = true): static
    {
        $this->pill = $pill;
        return $this;
    }

    /**
     * Enable soft style (light background)
     *
     * @param bool $soft
     * @return static
     */
    public function soft(bool $soft = true): static
    {
        $this->soft = $soft;
        return $this;
    }

    /**
     * Set badge size
     *
     * @param string $size sm or lg
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
     * Enable dot style (status indicator)
     *
     * @param bool $dot
     * @return static
     */
    public function dot(bool $dot = true): static
    {
        $this->dot = $dot;
        return $this;
    }

    /**
     * Set label text (displayed after dot badge)
     *
     * @param string $label
     * @return static
     */
    public function label(string $label): static
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Set badge icon
     *
     * @param string $icon
     * @return static
     */
    public function icon(string $icon): static
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Make badge a link
     *
     * @param string $href
     * @return static
     */
    public function href(string $href): static
    {
        $this->href = $href;
        $this->tagName = 'a';
        return $this;
    }

    /**
     * Build the CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('badge'));

        // Variant class: so-badge-{variant} or so-badge-soft-{variant}
        if ($this->soft) {
            $this->addClass(CssPrefix::cls('badge-soft', $this->variant));
        } else {
            $this->addClass(CssPrefix::cls('badge', $this->variant));
        }

        // Size class
        if ($this->size !== null) {
            $this->addClass(CssPrefix::cls('badge', $this->size));
        }

        // Pill style
        if ($this->pill) {
            $this->addClass(CssPrefix::cls('badge-pill'));
        }

        // Dot style
        if ($this->dot) {
            $this->addClass(CssPrefix::cls('badge-dot'));
        }

        return parent::buildClassString();
    }

    /**
     * Gather all attributes
     *
     * @return array<string, mixed>
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = parent::gatherAllAttributes();

        if ($this->href !== null) {
            $attrs['href'] = $this->href;
        }

        return $attrs;
    }

    /**
     * Render the content
     *
     * @return string
     */
    public function renderContent(): string
    {
        // Dot badges have no text content inside
        if ($this->dot) {
            return '';
        }

        $html = '';

        // Icon
        if ($this->icon !== null) {
            $html .= '<span class="material-icons" style="font-size: 14px; vertical-align: middle;">'
                . e($this->icon) . '</span> ';
        }

        // Text
        if ($this->text !== null) {
            $html .= e($this->text);
        }

        return $html;
    }

    /**
     * Render the element
     *
     * @return string
     */
    public function render(): string
    {
        $badge = parent::render();

        // For dot badges with label, wrap in container with label
        if ($this->dot && $this->label !== null) {
            return '<span class="' . CssPrefix::cls('d-inline-flex') . ' ' . CssPrefix::cls('align-items-center') . ' ' . CssPrefix::cls('gap-2') . '">'
                . $badge
                . '<span>' . e($this->label) . '</span>'
                . '</span>';
        }

        return $badge;
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        if ($this->text !== null) {
            $config['text'] = $this->text;
        }

        $config['variant'] = $this->variant;

        if ($this->soft) {
            $config['soft'] = true;
        }

        if ($this->pill) {
            $config['pill'] = true;
        }

        if ($this->size !== null) {
            $config['size'] = $this->size;
        }

        if ($this->icon !== null) {
            $config['icon'] = $this->icon;
        }

        if ($this->dot) {
            $config['dot'] = true;
        }

        if ($this->label !== null) {
            $config['label'] = $this->label;
        }

        if ($this->href !== null) {
            $config['href'] = $this->href;
        }

        return $config;
    }
}
