<?php

namespace Core\UiEngine\Traits;

/**
 * Trait for managing validation rules on form elements
 *
 * Provides methods for setting validation rules and custom error messages
 * that can be exported to JavaScript for client-side validation.
 */
trait HasValidation
{
    /**
     * Validation rules
     *
     * @var array<string, mixed>
     */
    protected array $validationRules = [];

    /**
     * Custom validation error messages
     *
     * @var array<string, string>
     */
    protected array $validationMessages = [];

    /**
     * Set validation rules
     *
     * @param string|array $rules Pipe-separated string or array
     * @return static
     */
    public function rules(string|array $rules): static
    {
        if (is_string($rules)) {
            $rules = $this->parseRuleString($rules);
        }

        $this->validationRules = array_merge($this->validationRules, $rules);

        return $this;
    }

    /**
     * Add a single validation rule
     *
     * @param string $rule Rule name
     * @param mixed $params Rule parameters (optional)
     * @return static
     */
    public function addRule(string $rule, mixed $params = true): static
    {
        $this->validationRules[$rule] = $params;
        return $this;
    }

    /**
     * Remove a validation rule
     *
     * @param string $rule
     * @return static
     */
    public function removeRule(string $rule): static
    {
        unset($this->validationRules[$rule]);
        return $this;
    }

    /**
     * Check if a specific rule exists
     *
     * @param string $rule
     * @return bool
     */
    public function hasRule(string $rule): bool
    {
        return isset($this->validationRules[$rule]);
    }

    /**
     * Get validation rules
     *
     * @return array<string, mixed>
     */
    public function getRules(): array
    {
        return $this->validationRules;
    }

    /**
     * Check if field has any validation rules
     *
     * @return bool
     */
    public function hasRules(): bool
    {
        return !empty($this->validationRules);
    }

    /**
     * Clear all validation rules
     *
     * @return static
     */
    public function clearRules(): static
    {
        $this->validationRules = [];
        return $this;
    }

    /**
     * Set custom validation error messages
     *
     * @param array<string, string> $messages Map of rule => message
     * @return static
     */
    public function messages(array $messages): static
    {
        $this->validationMessages = array_merge($this->validationMessages, $messages);
        return $this;
    }

    /**
     * Set a single custom error message
     *
     * @param string $rule Rule name
     * @param string $message Error message
     * @return static
     */
    public function message(string $rule, string $message): static
    {
        $this->validationMessages[$rule] = $message;
        return $this;
    }

    /**
     * Get custom validation messages
     *
     * @return array<string, string>
     */
    public function getMessages(): array
    {
        return $this->validationMessages;
    }

    /**
     * Get message for a specific rule
     *
     * @param string $rule
     * @return string|null
     */
    public function getMessage(string $rule): ?string
    {
        return $this->validationMessages[$rule] ?? null;
    }

    /**
     * Parse pipe-separated rule string into array
     *
     * @param string $rules e.g., "required|email|max:255"
     * @return array<string, mixed>
     */
    protected function parseRuleString(string $rules): array
    {
        $parsed = [];

        foreach (explode('|', $rules) as $rule) {
            $rule = trim($rule);
            if ($rule === '') {
                continue;
            }

            if (str_contains($rule, ':')) {
                [$name, $params] = explode(':', $rule, 2);
                // Handle comma-separated params (e.g., between:1,100)
                $parsed[$name] = str_contains($params, ',')
                    ? array_map('trim', explode(',', $params))
                    : $params;
            } else {
                $parsed[$rule] = true;
            }
        }

        return $parsed;
    }

    /**
     * Convert rules back to pipe-separated string
     *
     * @return string
     */
    public function rulesToString(): string
    {
        $parts = [];

        foreach ($this->validationRules as $rule => $params) {
            if ($params === true) {
                $parts[] = $rule;
            } elseif (is_array($params)) {
                $parts[] = $rule . ':' . implode(',', $params);
            } else {
                $parts[] = $rule . ':' . $params;
            }
        }

        return implode('|', $parts);
    }

    /**
     * Export validation rules for JavaScript
     *
     * @return array
     */
    public function exportValidation(): array
    {
        return [
            'rules' => $this->validationRules,
            'messages' => $this->validationMessages,
        ];
    }

    // ==================
    // Convenience methods for common rules
    // ==================

    /**
     * Add required rule
     *
     * @param bool $required Whether field is required
     * @return static
     */
    public function required(bool $required = true): static
    {
        if ($required) {
            $this->addRule('required');
        } else {
            $this->removeRule('required');
        }

        return $this;
    }

    /**
     * Add email rule
     *
     * @param string|null $message
     * @return static
     */
    public function email(?string $message = null): static
    {
        $this->addRule('email');

        if ($message) {
            $this->message('email', $message);
        }

        return $this;
    }

    /**
     * Add min length/value rule
     *
     * @param int $min
     * @param string|null $message
     * @return static
     */
    public function min(int $min, ?string $message = null): static
    {
        $this->addRule('min', $min);

        if ($message) {
            $this->message('min', $message);
        }

        return $this;
    }

    /**
     * Add max length/value rule
     *
     * @param int $max
     * @param string|null $message
     * @return static
     */
    public function max(int $max, ?string $message = null): static
    {
        $this->addRule('max', $max);

        if ($message) {
            $this->message('max', $message);
        }

        return $this;
    }

    /**
     * Add between rule
     *
     * @param int $min
     * @param int $max
     * @param string|null $message
     * @return static
     */
    public function between(int $min, int $max, ?string $message = null): static
    {
        $this->addRule('between', [$min, $max]);

        if ($message) {
            $this->message('between', $message);
        }

        return $this;
    }

    /**
     * Add numeric rule
     *
     * @param string|null $message
     * @return static
     */
    public function numeric(?string $message = null): static
    {
        $this->addRule('numeric');

        if ($message) {
            $this->message('numeric', $message);
        }

        return $this;
    }

    /**
     * Add integer rule
     *
     * @param string|null $message
     * @return static
     */
    public function integer(?string $message = null): static
    {
        $this->addRule('integer');

        if ($message) {
            $this->message('integer', $message);
        }

        return $this;
    }

    /**
     * Add URL rule
     *
     * @param string|null $message
     * @return static
     */
    public function url(?string $message = null): static
    {
        $this->addRule('url');

        if ($message) {
            $this->message('url', $message);
        }

        return $this;
    }

    /**
     * Add regex pattern rule
     *
     * @param string $pattern
     * @param string|null $message
     * @return static
     */
    public function pattern(string $pattern, ?string $message = null): static
    {
        $this->addRule('regex', $pattern);

        if ($message) {
            $this->message('regex', $message);
        }

        return $this;
    }

    /**
     * Add "in" rule (value must be in list)
     *
     * @param array $values
     * @param string|null $message
     * @return static
     */
    public function in(array $values, ?string $message = null): static
    {
        $this->addRule('in', $values);

        if ($message) {
            $this->message('in', $message);
        }

        return $this;
    }

    /**
     * Add confirmed rule (for password confirmation)
     *
     * @param string|null $message
     * @return static
     */
    public function confirmed(?string $message = null): static
    {
        $this->addRule('confirmed');

        if ($message) {
            $this->message('confirmed', $message);
        }

        return $this;
    }

    /**
     * Add unique rule
     *
     * @param string $table
     * @param string|null $column
     * @param int|null $exceptId
     * @param string|null $message
     * @return static
     */
    public function unique(string $table, ?string $column = null, ?int $exceptId = null, ?string $message = null): static
    {
        $params = [$table];

        if ($column) {
            $params[] = $column;
        }

        if ($exceptId) {
            $params[] = $exceptId;
        }

        $this->addRule('unique', $params);

        if ($message) {
            $this->message('unique', $message);
        }

        return $this;
    }
}
