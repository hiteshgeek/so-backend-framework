<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * Toast - Toast notification
 *
 * Provides toast/snackbar notifications with auto-dismiss
 */
class Toast extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'toast';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Toast variant
     *
     * @var string
     */
    protected string $variant = 'default';

    /**
     * Toast message
     *
     * @var string|null
     */
    protected ?string $message = null;

    /**
     * Toast title
     *
     * @var string|null
     */
    protected ?string $title = null;

    /**
     * Toast icon
     *
     * @var string|null
     */
    protected ?string $icon = null;

    /**
     * Show dismiss button
     *
     * @var bool
     */
    protected bool $dismissible = true;

    /**
     * Auto-dismiss delay in milliseconds
     *
     * @var int
     */
    protected int $autoDismiss = 5000;

    /**
     * Toast position
     *
     * @var string
     */
    protected string $position = 'top-right';

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

        if (isset($config['position'])) {
            $this->position = $config['position'];
        }
    }

    /**
     * Set variant
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
     * Set message
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
     * Set title
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
     * Set icon
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
     * Set dismissible
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
     * Set auto-dismiss delay
     *
     * @param int $ms
     * @return static
     */
    public function autoDismiss(int $ms): static
    {
        $this->autoDismiss = $ms;
        return $this;
    }

    /**
     * Disable auto-dismiss
     *
     * @return static
     */
    public function persistent(): static
    {
        return $this->autoDismiss(0);
    }

    /**
     * Set position
     *
     * @param string $position
     * @return static
     */
    public function position(string $position): static
    {
        $this->position = $position;
        return $this;
    }

    /**
     * Build CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('toast'));
        $this->addClass(CssPrefix::cls('fade'));
        $this->addClass(CssPrefix::cls('show'));

        if ($this->variant !== 'default') {
            $this->addClass(CssPrefix::cls('toast', $this->variant));
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
        $attrs['aria-live'] = 'assertive';
        $attrs['aria-atomic'] = 'true';
        $attrs[CssPrefix::data('autohide')] = $this->autoDismiss > 0 ? 'true' : 'false';
        $attrs[CssPrefix::data('delay')] = $this->autoDismiss;
        $attrs[CssPrefix::data('ui-init')] = 'toast';

        $config = [
            'autoDismiss' => $this->autoDismiss,
            'position' => $this->position,
        ];
        $attrs[CssPrefix::data('ui-config')] = htmlspecialchars(json_encode($config), ENT_QUOTES);

        return $attrs;
    }

    /**
     * Render content
     *
     * @return string
     */
    public function renderContent(): string
    {
        $html = '<div class="' . CssPrefix::cls('toast-header') . '">';

        if ($this->icon !== null) {
            $html .= '<span class="material-icons ' . CssPrefix::cls('me-2') . '">' . e($this->icon) . '</span>';
        }

        if ($this->title !== null) {
            $html .= '<strong class="' . CssPrefix::cls('me-auto') . '">' . e($this->title) . '</strong>';
        }

        if ($this->dismissible) {
            $html .= '<button type="button" class="' . CssPrefix::cls('btn-close') . '" ' . CssPrefix::data('dismiss') . '="toast" aria-label="Close"></button>';
        }

        $html .= '</div>';
        $html .= '<div class="' . CssPrefix::cls('toast-body') . '">';

        if ($this->message !== null) {
            $html .= e($this->message);
        }

        $html .= parent::renderContent();
        $html .= '</div>';

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

        if ($this->variant !== 'default') {
            $config['variant'] = $this->variant;
        }

        if ($this->message !== null) {
            $config['message'] = $this->message;
        }

        if ($this->title !== null) {
            $config['title'] = $this->title;
        }

        if ($this->icon !== null) {
            $config['icon'] = $this->icon;
        }

        if (!$this->dismissible) {
            $config['dismissible'] = false;
        }

        if ($this->autoDismiss !== 5000) {
            $config['autoDismiss'] = $this->autoDismiss;
        }

        if ($this->position !== 'top-right') {
            $config['position'] = $this->position;
        }

        return $config;
    }
}
