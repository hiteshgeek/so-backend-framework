<?php

namespace Core\Routing;

use Core\Http\Request;
use Core\Http\Response;

/**
 * Route Class
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

    public function __construct(array $methods, string $uri, $action)
    {
        $this->methods = $methods;
        $this->uri = $uri;
        $this->action = $action;
        $this->compilePattern();
    }

    protected function compilePattern(): void
    {
        $pattern = preg_replace('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', '(?P<$1>[^/]+)', $this->uri);
        $pattern = preg_replace('/\{([a-zA-Z_][a-zA-Z0-9_]*)\?\}/', '(?P<$1>[^/]*)', $pattern);
        $this->pattern = '#^' . $pattern . '$#';
    }

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

    public function run(Request $request): Response
    {
        if (is_array($this->action)) {
            [$controller, $method] = $this->action;
            $controller = app()->make($controller);
            return app()->call([$controller, $method], $this->parameters);
        }

        if (is_callable($this->action)) {
            return app()->call($this->action, $this->parameters);
        }

        throw new \Exception('Invalid route action');
    }

    public function middleware(array|string $middleware): self
    {
        $this->middleware = is_array($middleware) ? $middleware : [$middleware];
        return $this;
    }

    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

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
}
