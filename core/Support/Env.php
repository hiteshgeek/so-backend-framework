<?php

namespace Core\Support;

/**
 * Environment Variable Parser
 *
 * Loads and parses .env files
 */
class Env
{
    /**
     * Loaded environment variables
     *
     * @var array
     */
    private static array $variables = [];

    /**
     * Whether environment has been loaded
     *
     * @var bool
     */
    private static bool $loaded = false;

    /**
     * Load environment file
     *
     * @param string $path
     * @return void
     */
    public static function load(string $path): void
    {
        if (self::$loaded) {
            return;
        }

        if (!file_exists($path)) {
            throw new \RuntimeException("Environment file not found: {$path}");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Skip comments
            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            // Parse line
            if (str_contains($line, '=')) {
                list($name, $value) = explode('=', $line, 2);

                $name = trim($name);
                $value = trim($value);

                // Remove quotes
                $value = self::stripQuotes($value);

                // Set in environment
                self::$variables[$name] = $value;

                // Set in PHP environment
                if (!array_key_exists($name, $_ENV)) {
                    $_ENV[$name] = $value;
                }

                if (!array_key_exists($name, $_SERVER)) {
                    $_SERVER[$name] = $value;
                }

                putenv("{$name}={$value}");
            }
        }

        self::$loaded = true;
    }

    /**
     * Get environment variable
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        // Check our loaded variables first
        if (array_key_exists($key, self::$variables)) {
            return self::parseValue(self::$variables[$key]);
        }

        // Check PHP environment
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

        if ($value === false) {
            return value($default);
        }

        return self::parseValue($value);
    }

    /**
     * Set environment variable
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, mixed $value): void
    {
        self::$variables[$key] = $value;
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
        putenv("{$key}={$value}");
    }

    /**
     * Check if environment variable exists
     *
     * @param string $key
     * @return bool
     */
    public static function has(string $key): bool
    {
        return array_key_exists($key, self::$variables)
            || array_key_exists($key, $_ENV)
            || array_key_exists($key, $_SERVER)
            || getenv($key) !== false;
    }

    /**
     * Strip quotes from value
     *
     * @param string $value
     * @return string
     */
    private static function stripQuotes(string $value): string
    {
        if (strlen($value) >= 2) {
            $firstChar = $value[0];
            $lastChar = $value[strlen($value) - 1];

            if (($firstChar === '"' && $lastChar === '"') || ($firstChar === "'" && $lastChar === "'")) {
                return substr($value, 1, -1);
            }
        }

        return $value;
    }

    /**
     * Parse value to appropriate type
     *
     * @param mixed $value
     * @return mixed
     */
    private static function parseValue(mixed $value): mixed
    {
        if (!is_string($value)) {
            return $value;
        }

        // Boolean values
        $lower = strtolower($value);
        if ($lower === 'true' || $lower === '(true)') {
            return true;
        }
        if ($lower === 'false' || $lower === '(false)') {
            return false;
        }

        // Null values
        if ($lower === 'null' || $lower === '(null)') {
            return null;
        }

        // Empty string
        if ($lower === 'empty' || $lower === '(empty)') {
            return '';
        }

        // Numeric values
        if (is_numeric($value)) {
            return str_contains($value, '.') ? (float) $value : (int) $value;
        }

        return $value;
    }

    /**
     * Get all environment variables
     *
     * @return array
     */
    public static function all(): array
    {
        return self::$variables;
    }

    /**
     * Clear loaded environment
     *
     * @return void
     */
    public static function clear(): void
    {
        self::$variables = [];
        self::$loaded = false;
    }
}
