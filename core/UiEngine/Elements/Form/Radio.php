<?php

namespace Core\UiEngine\Elements\Form;

use Core\UiEngine\Elements\FormElement;
use Core\UiEngine\Support\CssPrefix;

/**
 * Radio - Radio button form element
 *
 * Supports radio button groups.
 */
class Radio extends FormElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'radio';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'input';

    /**
     * Radio options
     *
     * @var array
     */
    protected array $options = [];

    /**
     * Display inline
     *
     * @var bool
     */
    protected bool $inline = false;

    /**
     * Button style (toggle buttons)
     *
     * @var bool
     */
    protected bool $buttonStyle = false;

    /**
     * Button variant (for button style)
     *
     * @var string
     */
    protected string $buttonVariant = 'outline-primary';

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['options'])) {
            $this->options = $config['options'];
        }

        if (isset($config['inline'])) {
            $this->inline = (bool) $config['inline'];
        }

        if (isset($config['buttonStyle'])) {
            $this->buttonStyle = (bool) $config['buttonStyle'];
        }

        if (isset($config['buttonVariant'])) {
            $this->buttonVariant = $config['buttonVariant'];
        }
    }

    /**
     * Set radio options
     *
     * @param array $options
     * @return static
     */
    public function options(array $options): static
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Add a single option
     *
     * @param string|int $value
     * @param string $label
     * @return static
     */
    public function option(string|int $value, string $label): static
    {
        $this->options[] = [
            'value' => $value,
            'label' => $label,
        ];

        return $this;
    }

    /**
     * Display radios inline
     *
     * @param bool $inline
     * @return static
     */
    public function inline(bool $inline = true): static
    {
        $this->inline = $inline;
        return $this;
    }

    /**
     * Use button style (toggle buttons)
     *
     * @param bool $buttonStyle
     * @return static
     */
    public function buttonStyle(bool $buttonStyle = true): static
    {
        $this->buttonStyle = $buttonStyle;
        return $this;
    }

    /**
     * Set button variant (for button style)
     *
     * @param string $variant
     * @return static
     */
    public function buttonVariant(string $variant): static
    {
        $this->buttonVariant = $variant;
        return $this;
    }

    /**
     * Check if value attribute should be rendered
     *
     * @return bool
     */
    protected function shouldRenderValueAttribute(): bool
    {
        return true;
    }

    /**
     * Add base CSS classes
     *
     * @return void
     */
    protected function addBaseClasses(): void
    {
        if ($this->buttonStyle) {
            $this->addClass(CssPrefix::cls('btn-check'));
        }
        // Standard radio uses wrapper label pattern, no input class needed
    }

    /**
     * Render the complete element
     *
     * @return string
     */
    public function render(): string
    {
        $html = '<div class="' . CssPrefix::cls('form-group') . '">';

        // Group label
        if ($this->label !== null) {
            $html .= '<label class="' . CssPrefix::cls('form-label') . ' ' . CssPrefix::cls('mb-2') . '">' . e($this->label);
            if ($this->isRequired()) {
                $html .= ' <span class="' . CssPrefix::cls('text-danger') . '">*</span>';
            }
            $html .= '</label>';
        }

        // Button group wrapper for button style
        if ($this->buttonStyle) {
            $html .= '<div class="' . CssPrefix::cls('btn-group') . '" role="group">';
        } else {
            // Radio group wrapper
            $groupClass = CssPrefix::cls('radio-group');
            $groupClass .= $this->inline
                ? ' ' . CssPrefix::cls('radio-group-inline')
                : ' ' . CssPrefix::cls('radio-group-vertical');
            $html .= '<div class="' . $groupClass . '">';
        }

        // Radio buttons
        foreach ($this->options as $index => $option) {
            $value = $option['value'] ?? $index;
            $label = $option['label'] ?? $value;
            $disabled = $option['disabled'] ?? false;

            $optionId = $this->id ? $this->id . '_' . $index : $this->name . '_' . $index;
            $checked = $this->isSelected($value);

            if ($this->buttonStyle) {
                $html .= $this->renderButtonOption($optionId, $value, $label, $checked, $disabled);
            } else {
                $html .= $this->renderStandardOption($optionId, $value, $label, $checked, $disabled);
            }
        }

        // Close group wrapper
        $html .= '</div>';

        // Help text
        if ($this->help !== null) {
            $html .= '<div class="' . CssPrefix::cls('form-text') . '">' . e($this->help) . '</div>';
        }

        // Error
        if ($this->error !== null) {
            $html .= '<div class="' . CssPrefix::cls('invalid-feedback') . ' ' . CssPrefix::cls('d-block') . '">' . e($this->error) . '</div>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Render a standard radio option
     *
     * @param string $id
     * @param mixed $value
     * @param string $label
     * @param bool $checked
     * @param bool $disabled
     * @return string
     */
    protected function renderStandardOption(
        string $id,
        mixed $value,
        string $label,
        bool $checked,
        bool $disabled
    ): string {
        // Wrapper label with so-radio class
        $labelClass = CssPrefix::cls('radio');
        if ($disabled || $this->disabled) {
            $labelClass .= ' ' . CssPrefix::cls('disabled');
        }
        if ($this->error !== null) {
            $labelClass .= ' ' . CssPrefix::cls('is-invalid');
        }

        $html = '<label class="' . $labelClass . '">';

        // Hidden input
        $inputAttrs = 'type="radio"';
        $inputAttrs .= ' name="' . e($this->name) . '"';
        $inputAttrs .= ' value="' . e($value) . '"';

        if ($checked) {
            $inputAttrs .= ' checked';
        }

        if ($disabled || $this->disabled) {
            $inputAttrs .= ' disabled';
        }

        if ($this->isRequired()) {
            $inputAttrs .= ' required';
        }

        $html .= '<input ' . $inputAttrs . '>';

        // Visual circle indicator
        $html .= '<span class="' . CssPrefix::cls('radio-circle') . '"></span>';

        // Label text
        $html .= '<span class="' . CssPrefix::cls('radio-label') . '">' . e($label) . '</span>';

        $html .= '</label>';

        return $html;
    }

    /**
     * Render a button-style radio option
     *
     * @param string $id
     * @param mixed $value
     * @param string $label
     * @param bool $checked
     * @param bool $disabled
     * @return string
     */
    protected function renderButtonOption(
        string $id,
        mixed $value,
        string $label,
        bool $checked,
        bool $disabled
    ): string {
        $html = '';

        // Input (hidden visually)
        $inputAttrs = 'type="radio"';
        $inputAttrs .= ' class="' . CssPrefix::cls('btn-check') . '"';
        $inputAttrs .= ' name="' . e($this->name) . '"';
        $inputAttrs .= ' id="' . e($id) . '"';
        $inputAttrs .= ' value="' . e($value) . '"';
        $inputAttrs .= ' autocomplete="off"';

        if ($checked) {
            $inputAttrs .= ' checked';
        }

        if ($disabled || $this->disabled) {
            $inputAttrs .= ' disabled';
        }

        $html .= '<input ' . $inputAttrs . '>';

        // Label as button
        $html .= '<label class="' . CssPrefix::cls('btn') . ' ' . CssPrefix::cls('btn', $this->buttonVariant) . '" for="' . e($id) . '">'
            . e($label) . '</label>';

        return $html;
    }

    /**
     * Check if a value is selected
     *
     * @param mixed $value
     * @return bool
     */
    protected function isSelected(mixed $value): bool
    {
        if ($this->value === null) {
            return false;
        }

        return (string) $this->value === (string) $value;
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        if (!empty($this->options)) {
            $config['options'] = $this->options;
        }

        if ($this->inline) {
            $config['inline'] = true;
        }

        if ($this->buttonStyle) {
            $config['buttonStyle'] = true;
            $config['buttonVariant'] = $this->buttonVariant;
        }

        return $config;
    }
}
