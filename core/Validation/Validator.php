<?php

namespace Core\Validation;

/**
 * Validator
 *
 * Validates data against a set of rules with automatic error message generation.
 * Supports 15+ built-in rules and custom rule extensions.
 *
 * Usage:
 *   $validator = new Validator($data, [
 *       'email' => ['required', 'email'],
 *       'password' => ['required', 'min:8'],
 *   ]);
 *
 *   $validated = $validator->validate(); // Throws ValidationException on failure
 *   // OR
 *   if ($validator->fails()) {
 *       $errors = $validator->errors();
 *   }
 */
class Validator
{
    /**
     * Data to validate
     */
    protected array $data;

    /**
     * Validation rules
     */
    protected array $rules;

    /**
     * Custom error messages
     */
    protected array $customMessages;

    /**
     * Validation errors
     */
    protected array $errors = [];

    /**
     * Expanded rules after wildcard resolution.
     * Populated during validate() so that validated() can use concrete keys.
     */
    protected array $expandedRules = [];

    /**
     * Default error messages
     */
    protected array $messages = [
        'required' => 'The :attribute field is required.',
        'required_if' => 'The :attribute field is required when :other is :value.',
        'required_with' => 'The :attribute field is required when :values is present.',
        'email' => 'The :attribute must be a valid email address.',
        'url' => 'The :attribute must be a valid URL.',
        'ip' => 'The :attribute must be a valid IP address.',
        'alpha' => 'The :attribute may only contain letters.',
        'alpha_num' => 'The :attribute may only contain letters and numbers.',
        'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
        'numeric' => 'The :attribute must be a number.',
        'integer' => 'The :attribute must be an integer.',
        'string' => 'The :attribute must be a string.',
        'array' => 'The :attribute must be an array.',
        'boolean' => 'The :attribute must be true or false.',
        'min' => 'The :attribute must be at least :min.',
        'max' => 'The :attribute may not be greater than :max.',
        'between' => 'The :attribute must be between :min and :max.',
        'in' => 'The selected :attribute is invalid.',
        'not_in' => 'The selected :attribute is invalid.',
        'same' => 'The :attribute and :other must match.',
        'different' => 'The :attribute and :other must be different.',
        'confirmed' => 'The :attribute confirmation does not match.',
        'date' => 'The :attribute is not a valid date.',
        'before' => 'The :attribute must be a date before :date.',
        'after' => 'The :attribute must be a date after :date.',
        'unique' => 'The :attribute has already been taken.',
        'exists' => 'The selected :attribute is invalid.',
    ];

    /**
     * Constructor
     *
     * @param array $data Data to validate
     * @param array $rules Validation rules
     * @param array $customMessages Custom error messages
     */
    public function __construct(array $data, array $rules, array $customMessages = [])
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->customMessages = $customMessages;
    }

    /**
     * Create a new validator instance (static factory method)
     *
     * @param array $data Data to validate
     * @param array $rules Validation rules
     * @param array $customMessages Custom error messages
     * @return static
     */
    public static function make(array $data, array $rules, array $customMessages = []): static
    {
        return new static($data, $rules, $customMessages);
    }

    /**
     * Validate the data
     *
     * Supports flat keys ('email'), dot-notation keys ('user.email'),
     * and wildcard keys ('items.*.name').  Wildcard rules are expanded
     * into concrete indexed rules before validation begins, so error
     * keys always use concrete dot-notation paths.
     *
     * @return array Validated data
     * @throws ValidationException
     */
    public function validate(): array
    {
        // Run validation if not yet executed
        if (empty($this->expandedRules)) {
            $this->runValidation();
        }

        if ($this->fails()) {
            throw new ValidationException($this->errors);
        }

        return $this->validated();
    }

    /**
     * Check if validation has failed
     *
     * @return bool
     */
    public function fails(): bool
    {
        // Run validation if not yet executed
        if (empty($this->expandedRules)) {
            $this->runValidation();
        }

        return !empty($this->errors);
    }

    /**
     * Check if validation passed
     *
     * @return bool
     */
    public function passes(): bool
    {
        return !$this->fails();
    }

    /**
     * Run validation without throwing exception
     *
     * @return void
     */
    protected function runValidation(): void
    {
        // Expand wildcard rules
        $this->expandedRules = $this->expandWildcardRules($this->rules, $this->data);

        foreach ($this->expandedRules as $field => $rules) {
            $rulesList = is_string($rules) ? explode('|', $rules) : $rules;

            foreach ($rulesList as $rule) {
                $this->validateRule($field, $rule);
            }
        }
    }

    /**
     * Get validation errors
     *
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Get validated data
     *
     * Returns only the fields that had validation rules applied.
     * For dot-notation and wildcard rules, the output is a properly
     * nested array structure.  For flat keys the output is identical
     * to the previous behaviour (backward compatible).
     *
     * @return array
     */
    public function validated(): array
    {
        $validated = [];

        // Use expanded rules if available (set during validate()), otherwise
        // fall back to the raw rules so that validated() works even when
        // called without a prior validate() call (e.g. after manual fails() check).
        $rulesToUse = !empty($this->expandedRules) ? $this->expandedRules : $this->rules;

        foreach ($rulesToUse as $field => $rules) {
            if ($this->hasValueByDotNotation($this->data, $field)) {
                $value = $this->getValueByDotNotation($this->data, $field);
                $this->setValueByDotNotation($validated, $field, $value);
            }
        }

        return $validated;
    }

    /**
     * Validate a single rule
     *
     * Resolves the field value using dot notation so that nested and
     * wildcard-expanded fields are properly accessed.
     *
     * @param string $field Field name (may use dot notation, e.g. 'user.email')
     * @param string|object $rule Rule to validate
     * @return void
     */
    protected function validateRule(string $field, $rule): void
    {
        // Resolve value via dot notation (falls back to flat key for backward compat)
        $value = $this->getValueByDotNotation($this->data, $field);

        // Handle custom rule objects
        if (is_object($rule) && $rule instanceof Rule) {
            if (!$rule->passes($field, $value)) {
                $this->addError($field, $rule->message());
            }
            return;
        }

        // Handle closure rules
        if ($rule instanceof \Closure) {
            $message = $rule($field, $value);
            if ($message !== true) {
                $this->addError($field, is_string($message) ? $message : "The $field field is invalid.");
            }
            return;
        }

        // Parse rule and parameters
        [$ruleName, $parameters] = $this->parseRule($rule);

        // Get validation method
        $method = 'validate' . str_replace('_', '', ucwords($ruleName, '_'));

        if (!method_exists($this, $method)) {
            throw new \Exception("Validation rule [$ruleName] does not exist.");
        }

        // Call validation method
        $passes = $this->$method($field, $value, $parameters);

        if (!$passes) {
            $this->addError($field, $this->getMessage($field, $ruleName, $parameters));
        }
    }

    /**
     * Parse rule into name and parameters
     *
     * @param string $rule
     * @return array
     */
    protected function parseRule(string $rule): array
    {
        if (str_contains($rule, ':')) {
            [$name, $params] = explode(':', $rule, 2);
            return [$name, explode(',', $params)];
        }

        return [$rule, []];
    }

    /**
     * Add validation error
     *
     * @param string $field
     * @param string $message
     * @return void
     */
    protected function addError(string $field, string $message): void
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }

        $this->errors[$field][] = $message;
    }

    /**
     * Get error message for rule
     *
     * @param string $field
     * @param string $rule
     * @param array $parameters
     * @return string
     */
    protected function getMessage(string $field, string $rule, array $parameters): string
    {
        // Check for custom message
        $key = "$field.$rule";
        if (isset($this->customMessages[$key])) {
            return $this->replacePlaceholders($this->customMessages[$key], $field, $parameters);
        }

        // Use default message
        $message = $this->messages[$rule] ?? "The $field field is invalid.";

        return $this->replacePlaceholders($message, $field, $parameters);
    }

    /**
     * Replace message placeholders
     *
     * @param string $message
     * @param string $field
     * @param array $parameters
     * @return string
     */
    protected function replacePlaceholders(string $message, string $field, array $parameters): string
    {
        $message = str_replace(':attribute', $field, $message);

        // Replace parameter placeholders
        $replacements = [
            ':min' => $parameters[0] ?? '',
            ':max' => $parameters[0] ?? '',
            ':value' => $parameters[1] ?? '',
            ':other' => $parameters[0] ?? '',
            ':values' => implode(', ', $parameters),
            ':date' => $parameters[0] ?? '',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $message);
    }

    // ==================== DOT NOTATION & WILDCARD HELPERS ====================

    /**
     * Get a value from a nested array using dot notation.
     *
     * Resolves paths like 'user.name' to $data['user']['name'].
     * Returns the provided default if any segment of the path does not exist.
     *
     * @param array $data The data array to traverse
     * @param string $key Dot-notation key (e.g., 'user.profile.email')
     * @param mixed $default Value to return if the path does not exist
     * @return mixed
     */
    protected function getValueByDotNotation(array $data, string $key, $default = null)
    {
        // Fast path: the key exists as a top-level flat key (backward compat)
        if (array_key_exists($key, $data)) {
            return $data[$key];
        }

        $segments = explode('.', $key);
        $current = $data;

        foreach ($segments as $segment) {
            if (!is_array($current) || !array_key_exists($segment, $current)) {
                return $default;
            }
            $current = $current[$segment];
        }

        return $current;
    }

    /**
     * Set a value in a nested array using dot notation.
     *
     * Builds the nested structure as needed. For example,
     * setValueByDotNotation($arr, 'user.profile.name', 'Alice')
     * produces $arr['user']['profile']['name'] = 'Alice'.
     *
     * @param array &$array The target array (modified in-place)
     * @param string $key Dot-notation key
     * @param mixed $value The value to set
     * @return void
     */
    protected function setValueByDotNotation(array &$array, string $key, $value): void
    {
        $segments = explode('.', $key);
        $current = &$array;

        foreach ($segments as $i => $segment) {
            // If this is the last segment, assign the value
            if ($i === count($segments) - 1) {
                $current[$segment] = $value;
            } else {
                // Create intermediate arrays as needed
                if (!isset($current[$segment]) || !is_array($current[$segment])) {
                    $current[$segment] = [];
                }
                $current = &$current[$segment];
            }
        }
    }

    /**
     * Check whether a value exists in the data using dot notation.
     *
     * Unlike getValueByDotNotation, this distinguishes between "key exists
     * with a null value" and "key does not exist at all".
     *
     * @param array $data The data array
     * @param string $key Dot-notation key
     * @return bool
     */
    protected function hasValueByDotNotation(array $data, string $key): bool
    {
        if (array_key_exists($key, $data)) {
            return true;
        }

        $segments = explode('.', $key);
        $current = $data;

        foreach ($segments as $segment) {
            if (!is_array($current) || !array_key_exists($segment, $current)) {
                return false;
            }
            $current = $current[$segment];
        }

        return true;
    }

    /**
     * Expand wildcard rules into concrete, indexed rules.
     *
     * Given a rule like 'items.*.name' => 'required|string' and data containing
     * 'items' with 3 elements, this produces:
     *   'items.0.name' => 'required|string'
     *   'items.1.name' => 'required|string'
     *   'items.2.name' => 'required|string'
     *
     * Supports multiple wildcards (e.g., 'a.*.b.*.c') and trailing wildcards
     * (e.g., 'items.*.tags.*').
     *
     * Rules without wildcards are passed through unchanged.
     *
     * @param array $rules The rule definitions (may contain '*' segments)
     * @param array $data The input data used to determine array sizes
     * @return array Expanded rules with concrete indices replacing wildcards
     */
    protected function expandWildcardRules(array $rules, array $data): array
    {
        $expanded = [];

        foreach ($rules as $field => $fieldRules) {
            if (!str_contains($field, '*')) {
                // No wildcard -- pass through as-is
                $expanded[$field] = $fieldRules;
                continue;
            }

            // Recursively expand wildcards in the field key
            $expandedKeys = $this->expandWildcardKey($field, $data);

            foreach ($expandedKeys as $concreteKey) {
                $expanded[$concreteKey] = $fieldRules;
            }
        }

        return $expanded;
    }

    /**
     * Recursively expand a single wildcard key into all matching concrete keys.
     *
     * For example, with key 'items.*.name' and data ['items' => [['name'=>'A'], ['name'=>'B']]],
     * this returns ['items.0.name', 'items.1.name'].
     *
     * @param string $pattern The dot-notation key pattern containing '*'
     * @param array $data The input data
     * @return array List of concrete dot-notation keys
     */
    protected function expandWildcardKey(string $pattern, array $data): array
    {
        $segments = explode('.', $pattern);
        return $this->expandSegments($segments, 0, $data, '');
    }

    /**
     * Recursive segment expander used by expandWildcardKey.
     *
     * Walks the segments array. When a '*' segment is encountered, iterates
     * over the array elements at the current data position and recurses for
     * each index. Non-wildcard segments simply descend into the data.
     *
     * @param array $segments All segments of the dot-notation pattern
     * @param int $index Current segment index
     * @param mixed $currentData The data subtree at the current position
     * @param string $prefix The concrete key built so far
     * @return array List of fully-expanded concrete keys
     */
    protected function expandSegments(array $segments, int $index, $currentData, string $prefix): array
    {
        // Base case: all segments consumed -- we have a complete concrete key
        if ($index >= count($segments)) {
            return [$prefix];
        }

        $segment = $segments[$index];
        $keys = [];

        if ($segment === '*') {
            // The current data must be an array to expand
            if (!is_array($currentData)) {
                return [];
            }

            foreach (array_keys($currentData) as $arrayIndex) {
                $newPrefix = $prefix === '' ? (string)$arrayIndex : $prefix . '.' . $arrayIndex;
                $keys = array_merge(
                    $keys,
                    $this->expandSegments($segments, $index + 1, $currentData[$arrayIndex] ?? null, $newPrefix)
                );
            }
        } else {
            $newPrefix = $prefix === '' ? $segment : $prefix . '.' . $segment;
            $nextData = is_array($currentData) ? ($currentData[$segment] ?? null) : null;
            $keys = $this->expandSegments($segments, $index + 1, $nextData, $newPrefix);
        }

        return $keys;
    }

    // ==================== VALIDATION RULES ====================

    /**
     * Required rule
     */
    protected function validateRequired(string $field, $value, array $parameters): bool
    {
        if (is_null($value)) {
            return false;
        }

        if (is_string($value) && trim($value) === '') {
            return false;
        }

        if (is_array($value) && empty($value)) {
            return false;
        }

        return true;
    }

    /**
     * Required if rule
     */
    protected function validateRequiredIf(string $field, $value, array $parameters): bool
    {
        [$otherField, $otherValue] = $parameters;

        if ($this->getValueByDotNotation($this->data, $otherField) == $otherValue) {
            return $this->validateRequired($field, $value, []);
        }

        return true;
    }

    /**
     * Required with rule
     */
    protected function validateRequiredWith(string $field, $value, array $parameters): bool
    {
        foreach ($parameters as $otherField) {
            $otherValue = $this->getValueByDotNotation($this->data, $otherField);
            if ($otherValue !== null && $otherValue !== '' && $otherValue !== []) {
                return $this->validateRequired($field, $value, []);
            }
        }

        return true;
    }

    /**
     * Email rule
     */
    protected function validateEmail(string $field, $value, array $parameters): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * URL rule
     */
    protected function validateUrl(string $field, $value, array $parameters): bool
    {
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * IP rule
     */
    protected function validateIp(string $field, $value, array $parameters): bool
    {
        return filter_var($value, FILTER_VALIDATE_IP) !== false;
    }

    /**
     * Alpha rule
     */
    protected function validateAlpha(string $field, $value, array $parameters): bool
    {
        return is_string($value) && preg_match('/^[a-zA-Z]+$/', $value);
    }

    /**
     * Alpha numeric rule
     */
    protected function validateAlphaNum(string $field, $value, array $parameters): bool
    {
        return is_string($value) && preg_match('/^[a-zA-Z0-9]+$/', $value);
    }

    /**
     * Alpha dash rule
     */
    protected function validateAlphaDash(string $field, $value, array $parameters): bool
    {
        return is_string($value) && preg_match('/^[a-zA-Z0-9_-]+$/', $value);
    }

    /**
     * Numeric rule
     */
    protected function validateNumeric(string $field, $value, array $parameters): bool
    {
        return is_numeric($value);
    }

    /**
     * Integer rule
     */
    protected function validateInteger(string $field, $value, array $parameters): bool
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    /**
     * String rule
     */
    protected function validateString(string $field, $value, array $parameters): bool
    {
        return is_string($value);
    }

    /**
     * Array rule
     */
    protected function validateArray(string $field, $value, array $parameters): bool
    {
        return is_array($value);
    }

    /**
     * Boolean rule
     */
    protected function validateBoolean(string $field, $value, array $parameters): bool
    {
        return in_array($value, [true, false, 1, 0, '1', '0'], true);
    }

    /**
     * Min rule
     */
    protected function validateMin(string $field, $value, array $parameters): bool
    {
        $min = $parameters[0];

        if (is_numeric($value)) {
            return $value >= $min;
        }

        if (is_string($value)) {
            return strlen($value) >= $min;
        }

        if (is_array($value)) {
            return count($value) >= $min;
        }

        return false;
    }

    /**
     * Max rule
     */
    protected function validateMax(string $field, $value, array $parameters): bool
    {
        $max = $parameters[0];

        if (is_numeric($value)) {
            return $value <= $max;
        }

        if (is_string($value)) {
            return strlen($value) <= $max;
        }

        if (is_array($value)) {
            return count($value) <= $max;
        }

        return false;
    }

    /**
     * Between rule
     */
    protected function validateBetween(string $field, $value, array $parameters): bool
    {
        [$min, $max] = $parameters;

        return $this->validateMin($field, $value, [$min]) &&
               $this->validateMax($field, $value, [$max]);
    }

    /**
     * In rule
     */
    protected function validateIn(string $field, $value, array $parameters): bool
    {
        return in_array((string) $value, $parameters, true);
    }

    /**
     * Not in rule
     */
    protected function validateNotIn(string $field, $value, array $parameters): bool
    {
        return !in_array((string) $value, $parameters, true);
    }

    /**
     * Same rule
     */
    protected function validateSame(string $field, $value, array $parameters): bool
    {
        $other = $parameters[0];
        return $value === $this->getValueByDotNotation($this->data, $other);
    }

    /**
     * Different rule
     */
    protected function validateDifferent(string $field, $value, array $parameters): bool
    {
        $other = $parameters[0];
        return $value !== $this->getValueByDotNotation($this->data, $other);
    }

    /**
     * Confirmed rule
     */
    protected function validateConfirmed(string $field, $value, array $parameters): bool
    {
        $confirmation = $field . '_confirmation';
        return $value === $this->getValueByDotNotation($this->data, $confirmation);
    }

    /**
     * Date rule
     */
    protected function validateDate(string $field, $value, array $parameters): bool
    {
        if ($value instanceof \DateTime) {
            return true;
        }

        return strtotime($value) !== false;
    }

    /**
     * Before rule
     */
    protected function validateBefore(string $field, $value, array $parameters): bool
    {
        $date = $parameters[0];
        $valueTime = strtotime($value);
        $dateTime = strtotime($date);

        return $valueTime !== false && $dateTime !== false && $valueTime < $dateTime;
    }

    /**
     * After rule
     */
    protected function validateAfter(string $field, $value, array $parameters): bool
    {
        $date = $parameters[0];
        $valueTime = strtotime($value);
        $dateTime = strtotime($date);

        return $valueTime !== false && $dateTime !== false && $valueTime > $dateTime;
    }

    /**
     * Unique rule (database)
     */
    protected function validateUnique(string $field, $value, array $parameters): bool
    {
        $table = $parameters[0];
        $column = $parameters[1] ?? $field;
        $except = $parameters[2] ?? null;

        $db = app('db');
        $query = $db->table($table)->where($column, '=', $value);

        if ($except !== null) {
            $query->where('id', '!=', $except);
        }

        return $query->count() === 0;
    }

    /**
     * Exists rule (database)
     */
    protected function validateExists(string $field, $value, array $parameters): bool
    {
        $table = $parameters[0];
        $column = $parameters[1] ?? $field;

        $db = app('db');
        return $db->table($table)->where($column, '=', $value)->count() > 0;
    }
}
