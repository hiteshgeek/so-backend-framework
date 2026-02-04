<?php

namespace Core\UiEngine\Support;

/**
 * CssPrefix - Centralized CSS prefix management for UiEngine
 *
 * Provides consistent prefix handling for all CSS class names,
 * matching the SixOrbit JavaScript configuration.
 */
class CssPrefix
{
    /**
     * The CSS class prefix
     *
     * @var string
     */
    protected static string $prefix = 'so';

    /**
     * The data attribute prefix
     *
     * @var string
     */
    protected static string $dataPrefix = 'data-so';

    /**
     * Set the CSS prefix
     *
     * @param string $prefix
     * @return void
     */
    public static function setPrefix(string $prefix): void
    {
        static::$prefix = $prefix;
    }

    /**
     * Get the raw prefix
     *
     * @return string
     */
    public static function getPrefix(): string
    {
        return static::$prefix;
    }

    /**
     * Build a CSS class name with the prefix
     *
     * Examples:
     *   CssPrefix::cls('form-control') => 'so-form-control'
     *   CssPrefix::cls('btn', 'primary') => 'so-btn-primary'
     *   CssPrefix::cls('col', 6) => 'so-col-6'
     *
     * @param string ...$parts Class name parts to join with hyphen
     * @return string
     */
    public static function cls(string ...$parts): string
    {
        if (empty($parts)) {
            return static::$prefix;
        }

        return static::$prefix . '-' . implode('-', $parts);
    }

    /**
     * Build a CSS selector with the prefix
     *
     * Examples:
     *   CssPrefix::sel('form-control') => '.so-form-control'
     *   CssPrefix::sel('btn', 'primary') => '.so-btn-primary'
     *
     * @param string ...$parts Class name parts to join with hyphen
     * @return string
     */
    public static function sel(string ...$parts): string
    {
        return '.' . static::cls(...$parts);
    }

    /**
     * Build a data attribute name with the prefix
     *
     * Examples:
     *   CssPrefix::data('toggle') => 'data-so-toggle'
     *   CssPrefix::data('target') => 'data-so-target'
     *
     * @param string $name Attribute name without prefix
     * @return string
     */
    public static function data(string $name): string
    {
        return static::$dataPrefix . '-' . $name;
    }

    /**
     * Build multiple CSS class names
     *
     * Examples:
     *   CssPrefix::classes('btn', 'btn-primary') => 'so-btn so-btn-primary'
     *   CssPrefix::classes(['btn', 'btn-primary']) => 'so-btn so-btn-primary'
     *
     * @param string|array ...$classes
     * @return string
     */
    public static function classes(string|array ...$classes): string
    {
        $result = [];

        foreach ($classes as $class) {
            if (is_array($class)) {
                foreach ($class as $c) {
                    $result[] = static::cls($c);
                }
            } else {
                $result[] = static::cls($class);
            }
        }

        return implode(' ', $result);
    }

    /**
     * Conditionally build a class name
     *
     * @param bool $condition
     * @param string ...$parts Class name parts if condition is true
     * @return string Empty string if condition is false
     */
    public static function clsIf(bool $condition, string ...$parts): string
    {
        return $condition ? static::cls(...$parts) : '';
    }
}
