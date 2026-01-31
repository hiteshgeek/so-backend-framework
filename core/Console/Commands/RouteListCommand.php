<?php

namespace Core\Console\Commands;

use Core\Console\Command;
use Core\Routing\Router;

/**
 * Route List Command
 *
 * Displays all registered routes in a formatted table
 *
 * Usage:
 *   php sixorbit route:list
 *   php sixorbit route:list --method=GET
 *   php sixorbit route:list --method=POST
 *   php sixorbit route:list --name=user
 *   php sixorbit route:list --method=GET --name=api
 */
class RouteListCommand extends Command
{
    protected string $signature = 'route:list {--method=} {--name=}';
    protected string $description = 'Display all registered routes';

    public function handle(): int
    {
        try {
            $router = app('router');
            $routes = Router::getRoutes();

            if (empty($routes)) {
                $this->comment('No routes registered.');
                return 0;
            }

            // Apply filters
            $methodFilter = $this->option('method');
            $nameFilter = $this->option('name');

            $filteredRoutes = $this->filterRoutes($routes, $methodFilter, $nameFilter);

            if (empty($filteredRoutes)) {
                $this->comment('No routes match the specified filters.');
                return 0;
            }

            // Display routes in formatted table
            $this->displayRoutes($filteredRoutes);

            return 0;
        } catch (\Exception $e) {
            $this->error("Error listing routes: " . $e->getMessage());
            return 1;
        }
    }

    /**
     * Filter routes based on method and name
     *
     * @param array $routes
     * @param string|null $methodFilter
     * @param string|null $nameFilter
     * @return array
     */
    protected function filterRoutes(array $routes, ?string $methodFilter, ?string $nameFilter): array
    {
        $filtered = [];

        foreach ($routes as $route) {
            // Filter by method
            if ($methodFilter !== null) {
                $methods = $route->getMethods();
                if (!in_array(strtoupper($methodFilter), $methods)) {
                    continue;
                }
            }

            // Filter by name (partial match)
            if ($nameFilter !== null) {
                $routeName = $route->getName() ?? '';
                if (stripos($routeName, $nameFilter) === false) {
                    continue;
                }
            }

            $filtered[] = $route;
        }

        return $filtered;
    }

    /**
     * Display routes in a formatted table
     *
     * @param array $routes
     * @return void
     */
    protected function displayRoutes(array $routes): void
    {
        // Calculate column widths
        $methodWidth = 10;
        $uriWidth = 40;
        $nameWidth = 30;
        $actionWidth = 50;

        foreach ($routes as $route) {
            $methods = implode('|', $route->getMethods());
            $methodWidth = max($methodWidth, strlen($methods) + 2);
            $uriWidth = max($uriWidth, strlen($route->getUri()) + 2);

            $name = $route->getName() ?? '';
            $nameWidth = max($nameWidth, strlen($name) + 2);

            $action = $this->getActionString($route);
            $actionWidth = max($actionWidth, strlen($action) + 2);
        }

        // Print header
        $separator = '+' . str_repeat('-', $methodWidth) . '+' .
                    str_repeat('-', $uriWidth) . '+' .
                    str_repeat('-', $nameWidth) . '+' .
                    str_repeat('-', $actionWidth) . '+';

        $this->info($separator);
        $this->info(
            '|' . str_pad(' Method', $methodWidth) .
            '|' . str_pad(' URI', $uriWidth) .
            '|' . str_pad(' Name', $nameWidth) .
            '|' . str_pad(' Action', $actionWidth) . '|'
        );
        $this->info($separator);

        // Print routes
        foreach ($routes as $route) {
            $methods = implode('|', $route->getMethods());
            $uri = $route->getUri();
            $name = $route->getName() ?? '';
            $action = $this->getActionString($route);

            // Truncate if too long
            if (strlen($action) > $actionWidth - 2) {
                $action = substr($action, 0, $actionWidth - 5) . '...';
            }

            $this->info(
                '|' . str_pad(' ' . $methods, $methodWidth) .
                '|' . str_pad(' ' . $uri, $uriWidth) .
                '|' . str_pad(' ' . $name, $nameWidth) .
                '|' . str_pad(' ' . $action, $actionWidth) . '|'
            );
        }

        $this->info($separator);
        $this->info('Total routes: ' . count($routes));
    }

    /**
     * Get a string representation of the route action
     *
     * @param \Core\Routing\Route $route
     * @return string
     */
    protected function getActionString($route): string
    {
        $action = $route->getAction();

        if (is_array($action)) {
            return $action[0] . '@' . $action[1];
        }

        if ($action instanceof \Closure) {
            return 'Closure';
        }

        if (is_string($action)) {
            return $action;
        }

        if (is_callable($action)) {
            return 'Callable';
        }

        return 'Unknown';
    }
}
