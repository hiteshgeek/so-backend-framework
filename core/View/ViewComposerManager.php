<?php

namespace Core\View;

use Core\Application;

/**
 * Manages View Composers - callbacks that inject data into views
 *
 * View composers automatically inject data into specific views when rendered.
 * Supports pattern matching with wildcards for flexible view targeting.
 *
 * Usage:
 *   $composers->composer('admin.*', fn($view, $data) => ['menu' => getAdminMenu()]);
 *   $composers->composer('dashboard.index', DashboardComposer::class);
 */
class ViewComposerManager
{
    /**
     * Pattern => composers mapping
     * @var array<string, array<callable|string>>
     */
    protected array $composers = [];

    /**
     * Application instance for resolving class-based composers
     */
    protected Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Register a composer for view(s)
     *
     * @param string|array $views View name(s), supports wildcards (e.g., 'admin.*', 'admin.**')
     * @param callable|string $composer Closure or class name implementing ViewComposer
     * @return void
     */
    public function composer(string|array $views, callable|string $composer): void
    {
        $views = (array) $views;

        foreach ($views as $view) {
            if (!isset($this->composers[$view])) {
                $this->composers[$view] = [];
            }
            $this->composers[$view][] = $composer;
        }
    }

    /**
     * Get composed data for a view
     *
     * Runs all matching composers and merges their data with existing data.
     *
     * @param string $viewName The view being rendered
     * @param array $existingData Existing view data
     * @return array Merged data with composer injections
     */
    public function compose(string $viewName, array $existingData = []): array
    {
        $composedData = $existingData;

        foreach ($this->composers as $pattern => $composers) {
            if ($this->matches($pattern, $viewName)) {
                foreach ($composers as $composer) {
                    $data = $this->resolveComposer($composer, $viewName, $composedData);
                    if (is_array($data)) {
                        $composedData = array_merge($composedData, $data);
                    }
                }
            }
        }

        return $composedData;
    }

    /**
     * Check if a pattern matches a view name
     *
     * Supports:
     * - Exact match: 'dashboard.index' matches only 'dashboard.index'
     * - Single wildcard: 'admin.*' matches 'admin.users', 'admin.settings'
     * - Deep wildcard: 'admin.**' matches 'admin.users', 'admin.users.edit', 'admin.settings.general'
     *
     * @param string $pattern Pattern to match against
     * @param string $viewName View name to check
     * @return bool
     */
    protected function matches(string $pattern, string $viewName): bool
    {
        // Exact match
        if ($pattern === $viewName) {
            return true;
        }

        // No wildcards - no match
        if (!str_contains($pattern, '*')) {
            return false;
        }

        // Handle '**' (deep wildcard) - matches any depth
        if (str_contains($pattern, '**')) {
            $regex = str_replace('.', '\.', $pattern);
            $regex = str_replace('**', '.*', $regex);
            $regex = '/^' . $regex . '$/';
            return (bool) preg_match($regex, $viewName);
        }

        // Handle '*' (single level wildcard) - matches one segment only
        $regex = str_replace('.', '\.', $pattern);
        $regex = str_replace('*', '[^.]+', $regex);
        $regex = '/^' . $regex . '$/';

        return (bool) preg_match($regex, $viewName);
    }

    /**
     * Resolve a composer (closure or class-based)
     *
     * @param callable|string $composer
     * @param string $viewName
     * @param array $data
     * @return array|null
     */
    protected function resolveComposer(callable|string $composer, string $viewName, array $data): ?array
    {
        // Closure-based composer
        if (is_callable($composer)) {
            return $composer($viewName, $data);
        }

        // Class-based composer
        try {
            $instance = $this->app->make($composer);

            if (method_exists($instance, 'compose')) {
                return $instance->compose($viewName, $data);
            }
        } catch (\Throwable $e) {
            // Log error but don't break rendering
            error_log("View composer error [{$composer}]: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Check if any composers are registered for a view
     *
     * @param string $viewName
     * @return bool
     */
    public function hasComposers(string $viewName): bool
    {
        foreach ($this->composers as $pattern => $composers) {
            if ($this->matches($pattern, $viewName) && !empty($composers)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get all registered patterns
     *
     * @return array
     */
    public function getPatterns(): array
    {
        return array_keys($this->composers);
    }

    /**
     * Clear all composers (useful for testing)
     *
     * @return void
     */
    public function clear(): void
    {
        $this->composers = [];
    }
}
