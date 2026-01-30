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
 *   php sixorbit make:controller UserController --api
 *   php sixorbit make:controller UserController --resource
 */
class MakeControllerCommand extends Command
{
    protected string $signature = 'make:controller {name} {--api} {--resource}';

    protected string $description = 'Create a new controller class';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Controller name is required.');
            return 1;
        }

        $basePath = getcwd();
        $relativePath = 'app/Controllers/' . $name . '.php';
        $filePath = $basePath . '/' . $relativePath;

        if (file_exists($filePath)) {
            $this->error("Controller already exists: {$relativePath}");
            return 1;
        }

        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $isApi = $this->option('api', false);
        $isResource = $this->option('resource', false);

        if ($isApi) {
            $content = $this->buildApiController($name);
        } elseif ($isResource) {
            $content = $this->buildResourceController($name);
        } else {
            $content = $this->buildBasicController($name);
        }

        if (file_put_contents($filePath, $content) === false) {
            $this->error("Failed to create controller: {$relativePath}");
            return 1;
        }

        $this->info("Controller created successfully: {$relativePath}");
        return 0;
    }

    /**
     * Build a basic controller with no methods
     */
    protected function buildBasicController(string $name): string
    {
        return <<<PHP
<?php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;

/**
 * {$name}
 */
class {$name}
{
    //
}
PHP;
    }

    /**
     * Build an API controller with JSON resource methods
     */
    protected function buildApiController(string $name): string
    {
        return <<<PHP
<?php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\JsonResponse;

/**
 * {$name}
 *
 * API resource controller
 */
class {$name}
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
    protected function buildResourceController(string $name): string
    {
        return <<<PHP
<?php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;

/**
 * {$name}
 *
 * Resource controller
 */
class {$name}
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request \$request): Response
    {
        return Response::view('{$this->guessViewPath($name)}/index', [
            //
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request \$request): Response
    {
        return Response::view('{$this->guessViewPath($name)}/create', [
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
        return Response::view('{$this->guessViewPath($name)}/show', [
            //
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request \$request, int \$id): Response
    {
        return Response::view('{$this->guessViewPath($name)}/edit', [
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
