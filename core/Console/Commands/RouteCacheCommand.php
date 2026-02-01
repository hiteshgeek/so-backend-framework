<?php

namespace Core\Console\Commands;

use Core\Console\Command;
use Core\Routing\Router;

/**
 * Route Cache Command
 *
 * Caches all registered routes to improve performance in production
 *
 * Usage:
 *   php sixorbit route:cache
 */
class RouteCacheCommand extends Command
{
    protected string $signature = 'route:cache';
    protected string $description = 'Cache routes for production';

    public function handle(): int
    {
        try {
            $this->info('Caching routes...');

            // Get all routes from the router
            $router = app('router');
            $routes = Router::getRoutes();

            if (empty($routes)) {
                $this->comment('No routes to cache.');
                return 0;
            }

            // Serialize routes data
            $routesData = $this->serializeRoutes($routes);

            // Ensure storage/framework directory exists
            $frameworkPath = storage_path('framework');
            if (!is_dir($frameworkPath)) {
                if (!mkdir($frameworkPath, 0755, true)) {
                    $this->error("Failed to create directory: {$frameworkPath}");
                    return 1;
                }
            }

            // Write routes cache file
            $cachePath = $frameworkPath . DIRECTORY_SEPARATOR . 'routes.php';
            $content = '<?php' . PHP_EOL . PHP_EOL . 'return ' . var_export($routesData, true) . ';';

            if (file_put_contents($cachePath, $content) === false) {
                $this->error("Failed to write routes cache file: {$cachePath}");
                return 1;
            }

            $this->info("Routes cached successfully!");
            $this->info("Cache file: {$cachePath}");
            $this->comment("Total routes cached: " . count($routes));

            return 0;
        } catch (\Exception $e) {
            $this->error("Error caching routes: " . $e->getMessage());
            return 1;
        }
    }

    /**
     * Serialize routes to an array format suitable for caching
     *
     * @param array $routes
     * @return array
     */
    protected function serializeRoutes(array $routes): array
    {
        $serialized = [];

        foreach ($routes as $route) {
            $action = $route->getAction();

            // Serialize action
            if (is_array($action)) {
                $actionData = [
                    'type' => 'controller',
                    'controller' => $action[0],
                    'method' => $action[1],
                ];
            } elseif ($action instanceof \Closure) {
                $actionData = [
                    'type' => 'closure',
                    'closure' => 'Closure', // Closures cannot be serialized
                ];
            } else {
                $actionData = [
                    'type' => 'other',
                    'value' => is_string($action) ? $action : 'Callable',
                ];
            }

            $serialized[] = [
                'methods' => $route->getMethods(),
                'uri' => $route->getUri(),
                'name' => $route->getName(),
                'action' => $actionData,
                'middleware' => $route->getMiddleware(),
                'wheres' => $route->getWheres(),
            ];
        }

        return $serialized;
    }
}
