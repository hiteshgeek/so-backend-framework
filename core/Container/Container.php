<?php

namespace Core\Container;

use Closure;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionParameter;

/**
 * Dependency Injection Container
 *
 * Manages service bindings and auto-resolution
 */
class Container
{
    /**
     * Service bindings
     *
     * @var array
     */
    protected array $bindings = [];

    /**
     * Singleton instances
     *
     * @var array
     */
    protected array $instances = [];

    /**
     * Aliases
     *
     * @var array
     */
    protected array $aliases = [];

    /**
     * Bind a service to the container
     *
     * @param string $abstract
     * @param Closure|string|null $concrete
     * @param bool $shared
     * @return void
     */
    public function bind(string $abstract, Closure|string|null $concrete = null, bool $shared = false): void
    {
        // Remove existing instance if rebinding
        if ($shared && isset($this->instances[$abstract])) {
            unset($this->instances[$abstract]);
        }

        // If no concrete given, use abstract as concrete
        if ($concrete === null) {
            $concrete = $abstract;
        }

        $this->bindings[$abstract] = [
            'concrete' => $concrete,
            'shared' => $shared,
        ];
    }

    /**
     * Bind a singleton service
     *
     * @param string $abstract
     * @param Closure|string|null $concrete
     * @return void
     */
    public function singleton(string $abstract, Closure|string|null $concrete = null): void
    {
        $this->bind($abstract, $concrete, true);
    }

    /**
     * Register an existing instance
     *
     * @param string $abstract
     * @param mixed $instance
     * @return void
     */
    public function instance(string $abstract, mixed $instance): void
    {
        $this->instances[$abstract] = $instance;
    }

    /**
     * Register an alias
     *
     * @param string $abstract
     * @param string $alias
     * @return void
     */
    public function alias(string $abstract, string $alias): void
    {
        $this->aliases[$alias] = $abstract;
    }

    /**
     * Resolve a service from the container
     *
     * @param string $abstract
     * @param array $parameters
     * @return mixed
     */
    public function make(string $abstract, array $parameters = []): mixed
    {
        // Resolve alias
        $abstract = $this->getAlias($abstract);

        // Return existing instance if singleton
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        // Get concrete implementation
        $concrete = $this->getConcrete($abstract);

        // Build the object
        if ($concrete instanceof Closure) {
            $object = $concrete($this, $parameters);
        } else {
            $object = $this->build($concrete, $parameters);
        }

        // Store as singleton if needed
        if (isset($this->bindings[$abstract]) && $this->bindings[$abstract]['shared']) {
            $this->instances[$abstract] = $object;
        }

        return $object;
    }

    /**
     * Check if service is bound
     *
     * @param string $abstract
     * @return bool
     */
    public function bound(string $abstract): bool
    {
        return isset($this->bindings[$abstract])
            || isset($this->instances[$abstract])
            || isset($this->aliases[$abstract]);
    }

    /**
     * Get concrete implementation
     *
     * @param string $abstract
     * @return Closure|string
     */
    protected function getConcrete(string $abstract): Closure|string
    {
        if (isset($this->bindings[$abstract])) {
            return $this->bindings[$abstract]['concrete'];
        }

        return $abstract;
    }

    /**
     * Build a concrete instance
     *
     * @param string $concrete
     * @param array $parameters
     * @return mixed
     * @throws ReflectionException
     */
    protected function build(string $concrete, array $parameters = []): mixed
    {
        // Get reflection class
        $reflector = new ReflectionClass($concrete);

        // Check if class is instantiable
        if (!$reflector->isInstantiable()) {
            throw new \Exception("Class {$concrete} is not instantiable");
        }

        // Get constructor
        $constructor = $reflector->getConstructor();

        // No constructor, just instantiate
        if ($constructor === null) {
            return new $concrete();
        }

        // Get constructor parameters
        $dependencies = $constructor->getParameters();

        // Resolve dependencies
        $instances = $this->resolveDependencies($dependencies, $parameters);

        // Create instance
        return $reflector->newInstanceArgs($instances);
    }

    /**
     * Resolve dependencies
     *
     * @param array $dependencies
     * @param array $parameters
     * @return array
     * @throws ReflectionException
     */
    protected function resolveDependencies(array $dependencies, array $parameters = []): array
    {
        $results = [];

        /** @var ReflectionParameter $dependency */
        foreach ($dependencies as $dependency) {
            // Check if parameter was explicitly provided
            if (array_key_exists($dependency->getName(), $parameters)) {
                $results[] = $parameters[$dependency->getName()];
                continue;
            }

            // Get dependency type
            $type = $dependency->getType();

            // If no type hint or not a class, use default value or null
            if ($type === null || !$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                if ($dependency->isDefaultValueAvailable()) {
                    $results[] = $dependency->getDefaultValue();
                } elseif ($type && $type->allowsNull()) {
                    $results[] = null;
                } else {
                    throw new \Exception("Cannot resolve dependency {$dependency->getName()}");
                }
                continue;
            }

            // Resolve class dependency
            $results[] = $this->make($type->getName());
        }

        return $results;
    }

    /**
     * Get alias for abstract
     *
     * @param string $abstract
     * @return string
     */
    protected function getAlias(string $abstract): string
    {
        if (!isset($this->aliases[$abstract])) {
            return $abstract;
        }

        // Resolve nested aliases
        return $this->getAlias($this->aliases[$abstract]);
    }

    /**
     * Call a class method with dependency injection
     *
     * @param callable|array $callback
     * @param array $parameters
     * @return mixed
     * @throws ReflectionException
     */
    public function call(callable|array $callback, array $parameters = []): mixed
    {
        // Handle array callback [Class, 'method']
        if (is_array($callback)) {
            $reflection = new \ReflectionMethod($callback[0], $callback[1]);
            $dependencies = $reflection->getParameters();
            $instances = $this->resolveDependencies($dependencies, $parameters);

            return $reflection->invokeArgs(
                is_string($callback[0]) ? null : $callback[0],
                $instances
            );
        }

        // Handle closure or function
        $reflection = new \ReflectionFunction($callback);
        $dependencies = $reflection->getParameters();
        $instances = $this->resolveDependencies($dependencies, $parameters);

        return $reflection->invokeArgs($instances);
    }

    /**
     * Flush container
     *
     * @return void
     */
    public function flush(): void
    {
        $this->bindings = [];
        $this->instances = [];
        $this->aliases = [];
    }
}
