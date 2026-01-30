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
        'ondblclick',
        'onmouseover',
        'onmouseout',
        'onmousemove',
        'onmouseenter',
        'onmouseleave',
        'onmousedown',
        'onmouseup',
        'onfocus',
        'onblur',
        'onchange',
        'onsubmit',
        'onkeydown',
        'onkeyup',
        'onkeypress',
        'onreset',
        'onselect',
        'onabort',
        'ondrag',
        'ondragstart',
        'ondragend',
        'ondrop',
        'oncopy',
        'oncut',
        'onpaste',
        'oncontextmenu',
        'oninput',
        'oninvalid',
        'onsearch',
        'onwheel',
        'ontouchstart',
        'ontouchend',
        'ontouchmove',
        'onanimationstart',
        'onanimationend',
        'ontransitionend',
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
     * Strip dangerous HTML tags using DOMDocument
     *
     * This method uses DOMDocument for robust HTML parsing instead of regex,
     * which prevents bypasses with nested/malformed tags.
     *
     * @param string $value
     * @return string
     */
    public static function stripDangerousTags(string $value): string
    {
        // Quick check: if no HTML tags present, return as-is
        if (!str_contains($value, '<')) {
            return $value;
        }

        // Try DOMDocument approach (more robust)
        if (class_exists('DOMDocument')) {
            return self::stripDangerousTagsWithDOM($value);
        }

        // Fallback to regex approach (less secure but better than nothing)
        return self::stripDangerousTagsWithRegex($value);
    }

    /**
     * Strip dangerous tags using DOMDocument (robust, prevents bypass)
     *
     * @param string $value
     * @return string
     */
    protected static function stripDangerousTagsWithDOM(string $value): string
    {
        // Create DOMDocument and suppress warnings for malformed HTML
        $dom = new \DOMDocument();
        $previousErrorSetting = libxml_use_internal_errors(true);

        // Wrap in div to preserve fragments, use UTF-8 meta tag
        $wrapped = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>' . $value . '</body></html>';
        $dom->loadHTML($wrapped, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // Remove dangerous tags
        foreach (self::$dangerousTags as $tagName) {
            $nodes = $dom->getElementsByTagName($tagName);

            // Collect nodes to remove (can't remove while iterating)
            $toRemove = [];
            foreach ($nodes as $node) {
                $toRemove[] = $node;
            }

            // Remove collected nodes
            foreach ($toRemove as $node) {
                if ($node->parentNode) {
                    $node->parentNode->removeChild($node);
                }
            }
        }

        // Extract body content
        $body = $dom->getElementsByTagName('body')->item(0);
        $cleaned = '';

        if ($body) {
            foreach ($body->childNodes as $child) {
                $cleaned .= $dom->saveHTML($child);
            }
        }

        // Restore error handling
        libxml_clear_errors();
        libxml_use_internal_errors($previousErrorSetting);

        return $cleaned;
    }

    /**
     * Strip dangerous tags using regex (fallback, less secure)
     *
     * @param string $value
     * @return string
     */
    protected static function stripDangerousTagsWithRegex(string $value): string
    {
        // Run multiple passes to handle nested tags
        $maxIterations = 5;
        $iteration = 0;

        do {
            $before = $value;
            $pattern = '/<(' . implode('|', self::$dangerousTags) . ')[^>]*>.*?<\/\1>|<(' . implode('|', self::$dangerousTags) . ')[^>]*\/>/is';
            $value = preg_replace($pattern, '', $value);
            $iteration++;
        } while ($value !== $before && $iteration < $maxIterations);

        return $value;
    }

    /**
     * Strip dangerous HTML attributes using DOMDocument
     *
     * This method uses DOMDocument for robust attribute removal,
     * which prevents bypasses with malformed attributes.
     *
     * @param string $value
     * @return string
     */
    public static function stripDangerousAttributes(string $value): string
    {
        // Quick check: if no HTML tags present, return as-is
        if (!str_contains($value, '<')) {
            return $value;
        }

        // Try DOMDocument approach (more robust)
        if (class_exists('DOMDocument')) {
            return self::stripDangerousAttributesWithDOM($value);
        }

        // Fallback to regex approach
        return self::stripDangerousAttributesWithRegex($value);
    }

    /**
     * Strip dangerous attributes using DOMDocument (robust, prevents bypass)
     *
     * @param string $value
     * @return string
     */
    protected static function stripDangerousAttributesWithDOM(string $value): string
    {
        // Create DOMDocument and suppress warnings for malformed HTML
        $dom = new \DOMDocument();
        $previousErrorSetting = libxml_use_internal_errors(true);

        // Wrap in div to preserve fragments, use UTF-8 meta tag
        $wrapped = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>' . $value . '</body></html>';
        $dom->loadHTML($wrapped, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // Traverse all elements and remove dangerous attributes
        $xpath = new \DOMXPath($dom);
        $elements = $xpath->query('//*');

        foreach ($elements as $element) {
            if ($element instanceof \DOMElement) {
                // Remove dangerous attributes
                foreach (self::$dangerousAttributes as $attribute) {
                    if ($element->hasAttribute($attribute)) {
                        $element->removeAttribute($attribute);
                    }
                }

                // Also check for javascript: protocol in href/src
                foreach (['href', 'src', 'action', 'formaction'] as $attr) {
                    if ($element->hasAttribute($attr)) {
                        $value = $element->getAttribute($attr);
                        if (preg_match('/^\s*javascript:/i', $value)) {
                            $element->removeAttribute($attr);
                        }
                    }
                }

                // Remove data: protocol in src (can be used for XSS)
                if ($element->hasAttribute('src')) {
                    $value = $element->getAttribute('src');
                    if (preg_match('/^\s*data:text\/html/i', $value)) {
                        $element->removeAttribute('src');
                    }
                }
            }
        }

        // Extract body content
        $body = $dom->getElementsByTagName('body')->item(0);
        $cleaned = '';

        if ($body) {
            foreach ($body->childNodes as $child) {
                $cleaned .= $dom->saveHTML($child);
            }
        }

        // Restore error handling
        libxml_clear_errors();
        libxml_use_internal_errors($previousErrorSetting);

        return $cleaned;
    }

    /**
     * Strip dangerous attributes using regex (fallback, less secure)
     *
     * @param string $value
     * @return string
     */
    protected static function stripDangerousAttributesWithRegex(string $value): string
    {
        // Remove event handler attributes
        foreach (self::$dangerousAttributes as $attribute) {
            $pattern = '/' . preg_quote($attribute, '/') . '\s*=\s*(["\'][^"\']*["\']|[^\s>]+)/i';
            $value = preg_replace($pattern, '', $value);
        }

        // Remove javascript: protocol
        $value = preg_replace('/(href|src|action|formaction)\s*=\s*(["\'])\s*javascript:/i', '$1=$2', $value);

        // Remove data:text/html protocol
        $value = preg_replace('/src\s*=\s*(["\'])\s*data:text\/html/i', 'src=$1', $value);

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
