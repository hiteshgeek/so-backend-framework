<?php

/**
 * PHPUnit Test Bootstrap
 *
 * Sets up the testing environment for all test suites.
 */

// Load autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Set error reporting
error_reporting(E_ALL);

// Set default timezone
date_default_timezone_set('UTC');

// Load configuration helper first
require_once __DIR__ . '/../core/Support/Helpers.php';

// Try to bootstrap the application for integration tests
$bootstrapFile = __DIR__ . '/../bootstrap/app.php';
if (file_exists($bootstrapFile)) {
    // Bootstrap the application
    try {
        $app = require $bootstrapFile;

        // Set testing environment
        if ($app && method_exists($app, 'isDebug')) {
            // Application bootstrapped successfully
        }
    } catch (\Throwable $e) {
        // Application bootstrap failed - tests will run in isolated mode
        // This is fine for unit tests that don't need the full app
    }
}

// Define testing constants if not already defined
if (!defined('TESTING')) {
    define('TESTING', true);
}

// Set up a minimal config() function if not available
if (!function_exists('config')) {
    /**
     * Get configuration value (testing fallback)
     *
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    function config(?string $key = null, $default = null)
    {
        static $config = [];

        // Load config files if not already loaded
        if (empty($config)) {
            $configPath = __DIR__ . '/../config';
            if (is_dir($configPath)) {
                foreach (glob($configPath . '/*.php') as $file) {
                    $name = basename($file, '.php');
                    $config[$name] = require $file;
                }
            }
        }

        if ($key === null) {
            return $config;
        }

        // Handle dot notation
        $parts = explode('.', $key);
        $value = $config;

        foreach ($parts as $part) {
            if (!is_array($value) || !array_key_exists($part, $value)) {
                return $default;
            }
            $value = $value[$part];
        }

        return $value;
    }
}

// Set up storage_path helper if not available
if (!function_exists('storage_path')) {
    function storage_path(?string $path = null): string
    {
        $basePath = __DIR__ . '/../storage';
        return $path ? $basePath . '/' . ltrim($path, '/') : $basePath;
    }
}

// Set up base_path helper if not available
if (!function_exists('base_path')) {
    function base_path(?string $path = null): string
    {
        $basePath = __DIR__ . '/..';
        return $path ? $basePath . '/' . ltrim($path, '/') : $basePath;
    }
}

// Set up resource_path helper if not available
if (!function_exists('resource_path')) {
    function resource_path(?string $path = null): string
    {
        $basePath = __DIR__ . '/../resources';
        return $path ? $basePath . '/' . ltrim($path, '/') : $basePath;
    }
}

// Set up env helper if not available
if (!function_exists('env')) {
    function env(string $key, $default = null)
    {
        $value = getenv($key);
        if ($value === false) {
            return $default;
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'null':
            case '(null)':
                return null;
            case 'empty':
            case '(empty)':
                return '';
        }

        return $value;
    }
}

// Set up app helper if not available
if (!function_exists('app')) {
    function app(?string $abstract = null)
    {
        static $container = [];

        if ($abstract === null) {
            return \Core\Application::getInstance() ?? null;
        }

        if (isset($container[$abstract])) {
            return $container[$abstract];
        }

        // Try to get from application container
        try {
            $app = \Core\Application::getInstance();
            if ($app) {
                return $app->get($abstract);
            }
        } catch (\Throwable $e) {
            // Ignore
        }

        return null;
    }
}
