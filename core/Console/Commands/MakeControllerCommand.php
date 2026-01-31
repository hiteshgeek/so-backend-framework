<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Make Controller Command
 *
 * Generates a new controller class file.
 *
 * Usage:
 *   php sixorbit make:controller UserController
 *   php sixorbit make:controller Admin/UserController
 *   php sixorbit make:controller UserController --api
 *   php sixorbit make:controller UserController --resource
 *   php sixorbit make:controller UserController --force
 *   php sixorbit make:controller UserController --dry-run
 */
class MakeControllerCommand extends Command
{
    protected string $signature = 'make:controller {name} {--api} {--resource} {--force} {--dry-run}';

    protected string $description = 'Create a new controller class';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Controller name is required.');
            return 1;
        }

        // Parse nested paths (e.g., Admin/UserController)
        $parsedName = $this->parseName($name);
        $className = $parsedName['class'];
        $namespace = $parsedName['namespace'];
        $relativePath = $parsedName['path'];

        $basePath = getcwd();
        $filePath = $basePath . '/' . $relativePath;

        // Check if file exists
        if (file_exists($filePath) && !$this->option('force', false)) {
            $this->error("Controller already exists: {$relativePath}");
            $this->comment("Use --force to overwrite");
            return 1;
        }

        $isApi = $this->option('api', false);
        $isResource = $this->option('resource', false);

        if ($isApi) {
            $content = $this->buildApiController($className, $namespace);
        } elseif ($isResource) {
            $content = $this->buildResourceController($className, $namespace);
        } else {
            $content = $this->buildBasicController($className, $namespace);
        }

        // Dry run - show what would be created
        if ($this->option('dry-run', false)) {
            $this->comment("Would create: {$relativePath}");
            $this->info("\n" . $content);
            return 0;
        }

        // Create directory if it doesn't exist
        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Write file
        if (file_put_contents($filePath, $content) === false) {
            $this->error("Failed to create controller: {$relativePath}");
            return 1;
        }

        $this->info("Controller created successfully: {$relativePath}");
        return 0;
    }

    /**
     * Parse the name to extract class name, namespace, and file path
     * Supports nested paths like Admin/UserController
     */
    protected function parseName(string $name): array
    {
        // Remove .php extension if provided
        $name = str_replace('.php', '', $name);

        // Split by forward slash for nested paths
        $parts = explode('/', $name);
        $className = array_pop($parts);

        // Build namespace
        $namespace = 'App\\Controllers';
        if (!empty($parts)) {
            $namespace .= '\\' . implode('\\', $parts);
        }

        // Build file path
        $path = 'app/Controllers';
        if (!empty($parts)) {
            $path .= '/' . implode('/', $parts);
        }
        $path .= '/' . $className . '.php';

        return [
            'class' => $className,
            'namespace' => $namespace,
            'path' => $path,
        ];
    }

    /**
     * Build a basic controller with no methods
     */
    protected function buildBasicController(string $className, string $namespace): string
    {
        return <<<PHP
<?php

namespace {$namespace};

use Core\Http\Request;
use Core\Http\Response;

/**
 * {$className}
 */
class {$className}
{
    //
}
PHP;
    }

    /**
     * Build an API controller with JSON resource methods
     */
    protected function buildApiController(string $className, string $namespace): string
    {
        return <<<PHP
<?php

namespace {$namespace};

use Core\Http\Request;
use Core\Http\JsonResponse;

/**
 * {$className}
 *
 * API resource controller
 */
class {$className}
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request \$request): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'data' => [],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request \$request, int \$id): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'data' => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request \$request): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'message' => 'Resource created successfully.',
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request \$request, int \$id): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'message' => 'Resource updated successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request \$request, int \$id): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'message' => 'Resource deleted successfully.',
        ]);
    }
}
PHP;
    }

    /**
     * Build a resource controller with view-returning methods
     */
    protected function buildResourceController(string $className, string $namespace): string
    {
        $viewPath = $this->guessViewPath($className);

        return <<<PHP
<?php

namespace {$namespace};

use Core\Http\Request;
use Core\Http\Response;

/**
 * {$className}
 *
 * Resource controller
 */
class {$className}
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request \$request): Response
    {
        return Response::view('{$viewPath}/index', [
            //
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request \$request): Response
    {
        return Response::view('{$viewPath}/create', [
            //
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request \$request): Response
    {
        // Validate and store...

        return redirect(url('/'))
            ->with('success', 'Resource created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request \$request, int \$id): Response
    {
        return Response::view('{$viewPath}/show', [
            //
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request \$request, int \$id): Response
    {
        return Response::view('{$viewPath}/edit', [
            //
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request \$request, int \$id): Response
    {
        // Validate and update...

        return redirect(url('/'))
            ->with('success', 'Resource updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request \$request, int \$id): Response
    {
        // Delete resource...

        return redirect(url('/'))
            ->with('success', 'Resource deleted successfully.');
    }
}
PHP;
    }

    /**
     * Guess the view path from the controller name
     * e.g., "UserController" -> "users", "ProductController" -> "products"
     */
    protected function guessViewPath(string $name): string
    {
        $name = str_replace('Controller', '', $name);
        $name = $this->toSnakeCase($name);
        // Simple pluralization: append 's'
        return $name . 's';
    }

    /**
     * Convert a PascalCase string to snake_case
     */
    protected function toSnakeCase(string $value): string
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $value));
    }
}
