<?php

namespace Core\Routing;

use Core\Http\Request;
use Core\Http\Response;

/**
 * Route Class
 *
 * Represents a single route with support for:
 * - HTTP method matching
 * - URI pattern matching with parameters
 * - Parameter constraints (where, whereNumber, etc.)
 * - Middleware
 * - Named routes
 * - Route model binding
 */
class Route
{
    protected string $uri;
    protected array $methods;
    protected $action;
    protected array $middleware = [];
    protected ?string $name = null;
    protected array $parameters = [];
    protected ?string $pattern = null;
    protected array $wheres = [];

    public function __construct(array $methods, string $uri, $action)
    {
        $this->methods = $methods;
        $this->uri = $uri;
        $this->action = $action;
        $this->compilePattern();
    }

    /**
     * Compile URI pattern to regex
     */
    protected function compilePattern(): void
    {
        $pattern = $this->uri;

        // Replace optional parameters with regex (must be done first)
        $pattern = preg_replace_callback('/\{([a-zA-Z_][a-zA-Z0-9_]*)\?\}/', function ($matches) {
            $param = $matches[1];
            $regex = $this->wheres[$param] ?? '[^/]*';
            return "(?P<{$param}>{$regex})";
        }, $pattern);

        // Replace required parameters with regex
        $pattern = preg_replace_callback('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', function ($matches) {
            $param = $matches[1];
            $regex = $this->wheres[$param] ?? '[^/]+';
            return "(?P<{$param}>{$regex})";
        }, $pattern);

        $this->pattern = '#^' . $pattern . '$#';
    }

    /**
     * Check if route matches the request
     */
    public function matches(Request $request): bool
    {
        if (!in_array($request->method(), $this->methods)) {
            return false;
        }

        if (preg_match($this->pattern, $request->uri(), $matches)) {
            foreach ($matches as $key => $value) {
                if (!is_numeric($key)) {
                    $this->parameters[$key] = $value;
                }
            }
            return true;
        }

        return false;
    }

    /**
     * Run the route handler
     */
    public function run(Request $request): Response
    {
        $parameters = array_merge(['request' => $request], $this->parameters);

        if (is_array($this->action)) {
            [$controller, $method] = $this->action;
            $controllerInstance = app()->make($controller);

            // Resolve model bindings for controller methods
            $parameters = $this->resolveModelBindings($controllerInstance, $method, $parameters);

            return app()->call([$controllerInstance, $method], $parameters);
        }

        if ($this->action instanceof \Closure) {
            // Resolve model bindings for closures
            $parameters = $this->resolveClosureBindings($this->action, $parameters);
            return app()->call($this->action, $parameters);
        }

        if (is_callable($this->action)) {
            return app()->call($this->action, $parameters);
        }

        throw new \Exception('Invalid route action');
    }

    /**
     * Resolve route model bindings for controller methods
     */
    protected function resolveModelBindings($controller, string $method, array $parameters): array
    {
        try {
            $reflection = new \ReflectionMethod($controller, $method);

            foreach ($reflection->getParameters() as $param) {
                $type = $param->getType();
                $paramName = $param->getName();

                if ($type && !$type->isBuiltin() && isset($parameters[$paramName])) {
                    $className = $type->getName();

                    // Check if it's a Model class
                    if (is_subclass_of($className, \Core\Model\Model::class)) {
                        $id = $parameters[$paramName];
                        $model = $className::find((int) $id);

                        if (!$model) {
                            throw new \Core\Exceptions\NotFoundException("Resource not found");
                        }

                        $parameters[$paramName] = $model;
                    }
                }
            }
        } catch (\ReflectionException $e) {
            // If reflection fails, continue without model binding
        }

        return $parameters;
    }

    /**
     * Resolve route model bindings for closures
     */
    protected function resolveClosureBindings(\Closure $closure, array $parameters): array
    {
        try {
            $reflection = new \ReflectionFunction($closure);

            foreach ($reflection->getParameters() as $param) {
                $type = $param->getType();
                $paramName = $param->getName();

                if ($type && !$type->isBuiltin() && isset($parameters[$paramName])) {
                    $className = $type->getName();

                    // Check if it's a Model class
                    if (is_subclass_of($className, \Core\Model\Model::class)) {
                        $id = $parameters[$paramName];
                        $model = $className::find((int) $id);

                        if (!$model) {
                            throw new \Core\Exceptions\NotFoundException("Resource not found");
                        }

                        $parameters[$paramName] = $model;
                    }
                }
            }
        } catch (\ReflectionException $e) {
            // If reflection fails, continue without model binding
        }

        return $parameters;
    }

    // ==========================================
    // Where Constraint Methods
    // ==========================================

    /**
     * Add regex constraint for route parameter(s)
     *
     * @param string|array $name Parameter name or array of name => pattern
     * @param string|null $pattern Regex pattern (if $name is string)
     * @return self
     */
    public function where(string|array $name, ?string $pattern = null): self
    {
        if (is_array($name)) {
            foreach ($name as $key => $value) {
                $this->wheres[$key] = $value;
            }
        } else {
            $this->wheres[$name] = $pattern;
        }
        $this->compilePattern();
        return $this;
    }

    /**
     * Constrain parameter(s) to numeric values only
     */
    public function whereNumber(string ...$parameters): self
    {
        foreach ($parameters as $param) {
            $this->wheres[$param] = '[0-9]+';
        }
        $this->compilePattern();
        return $this;
    }

    /**
     * Constrain parameter(s) to alphabetic characters only
     */
    public function whereAlpha(string ...$parameters): self
    {
        foreach ($parameters as $param) {
            $this->wheres[$param] = '[a-zA-Z]+';
        }
        $this->compilePattern();
        return $this;
    }

    /**
     * Constrain parameter(s) to alphanumeric characters only
     */
    public function whereAlphaNumeric(string ...$parameters): self
    {
        foreach ($parameters as $param) {
            $this->wheres[$param] = '[a-zA-Z0-9]+';
        }
        $this->compilePattern();
        return $this;
    }

    /**
     * Constrain parameter(s) to UUID format
     */
    public function whereUuid(string ...$parameters): self
    {
        foreach ($parameters as $param) {
            $this->wheres[$param] = '[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}';
        }
        $this->compilePattern();
        return $this;
    }

    /**
     * Constrain parameter to specific values
     */
    public function whereIn(string $parameter, array $values): self
    {
        $this->wheres[$parameter] = implode('|', array_map(function ($v) {
            return preg_quote($v, '#');
        }, $values));
        $this->compilePattern();
        return $this;
    }

    /**
     * Constrain parameter(s) to slug format (alphanumeric with dashes)
     */
    public function whereSlug(string ...$parameters): self
    {
        foreach ($parameters as $param) {
            $this->wheres[$param] = '[a-zA-Z0-9-]+';
        }
        $this->compilePattern();
        return $this;
    }

    // ==========================================
    // Fluent Methods
    // ==========================================

    /**
     * Set middleware for this route
     */
    public function middleware(array|string $middleware): self
    {
        $this->middleware = is_array($middleware) ? $middleware : [$middleware];
        return $this;
    }

    /**
     * Set the route name
     */
    public function name(string $name): self
    {
        $this->name = $name;
        Router::registerNamed($name, $this);
        return $this;
    }

    // ==========================================
    // Getter Methods
    // ==========================================

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getMethods(): array
    {
        return $this->methods;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getWheres(): array
    {
        return $this->wheres;
    }
}
