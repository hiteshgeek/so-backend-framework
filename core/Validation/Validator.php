<?php

namespace Core\Validation;

/**
 * Input Validator
 *
 * Validates form input data against a set of rules
 */
class Validator
{
    protected array $data;
    protected array $rules;
    protected array $errors = [];

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }

    /**
     * Create a new validator instance
     */
    public static function make(array $data, array $rules): self
    {
        return new static($data, $rules);
    }

    /**
     * Run validation and return true if passes
     */
    public function validate(): bool
    {
        foreach ($this->rules as $field => $rules) {
            $ruleList = is_string($rules) ? explode('|', $rules) : $rules;
            $value = $this->data[$field] ?? null;

            $hasRequiredRule = false;
            foreach ($ruleList as $rule) {
                $ruleName = is_string($rule) && str_contains($rule, ':')
                    ? explode(':', $rule)[0]
                    : $rule;

                if ($ruleName === 'required') {
                    $hasRequiredRule = true;
                }
            }

            foreach ($ruleList as $rule) {
                // Skip validation for other rules if field is empty and not required
                $isEmpty = is_null($value) || (is_string($value) && trim($value) === '');

                $ruleName = is_string($rule) && str_contains($rule, ':')
                    ? explode(':', $rule)[0]
                    : $rule;

                if ($isEmpty && $ruleName !== 'required' && !$hasRequiredRule) {
                    continue;
                }

                $this->validateRule($field, $value, $rule);
            }
        }

        return empty($this->errors);
    }

    /**
     * Check if validation fails
     */
    public function fails(): bool
    {
        return !$this->validate();
    }

    /**
     * Get validation errors
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Validate a single rule for a field
     */
    protected function validateRule(string $field, mixed $value, string $rule): void
    {
        // Parse rule and parameters (e.g., "min:3" => rule="min", params=["3"])
        [$ruleName, $params] = $this->parseRule($rule);

        $method = 'validate' . ucfirst($ruleName);

        if (method_exists($this, $method)) {
            $this->$method($field, $value, $params);
        }
    }

    /**
     * Parse a rule string into name and parameters
     */
    protected function parseRule(string $rule): array
    {
        if (str_contains($rule, ':')) {
            [$ruleName, $paramString] = explode(':', $rule, 2);
            $params = explode(',', $paramString);
            return [$ruleName, $params];
        }

        return [$rule, []];
    }

    /**
     * Validate required field
     */
    protected function validateRequired(string $field, mixed $value, array $params): void
    {
        if (is_null($value) || (is_string($value) && trim($value) === '')) {
            $this->errors[$field][] = "The {$field} field is required.";
        }
    }

    /**
     * Validate email format
     */
    protected function validateEmail(string $field, mixed $value, array $params): void
    {
        // Skip if field is empty (let 'required' rule handle that)
        if (is_null($value) || trim((string) $value) === '') {
            return;
        }

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "The {$field} must be a valid email address.";
        }
    }

    /**
     * Validate minimum length
     */
    protected function validateMin(string $field, mixed $value, array $params): void
    {
        $min = (int) ($params[0] ?? 0);

        if ($value && strlen((string) $value) < $min) {
            $this->errors[$field][] = "The {$field} must be at least {$min} characters.";
        }
    }

    /**
     * Validate maximum length
     */
    protected function validateMax(string $field, mixed $value, array $params): void
    {
        $max = (int) ($params[0] ?? 0);

        if ($value && strlen((string) $value) > $max) {
            $this->errors[$field][] = "The {$field} must not exceed {$max} characters.";
        }
    }

    /**
     * Validate field confirmation (e.g., password_confirmation)
     */
    protected function validateConfirmed(string $field, mixed $value, array $params): void
    {
        $confirmField = $field . '_confirmation';
        $confirmValue = $this->data[$confirmField] ?? null;

        if ($value !== $confirmValue) {
            $this->errors[$field][] = "The {$field} confirmation does not match.";
        }
    }

    /**
     * Validate unique value in database table
     */
    protected function validateUnique(string $field, mixed $value, array $params): void
    {
        if (!$value) {
            return;
        }

        $table = $params[0] ?? null;
        $column = $params[1] ?? $field;

        if (!$table) {
            return;
        }

        // Query database for existing record
        $db = app('db');
        $existing = $db->table($table)
            ->where($column, '=', $value)
            ->first();

        if ($existing) {
            $this->errors[$field][] = "The {$field} has already been taken.";
        }
    }
}
