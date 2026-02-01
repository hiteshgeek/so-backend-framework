<?php

namespace Core\Support;

/**
 * Str - String Utility Class
 *
 * Provides static methods for common string operations including
 * case conversion, slug generation, limiting, and more.
 *
 * Usage:
 * ```php
 * use Core\Support\Str;
 *
 * Str::slug('Hello World');     // 'hello-world'
 * Str::camel('hello_world');    // 'helloWorld'
 * Str::snake('helloWorld');     // 'hello_world'
 * Str::studly('hello-world');   // 'HelloWorld'
 * Str::limit('Long text...', 10); // 'Long text...'
 * ```
 */
class Str
{
    /**
     * Cache of snake-cased words
     */
    protected static array $snakeCache = [];

    /**
     * Cache of camel-cased words
     */
    protected static array $camelCache = [];

    /**
     * Cache of studly-cased words
     */
    protected static array $studlyCache = [];

    /**
     * Generate a URL-friendly slug from the given string
     *
     * @param string $value The string to slugify
     * @param string $separator The separator to use (default: '-')
     * @param string|null $language The language for transliteration
     * @return string
     */
    public static function slug(string $value, string $separator = '-', ?string $language = 'en'): string
    {
        // Convert to ASCII if possible
        $value = static::ascii($value, $language);

        // Replace @ with 'at'
        $value = str_replace('@', $separator . 'at' . $separator, $value);

        // Remove all characters that are not alphanumeric, spaces, or the separator
        $value = preg_replace('/[^\p{L}\p{N}\s' . preg_quote($separator, '/') . ']+/u', '', mb_strtolower($value, 'UTF-8'));

        // Replace spaces and multiple separators with single separator
        $value = preg_replace('/[\s' . preg_quote($separator, '/') . ']+/u', $separator, $value);

        // Trim separators from beginning and end
        return trim($value, $separator);
    }

    /**
     * Convert a string to ASCII
     *
     * @param string $value
     * @param string $language
     * @return string
     */
    public static function ascii(string $value, string $language = 'en'): string
    {
        // Common transliteration map
        $transliterations = [
            'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'ß' => 'ss',
            'Ä' => 'Ae', 'Ö' => 'Oe', 'Ü' => 'Ue',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'å' => 'a',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
            'ù' => 'u', 'ú' => 'u', 'û' => 'u',
            'ñ' => 'n', 'ç' => 'c',
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Å' => 'A',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
            'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O',
            'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U',
            'Ñ' => 'N', 'Ç' => 'C',
        ];

        return strtr($value, $transliterations);
    }

    /**
     * Convert a string to camelCase
     *
     * @param string $value
     * @return string
     */
    public static function camel(string $value): string
    {
        if (isset(static::$camelCache[$value])) {
            return static::$camelCache[$value];
        }

        return static::$camelCache[$value] = lcfirst(static::studly($value));
    }

    /**
     * Convert a string to StudlyCase (PascalCase)
     *
     * @param string $value
     * @return string
     */
    public static function studly(string $value): string
    {
        $key = $value;

        if (isset(static::$studlyCache[$key])) {
            return static::$studlyCache[$key];
        }

        $words = explode(' ', str_replace(['-', '_'], ' ', $value));

        $studlyWords = array_map(function ($word) {
            return mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
        }, $words);

        return static::$studlyCache[$key] = implode('', $studlyWords);
    }

    /**
     * Convert a string to snake_case
     *
     * @param string $value
     * @param string $delimiter
     * @return string
     */
    public static function snake(string $value, string $delimiter = '_'): string
    {
        $key = $value;

        if (isset(static::$snakeCache[$key][$delimiter])) {
            return static::$snakeCache[$key][$delimiter];
        }

        if (!ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', ucwords($value));
            $value = preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $value);
        }

        return static::$snakeCache[$key][$delimiter] = mb_strtolower($value, 'UTF-8');
    }

    /**
     * Convert a string to kebab-case
     *
     * @param string $value
     * @return string
     */
    public static function kebab(string $value): string
    {
        return static::snake($value, '-');
    }

    /**
     * Convert a string to Title Case
     *
     * @param string $value
     * @return string
     */
    public static function title(string $value): string
    {
        return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * Convert the first character to uppercase
     *
     * @param string $value
     * @return string
     */
    public static function ucfirst(string $value): string
    {
        return mb_strtoupper(mb_substr($value, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($value, 1, null, 'UTF-8');
    }

    /**
     * Convert the first character to lowercase
     *
     * @param string $value
     * @return string
     */
    public static function lcfirst(string $value): string
    {
        return mb_strtolower(mb_substr($value, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($value, 1, null, 'UTF-8');
    }

    /**
     * Convert a string to uppercase
     *
     * @param string $value
     * @return string
     */
    public static function upper(string $value): string
    {
        return mb_strtoupper($value, 'UTF-8');
    }

    /**
     * Convert a string to lowercase
     *
     * @param string $value
     * @return string
     */
    public static function lower(string $value): string
    {
        return mb_strtolower($value, 'UTF-8');
    }

    /**
     * Limit the number of characters in a string
     *
     * @param string $value
     * @param int $limit
     * @param string $end
     * @return string
     */
    public static function limit(string $value, int $limit = 100, string $end = '...'): string
    {
        if (mb_strlen($value, 'UTF-8') <= $limit) {
            return $value;
        }

        return mb_substr($value, 0, $limit, 'UTF-8') . $end;
    }

    /**
     * Limit the number of words in a string
     *
     * @param string $value
     * @param int $words
     * @param string $end
     * @return string
     */
    public static function words(string $value, int $words = 100, string $end = '...'): string
    {
        preg_match('/^\s*+(?:\S++\s*+){1,' . $words . '}/u', $value, $matches);

        if (!isset($matches[0]) || mb_strlen($value, 'UTF-8') === mb_strlen($matches[0], 'UTF-8')) {
            return $value;
        }

        return rtrim($matches[0]) . $end;
    }

    /**
     * Generate a random string of the given length
     *
     * @param int $length
     * @return string
     */
    public static function random(int $length = 16): string
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;
            $bytes = random_bytes($size);
            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }

    /**
     * Generate a UUID v4
     *
     * @return string
     */
    public static function uuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    /**
     * Generate an ordered UUID (timestamp-based for better indexing)
     *
     * @return string
     */
    public static function orderedUuid(): string
    {
        $time = microtime(true) * 10000;
        $timeLow = (int) ($time & 0xffffffff);
        $timeMid = (int) (($time >> 32) & 0xffff);

        return sprintf(
            '%08x-%04x-%04x-%04x-%04x%04x%04x',
            $timeLow,
            $timeMid,
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    /**
     * Get the plural form of an English word
     *
     * @param string $value
     * @param int $count
     * @return string
     */
    public static function plural(string $value, int $count = 2): string
    {
        if ($count === 1) {
            return $value;
        }

        // Irregular plurals
        $irregulars = [
            'child' => 'children',
            'person' => 'people',
            'man' => 'men',
            'woman' => 'women',
            'tooth' => 'teeth',
            'foot' => 'feet',
            'mouse' => 'mice',
            'goose' => 'geese',
        ];

        $lower = strtolower($value);
        if (isset($irregulars[$lower])) {
            return $irregulars[$lower];
        }

        // Words ending in s, x, z, ch, sh
        if (preg_match('/(s|x|z|ch|sh)$/i', $value)) {
            return $value . 'es';
        }

        // Words ending in consonant + y
        if (preg_match('/[^aeiou]y$/i', $value)) {
            return substr($value, 0, -1) . 'ies';
        }

        // Words ending in f or fe
        if (preg_match('/f$/i', $value)) {
            return substr($value, 0, -1) . 'ves';
        }
        if (preg_match('/fe$/i', $value)) {
            return substr($value, 0, -2) . 'ves';
        }

        // Words ending in o (preceded by consonant)
        if (preg_match('/[^aeiou]o$/i', $value)) {
            return $value . 'es';
        }

        // Default: add 's'
        return $value . 's';
    }

    /**
     * Get the singular form of an English word
     *
     * @param string $value
     * @return string
     */
    public static function singular(string $value): string
    {
        // Irregular singulars
        $irregulars = [
            'children' => 'child',
            'people' => 'person',
            'men' => 'man',
            'women' => 'woman',
            'teeth' => 'tooth',
            'feet' => 'foot',
            'mice' => 'mouse',
            'geese' => 'goose',
        ];

        $lower = strtolower($value);
        if (isset($irregulars[$lower])) {
            return $irregulars[$lower];
        }

        // Words ending in 'ies' (preceded by consonant)
        if (preg_match('/[^aeiou]ies$/i', $value)) {
            return substr($value, 0, -3) . 'y';
        }

        // Words ending in 'ves'
        if (preg_match('/ves$/i', $value)) {
            return substr($value, 0, -3) . 'f';
        }

        // Words ending in 'es' after s, x, z, ch, sh
        if (preg_match('/(s|x|z|ch|sh)es$/i', $value)) {
            return substr($value, 0, -2);
        }

        // Words ending in 's' (but not 'ss')
        if (preg_match('/[^s]s$/i', $value)) {
            return substr($value, 0, -1);
        }

        return $value;
    }

    /**
     * Check if a string starts with a given substring
     *
     * @param string $haystack
     * @param string|array $needles
     * @return bool
     */
    public static function startsWith(string $haystack, string|array $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ((string) $needle !== '' && str_starts_with($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if a string ends with a given substring
     *
     * @param string $haystack
     * @param string|array $needles
     * @return bool
     */
    public static function endsWith(string $haystack, string|array $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ((string) $needle !== '' && str_ends_with($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if a string contains a given substring
     *
     * @param string $haystack
     * @param string|array $needles
     * @param bool $ignoreCase
     * @return bool
     */
    public static function contains(string $haystack, string|array $needles, bool $ignoreCase = false): bool
    {
        if ($ignoreCase) {
            $haystack = mb_strtolower($haystack, 'UTF-8');
        }

        foreach ((array) $needles as $needle) {
            if ($ignoreCase) {
                $needle = mb_strtolower($needle, 'UTF-8');
            }

            if ((string) $needle !== '' && str_contains($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if a string contains all given substrings
     *
     * @param string $haystack
     * @param array $needles
     * @param bool $ignoreCase
     * @return bool
     */
    public static function containsAll(string $haystack, array $needles, bool $ignoreCase = false): bool
    {
        foreach ($needles as $needle) {
            if (!static::contains($haystack, $needle, $ignoreCase)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the length of a string
     *
     * @param string $value
     * @param string|null $encoding
     * @return int
     */
    public static function length(string $value, ?string $encoding = null): int
    {
        return mb_strlen($value, $encoding ?? 'UTF-8');
    }

    /**
     * Get a substring
     *
     * @param string $value
     * @param int $start
     * @param int|null $length
     * @param string $encoding
     * @return string
     */
    public static function substr(string $value, int $start, ?int $length = null, string $encoding = 'UTF-8'): string
    {
        return mb_substr($value, $start, $length, $encoding);
    }

    /**
     * Reverse a string
     *
     * @param string $value
     * @return string
     */
    public static function reverse(string $value): string
    {
        $chars = preg_split('//u', $value, -1, PREG_SPLIT_NO_EMPTY);
        return implode('', array_reverse($chars));
    }

    /**
     * Pad a string to a certain length
     *
     * @param string $value
     * @param int $length
     * @param string $pad
     * @param int $padType STR_PAD_LEFT, STR_PAD_RIGHT, or STR_PAD_BOTH
     * @return string
     */
    public static function pad(string $value, int $length, string $pad = ' ', int $padType = STR_PAD_RIGHT): string
    {
        $strLength = mb_strlen($value, 'UTF-8');

        if ($strLength >= $length) {
            return $value;
        }

        $padLength = $length - $strLength;

        switch ($padType) {
            case STR_PAD_LEFT:
                return str_repeat($pad, $padLength) . $value;
            case STR_PAD_BOTH:
                $left = (int) floor($padLength / 2);
                $right = (int) ceil($padLength / 2);
                return str_repeat($pad, $left) . $value . str_repeat($pad, $right);
            default:
                return $value . str_repeat($pad, $padLength);
        }
    }

    /**
     * Pad left
     *
     * @param string $value
     * @param int $length
     * @param string $pad
     * @return string
     */
    public static function padLeft(string $value, int $length, string $pad = ' '): string
    {
        return static::pad($value, $length, $pad, STR_PAD_LEFT);
    }

    /**
     * Pad right
     *
     * @param string $value
     * @param int $length
     * @param string $pad
     * @return string
     */
    public static function padRight(string $value, int $length, string $pad = ' '): string
    {
        return static::pad($value, $length, $pad, STR_PAD_RIGHT);
    }

    /**
     * Replace the first occurrence of a substring
     *
     * @param string $search
     * @param string $replace
     * @param string $subject
     * @return string
     */
    public static function replaceFirst(string $search, string $replace, string $subject): string
    {
        if ($search === '') {
            return $subject;
        }

        $position = strpos($subject, $search);

        if ($position !== false) {
            return substr_replace($subject, $replace, $position, strlen($search));
        }

        return $subject;
    }

    /**
     * Replace the last occurrence of a substring
     *
     * @param string $search
     * @param string $replace
     * @param string $subject
     * @return string
     */
    public static function replaceLast(string $search, string $replace, string $subject): string
    {
        if ($search === '') {
            return $subject;
        }

        $position = strrpos($subject, $search);

        if ($position !== false) {
            return substr_replace($subject, $replace, $position, strlen($search));
        }

        return $subject;
    }

    /**
     * Get the portion of a string before a given value
     *
     * @param string $subject
     * @param string $search
     * @return string
     */
    public static function before(string $subject, string $search): string
    {
        if ($search === '') {
            return $subject;
        }

        $result = strstr($subject, $search, true);

        return $result === false ? $subject : $result;
    }

    /**
     * Get the portion of a string before the last occurrence of a given value
     *
     * @param string $subject
     * @param string $search
     * @return string
     */
    public static function beforeLast(string $subject, string $search): string
    {
        if ($search === '') {
            return $subject;
        }

        $pos = mb_strrpos($subject, $search);

        if ($pos === false) {
            return $subject;
        }

        return static::substr($subject, 0, $pos);
    }

    /**
     * Get the portion of a string after a given value
     *
     * @param string $subject
     * @param string $search
     * @return string
     */
    public static function after(string $subject, string $search): string
    {
        if ($search === '') {
            return $subject;
        }

        return array_reverse(explode($search, $subject, 2))[0];
    }

    /**
     * Get the portion of a string after the last occurrence of a given value
     *
     * @param string $subject
     * @param string $search
     * @return string
     */
    public static function afterLast(string $subject, string $search): string
    {
        if ($search === '') {
            return $subject;
        }

        $position = mb_strrpos($subject, $search);

        if ($position === false) {
            return $subject;
        }

        return static::substr($subject, $position + static::length($search));
    }

    /**
     * Get the portion of a string between two values
     *
     * @param string $subject
     * @param string $from
     * @param string $to
     * @return string
     */
    public static function between(string $subject, string $from, string $to): string
    {
        if ($from === '' || $to === '') {
            return $subject;
        }

        return static::beforeLast(static::after($subject, $from), $to);
    }

    /**
     * Check if a string is a valid UUID
     *
     * @param string $value
     * @return bool
     */
    public static function isUuid(string $value): bool
    {
        return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $value) === 1;
    }

    /**
     * Check if a string is valid JSON
     *
     * @param string $value
     * @return bool
     */
    public static function isJson(string $value): bool
    {
        json_decode($value);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Convert a string to its ASCII representation
     *
     * @param string $value
     * @return string
     */
    public static function toAscii(string $value): string
    {
        return static::ascii($value);
    }

    /**
     * Mask a portion of a string with repeated characters
     *
     * @param string $value
     * @param string $character
     * @param int $index
     * @param int|null $length
     * @return string
     */
    public static function mask(string $value, string $character, int $index, ?int $length = null): string
    {
        $strLength = mb_strlen($value, 'UTF-8');

        if ($index < 0) {
            $index = $strLength + $index;
        }

        if ($length === null) {
            $length = $strLength - $index;
        }

        if ($length < 0) {
            $length = $strLength - $index + $length;
        }

        $start = mb_substr($value, 0, $index, 'UTF-8');
        $masked = str_repeat($character, $length);
        $end = mb_substr($value, $index + $length, null, 'UTF-8');

        return $start . $masked . $end;
    }

    /**
     * Remove all whitespace from a string
     *
     * @param string $value
     * @return string
     */
    public static function squish(string $value): string
    {
        return preg_replace('/\s+/', ' ', trim($value));
    }

    /**
     * Strip HTML tags from a string
     *
     * @param string $value
     * @param string|null $allowedTags
     * @return string
     */
    public static function stripTags(string $value, ?string $allowedTags = null): string
    {
        return strip_tags($value, $allowedTags);
    }

    /**
     * Escape HTML entities
     *
     * @param string $value
     * @param bool $doubleEncode
     * @return string
     */
    public static function escape(string $value, bool $doubleEncode = true): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8', $doubleEncode);
    }

    /**
     * Headline a string (convert to Title Case with spaces)
     *
     * @param string $value
     * @return string
     */
    public static function headline(string $value): string
    {
        // Convert camelCase and snake_case to spaces
        $value = preg_replace('/(?<!^)([A-Z])/', ' $1', $value);
        $value = str_replace(['_', '-'], ' ', $value);

        return static::title(static::squish($value));
    }

    /**
     * Wrap a string with given strings
     *
     * @param string $value
     * @param string $before
     * @param string|null $after
     * @return string
     */
    public static function wrap(string $value, string $before, ?string $after = null): string
    {
        return $before . $value . ($after ?? $before);
    }

    /**
     * Remove the given string(s) from the beginning of the value
     *
     * @param string $value
     * @param string|array $prefixes
     * @return string
     */
    public static function ltrim(string $value, string|array $prefixes): string
    {
        foreach ((array) $prefixes as $prefix) {
            if (static::startsWith($value, $prefix)) {
                $value = mb_substr($value, mb_strlen($prefix));
            }
        }

        return $value;
    }

    /**
     * Remove the given string(s) from the end of the value
     *
     * @param string $value
     * @param string|array $suffixes
     * @return string
     */
    public static function rtrim(string $value, string|array $suffixes): string
    {
        foreach ((array) $suffixes as $suffix) {
            if (static::endsWith($value, $suffix)) {
                $value = mb_substr($value, 0, -mb_strlen($suffix));
            }
        }

        return $value;
    }

    /**
     * Clear the cached values
     *
     * @return void
     */
    public static function flushCache(): void
    {
        static::$snakeCache = [];
        static::$camelCache = [];
        static::$studlyCache = [];
    }
}
