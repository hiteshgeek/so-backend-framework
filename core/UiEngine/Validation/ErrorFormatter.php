<?php

namespace Core\UiEngine\Validation;

/**
 * ErrorFormatter - Formats validation errors for JavaScript consumption
 *
 * Converts validation errors from various sources (Validator, exceptions, etc.)
 * to a standardized format for the JavaScript ErrorReporter.
 */
class ErrorFormatter
{
    /**
     * Default error messages for common rules
     *
     * @var array<string, string>
     */
    protected static array $defaultMessages = [
        'required' => 'This field is required.',
        'email' => 'Please enter a valid email address.',
        'url' => 'Please enter a valid URL.',
        'numeric' => 'Please enter a number.',
        'integer' => 'Please enter a whole number.',
        'min' => 'Must be at least :min characters.',
        'max' => 'Must not exceed :max characters.',
        'between' => 'Must be between :min and :max characters.',
        'in' => 'Please select a valid option.',
        'confirmed' => 'The confirmation does not match.',
        'date' => 'Please enter a valid date.',
        'accepted' => 'This field must be accepted.',
        'regex' => 'The format is invalid.',
        'alpha' => 'Only letters are allowed.',
        'alpha_num' => 'Only letters and numbers are allowed.',
    ];

    /**
     * Format errors from Validator
     *
     * @param array $errors Raw errors from Validator
     * @return array Formatted errors for JS
     */
    public static function format(array $errors): array
    {
        $formatted = [];

        foreach ($errors as $field => $messages) {
            if (is_array($messages)) {
                // Multiple messages per field
                $formatted[$field] = array_values($messages);
            } else {
                // Single message
                $formatted[$field] = [$messages];
            }
        }

        return $formatted;
    }

    /**
     * Format errors as flat array (first error per field)
     *
     * @param array $errors
     * @return array
     */
    public static function formatFlat(array $errors): array
    {
        $formatted = [];

        foreach ($errors as $field => $messages) {
            if (is_array($messages)) {
                $formatted[$field] = reset($messages);
            } else {
                $formatted[$field] = $messages;
            }
        }

        return $formatted;
    }

    /**
     * Format errors for JSON response
     *
     * @param array $errors
     * @param bool $success
     * @param string|null $message
     * @return array
     */
    public static function formatResponse(array $errors, bool $success = false, ?string $message = null): array
    {
        return [
            'success' => $success,
            'message' => $message ?? ($success ? 'Success' : 'Validation failed'),
            'errors' => static::format($errors),
        ];
    }

    /**
     * Format errors as JSON string
     *
     * @param array $errors
     * @param int $flags
     * @return string
     */
    public static function toJson(array $errors, int $flags = 0): string
    {
        return json_encode(static::formatResponse($errors), $flags);
    }

    /**
     * Get default message for a rule
     *
     * @param string $rule
     * @param array $params
     * @return string
     */
    public static function getDefaultMessage(string $rule, array $params = []): string
    {
        $message = static::$defaultMessages[$rule] ?? 'Validation failed for :attribute.';

        // Replace placeholders
        foreach ($params as $key => $value) {
            $message = str_replace(':' . $key, $value, $message);
        }

        return $message;
    }

    /**
     * Set default message for a rule
     *
     * @param string $rule
     * @param string $message
     * @return void
     */
    public static function setDefaultMessage(string $rule, string $message): void
    {
        static::$defaultMessages[$rule] = $message;
    }

    /**
     * Set multiple default messages
     *
     * @param array<string, string> $messages
     * @return void
     */
    public static function setDefaultMessages(array $messages): void
    {
        static::$defaultMessages = array_merge(static::$defaultMessages, $messages);
    }

    /**
     * Get all default messages
     *
     * @return array<string, string>
     */
    public static function getDefaultMessages(): array
    {
        return static::$defaultMessages;
    }

    /**
     * Format field name for display
     *
     * @param string $field
     * @return string
     */
    public static function formatFieldName(string $field): string
    {
        // Convert snake_case and camelCase to Title Case
        $formatted = preg_replace('/([a-z])([A-Z])/', '$1 $2', $field);
        $formatted = str_replace(['_', '-'], ' ', $formatted);

        return ucwords(strtolower($formatted));
    }

    /**
     * Replace :attribute placeholder in messages
     *
     * @param array $errors
     * @param array $fieldLabels Custom field labels
     * @return array
     */
    public static function replaceAttributePlaceholders(array $errors, array $fieldLabels = []): array
    {
        $formatted = [];

        foreach ($errors as $field => $messages) {
            $label = $fieldLabels[$field] ?? static::formatFieldName($field);

            if (is_array($messages)) {
                $formatted[$field] = array_map(
                    fn($msg) => str_replace(':attribute', $label, $msg),
                    $messages
                );
            } else {
                $formatted[$field] = str_replace(':attribute', $label, $messages);
            }
        }

        return $formatted;
    }

    /**
     * Group errors by category
     *
     * @param array $errors
     * @param array $categories Map of field => category
     * @return array
     */
    public static function groupByCategory(array $errors, array $categories): array
    {
        $grouped = ['uncategorized' => []];

        foreach ($errors as $field => $messages) {
            $category = $categories[$field] ?? 'uncategorized';

            if (!isset($grouped[$category])) {
                $grouped[$category] = [];
            }

            $grouped[$category][$field] = $messages;
        }

        // Remove empty uncategorized
        if (empty($grouped['uncategorized'])) {
            unset($grouped['uncategorized']);
        }

        return $grouped;
    }

    /**
     * Count total errors
     *
     * @param array $errors
     * @return int
     */
    public static function count(array $errors): int
    {
        $count = 0;

        foreach ($errors as $messages) {
            if (is_array($messages)) {
                $count += count($messages);
            } else {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Check if there are any errors
     *
     * @param array $errors
     * @return bool
     */
    public static function hasErrors(array $errors): bool
    {
        return !empty($errors);
    }

    /**
     * Get first error message
     *
     * @param array $errors
     * @return string|null
     */
    public static function first(array $errors): ?string
    {
        foreach ($errors as $messages) {
            if (is_array($messages) && !empty($messages)) {
                return reset($messages);
            } elseif (is_string($messages)) {
                return $messages;
            }
        }

        return null;
    }

    /**
     * Get error for a specific field
     *
     * @param array $errors
     * @param string $field
     * @return string|null
     */
    public static function get(array $errors, string $field): ?string
    {
        if (!isset($errors[$field])) {
            return null;
        }

        $messages = $errors[$field];

        if (is_array($messages)) {
            return reset($messages) ?: null;
        }

        return $messages;
    }

    /**
     * Get all errors for a specific field
     *
     * @param array $errors
     * @param string $field
     * @return array
     */
    public static function getAll(array $errors, string $field): array
    {
        if (!isset($errors[$field])) {
            return [];
        }

        $messages = $errors[$field];

        return is_array($messages) ? $messages : [$messages];
    }

    /**
     * Check if a field has errors
     *
     * @param array $errors
     * @param string $field
     * @return bool
     */
    public static function has(array $errors, string $field): bool
    {
        return isset($errors[$field]) && !empty($errors[$field]);
    }
}
