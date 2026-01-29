<?php

namespace Core\Security;

/**
 * Input Sanitizer
 *
 * Provides XSS prevention and input sanitization utilities.
 * Helps protect against cross-site scripting attacks by cleaning user input.
 *
 * Usage:
 *   $clean = Sanitizer::clean($dirty);
 *   $text = Sanitizer::stripTags($html);
 *   $email = Sanitizer::email($input);
 */
class Sanitizer
{
    /**
     * Dangerous HTML tags to strip
     */
    protected static array $dangerousTags = [
        'script',
        'iframe',
        'object',
        'embed',
        'applet',
        'meta',
        'link',
        'style',
        'form',
    ];

    /**
     * Dangerous attributes to remove
     */
    protected static array $dangerousAttributes = [
        'onload',
        'onerror',
        'onclick',
        'onmouseover',
        'onmouseout',
        'onmousemove',
        'onmouseenter',
        'onmouseleave',
        'onfocus',
        'onblur',
        'onchange',
        'onsubmit',
        'onkeydown',
        'onkeyup',
        'onkeypress',
    ];

    /**
     * Clean input data (strings or arrays)
     *
     * @param mixed $data
     * @return mixed
     */
    public static function clean($data)
    {
        if (is_array($data)) {
            return self::cleanArray($data);
        }

        if (is_string($data)) {
            return self::cleanString($data);
        }

        return $data;
    }

    /**
     * Clean string input
     *
     * @param string $value
     * @return string
     */
    public static function cleanString(string $value): string
    {
        // Remove null bytes
        $value = str_replace("\0", '', $value);

        // Strip dangerous tags
        $value = self::stripDangerousTags($value);

        // Remove dangerous attributes
        $value = self::stripDangerousAttributes($value);

        return trim($value);
    }

    /**
     * Clean array recursively
     *
     * @param array $data
     * @return array
     */
    public static function cleanArray(array $data): array
    {
        $cleaned = [];

        foreach ($data as $key => $value) {
            $cleanKey = self::cleanString((string) $key);

            if (is_array($value)) {
                $cleaned[$cleanKey] = self::cleanArray($value);
            } elseif (is_string($value)) {
                $cleaned[$cleanKey] = self::cleanString($value);
            } else {
                $cleaned[$cleanKey] = $value;
            }
        }

        return $cleaned;
    }

    /**
     * Strip dangerous HTML tags
     *
     * @param string $value
     * @return string
     */
    public static function stripDangerousTags(string $value): string
    {
        $pattern = '/<(' . implode('|', self::$dangerousTags) . ')[^>]*>.*?<\/\1>|<(' . implode('|', self::$dangerousTags) . ')[^>]*\/>/is';

        return preg_replace($pattern, '', $value);
    }

    /**
     * Strip dangerous HTML attributes
     *
     * @param string $value
     * @return string
     */
    public static function stripDangerousAttributes(string $value): string
    {
        foreach (self::$dangerousAttributes as $attribute) {
            $pattern = '/' . $attribute . '\s*=\s*["\'][^"\']*["\']/i';
            $value = preg_replace($pattern, '', $value);
        }

        return $value;
    }

    /**
     * Strip all HTML tags
     *
     * @param string $value
     * @param string|array|null $allowedTags Tags to keep (e.g., '<p><br>')
     * @return string
     */
    public static function stripTags(string $value, $allowedTags = null): string
    {
        return strip_tags($value, $allowedTags);
    }

    /**
     * Sanitize email address
     *
     * @param string $email
     * @return string|false
     */
    public static function email(string $email)
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Sanitize URL
     *
     * @param string $url
     * @return string|false
     */
    public static function url(string $url)
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }

    /**
     * Sanitize integer
     *
     * @param mixed $value
     * @return int
     */
    public static function int($value): int
    {
        return (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * Sanitize float
     *
     * @param mixed $value
     * @return float
     */
    public static function float($value): float
    {
        return (float) filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    /**
     * Escape HTML entities
     *
     * @param string $value
     * @return string
     */
    public static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}
