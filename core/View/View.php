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
    protected array $sections = [];
    protected array $sectionStack = [];
    protected ?string $currentLayout = null;
    protected array $layoutData = [];

    public function __construct(string $viewsPath)
    {
        $this->viewsPath = rtrim($viewsPath, '/\\');
    }

    /**
     * Render a template with layout inheritance support
     *
     * @param string $template Template name (dot notation supported)
     * @param array $data Data to pass to the template
     * @return string Rendered content
     */
    public function render(string $template, array $data = []): string
    {
        $viewPath = $this->resolveViewPath($template);

        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View not found: {$template}");
        }

        // Merge shared data with view data (view data takes precedence)
        $data = array_merge($this->shared, $data);

        // Reset layout state for this render
        $this->currentLayout = null;
        $this->sections = [];
        $this->sectionStack = [];

        // Render the child view (it may call extends() to set a layout)
        $content = $this->renderViewFile($viewPath, $data);

        // If child called extends(), render the layout with sections
        if ($this->currentLayout !== null) {
            $layoutPath = $this->resolveViewPath($this->currentLayout);
            if (!file_exists($layoutPath)) {
                throw new \RuntimeException("Layout not found: {$this->currentLayout}");
            }
            // Store child body content as 'content' section if not defined
            if (!isset($this->sections['content'])) {
                $this->sections['content'] = $content;
            }
            $content = $this->renderViewFile($layoutPath, array_merge($data, $this->layoutData));
        }

        return $content;
    }

    /**
     * Render a PHP view file and capture output
     */
    protected function renderViewFile(string $viewPath, array $data): string
    {
        extract($data);

        // Make $view available in templates for calling section/yield/extends
        $view = $this;

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
     * Set the layout this view extends
     *
     * Call from a child view: $view->extends('layouts.app')
     */
    public function extends(string $layout, array $data = []): void
    {
        $this->currentLayout = $layout;
        $this->layoutData = $data;
    }

    /**
     * Start a named section
     *
     * Call from a child view: $view->section('title')
     */
    public function section(string $name): void
    {
        $this->sectionStack[] = $name;
        ob_start();
    }

    /**
     * End the current section
     */
    public function endSection(): void
    {
        if (empty($this->sectionStack)) {
            throw new \RuntimeException('Cannot end a section without starting one.');
        }

        $name = array_pop($this->sectionStack);
        $this->sections[$name] = ob_get_clean();
    }

    /**
     * Yield a section's content in a layout
     *
     * Call from layout: <?= $view->yield('title', 'Default Title') ?>
     */
    public function yield(string $name, string $default = ''): string
    {
        return $this->sections[$name] ?? $default;
    }

    /**
     * Include a partial view
     *
     * Call from any view: <?php $view->include('partials.nav', ['active' => 'home']) ?>
     */
    public function include(string $template, array $data = []): void
    {
        $viewPath = $this->resolveViewPath($template);

        if (!file_exists($viewPath)) {
            throw new \RuntimeException("Partial not found: {$template}");
        }

        $data = array_merge($this->shared, $data);
        $data['view'] = $this;
        extract($data);

        require $viewPath;
    }

    /**
     * Resolve a dot-notation template name to a file path
     */
    protected function resolveViewPath(string $template): string
    {
        $template = str_replace('.', DIRECTORY_SEPARATOR, $template);
        return $this->viewsPath . DIRECTORY_SEPARATOR . $template . '.php';
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
