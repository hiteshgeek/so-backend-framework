<?php

namespace Core\UiEngine\Contracts;

/**
 * Interface for form elements (inputs, selects, checkboxes, etc.)
 *
 * Extends ElementInterface with form-specific functionality including
 * validation, events, and form state management.
 */
interface FormElementInterface extends ElementInterface
{
    /**
     * Get the field name
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Set the field name
     *
     * @param string $name
     * @return static
     */
    public function name(string $name): static;

    /**
     * Get the label text
     *
     * @return string|null
     */
    public function getLabel(): ?string;

    /**
     * Set the label text
     *
     * @param string $label
     * @return static
     */
    public function label(string $label): static;

    /**
     * Get the field value
     *
     * @return mixed
     */
    public function getValue(): mixed;

    /**
     * Set the field value
     *
     * @param mixed $value
     * @return static
     */
    public function value(mixed $value): static;

    /**
     * Get the placeholder text
     *
     * @return string|null
     */
    public function getPlaceholder(): ?string;

    /**
     * Set the placeholder text
     *
     * @param string $placeholder
     * @return static
     */
    public function placeholder(string $placeholder): static;

    /**
     * Get help text
     *
     * @return string|null
     */
    public function getHelp(): ?string;

    /**
     * Set help text (displayed below the input)
     *
     * @param string $help
     * @return static
     */
    public function help(string $help): static;

    /**
     * Check if the field is disabled
     *
     * @return bool
     */
    public function isDisabled(): bool;

    /**
     * Set disabled state
     *
     * @param bool $disabled
     * @return static
     */
    public function disabled(bool $disabled = true): static;

    /**
     * Check if the field is readonly
     *
     * @return bool
     */
    public function isReadonly(): bool;

    /**
     * Set readonly state
     *
     * @param bool $readonly
     * @return static
     */
    public function readonly(bool $readonly = true): static;

    /**
     * Check if the field is required
     *
     * @return bool
     */
    public function isRequired(): bool;

    /**
     * Set required state
     *
     * @param bool $required
     * @return static
     */
    public function required(bool $required = true): static;

    /**
     * Get validation rules
     *
     * @return array
     */
    public function getRules(): array;

    /**
     * Check if field has validation rules
     *
     * @return bool
     */
    public function hasRules(): bool;

    /**
     * Set validation rules
     *
     * @param string|array $rules Pipe-separated string or array
     * @return static
     */
    public function rules(string|array $rules): static;

    /**
     * Get custom validation messages
     *
     * @return array
     */
    public function getMessages(): array;

    /**
     * Set custom validation error messages
     *
     * @param array $messages
     * @return static
     */
    public function messages(array $messages): static;

    /**
     * Get event handlers
     *
     * @return array
     */
    public function getEvents(): array;

    /**
     * Set an event handler
     *
     * @param string $event Event name (change, blur, focus, etc.)
     * @param string $handler JS function name or inline code
     * @return static
     */
    public function on(string $event, string $handler): static;

    /**
     * Set change event handler
     *
     * @param string $handler
     * @return static
     */
    public function onChange(string $handler): static;

    /**
     * Set blur event handler
     *
     * @param string $handler
     * @return static
     */
    public function onBlur(string $handler): static;

    /**
     * Set focus event handler
     *
     * @param string $handler
     * @return static
     */
    public function onFocus(string $handler): static;

    /**
     * Set input event handler
     *
     * @param string $handler
     * @return static
     */
    public function onInput(string $handler): static;
}
