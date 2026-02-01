<?php

namespace Core\Localization;

use Core\Localization\Pluralization\PluralRules;

/**
 * MessageFormatter
 *
 * ICU MessageFormat support for complex message formatting.
 * Uses php-intl extension when available, falls back to custom implementation.
 *
 * Supports:
 * - Simple placeholders: {name}
 * - Select patterns: {gender, select, male{He} female{She} other{They}}
 * - Plural patterns: {count, plural, one{# item} other{# items}}
 * - Number formatting: {price, number}
 * - Date/time formatting: {date, date, medium}
 *
 * Usage:
 * ```php
 * $formatter = new MessageFormatter();
 *
 * // Simple placeholder
 * echo $formatter->format('Hello, {name}!', ['name' => 'John']);
 * // Output: Hello, John!
 *
 * // Gender selection
 * echo $formatter->format(
 *     '{gender, select, male{He} female{She} other{They}} liked your post.',
 *     ['gender' => 'female']
 * );
 * // Output: She liked your post.
 *
 * // Plural form
 * echo $formatter->format(
 *     'You have {count, plural, one{# message} other{# messages}}.',
 *     ['count' => 5]
 * );
 * // Output: You have 5 messages.
 * ```
 */
class MessageFormatter
{
    /**
     * Whether php-intl MessageFormatter is available
     */
    protected bool $intlAvailable;

    /**
     * Default locale
     */
    protected string $defaultLocale;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->intlAvailable = class_exists('\MessageFormatter');
        $this->defaultLocale = config('app.locale', 'en');
    }

    /**
     * Format a message using ICU MessageFormat
     *
     * @param string $pattern ICU message pattern
     * @param array $args Arguments for placeholders
     * @param string|null $locale Locale (null = default)
     * @return string Formatted message
     */
    public function format(string $pattern, array $args = [], ?string $locale = null): string
    {
        $locale = $locale ?? $this->defaultLocale;

        // Try php-intl first
        if ($this->intlAvailable) {
            $result = $this->formatWithIntl($pattern, $args, $locale);
            if ($result !== null) {
                return $result;
            }
        }

        // Fallback to custom implementation
        return $this->formatFallback($pattern, $args, $locale);
    }

    /**
     * Format using php-intl MessageFormatter
     *
     * @param string $pattern ICU message pattern
     * @param array $args Arguments
     * @param string $locale Locale
     * @return string|null Formatted string or null on failure
     */
    protected function formatWithIntl(string $pattern, array $args, string $locale): ?string
    {
        try {
            $formatter = new \MessageFormatter($locale, $pattern);

            if (!$formatter) {
                return null;
            }

            $result = $formatter->format($args);

            if ($result === false) {
                // Log error if logger available
                if (function_exists('logger')) {
                    logger()->warning('MessageFormatter error', [
                        'pattern' => $pattern,
                        'error' => $formatter->getErrorMessage(),
                    ]);
                }
                return null;
            }

            return $result;

        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Fallback formatter for when php-intl is not available
     *
     * @param string $pattern ICU message pattern
     * @param array $args Arguments
     * @param string $locale Locale
     * @return string Formatted string
     */
    protected function formatFallback(string $pattern, array $args, string $locale): string
    {
        $result = $pattern;

        // Handle select: {variable, select, option1{text1} option2{text2} other{default}}
        $result = $this->processSelect($result, $args);

        // Handle plural: {variable, plural, one{...} other{...}}
        $result = $this->processPlural($result, $args, $locale);

        // Handle selectordinal: {variable, selectordinal, one{...} other{...}}
        $result = $this->processSelectOrdinal($result, $args, $locale);

        // Handle number: {variable, number} or {variable, number, currency}
        $result = $this->processNumber($result, $args, $locale);

        // Handle date: {variable, date} or {variable, date, format}
        $result = $this->processDate($result, $args, $locale);

        // Handle time: {variable, time}
        $result = $this->processTime($result, $args, $locale);

        // Handle simple placeholders: {variable}
        $result = $this->processSimple($result, $args);

        return $result;
    }

    /**
     * Process select patterns
     *
     * @param string $pattern Pattern string
     * @param array $args Arguments
     * @return string Processed string
     */
    protected function processSelect(string $pattern, array $args): string
    {
        // Match select patterns with nested braces
        return preg_replace_callback(
            '/\{(\w+),\s*select,\s*((?:[^{}]|\{[^{}]*\})+)\}/',
            function ($matches) use ($args) {
                $variable = $matches[1];
                $options = $matches[2];
                $value = $args[$variable] ?? 'other';

                // Parse options: key{value} pairs
                preg_match_all('/(\w+)\{([^{}]*)\}/', $options, $optionMatches, PREG_SET_ORDER);

                $other = null;
                foreach ($optionMatches as $option) {
                    if ($option[1] === $value) {
                        return $option[2];
                    }
                    if ($option[1] === 'other') {
                        $other = $option[2];
                    }
                }

                return $other ?? '';
            },
            $pattern
        );
    }

    /**
     * Process plural patterns
     *
     * @param string $pattern Pattern string
     * @param array $args Arguments
     * @param string $locale Locale
     * @return string Processed string
     */
    protected function processPlural(string $pattern, array $args, string $locale): string
    {
        return preg_replace_callback(
            '/\{(\w+),\s*plural,\s*([^}]+(?:\{[^}]*\}[^}]*)+)\}/',
            function ($matches) use ($args, $locale) {
                $variable = $matches[1];
                $options = $matches[2];
                $count = isset($args[$variable]) ? (int) $args[$variable] : 0;

                // Get plural rule for locale
                $rule = PluralRules::forLocale($locale);
                $category = $rule->getCategory($count);

                // Parse options
                preg_match_all('/(zero|one|two|few|many|other|=\d+)\{([^}]*)\}/', $options, $optionMatches, PREG_SET_ORDER);

                $forms = [];
                foreach ($optionMatches as $option) {
                    $key = $option[1];
                    $text = $option[2];

                    // Handle exact matches (=0, =1, etc.)
                    if (str_starts_with($key, '=')) {
                        $exactValue = (int) substr($key, 1);
                        if ($count === $exactValue) {
                            return str_replace('#', (string) $count, $text);
                        }
                    } else {
                        $forms[$key] = $text;
                    }
                }

                // Get form by category
                $text = $forms[$category] ?? $forms['other'] ?? '';

                // Replace # with count
                return str_replace('#', (string) $count, $text);
            },
            $pattern
        );
    }

    /**
     * Process selectordinal patterns (1st, 2nd, 3rd, etc.)
     *
     * @param string $pattern Pattern string
     * @param array $args Arguments
     * @param string $locale Locale
     * @return string Processed string
     */
    protected function processSelectOrdinal(string $pattern, array $args, string $locale): string
    {
        return preg_replace_callback(
            '/\{(\w+),\s*selectordinal,\s*([^}]+(?:\{[^}]*\}[^}]*)+)\}/',
            function ($matches) use ($args, $locale) {
                $variable = $matches[1];
                $options = $matches[2];
                $count = isset($args[$variable]) ? (int) $args[$variable] : 0;

                // Get ordinal category
                $category = $this->getOrdinalCategory($count, $locale);

                // Parse options
                preg_match_all('/(zero|one|two|few|many|other)\{([^}]*)\}/', $options, $optionMatches, PREG_SET_ORDER);

                $forms = [];
                foreach ($optionMatches as $option) {
                    $forms[$option[1]] = $option[2];
                }

                $text = $forms[$category] ?? $forms['other'] ?? '';

                return str_replace('#', (string) $count, $text);
            },
            $pattern
        );
    }

    /**
     * Get ordinal category for a number
     *
     * @param int $number Number
     * @param string $locale Locale
     * @return string Ordinal category
     */
    protected function getOrdinalCategory(int $number, string $locale): string
    {
        $languageCode = strtolower(explode('_', $locale)[0]);

        // English ordinal rules
        if ($languageCode === 'en') {
            $mod10 = $number % 10;
            $mod100 = $number % 100;

            if ($mod10 === 1 && $mod100 !== 11) {
                return 'one';  // 1st, 21st, 31st
            }
            if ($mod10 === 2 && $mod100 !== 12) {
                return 'two';  // 2nd, 22nd, 32nd
            }
            if ($mod10 === 3 && $mod100 !== 13) {
                return 'few';  // 3rd, 23rd, 33rd
            }
            return 'other';  // 4th, 5th, 11th, 12th, 13th
        }

        // Default to 'other' for other languages
        return 'other';
    }

    /**
     * Process number formatting
     *
     * @param string $pattern Pattern string
     * @param array $args Arguments
     * @param string $locale Locale
     * @return string Processed string
     */
    protected function processNumber(string $pattern, array $args, string $locale): string
    {
        return preg_replace_callback(
            '/\{(\w+),\s*number(?:,\s*(\w+))?\}/',
            function ($matches) use ($args, $locale) {
                $variable = $matches[1];
                $style = $matches[2] ?? 'decimal';
                $value = $args[$variable] ?? 0;

                if (class_exists('\NumberFormatter')) {
                    $type = match ($style) {
                        'currency' => \NumberFormatter::CURRENCY,
                        'percent' => \NumberFormatter::PERCENT,
                        'integer' => \NumberFormatter::DECIMAL,
                        default => \NumberFormatter::DECIMAL,
                    };

                    $formatter = new \NumberFormatter($locale, $type);

                    if ($style === 'integer') {
                        $formatter->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, 0);
                    }

                    return $formatter->format($value);
                }

                // Fallback
                if ($style === 'percent') {
                    return number_format($value * 100, 0) . '%';
                }
                if ($style === 'integer') {
                    return number_format($value, 0);
                }
                return number_format($value, 2);
            },
            $pattern
        );
    }

    /**
     * Process date formatting
     *
     * @param string $pattern Pattern string
     * @param array $args Arguments
     * @param string $locale Locale
     * @return string Processed string
     */
    protected function processDate(string $pattern, array $args, string $locale): string
    {
        return preg_replace_callback(
            '/\{(\w+),\s*date(?:,\s*(\w+))?\}/',
            function ($matches) use ($args, $locale) {
                $variable = $matches[1];
                $style = $matches[2] ?? 'medium';
                $value = $args[$variable] ?? null;

                if (!$value) {
                    return '';
                }

                // Convert to timestamp if needed
                if (!is_numeric($value)) {
                    $value = strtotime($value);
                }

                if (class_exists('\IntlDateFormatter')) {
                    $dateType = match ($style) {
                        'short' => \IntlDateFormatter::SHORT,
                        'long' => \IntlDateFormatter::LONG,
                        'full' => \IntlDateFormatter::FULL,
                        default => \IntlDateFormatter::MEDIUM,
                    };

                    $formatter = new \IntlDateFormatter(
                        $locale,
                        $dateType,
                        \IntlDateFormatter::NONE
                    );

                    return $formatter->format($value);
                }

                // Fallback
                $format = match ($style) {
                    'short' => 'n/j/y',
                    'long' => 'F j, Y',
                    'full' => 'l, F j, Y',
                    default => 'M j, Y',
                };

                return date($format, $value);
            },
            $pattern
        );
    }

    /**
     * Process time formatting
     *
     * @param string $pattern Pattern string
     * @param array $args Arguments
     * @param string $locale Locale
     * @return string Processed string
     */
    protected function processTime(string $pattern, array $args, string $locale): string
    {
        return preg_replace_callback(
            '/\{(\w+),\s*time(?:,\s*(\w+))?\}/',
            function ($matches) use ($args, $locale) {
                $variable = $matches[1];
                $style = $matches[2] ?? 'medium';
                $value = $args[$variable] ?? null;

                if (!$value) {
                    return '';
                }

                // Convert to timestamp if needed
                if (!is_numeric($value)) {
                    $value = strtotime($value);
                }

                if (class_exists('\IntlDateFormatter')) {
                    $timeType = match ($style) {
                        'short' => \IntlDateFormatter::SHORT,
                        'long' => \IntlDateFormatter::LONG,
                        'full' => \IntlDateFormatter::FULL,
                        default => \IntlDateFormatter::MEDIUM,
                    };

                    $formatter = new \IntlDateFormatter(
                        $locale,
                        \IntlDateFormatter::NONE,
                        $timeType
                    );

                    return $formatter->format($value);
                }

                // Fallback
                $format = match ($style) {
                    'short' => 'g:i A',
                    'long' => 'g:i:s A T',
                    'full' => 'g:i:s A T',
                    default => 'g:i:s A',
                };

                return date($format, $value);
            },
            $pattern
        );
    }

    /**
     * Process simple placeholders
     *
     * @param string $pattern Pattern string
     * @param array $args Arguments
     * @return string Processed string
     */
    protected function processSimple(string $pattern, array $args): string
    {
        return preg_replace_callback(
            '/\{(\w+)\}/',
            function ($matches) use ($args) {
                $variable = $matches[1];
                return (string) ($args[$variable] ?? $matches[0]);
            },
            $pattern
        );
    }

    /**
     * Check if php-intl MessageFormatter is available
     *
     * @return bool
     */
    public function isIntlAvailable(): bool
    {
        return $this->intlAvailable;
    }

    /**
     * Create a reusable formatter for a pattern
     *
     * @param string $pattern ICU message pattern
     * @param string|null $locale Locale
     * @return callable Function that formats messages
     */
    public function createFormatter(string $pattern, ?string $locale = null): callable
    {
        $locale = $locale ?? $this->defaultLocale;

        return function (array $args = []) use ($pattern, $locale) {
            return $this->format($pattern, $args, $locale);
        };
    }
}
