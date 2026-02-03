<?php

namespace Core\UiEngine\Elements\Form;

use Core\UiEngine\Elements\FormElement;
use Core\UiEngine\Support\CssPrefix;

/**
 * Select - Dropdown select form element
 *
 * Supports single and multiple selection with option groups.
 */
class Select extends FormElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'select';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'select';

    /**
     * Select options
     *
     * @var array
     */
    protected array $options = [];

    /**
     * Whether multiple selection is allowed
     *
     * @var bool
     */
    protected bool $multiple = false;

    /**
     * Visible size (number of visible options)
     *
     * @var int|null
     */
    protected ?int $visibleSize = null;

    /**
     * Empty/placeholder option text
     *
     * @var string|null
     */
    protected ?string $emptyOption = null;

    /**
     * Empty option value
     *
     * @var string
     */
    protected string $emptyValue = '';

    /**
     * Whether options are searchable (for JS enhancement)
     *
     * @var bool
     */
    protected bool $searchable = false;

    /**
     * Whether to use enhanced SOSelect component
     *
     * @var bool
     */
    protected bool $enhanced = false;

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

        if (isset($config['multiple'])) {
            $this->multiple = (bool) $config['multiple'];
        }

        if (isset($config['visibleSize'])) {
            $this->visibleSize = (int) $config['visibleSize'];
        }

        if (isset($config['emptyOption'])) {
            $this->emptyOption = $config['emptyOption'];
        }

        if (isset($config['emptyValue'])) {
            $this->emptyValue = $config['emptyValue'];
        }

        if (isset($config['searchable'])) {
            $this->searchable = (bool) $config['searchable'];
        }

        if (isset($config['enhanced'])) {
            $this->enhanced = (bool) $config['enhanced'];
        }
    }

    /**
     * Set select options
     *
     * @param array $options Array of value => label or ['value' => x, 'label' => y] arrays
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
     * @param bool $disabled
     * @return static
     */
    public function option(string|int $value, string $label, bool $disabled = false): static
    {
        $opt = ['value' => $value, 'label' => $label];

        if ($disabled) {
            $opt['disabled'] = true;
        }

        $this->options[] = $opt;
        return $this;
    }

    /**
     * Add an option group
     *
     * @param string $label Group label
     * @param array $options Options in the group
     * @return static
     */
    public function optgroup(string $label, array $options): static
    {
        $this->options[] = [
            'label' => $label,
            'options' => $options,
        ];

        return $this;
    }

    /**
     * Enable multiple selection
     *
     * @param bool $multiple
     * @return static
     */
    public function multiple(bool $multiple = true): static
    {
        $this->multiple = $multiple;
        return $this;
    }

    /**
     * Set visible size
     *
     * @param int $size
     * @return static
     */
    public function visibleSize(int $size): static
    {
        $this->visibleSize = $size;
        return $this;
    }

    /**
     * Set empty/placeholder option
     *
     * @param string $text
     * @param string $value
     * @return static
     */
    public function emptyOption(string $text, string $value = ''): static
    {
        $this->emptyOption = $text;
        $this->emptyValue = $value;
        return $this;
    }

    /**
     * Enable searchable mode (for JS enhancement)
     *
     * @param bool $searchable
     * @return static
     */
    public function searchable(bool $searchable = true): static
    {
        $this->searchable = $searchable;
        return $this;
    }

    /**
     * Enable enhanced SOSelect component
     *
     * Adds data-so-select attribute to trigger JS enhancement
     *
     * @param bool $enhanced
     * @return static
     */
    public function enhanced(bool $enhanced = true): static
    {
        $this->enhanced = $enhanced;
        return $this;
    }

    /**
     * Check if value attribute should be rendered
     *
     * @return bool
     */
    protected function shouldRenderValueAttribute(): bool
    {
        return false; // Select doesn't use value attribute
    }

    /**
     * Add base CSS classes
     *
     * @return void
     */
    protected function addBaseClasses(): void
    {
        $this->addClass(CssPrefix::cls('form-control'));
    }

    /**
     * Gather all attributes
     *
     * @return array<string, mixed>
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = parent::gatherAllAttributes();

        if ($this->multiple) {
            $attrs['multiple'] = true;
        }

        if ($this->visibleSize !== null) {
            $attrs['size'] = $this->visibleSize;
        }

        if ($this->searchable) {
            $attrs[CssPrefix::data('searchable')] = 'true';
        }

        if ($this->enhanced) {
            $attrs[CssPrefix::data('select')] = true;
        }

        return $attrs;
    }

    /**
     * Render the content (options)
     *
     * @return string
     */
    public function renderContent(): string
    {
        $html = '';

        // Render empty option first
        if ($this->emptyOption !== null) {
            $selected = $this->isSelected($this->emptyValue) ? ' selected' : '';
            $html .= '<option value="' . e($this->emptyValue) . '"' . $selected . '>' . e($this->emptyOption) . '</option>';
        }

        // Render options
        $html .= $this->renderOptions($this->options);

        return $html;
    }

    /**
     * Render options array
     *
     * @param array $options
     * @return string
     */
    protected function renderOptions(array $options): string
    {
        $html = '';

        foreach ($options as $key => $option) {
            if (is_array($option)) {
                if (isset($option['options'])) {
                    // Option group
                    $html .= $this->renderOptgroup($option);
                } else {
                    // Structured option: ['value' => x, 'label' => y]
                    $html .= $this->renderOption($option);
                }
            } else {
                // Simple value => label format
                $html .= $this->renderOption([
                    'value' => $key,
                    'label' => $option,
                ]);
            }
        }

        return $html;
    }

    /**
     * Render a single option
     *
     * @param array $option
     * @return string
     */
    protected function renderOption(array $option): string
    {
        $value = $option['value'] ?? '';
        $label = $option['label'] ?? $value;
        $disabled = $option['disabled'] ?? false;

        $attrs = 'value="' . e($value) . '"';

        if ($this->isSelected($value)) {
            $attrs .= ' selected';
        }

        if ($disabled) {
            $attrs .= ' disabled';
        }

        return '<option ' . $attrs . '>' . e($label) . '</option>';
    }

    /**
     * Render an option group
     *
     * @param array $group
     * @return string
     */
    protected function renderOptgroup(array $group): string
    {
        $label = $group['label'] ?? '';
        $options = $group['options'] ?? [];
        $disabled = $group['disabled'] ?? false;

        $attrs = 'label="' . e($label) . '"';

        if ($disabled) {
            $attrs .= ' disabled';
        }

        return '<optgroup ' . $attrs . '>' . $this->renderOptions($options) . '</optgroup>';
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

        if ($this->multiple && is_array($this->value)) {
            return in_array($value, $this->value, true);
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

        if ($this->multiple) {
            $config['multiple'] = true;
        }

        if ($this->visibleSize !== null) {
            $config['visibleSize'] = $this->visibleSize;
        }

        if ($this->emptyOption !== null) {
            $config['emptyOption'] = $this->emptyOption;
            $config['emptyValue'] = $this->emptyValue;
        }

        if ($this->searchable) {
            $config['searchable'] = true;
        }

        if ($this->enhanced) {
            $config['enhanced'] = true;
        }

        return $config;
    }
}
