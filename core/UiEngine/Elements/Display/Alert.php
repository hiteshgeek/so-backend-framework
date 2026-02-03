<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * Alert - Alert/notification display element
 *
 * Creates SixOrbit-style alert messages with various types, outline styles, sizes, and dismissible options.
 */
class Alert extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'alert';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Alert variant (primary, secondary, success, danger, warning, info, light, dark)
     *
     * @var string
     */
    protected string $variant = 'info';

    /**
     * Alert message
     *
     * @var string|null
     */
    protected ?string $message = null;

    /**
     * Alert title
     *
     * @var string|null
     */
    protected ?string $title = null;

    /**
     * Alert icon
     *
     * @var string|null
     */
    protected ?string $icon = null;

    /**
     * Whether the alert is dismissible
     *
     * @var bool
     */
    protected bool $dismissible = false;

    /**
     * Auto-dismiss after seconds (0 = no auto-dismiss)
     *
     * @var int
     */
    protected int $autoDismiss = 0;

    /**
     * Whether to use outline style
     *
     * @var bool
     */
    protected bool $outline = false;

    /**
     * Whether to use small size
     *
     * @var bool
     */
    protected bool $small = false;

    /**
     * Footer content (with hr separator)
     *
     * @var string|null
     */
    protected ?string $footer = null;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['variant'])) {
            $this->variant = $config['variant'];
        }

        if (isset($config['message'])) {
            $this->message = $config['message'];
        }

        if (isset($config['title'])) {
            $this->title = $config['title'];
        }

        if (isset($config['icon'])) {
            $this->icon = $config['icon'];
        }

        if (isset($config['dismissible'])) {
            $this->dismissible = (bool) $config['dismissible'];
        }

        if (isset($config['autoDismiss'])) {
            $this->autoDismiss = (int) $config['autoDismiss'];
        }

        if (isset($config['outline'])) {
            $this->outline = (bool) $config['outline'];
        }

        if (isset($config['small'])) {
            $this->small = (bool) $config['small'];
        }

        if (isset($config['footer'])) {
            $this->footer = $config['footer'];
        }
    }

    /**
     * Set alert variant
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
        return $this->variant('success')->icon('check_circle');
    }

    /**
     * Danger variant
     *
     * @return static
     */
    public function danger(): static
    {
        return $this->variant('danger')->icon('error');
    }

    /**
     * Warning variant
     *
     * @return static
     */
    public function warning(): static
    {
        return $this->variant('warning')->icon('warning');
    }

    /**
     * Info variant
     *
     * @return static
     */
    public function info(): static
    {
        return $this->variant('info')->icon('info');
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
     * Set alert message
     *
     * @param string $message
     * @return static
     */
    public function message(string $message): static
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Set alert title
     *
     * @param string $title
     * @return static
     */
    public function title(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set alert icon
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
     * Make alert dismissible
     *
     * @param bool $dismissible
     * @return static
     */
    public function dismissible(bool $dismissible = true): static
    {
        $this->dismissible = $dismissible;
        return $this;
    }

    /**
     * Set auto-dismiss time
     *
     * @param int $seconds
     * @return static
     */
    public function autoDismiss(int $seconds): static
    {
        $this->autoDismiss = $seconds;
        return $this;
    }

    /**
     * Set outline style
     *
     * @param bool $outline
     * @return static
     */
    public function outline(bool $outline = true): static
    {
        $this->outline = $outline;
        return $this;
    }

    /**
     * Set small size
     *
     * @param bool $small
     * @return static
     */
    public function small(bool $small = true): static
    {
        $this->small = $small;
        return $this;
    }

    /**
     * Alias for message() - set alert content
     *
     * @param string $content
     * @return static
     */
    public function content(string $content): static
    {
        return $this->message($content);
    }

    /**
     * Set footer content
     *
     * @param string $footer
     * @return static
     */
    public function footer(string $footer): static
    {
        $this->footer = $footer;
        return $this;
    }

    /**
     * Build the CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('alert'));
        $this->addClass(CssPrefix::cls('alert', $this->variant));

        if ($this->dismissible) {
            $this->addClass(CssPrefix::cls('alert-dismissible'));
        }

        if ($this->outline) {
            $this->addClass(CssPrefix::cls('alert-outline'));
        }

        if ($this->small) {
            $this->addClass(CssPrefix::cls('alert-sm'));
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

        $attrs['role'] = 'alert';

        if ($this->autoDismiss > 0) {
            $attrs['data-so-auto-dismiss'] = $this->autoDismiss;
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
        $html = '';

        // Icon (wrapped in so-alert-icon)
        if ($this->icon !== null) {
            $html .= '<span class="' . CssPrefix::cls('alert-icon') . '"><span class="material-icons">' . e($this->icon) . '</span></span>';
        }

        // Content wrapper
        $html .= '<div class="' . CssPrefix::cls('alert-content') . '">';

        // Title
        if ($this->title !== null) {
            $html .= '<strong>' . e($this->title) . '</strong> ';
        }

        // Message
        if ($this->message !== null) {
            $html .= e($this->message);
        }

        // Content from parent (children)
        $html .= parent::renderContent();

        // Footer with hr separator
        if ($this->footer !== null) {
            $html .= '<hr>';
            $html .= '<p class="' . CssPrefix::cls('mb-0') . '">' . $this->footer . '</p>';
        }

        $html .= '</div>'; // Close content wrapper

        // Dismiss button (so-alert-close with icon)
        if ($this->dismissible) {
            $html .= '<button type="button" class="' . CssPrefix::cls('alert-close') . '" data-dismiss="alert" aria-label="Close">';
            $html .= '<span class="material-icons">close</span>';
            $html .= '</button>';
        }

        return $html;
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        $config['variant'] = $this->variant;

        if ($this->message !== null) {
            $config['message'] = $this->message;
        }

        if ($this->title !== null) {
            $config['title'] = $this->title;
        }

        if ($this->icon !== null) {
            $config['icon'] = $this->icon;
        }

        if ($this->dismissible) {
            $config['dismissible'] = true;
        }

        if ($this->autoDismiss > 0) {
            $config['autoDismiss'] = $this->autoDismiss;
        }

        if ($this->outline) {
            $config['outline'] = true;
        }

        if ($this->small) {
            $config['small'] = true;
        }

        if ($this->footer !== null) {
            $config['footer'] = $this->footer;
        }

        return $config;
    }
}
