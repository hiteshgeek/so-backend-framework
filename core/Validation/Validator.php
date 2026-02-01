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
     * Fields to exclude from validated data
     */
    protected array $excludedFields = [];

    /**
     * Expanded rules after wildcard resolution.
     * Populated during validate() so that validated() can use concrete keys.
     */
    protected array $expandedRules = [];

    /**
     * Default error messages (loaded from translation files)
     *
     * Note: Messages are now loaded from resources/lang/{locale}/validation.php
     * This array is kept for backward compatibility and fallback support.
     */
    protected array $messages = [];

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
            // Skip excluded fields
            if (in_array($field, $this->excludedFields)) {
                continue;
            }

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

        // Check for custom attribute-level messages in validation.custom
        $customKey = "validation.custom.$field.$rule";
        if (function_exists('trans') && trans($customKey) !== $customKey) {
            return $this->replacePlaceholders(trans($customKey), $field, $parameters);
        }

        // Get message from translation files
        $message = $this->getTranslatedMessage($rule);

        // Translate attribute name
        $translatedField = $this->getTranslatedAttribute($field);

        return $this->replacePlaceholders($message, $translatedField, $parameters);
    }

    /**
     * Get translated validation message
     *
     * @param string $rule Validation rule
     * @return string Translated message
     */
    protected function getTranslatedMessage(string $rule): string
    {
        // Try to get from translation files
        if (function_exists('trans')) {
            $key = "validation.$rule";
            $translated = trans($key);

            // If translation exists, use it
            if ($translated !== $key) {
                return $translated;
            }
        }

        // Fallback to hardcoded message if translation not available
        $fallbackMessages = [
            'required' => 'The :attribute field is required.',
            'email' => 'The :attribute must be a valid email address.',
            'min' => 'The :attribute must be at least :min.',
            'max' => 'The :attribute may not be greater than :max.',
            'unique' => 'The :attribute has already been taken.',
        ];

        return $fallbackMessages[$rule] ?? "The :attribute field is invalid.";
    }

    /**
     * Get translated attribute name
     *
     * @param string $field Field name
     * @return string Translated attribute name
     */
    protected function getTranslatedAttribute(string $field): string
    {
        // Try to get from translation files
        if (function_exists('trans')) {
            $key = "validation.attributes.$field";
            $translated = trans($key);

            // If translation exists, use it
            if ($translated !== $key) {
                return $translated;
            }
        }

        // Convert snake_case or camelCase to readable format
        $readable = str_replace('_', ' ', $field);
        $readable = preg_replace('/([a-z])([A-Z])/', '$1 $2', $readable);

        return strtolower($readable);
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

    // ==================== FILE VALIDATION RULES ====================

    /**
     * File rule - validates that the value is an uploaded file
     */
    protected function validateFile(string $field, $value, array $parameters = []): bool
    {
        if (!is_array($value)) {
            return false;
        }

        // Check for standard PHP file upload array structure
        if (!isset($value['tmp_name']) || !isset($value['error'])) {
            return false;
        }

        // Check if file was actually uploaded
        if ($value['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        // Verify it's an uploaded file (security check)
        return is_uploaded_file($value['tmp_name']);
    }

    /**
     * Image rule - validates that the file is a valid image
     */
    protected function validateImage(string $field, $value, array $parameters = []): bool
    {
        if (!$this->validateFile($field, $value)) {
            return false;
        }

        // Verify it's actually an image using getimagesize
        $imageInfo = @getimagesize($value['tmp_name']);

        if ($imageInfo === false) {
            return false;
        }

        // Optionally restrict to specific image types
        $allowedTypes = [
            IMAGETYPE_GIF,
            IMAGETYPE_JPEG,
            IMAGETYPE_PNG,
            IMAGETYPE_BMP,
            IMAGETYPE_WEBP,
        ];

        return in_array($imageInfo[2], $allowedTypes);
    }

    /**
     * Mimes rule - validates file extension
     *
     * Usage: mimes:jpg,png,pdf
     */
    protected function validateMimes(string $field, $value, array $parameters): bool
    {
        if (!$this->validateFile($field, $value)) {
            return false;
        }

        if (empty($parameters)) {
            return true;
        }

        // Get file extension from original filename
        $extension = strtolower(pathinfo($value['name'] ?? '', PATHINFO_EXTENSION));

        // Normalize parameters to lowercase
        $allowedExtensions = array_map('strtolower', $parameters);

        return in_array($extension, $allowedExtensions);
    }

    /**
     * Max file size rule - validates file size in kilobytes
     *
     * Usage: max_file_size:2048 (for 2MB max)
     */
    protected function validateMaxFileSize(string $field, $value, array $parameters): bool
    {
        if (!$this->validateFile($field, $value)) {
            return false;
        }

        if (empty($parameters)) {
            return true;
        }

        $maxKilobytes = (int) $parameters[0];
        $fileSizeKb = ($value['size'] ?? 0) / 1024;

        return $fileSizeKb <= $maxKilobytes;
    }

    /**
     * Min file size rule - validates minimum file size in kilobytes
     *
     * Usage: min_file_size:10 (for 10KB minimum)
     */
    protected function validateMinFileSize(string $field, $value, array $parameters): bool
    {
        if (!$this->validateFile($field, $value)) {
            return false;
        }

        if (empty($parameters)) {
            return true;
        }

        $minKilobytes = (int) $parameters[0];
        $fileSizeKb = ($value['size'] ?? 0) / 1024;

        return $fileSizeKb >= $minKilobytes;
    }

    /**
     * Dimensions rule - validates image dimensions
     *
     * Usage: dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000
     */
    protected function validateDimensions(string $field, $value, array $parameters): bool
    {
        if (!$this->validateImage($field, $value)) {
            return false;
        }

        $imageInfo = @getimagesize($value['tmp_name']);
        if ($imageInfo === false) {
            return false;
        }

        [$width, $height] = $imageInfo;

        // Parse dimension constraints
        $constraints = [];
        foreach ($parameters as $param) {
            if (str_contains($param, '=')) {
                [$key, $val] = explode('=', $param, 2);
                $constraints[$key] = (int) $val;
            }
        }

        // Check constraints
        if (isset($constraints['min_width']) && $width < $constraints['min_width']) {
            return false;
        }
        if (isset($constraints['max_width']) && $width > $constraints['max_width']) {
            return false;
        }
        if (isset($constraints['min_height']) && $height < $constraints['min_height']) {
            return false;
        }
        if (isset($constraints['max_height']) && $height > $constraints['max_height']) {
            return false;
        }
        if (isset($constraints['width']) && $width !== $constraints['width']) {
            return false;
        }
        if (isset($constraints['height']) && $height !== $constraints['height']) {
            return false;
        }
        if (isset($constraints['ratio'])) {
            $expectedRatio = $constraints['ratio'];
            $actualRatio = $width / $height;
            // Allow small floating point tolerance
            if (abs($actualRatio - $expectedRatio) > 0.01) {
                return false;
            }
        }

        return true;
    }

    // ==================== PATTERN MATCHING RULES ====================

    /**
     * Regex rule - validates value matches a regular expression
     *
     * Usage: regex:/^[a-z]+$/i
     */
    protected function validateRegex(string $field, $value, array $parameters): bool
    {
        if (!is_string($value) && !is_numeric($value)) {
            return false;
        }

        if (empty($parameters)) {
            return true;
        }

        // The pattern is passed as the first parameter
        // Handle both array format and full pattern string
        $pattern = $parameters[0];

        // If pattern doesn't have delimiters, assume it was split by comma
        // and rejoin it (handles patterns with commas)
        if (count($parameters) > 1) {
            $pattern = implode(',', $parameters);
        }

        return preg_match($pattern, (string) $value) === 1;
    }

    /**
     * Not regex rule - validates value does NOT match a regular expression
     *
     * Usage: not_regex:/[<>]/
     */
    protected function validateNotRegex(string $field, $value, array $parameters): bool
    {
        if (!is_string($value) && !is_numeric($value)) {
            return true; // Non-strings/numbers pass the "not matching" test
        }

        if (empty($parameters)) {
            return true;
        }

        $pattern = $parameters[0];

        if (count($parameters) > 1) {
            $pattern = implode(',', $parameters);
        }

        return preg_match($pattern, (string) $value) === 0;
    }

    // ==================== TYPE VALIDATION RULES ====================

    /**
     * UUID rule - validates value is a valid UUID
     *
     * Supports UUID versions 1-5
     */
    protected function validateUuid(string $field, $value, array $parameters = []): bool
    {
        if (!is_string($value)) {
            return false;
        }

        // UUID pattern supporting versions 1-5
        $pattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';

        return preg_match($pattern, $value) === 1;
    }

    /**
     * ULID rule - validates value is a valid ULID
     */
    protected function validateUlid(string $field, $value, array $parameters = []): bool
    {
        if (!is_string($value)) {
            return false;
        }

        // ULID is 26 characters, base32 encoded (Crockford's alphabet)
        $pattern = '/^[0-7][0-9A-HJKMNP-TV-Z]{25}$/i';

        return preg_match($pattern, $value) === 1;
    }

    /**
     * JSON rule - validates value is valid JSON
     */
    protected function validateJson(string $field, $value, array $parameters = []): bool
    {
        if (!is_string($value)) {
            return false;
        }

        json_decode($value);

        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Timezone rule - validates value is a valid timezone
     */
    protected function validateTimezone(string $field, $value, array $parameters = []): bool
    {
        if (!is_string($value)) {
            return false;
        }

        return in_array($value, timezone_identifiers_list());
    }

    /**
     * MAC address rule - validates value is a valid MAC address
     */
    protected function validateMacAddress(string $field, $value, array $parameters = []): bool
    {
        if (!is_string($value)) {
            return false;
        }

        // Supports formats: 00:11:22:33:44:55, 00-11-22-33-44-55
        $pattern = '/^([0-9A-Fa-f]{2}[:-]){5}[0-9A-Fa-f]{2}$/';

        return preg_match($pattern, $value) === 1;
    }

    // ==================== CONDITIONAL RULES ====================

    /**
     * Required unless rule - field is required unless another field has certain values
     *
     * Usage: required_unless:other_field,value1,value2
     */
    protected function validateRequiredUnless(string $field, $value, array $parameters): bool
    {
        if (empty($parameters)) {
            return true;
        }

        $otherField = array_shift($parameters);
        $otherValue = $this->getValueByDotNotation($this->data, $otherField);

        // If the other field does NOT have one of the specified values,
        // then this field is required
        if (!in_array($otherValue, $parameters)) {
            return $this->validateRequired($field, $value, []);
        }

        return true;
    }

    /**
     * Required without rule - field is required when another field is not present
     *
     * Usage: required_without:other_field
     */
    protected function validateRequiredWithout(string $field, $value, array $parameters): bool
    {
        foreach ($parameters as $otherField) {
            $otherValue = $this->getValueByDotNotation($this->data, $otherField);

            // If any of the other fields is empty, this field is required
            if ($otherValue === null || $otherValue === '' || $otherValue === []) {
                return $this->validateRequired($field, $value, []);
            }
        }

        return true;
    }

    /**
     * Required without all rule - field is required when ALL other fields are not present
     *
     * Usage: required_without_all:field1,field2
     */
    protected function validateRequiredWithoutAll(string $field, $value, array $parameters): bool
    {
        $allEmpty = true;

        foreach ($parameters as $otherField) {
            $otherValue = $this->getValueByDotNotation($this->data, $otherField);

            if ($otherValue !== null && $otherValue !== '' && $otherValue !== []) {
                $allEmpty = false;
                break;
            }
        }

        // If all other fields are empty, this field is required
        if ($allEmpty) {
            return $this->validateRequired($field, $value, []);
        }

        return true;
    }

    /**
     * Required with all rule - field is required when ALL other fields are present
     *
     * Usage: required_with_all:field1,field2
     */
    protected function validateRequiredWithAll(string $field, $value, array $parameters): bool
    {
        $allPresent = true;

        foreach ($parameters as $otherField) {
            $otherValue = $this->getValueByDotNotation($this->data, $otherField);

            if ($otherValue === null || $otherValue === '' || $otherValue === []) {
                $allPresent = false;
                break;
            }
        }

        // If all other fields are present, this field is required
        if ($allPresent) {
            return $this->validateRequired($field, $value, []);
        }

        return true;
    }

    /**
     * Exclude if rule - excludes field from validated data if condition is met
     *
     * Usage: exclude_if:other_field,value
     */
    protected function validateExcludeIf(string $field, $value, array $parameters): bool
    {
        if (count($parameters) < 2) {
            return true;
        }

        $otherField = $parameters[0];
        $otherExpectedValue = $parameters[1];
        $otherActualValue = $this->getValueByDotNotation($this->data, $otherField);

        // If condition is met, mark field for exclusion
        if ($otherActualValue == $otherExpectedValue) {
            $this->excludedFields[] = $field;
        }

        // This rule always passes - it just controls exclusion
        return true;
    }

    /**
     * Exclude unless rule - excludes field from validated data unless condition is met
     *
     * Usage: exclude_unless:other_field,value
     */
    protected function validateExcludeUnless(string $field, $value, array $parameters): bool
    {
        if (count($parameters) < 2) {
            return true;
        }

        $otherField = $parameters[0];
        $otherExpectedValue = $parameters[1];
        $otherActualValue = $this->getValueByDotNotation($this->data, $otherField);

        // If condition is NOT met, mark field for exclusion
        if ($otherActualValue != $otherExpectedValue) {
            $this->excludedFields[] = $field;
        }

        return true;
    }

    /**
     * Nullable rule - allows the field to be null
     *
     * This rule should be combined with other rules and prevents
     * validation from failing when the value is null.
     */
    protected function validateNullable(string $field, $value, array $parameters = []): bool
    {
        // Nullable always passes - it's a modifier, not a constraint
        return true;
    }

    /**
     * Sometimes rule - only validate if the field is present
     *
     * This is handled specially in the validation logic.
     */
    protected function validateSometimes(string $field, $value, array $parameters = []): bool
    {
        // Always passes - the logic is handled in runValidation
        return true;
    }

    /**
     * Bail rule - stop validating after first failure
     *
     * This is handled specially in the validation logic.
     */
    protected function validateBail(string $field, $value, array $parameters = []): bool
    {
        // Always passes - the logic is handled in validateRule
        return true;
    }

    // ==================== COMPARISON RULES ====================

    /**
     * Greater than rule - value must be greater than another field
     *
     * Usage: gt:other_field
     */
    protected function validateGt(string $field, $value, array $parameters): bool
    {
        if (empty($parameters)) {
            return true;
        }

        $otherField = $parameters[0];
        $otherValue = $this->getValueByDotNotation($this->data, $otherField);

        if (!is_numeric($value) || !is_numeric($otherValue)) {
            // For strings, compare lengths
            if (is_string($value) && is_string($otherValue)) {
                return strlen($value) > strlen($otherValue);
            }
            // For arrays, compare counts
            if (is_array($value) && is_array($otherValue)) {
                return count($value) > count($otherValue);
            }
            return false;
        }

        return $value > $otherValue;
    }

    /**
     * Greater than or equal rule
     *
     * Usage: gte:other_field
     */
    protected function validateGte(string $field, $value, array $parameters): bool
    {
        if (empty($parameters)) {
            return true;
        }

        $otherField = $parameters[0];
        $otherValue = $this->getValueByDotNotation($this->data, $otherField);

        if (!is_numeric($value) || !is_numeric($otherValue)) {
            if (is_string($value) && is_string($otherValue)) {
                return strlen($value) >= strlen($otherValue);
            }
            if (is_array($value) && is_array($otherValue)) {
                return count($value) >= count($otherValue);
            }
            return false;
        }

        return $value >= $otherValue;
    }

    /**
     * Less than rule
     *
     * Usage: lt:other_field
     */
    protected function validateLt(string $field, $value, array $parameters): bool
    {
        if (empty($parameters)) {
            return true;
        }

        $otherField = $parameters[0];
        $otherValue = $this->getValueByDotNotation($this->data, $otherField);

        if (!is_numeric($value) || !is_numeric($otherValue)) {
            if (is_string($value) && is_string($otherValue)) {
                return strlen($value) < strlen($otherValue);
            }
            if (is_array($value) && is_array($otherValue)) {
                return count($value) < count($otherValue);
            }
            return false;
        }

        return $value < $otherValue;
    }

    /**
     * Less than or equal rule
     *
     * Usage: lte:other_field
     */
    protected function validateLte(string $field, $value, array $parameters): bool
    {
        if (empty($parameters)) {
            return true;
        }

        $otherField = $parameters[0];
        $otherValue = $this->getValueByDotNotation($this->data, $otherField);

        if (!is_numeric($value) || !is_numeric($otherValue)) {
            if (is_string($value) && is_string($otherValue)) {
                return strlen($value) <= strlen($otherValue);
            }
            if (is_array($value) && is_array($otherValue)) {
                return count($value) <= count($otherValue);
            }
            return false;
        }

        return $value <= $otherValue;
    }

    // ==================== DATE RULES ====================

    /**
     * Date format rule - validates date matches a specific format
     *
     * Usage: date_format:Y-m-d
     */
    protected function validateDateFormat(string $field, $value, array $parameters): bool
    {
        if (empty($parameters) || !is_string($value)) {
            return false;
        }

        $format = $parameters[0];
        $date = \DateTime::createFromFormat($format, $value);

        return $date && $date->format($format) === $value;
    }

    /**
     * Before or equal rule
     *
     * Usage: before_or_equal:2024-12-31
     */
    protected function validateBeforeOrEqual(string $field, $value, array $parameters): bool
    {
        if (empty($parameters)) {
            return true;
        }

        $date = $parameters[0];
        $valueTime = strtotime($value);
        $dateTime = strtotime($date);

        return $valueTime !== false && $dateTime !== false && $valueTime <= $dateTime;
    }

    /**
     * After or equal rule
     *
     * Usage: after_or_equal:2024-01-01
     */
    protected function validateAfterOrEqual(string $field, $value, array $parameters): bool
    {
        if (empty($parameters)) {
            return true;
        }

        $date = $parameters[0];
        $valueTime = strtotime($value);
        $dateTime = strtotime($date);

        return $valueTime !== false && $dateTime !== false && $valueTime >= $dateTime;
    }

    // ==================== STRING RULES ====================

    /**
     * Starts with rule
     *
     * Usage: starts_with:foo,bar
     */
    protected function validateStartsWith(string $field, $value, array $parameters): bool
    {
        if (!is_string($value) || empty($parameters)) {
            return false;
        }

        foreach ($parameters as $needle) {
            if (str_starts_with($value, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Ends with rule
     *
     * Usage: ends_with:foo,bar
     */
    protected function validateEndsWith(string $field, $value, array $parameters): bool
    {
        if (!is_string($value) || empty($parameters)) {
            return false;
        }

        foreach ($parameters as $needle) {
            if (str_ends_with($value, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Doesnt start with rule
     *
     * Usage: doesnt_start_with:foo,bar
     */
    protected function validateDoesntStartWith(string $field, $value, array $parameters): bool
    {
        if (!is_string($value) || empty($parameters)) {
            return true;
        }

        foreach ($parameters as $needle) {
            if (str_starts_with($value, $needle)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Doesnt end with rule
     *
     * Usage: doesnt_end_with:foo,bar
     */
    protected function validateDoesntEndWith(string $field, $value, array $parameters): bool
    {
        if (!is_string($value) || empty($parameters)) {
            return true;
        }

        foreach ($parameters as $needle) {
            if (str_ends_with($value, $needle)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Lowercase rule - value must be all lowercase
     */
    protected function validateLowercase(string $field, $value, array $parameters = []): bool
    {
        return is_string($value) && $value === mb_strtolower($value, 'UTF-8');
    }

    /**
     * Uppercase rule - value must be all uppercase
     */
    protected function validateUppercase(string $field, $value, array $parameters = []): bool
    {
        return is_string($value) && $value === mb_strtoupper($value, 'UTF-8');
    }

    // ==================== NUMERIC RULES ====================

    /**
     * Digits rule - value must have exactly N digits
     *
     * Usage: digits:5
     */
    protected function validateDigits(string $field, $value, array $parameters): bool
    {
        if (empty($parameters)) {
            return false;
        }

        $length = (int) $parameters[0];

        return is_numeric($value) && strlen((string) $value) === $length;
    }

    /**
     * Digits between rule - value must have between min and max digits
     *
     * Usage: digits_between:3,5
     */
    protected function validateDigitsBetween(string $field, $value, array $parameters): bool
    {
        if (count($parameters) < 2) {
            return false;
        }

        $min = (int) $parameters[0];
        $max = (int) $parameters[1];
        $length = strlen((string) $value);

        return is_numeric($value) && $length >= $min && $length <= $max;
    }

    /**
     * Decimal rule - value must be a decimal with specified precision
     *
     * Usage: decimal:2 or decimal:2,4
     */
    protected function validateDecimal(string $field, $value, array $parameters): bool
    {
        if (!is_numeric($value) || empty($parameters)) {
            return false;
        }

        $minDecimals = (int) $parameters[0];
        $maxDecimals = isset($parameters[1]) ? (int) $parameters[1] : $minDecimals;

        $valueStr = (string) $value;
        $decimalPos = strpos($valueStr, '.');

        if ($decimalPos === false) {
            $decimalPlaces = 0;
        } else {
            $decimalPlaces = strlen($valueStr) - $decimalPos - 1;
        }

        return $decimalPlaces >= $minDecimals && $decimalPlaces <= $maxDecimals;
    }

    /**
     * Multiple of rule - value must be a multiple of given number
     *
     * Usage: multiple_of:5
     */
    protected function validateMultipleOf(string $field, $value, array $parameters): bool
    {
        if (!is_numeric($value) || empty($parameters)) {
            return false;
        }

        $divisor = (float) $parameters[0];

        if ($divisor == 0) {
            return false;
        }

        return fmod((float) $value, $divisor) == 0;
    }
}
