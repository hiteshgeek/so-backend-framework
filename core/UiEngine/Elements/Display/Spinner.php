<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * Spinner - Loading spinner
 *
 * Displays a loading indicator
 */
class Spinner extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'spinner';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Spinner variant
     *
     * @var string
     */
    protected string $variant = 'primary';

    /**
     * Spinner type (border or grow)
     *
     * @var string
     */
    protected string $spinnerType = 'border';

    /**
     * Spinner size
     *
     * @var string|null
     */
    protected ?string $spinnerSize = null;

    /**
     * Screen reader text
     *
     * @var string
     */
    protected string $srText = 'Loading...';

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

        if (isset($config['spinnerType'])) {
            $this->spinnerType = $config['spinnerType'];
        }

        if (isset($config['size'])) {
            $this->spinnerSize = $config['size'];
        }

        if (isset($config['srText'])) {
            $this->srText = $config['srText'];
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
     * Set spinner type
     *
     * @param string $type
     * @return static
     */
    public function spinnerType(string $type): static
    {
        $this->spinnerType = $type;
        return $this;
    }

    /**
     * Border spinner type
     *
     * @return static
     */
    public function border(): static
    {
        return $this->spinnerType('border');
    }

    /**
     * Grow spinner type
     *
     * @return static
     */
    public function grow(): static
    {
        return $this->spinnerType('grow');
    }

    /**
     * Set size
     *
     * @param string $size
     * @return static
     */
    public function size(string $size): static
    {
        $this->spinnerSize = $size;
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
     * Set screen reader text
     *
     * @param string $text
     * @return static
     */
    public function srText(string $text): static
    {
        $this->srText = $text;
        return $this;
    }

    /**
     * Build CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('spinner', $this->spinnerType));
        $this->addClass(CssPrefix::cls('text', $this->variant));

        if ($this->spinnerSize !== null) {
            $this->addClass(CssPrefix::cls('spinner', $this->spinnerType, $this->spinnerSize));
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
        $attrs['role'] = 'status';
        return $attrs;
    }

    /**
     * Render content
     *
     * @return string
     */
    public function renderContent(): string
    {
        return '<span class="' . CssPrefix::cls('visually-hidden') . '">' . e($this->srText) . '</span>';
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        if ($this->variant !== 'primary') {
            $config['variant'] = $this->variant;
        }

        if ($this->spinnerType !== 'border') {
            $config['spinnerType'] = $this->spinnerType;
        }

        if ($this->spinnerSize !== null) {
            $config['size'] = $this->spinnerSize;
        }

        if ($this->srText !== 'Loading...') {
            $config['srText'] = $this->srText;
        }

        return $config;
    }
}
