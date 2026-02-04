<?php

namespace Core\UiEngine\Elements\Form;

use Core\UiEngine\Elements\FormElement;
use Core\UiEngine\Support\CssPrefix;

/**
 * Checkbox - Checkbox form element
 *
 * Supports single checkbox and checkbox groups.
 */
class Checkbox extends FormElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'checkbox';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'input';

    /**
     * Whether the checkbox is checked
     *
     * @var bool
     */
    protected bool $checked = false;

    /**
     * Checkbox options (for groups)
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
     * Switch style
     *
     * @var bool
     */
    protected bool $switch = false;

    /**
     * Indeterminate state
     *
     * @var bool
     */
    protected bool $indeterminate = false;

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

        if (isset($config['options'])) {
            $this->options = $config['options'];
        }

        if (isset($config['inline'])) {
            $this->inline = (bool) $config['inline'];
        }

        if (isset($config['switch'])) {
            $this->switch = (bool) $config['switch'];
        }

        if (isset($config['indeterminate'])) {
            $this->indeterminate = (bool) $config['indeterminate'];
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
     * Set unchecked
     *
     * @return static
     */
    public function unchecked(): static
    {
        return $this->checked(false);
    }

    /**
     * Set checkbox options (for groups)
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
     * @param bool $checked
     * @return static
     */
    public function option(string|int $value, string $label, bool $checked = false): static
    {
        $this->options[] = [
            'value' => $value,
            'label' => $label,
            'checked' => $checked,
        ];

        return $this;
    }

    /**
     * Display checkboxes inline
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
     * Use switch style
     *
     * @param bool $switch
     * @return static
     */
    public function switch(bool $switch = true): static
    {
        $this->switch = $switch;
        return $this;
    }

    /**
     * Set indeterminate state
     *
     * @param bool $indeterminate
     * @return static
     */
    public function indeterminate(bool $indeterminate = true): static
    {
        $this->indeterminate = $indeterminate;
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
        // Don't add form-control class for checkboxes
    }

    /**
     * Gather all attributes for the input element
     *
     * @return array<string, mixed>
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = [];

        $attrs['type'] = 'checkbox';

        if ($this->name !== null) {
            $attrs['name'] = $this->name;
        }

        if ($this->id !== null) {
            $attrs['id'] = $this->id;
        }

        if ($this->value !== null) {
            $attrs['value'] = $this->value;
        }

        if ($this->checked) {
            $attrs['checked'] = true;
        }

        if ($this->disabled) {
            $attrs['disabled'] = true;
        }

        if ($this->indeterminate) {
            $attrs[CssPrefix::data('indeterminate')] = 'true';
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
        // If options are set, render as a group
        if (!empty($this->options)) {
            return $this->renderCheckboxGroup();
        }

        // Single checkbox
        return $this->renderSingleCheckbox();
    }

    /**
     * Render a single checkbox using so-checkbox structure
     *
     * @return string
     */
    protected function renderSingleCheckbox(): string
    {
        $labelClass = CssPrefix::cls('checkbox');

        if ($this->disabled) {
            $labelClass .= ' ' . CssPrefix::cls('disabled');
        }

        // Build input attributes
        $attrs = $this->gatherAllAttributes();
        $attrString = $this->buildAttributeString($attrs);

        // Icon for checkbox state
        $icon = $this->indeterminate ? 'remove' : 'check';

        $html = '<label class="' . $labelClass . '">';
        $html .= '<input ' . $attrString . '>';
        $html .= '<span class="' . CssPrefix::cls('checkbox-box') . '">';
        $html .= '<span class="material-icons">' . $icon . '</span>';
        $html .= '</span>';

        if ($this->label !== null) {
            $html .= '<span class="' . CssPrefix::cls('checkbox-label') . '">' . e($this->label) . '</span>';
        }

        $html .= '</label>';

        // Add help text
        if ($this->help !== null) {
            $html .= '<div class="' . CssPrefix::cls('form-text') . '">' . e($this->help) . '</div>';
        }

        // Add error
        if ($this->error !== null) {
            $html .= '<div class="' . CssPrefix::cls('invalid-feedback') . ' ' . CssPrefix::cls('d-block') . '">' . e($this->error) . '</div>';
        }

        return $html;
    }

    /**
     * Render as a checkbox group using so-checkbox-group structure
     *
     * @return string
     */
    protected function renderCheckboxGroup(): string
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

        // Checkbox group wrapper
        $groupClass = CssPrefix::cls('checkbox-group');
        $groupClass .= $this->inline
            ? ' ' . CssPrefix::cls('checkbox-group-inline')
            : ' ' . CssPrefix::cls('checkbox-group-vertical');

        $html .= '<div class="' . $groupClass . '">';

        // Checkboxes
        foreach ($this->options as $index => $option) {
            $value = $option['value'] ?? $index;
            $optionLabel = $option['label'] ?? $value;
            $checked = $option['checked'] ?? $this->isChecked($value);
            $optionDisabled = $option['disabled'] ?? false;
            $isDisabled = $optionDisabled || $this->disabled;

            $labelClass = CssPrefix::cls('checkbox');
            if ($isDisabled) {
                $labelClass .= ' ' . CssPrefix::cls('disabled');
            }

            $html .= '<label class="' . $labelClass . '">';

            // Input
            $html .= '<input type="checkbox"';
            $html .= ' name="' . e($this->name) . '[]"';
            $html .= ' value="' . e($value) . '"';

            if ($checked) {
                $html .= ' checked';
            }

            if ($isDisabled) {
                $html .= ' disabled';
            }

            $html .= '>';

            // Checkbox box with icon
            $html .= '<span class="' . CssPrefix::cls('checkbox-box') . '">';
            $html .= '<span class="material-icons">check</span>';
            $html .= '</span>';

            // Label
            $html .= '<span class="' . CssPrefix::cls('checkbox-label') . '">' . e($optionLabel) . '</span>';

            $html .= '</label>';
        }

        $html .= '</div>'; // End checkbox-group

        // Help text
        if ($this->help !== null) {
            $html .= '<div class="' . CssPrefix::cls('form-text') . '">' . e($this->help) . '</div>';
        }

        // Error
        if ($this->error !== null) {
            $html .= '<div class="' . CssPrefix::cls('invalid-feedback') . ' ' . CssPrefix::cls('d-block') . '">' . e($this->error) . '</div>';
        }

        $html .= '</div>'; // End form-group

        return $html;
    }

    /**
     * Check if a value is checked
     *
     * @param mixed $value
     * @return bool
     */
    protected function isChecked(mixed $value): bool
    {
        if ($this->value === null) {
            return false;
        }

        if (is_array($this->value)) {
            return in_array($value, $this->value, true);
        }

        return (string) $this->value === (string) $value;
    }

    /**
     * Render the form group (override to prevent double label)
     *
     * @return string
     */
    public function renderGroup(): string
    {
        // For checkboxes, render() already handles the full structure
        return $this->render();
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

        if (!empty($this->options)) {
            $config['options'] = $this->options;
        }

        if ($this->inline) {
            $config['inline'] = true;
        }

        if ($this->switch) {
            $config['switch'] = true;
        }

        if ($this->indeterminate) {
            $config['indeterminate'] = true;
        }

        return $config;
    }
}
