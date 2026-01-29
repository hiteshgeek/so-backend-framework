<?php

namespace Core\Support;

/**
 * Configuration Manager
 *
 * Loads and manages configuration files
 */
class Config
{
    /**
     * Configuration path
     *
     * @var string
     */
    private string $configPath;

    /**
     * Loaded configurations
     *
     * @var array
     */
    private array $config = [];

    /**
     * Constructor
     *
     * @param string $configPath
     */
    public function __construct(string $configPath)
    {
        $this->configPath = rtrim($configPath, '/\\');
    }

    /**
     * Get configuration value
     *
     * @param string $key Dot notation key (e.g., 'database.default')
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $segments = explode('.', $key);
        $file = array_shift($segments);

        // Load file if not already loaded
        if (!isset($this->config[$file])) {
            $this->load($file);
        }

        // File not found
        if (!isset($this->config[$file])) {
            return value($default);
        }

        // Return entire file config if no segments
        if (empty($segments)) {
            return $this->config[$file];
        }

        // Navigate through segments
        $value = $this->config[$file];
        foreach ($segments as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return value($default);
            }
            $value = $value[$segment];
        }

        return $value;
    }

    /**
     * Set configuration value
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $segments = explode('.', $key);
        $file = array_shift($segments);

        // Load file if not already loaded
        if (!isset($this->config[$file])) {
            $this->load($file);
        }

        // Initialize file if needed
        if (!isset($this->config[$file])) {
            $this->config[$file] = [];
        }

        // Set value
        if (empty($segments)) {
            $this->config[$file] = $value;
            return;
        }

        // Navigate and set
        $current = &$this->config[$file];
        foreach ($segments as $segment) {
            if (!isset($current[$segment]) || !is_array($current[$segment])) {
                $current[$segment] = [];
            }
            $current = &$current[$segment];
        }
        $current = $value;
    }

    /**
     * Check if configuration key exists
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        $segments = explode('.', $key);
        $file = array_shift($segments);

        // Load file if not already loaded
        if (!isset($this->config[$file])) {
            $this->load($file);
        }

        // File not found
        if (!isset($this->config[$file])) {
            return false;
        }

        // Check segments
        $value = $this->config[$file];
        foreach ($segments as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return false;
            }
            $value = $value[$segment];
        }

        return true;
    }

    /**
     * Load configuration file
     *
     * @param string $file
     * @return void
     */
    private function load(string $file): void
    {
        $path = $this->configPath . DIRECTORY_SEPARATOR . $file . '.php';

        if (!file_exists($path)) {
            return;
        }

        $config = require $path;

        if (is_array($config)) {
            $this->config[$file] = $config;
        }
    }

    /**
     * Get all configuration
     *
     * @return array
     */
    public function all(): array
    {
        return $this->config;
    }

    /**
     * Load all configuration files
     *
     * @return void
     */
    public function loadAll(): void
    {
        if (!is_dir($this->configPath)) {
            return;
        }

        $files = glob($this->configPath . '/*.php');

        foreach ($files as $file) {
            $name = basename($file, '.php');
            $this->load($name);
        }
    }
}
