<?php

namespace Core\UiEngine\Elements;

use Core\UiEngine\Contracts\FormElementInterface;
use Core\UiEngine\Support\CssPrefix;
use Core\UiEngine\Traits\HasValidation;
use Core\UiEngine\Traits\HasEvents;

/**
 * FormElement - Abstract base class for form elements
 *
 * Extends Element with form-specific functionality including
 * name, label, value, validation rules, and event handlers.
 */
abstract class FormElement extends Element implements FormElementInterface
{
    use HasValidation, HasEvents;

    /**
     * Field name attribute
     *
     * @var string|null
     */
    protected ?string $name = null;

    /**
     * Label text
     *
     * @var string|null
     */
    protected ?string $label = null;

    /**
     * Field value
     *
     * @var mixed
     */
    protected mixed $value = null;

    /**
     * Placeholder text
     *
     * @var string|null
     */
    protected ?string $placeholder = null;

    /**
     * Help text displayed below the field
     *
     * @var string|null
     */
    protected ?string $help = null;

    /**
     * Whether the field is disabled
     *
     * @var bool
     */
    protected bool $disabled = false;

    /**
     * Whether the field is readonly
     *
     * @var bool
     */
    protected bool $readonly = false;

    /**
     * Whether the field is required
     *
     * @var bool
     */
    protected bool $isRequired = false;

    /**
     * Error message for this field
     *
     * @var string|null
     */
    protected ?string $error = null;

    /**
     * Whether to show label
     *
     * @var bool
     */
    protected bool $showLabel = true;

    /**
     * Label position (top, left, right, floating)
     *
     * @var string
     */
    protected string $labelPosition = 'top';

    /**
     * Input size variant (sm, md, lg)
     *
     * @var string
     */
    protected string $size = 'md';

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        // Form-specific properties
        if (isset($config['name'])) {
            $this->name = $config['name'];
        }

        if (isset($config['label'])) {
            $this->label = $config['label'];
        }

        if (isset($config['value'])) {
            $this->value = $config['value'];
        }

        if (isset($config['placeholder'])) {
            $this->placeholder = $config['placeholder'];
        }

        if (isset($config['help'])) {
            $this->help = $config['help'];
        }

        if (isset($config['disabled'])) {
            $this->disabled = (bool) $config['disabled'];
        }

        if (isset($config['readonly'])) {
            $this->readonly = (bool) $config['readonly'];
        }

        if (isset($config['required'])) {
            $this->isRequired = (bool) $config['required'];
        }

        if (isset($config['error'])) {
            $this->error = $config['error'];
        }

        if (isset($config['showLabel'])) {
            $this->showLabel = (bool) $config['showLabel'];
        }

        if (isset($config['labelPosition'])) {
            $this->labelPosition = $config['labelPosition'];
        }

        if (isset($config['size'])) {
            $this->size = $config['size'];
        }

        // Validation rules
        if (isset($config['rules'])) {
            $this->rules($config['rules']);
        }

        // Custom validation messages
        if (isset($config['messages'])) {
            $this->messages($config['messages']);
        }

        // Event handlers
        if (isset($config['events']) && is_array($config['events'])) {
            $this->onMany($config['events']);
        }
    }

    /**
     * Get the field name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the field name
     *
     * @param string $name
     * @return static
     */
    public function name(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the label text
     *
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Set the label text
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
     * Get the field value
     *
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Set the field value
     *
     * @param mixed $value
     * @return static
     */
    public function value(mixed $value): static
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get the placeholder text
     *
     * @return string|null
     */
    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    /**
     * Set the placeholder text
     *
     * @param string $placeholder
     * @return static
     */
    public function placeholder(string $placeholder): static
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * Get the help text
     *
     * @return string|null
     */
    public function getHelp(): ?string
    {
        return $this->help;
    }

    /**
     * Set the help text
     *
     * @param string $help
     * @return static
     */
    public function help(string $help): static
    {
        $this->help = $help;
        return $this;
    }

    /**
     * Check if the field is disabled
     *
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * Set the disabled state
     *
     * @param bool $disabled
     * @return static
     */
    public function disabled(bool $disabled = true): static
    {
        $this->disabled = $disabled;
        return $this;
    }

    /**
     * Check if the field is readonly
     *
     * @return bool
     */
    public function isReadonly(): bool
    {
        return $this->readonly;
    }

    /**
     * Set the readonly state
     *
     * @param bool $readonly
     * @return static
     */
    public function readonly(bool $readonly = true): static
    {
        $this->readonly = $readonly;
        return $this;
    }

    /**
     * Check if the field is required
     *
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->isRequired || $this->hasRule('required');
    }

    /**
     * Set the error message
     *
     * @param string|null $error
     * @return static
     */
    public function error(?string $error): static
    {
        $this->error = $error;
        return $this;
    }

    /**
     * Get the error message
     *
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * Check if field has error
     *
     * @return bool
     */
    public function hasError(): bool
    {
        return $this->error !== null;
    }

    /**
     * Set whether to show label
     *
     * @param bool $show
     * @return static
     */
    public function showLabel(bool $show = true): static
    {
        $this->showLabel = $show;
        return $this;
    }

    /**
     * Hide the label
     *
     * @return static
     */
    public function hideLabel(): static
    {
        return $this->showLabel(false);
    }

    /**
     * Set label position
     *
     * @param string $position top|left|right|floating
     * @return static
     */
    public function labelPosition(string $position): static
    {
        $this->labelPosition = $position;
        return $this;
    }

    /**
     * Set input size
     *
     * @param string $size sm|md|lg
     * @return static
     */
    public function size(string $size): static
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Small size shortcut
     *
     * @return static
     */
    public function small(): static
    {
        return $this->size('sm');
    }

    /**
     * Large size shortcut
     *
     * @return static
     */
    public function large(): static
    {
        return $this->size('lg');
    }

    /**
     * Gather all attributes including form-specific ones
     *
     * @return array<string, mixed>
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = parent::gatherAllAttributes();

        // Name attribute
        if ($this->name !== null) {
            $attrs['name'] = $this->name;
        }

        // Value attribute (for input types)
        if ($this->value !== null && $this->shouldRenderValueAttribute()) {
            $attrs['value'] = $this->value;
        }

        // Placeholder
        if ($this->placeholder !== null) {
            $attrs['placeholder'] = $this->placeholder;
        }

        // Disabled state
        if ($this->disabled) {
            $attrs['disabled'] = true;
        }

        // Readonly state
        if ($this->readonly) {
            $attrs['readonly'] = true;
        }

        // Required state
        if ($this->isRequired()) {
            $attrs['required'] = true;
        }

        return $attrs;
    }

    /**
     * Check if value attribute should be rendered
     *
     * Override in subclasses where value is rendered differently (textarea, select)
     *
     * @return bool
     */
    protected function shouldRenderValueAttribute(): bool
    {
        return true;
    }

    /**
     * Build the CSS class string including form-specific classes
     *
     * @return string
     */
    public function buildClassString(): string
    {
        // Add base form control class
        $this->addBaseClasses();

        // Add size class
        if ($this->size !== 'md') {
            $this->addClass(CssPrefix::cls('form-control', $this->size));
        }

        // Add error state class
        if ($this->hasError()) {
            $this->addClass(CssPrefix::cls('is-invalid'));
        }

        return parent::buildClassString();
    }

    /**
     * Add base CSS classes for this element type
     *
     * Override in subclasses to add specific classes
     *
     * @return void
     */
    protected function addBaseClasses(): void
    {
        $this->addClass(CssPrefix::cls('form-control'));
    }

    /**
     * Render the label element
     *
     * @return string
     */
    protected function renderLabel(): string
    {
        if (!$this->showLabel || $this->label === null) {
            return '';
        }

        $labelAttrs = '';
        if ($this->id !== null) {
            $labelAttrs = ' for="' . e($this->id) . '"';
        }

        $requiredMark = $this->isRequired() ? ' <span class="' . CssPrefix::cls('text-danger') . '">*</span>' : '';

        return '<label class="' . CssPrefix::cls('form-label') . '"' . $labelAttrs . '>' . e($this->label) . $requiredMark . '</label>';
    }

    /**
     * Render the help text
     *
     * @return string
     */
    protected function renderHelp(): string
    {
        if ($this->help === null) {
            return '';
        }

        return '<div class="' . CssPrefix::cls('form-text') . '">' . e($this->help) . '</div>';
    }

    /**
     * Render the error message
     *
     * @return string
     */
    protected function renderError(): string
    {
        if ($this->error === null) {
            return '';
        }

        return '<div class="' . CssPrefix::cls('invalid-feedback') . '">' . e($this->error) . '</div>';
    }

    /**
     * Render the complete form group (label + input + help + error)
     *
     * @return string
     */
    public function renderGroup(): string
    {
        $groupClass = CssPrefix::cls('form-group');

        if ($this->labelPosition === 'floating') {
            $groupClass .= ' ' . CssPrefix::cls('form-floating');
        }

        $html = '<div class="' . $groupClass . '">';

        // Label position handling
        if ($this->labelPosition === 'top' || $this->labelPosition === 'left') {
            $html .= $this->renderLabel();
        }

        // The input element
        $html .= $this->render();

        // Floating label comes after input
        if ($this->labelPosition === 'floating') {
            $html .= $this->renderLabel();
        }

        // Label on right
        if ($this->labelPosition === 'right') {
            $html .= $this->renderLabel();
        }

        // Help text and error
        $html .= $this->renderHelp();
        $html .= $this->renderError();

        $html .= '</div>';

        return $html;
    }

    /**
     * Convert to array including form-specific properties
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        // Add form-specific properties
        if ($this->name !== null) {
            $config['name'] = $this->name;
        }

        if ($this->label !== null) {
            $config['label'] = $this->label;
        }

        if ($this->value !== null) {
            $config['value'] = $this->value;
        }

        if ($this->placeholder !== null) {
            $config['placeholder'] = $this->placeholder;
        }

        if ($this->help !== null) {
            $config['help'] = $this->help;
        }

        if ($this->disabled) {
            $config['disabled'] = true;
        }

        if ($this->readonly) {
            $config['readonly'] = true;
        }

        if ($this->isRequired) {
            $config['required'] = true;
        }

        return $config;
    }

    /**
     * Debug output
     *
     * @return array
     */
    public function __debugInfo(): array
    {
        return array_merge(parent::__debugInfo(), [
            'name' => $this->name,
            'label' => $this->label,
            'value' => $this->value,
            'placeholder' => $this->placeholder,
            'help' => $this->help,
            'disabled' => $this->disabled,
            'readonly' => $this->readonly,
            'required' => $this->isRequired,
            'rules' => $this->rules,
            'events' => $this->events,
        ]);
    }
}
