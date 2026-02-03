<?php

namespace Core\UiEngine\Elements\Form;

use Core\UiEngine\Elements\FormElement;
use Core\UiEngine\Support\CssPrefix;

/**
 * SwitchElement - Toggle switch input
 *
 * A styled toggle switch (alternative to checkbox)
 * Named SwitchElement to avoid conflict with PHP's switch keyword
 */
class SwitchElement extends FormElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'switch';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'input';

    /**
     * Checked state
     *
     * @var bool
     */
    protected bool $checked = false;

    /**
     * Switch variant/color
     *
     * @var string
     */
    protected string $variant = 'primary';

    /**
     * Switch size
     *
     * @var string|null
     */
    protected ?string $switchSize = null;

    /**
     * Show on/off labels inside track
     *
     * @var bool
     */
    protected bool $showLabels = false;

    /**
     * Enable icon mode
     *
     * @var bool
     */
    protected bool $iconMode = false;

    /**
     * Enable text mode
     *
     * @var bool
     */
    protected bool $textMode = false;

    /**
     * On label/text
     *
     * @var string
     */
    protected string $onLabel = 'ON';

    /**
     * Off label/text
     *
     * @var string
     */
    protected string $offLabel = 'OFF';

    /**
     * On icon (Material icon name)
     *
     * @var string
     */
    protected string $onIcon = 'check';

    /**
     * Off icon (Material icon name)
     *
     * @var string
     */
    protected string $offIcon = 'close';

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['checked'])) {
            $this->checked = (bool) $config['checked'];
        }

        if (isset($config['variant'])) {
            $this->variant = $config['variant'];
        }

        if (isset($config['switchSize'])) {
            $this->switchSize = $config['switchSize'];
        }

        if (isset($config['showLabels'])) {
            $this->showLabels = (bool) $config['showLabels'];
        }

        if (isset($config['iconMode'])) {
            $this->iconMode = (bool) $config['iconMode'];
        }

        if (isset($config['textMode'])) {
            $this->textMode = (bool) $config['textMode'];
        }

        if (isset($config['onLabel'])) {
            $this->onLabel = $config['onLabel'];
        }

        if (isset($config['offLabel'])) {
            $this->offLabel = $config['offLabel'];
        }

        if (isset($config['onIcon'])) {
            $this->onIcon = $config['onIcon'];
        }

        if (isset($config['offIcon'])) {
            $this->offIcon = $config['offIcon'];
        }
    }

    /**
     * Set checked state
     *
     * @param bool $checked
     * @return static
     */
    public function checked(bool $checked = true): static
    {
        $this->checked = $checked;
        return $this;
    }

    /**
     * Set unchecked state
     *
     * @return static
     */
    public function unchecked(): static
    {
        return $this->checked(false);
    }

    /**
     * Set variant/color
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
     * Alias for variant
     *
     * @param string $color
     * @return static
     */
    public function color(string $color): static
    {
        return $this->variant($color);
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
     * Set switch size
     *
     * @param string $size
     * @return static
     */
    public function size(string $size): static
    {
        $this->switchSize = $size;
        return $this;
    }

    /**
     * Small switch
     *
     * @return static
     */
    public function small(): static
    {
        return $this->size('sm');
    }

    /**
     * Large switch
     *
     * @return static
     */
    public function large(): static
    {
        return $this->size('lg');
    }

    /**
     * Enable icon mode
     *
     * @param bool $enable
     * @return static
     */
    public function icon(bool $enable = true): static
    {
        $this->iconMode = $enable;
        return $this;
    }

    /**
     * Enable text mode
     *
     * @param bool $enable
     * @return static
     */
    public function text(bool $enable = true): static
    {
        $this->textMode = $enable;
        return $this;
    }

    /**
     * Set on icon
     *
     * @param string $icon
     * @return static
     */
    public function onIcon(string $icon): static
    {
        $this->onIcon = $icon;
        $this->iconMode = true;
        return $this;
    }

    /**
     * Set off icon
     *
     * @param string $icon
     * @return static
     */
    public function offIcon(string $icon): static
    {
        $this->offIcon = $icon;
        $this->iconMode = true;
        return $this;
    }

    /**
     * Set on text
     *
     * @param string $text
     * @return static
     */
    public function onText(string $text): static
    {
        $this->onLabel = $text;
        $this->textMode = true;
        return $this;
    }

    /**
     * Set off text
     *
     * @param string $text
     * @return static
     */
    public function offText(string $text): static
    {
        $this->offLabel = $text;
        $this->textMode = true;
        return $this;
    }

    /**
     * Set on/off labels
     *
     * @param string $onLabel
     * @param string $offLabel
     * @return static
     */
    public function labels(string $onLabel, string $offLabel): static
    {
        $this->onLabel = $onLabel;
        $this->offLabel = $offLabel;
        $this->showLabels = true;
        return $this;
    }

    /**
     * Build wrapper CSS classes
     *
     * @return string
     */
    protected function buildWrapperClasses(): string
    {
        $classes = ['so-switch'];

        // Size
        if ($this->switchSize !== null) {
            $classes[] = 'so-switch-' . $this->switchSize;
        }

        // Color variant
        $classes[] = 'so-switch-' . $this->variant;

        // Modes
        if ($this->iconMode) {
            $classes[] = 'so-switch-icon';
        }
        if ($this->textMode) {
            $classes[] = 'so-switch-text';
        }
        if ($this->iconMode && $this->textMode) {
            $classes[] = 'so-switch-icon-text';
        }

        // Disabled
        if ($this->disabled) {
            $classes[] = 'so-disabled';
        }

        return implode(' ', $classes);
    }

    /**
     * Gather all attributes for the input
     *
     * @return array<string, mixed>
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = parent::gatherAllAttributes();

        $attrs['type'] = 'checkbox';

        if ($this->checked) {
            $attrs['checked'] = true;
        }

        return $attrs;
    }

    /**
     * Render the complete element
     *
     * @return string
     */
    public function render(): string
    {
        $wrapperClass = $this->buildWrapperClasses();

        $html = '<label class="' . $wrapperClass . '">';

        // Input (hidden)
        $html .= '<input';
        foreach ($this->gatherAllAttributes() as $key => $value) {
            if ($value === true) {
                $html .= ' ' . $key;
            } elseif ($value !== false && $value !== null) {
                $html .= ' ' . $key . '="' . e($value) . '"';
            }
        }
        $html .= '>';

        // Track with optional inner content
        $html .= '<span class="so-switch-track">';
        if ($this->iconMode || $this->textMode) {
            $html .= '<span class="so-switch-on">';
            if ($this->iconMode) {
                $html .= '<span class="material-icons">' . e($this->onIcon) . '</span>';
            }
            if ($this->textMode) {
                $html .= e($this->onLabel);
            }
            $html .= '</span>';
            $html .= '<span class="so-switch-off">';
            if ($this->textMode) {
                $html .= e($this->offLabel);
            }
            if ($this->iconMode) {
                $html .= '<span class="material-icons">' . e($this->offIcon) . '</span>';
            }
            $html .= '</span>';
        }
        $html .= '</span>';

        // Label
        if ($this->label !== null) {
            $html .= '<span class="so-switch-label">' . e($this->label) . '</span>';
        }

        $html .= '</label>';

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

        if ($this->checked) {
            $config['checked'] = true;
        }

        if ($this->variant !== 'primary') {
            $config['variant'] = $this->variant;
        }

        if ($this->switchSize !== null) {
            $config['switchSize'] = $this->switchSize;
        }

        if ($this->iconMode) {
            $config['iconMode'] = true;
            $config['onIcon'] = $this->onIcon;
            $config['offIcon'] = $this->offIcon;
        }

        if ($this->textMode) {
            $config['textMode'] = true;
            $config['onLabel'] = $this->onLabel;
            $config['offLabel'] = $this->offLabel;
        }

        return $config;
    }
}
