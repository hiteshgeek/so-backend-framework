<?php

namespace Core\View;

/**
 * View Service with PHP Templates
 *
 * Provides template rendering with native PHP templates
 */
class View
{
    protected string $viewsPath;
    protected array $shared = [];

    public function __construct(string $viewsPath)
    {
        $this->viewsPath = rtrim($viewsPath, '/\\');
    }

    /**
     * Render a template
     *
     * @param string $template Template name (dot notation supported)
     * @param array $data Data to pass to the template
     * @return string Rendered content
     */
    public function render(string $template, array $data = []): string
    {
        // Convert dot notation to directory separator
        $template = str_replace('.', DIRECTORY_SEPARATOR, $template);
        $viewPath = $this->viewsPath . DIRECTORY_SEPARATOR . $template . '.php';

        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View not found: {$template}");
        }

        // Merge shared data with view data (view data takes precedence)
        $data = array_merge($this->shared, $data);

        // Extract data to local scope
        extract($data);

        // Capture output
        ob_start();
        try {
            require $viewPath;
            return ob_get_clean();
        } catch (\Throwable $e) {
            ob_end_clean();
            throw $e;
        }
    }

    /**
     * Add a global variable to all templates
     *
     * @param string $name Variable name
     * @param mixed $value Variable value
     * @return void
     */
    public function share(string $name, mixed $value): void
    {
        $this->shared[$name] = $value;
    }

    /**
     * Add multiple shared variables
     *
     * @param array $data Array of key-value pairs
     * @return void
     */
    public function shareMany(array $data): void
    {
        $this->shared = array_merge($this->shared, $data);
    }

    /**
     * Check if a view exists
     *
     * @param string $template Template name
     * @return bool
     */
    public function exists(string $template): bool
    {
        $template = str_replace('.', DIRECTORY_SEPARATOR, $template);
        $viewPath = $this->viewsPath . DIRECTORY_SEPARATOR . $template . '.php';

        return file_exists($viewPath);
    }

    /**
     * Get the views path
     *
     * @return string
     */
    public function getViewsPath(): string
    {
        return $this->viewsPath;
    }
}
