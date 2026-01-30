<?php

namespace Core\Cache;

use Core\Cache\Drivers\DatabaseCache;
use Core\Cache\Drivers\ArrayCache;
use Core\Cache\Drivers\FileCache;
use Core\Database\Connection;
use Core\Cache\Lock;

/**
 * Cache Manager
 *
 * Manages cache stores and provides unified API
 */
class CacheManager
{
    protected Connection $connection;
    protected array $config;
    protected array $stores = [];
    protected ?string $default = null;

    public function __construct(Connection $connection, array $config)
    {
        $this->connection = $connection;
        $this->config = $config;
        $this->default = $config['default'] ?? 'database';
    }

    /**
     * Get a cache store instance
     */
    public function store(?string $name = null): Repository
    {
        $name = $name ?? $this->default;

        if (isset($this->stores[$name])) {
            return $this->stores[$name];
        }

        return $this->stores[$name] = $this->resolve($name);
    }

    /**
     * Resolve a cache store
     */
    protected function resolve(string $name): Repository
    {
        $config = $this->config['stores'][$name] ?? [];

        if (empty($config)) {
            throw new \InvalidArgumentException("Cache store [{$name}] not configured.");
        }

        $driver = $config['driver'] ?? 'array';

        $store = match($driver) {
            'database' => new DatabaseCache(
                $this->connection,
                $config['table'] ?? 'cache',
                $this->config['prefix'] ?? ''
            ),
            'array' => new ArrayCache(),
            'file' => new FileCache($config['path'] ?? null),
            default => throw new \InvalidArgumentException("Unsupported cache driver [{$driver}]."),
        };

        return new Repository($store);
    }

    /**
     * Get a cache lock instance
     */
    public function lock(string $name, int $seconds = 0): Lock
    {
        return new Lock($this->connection, $name, $seconds);
    }

    /**
     * Dynamically call the default store
     */
    public function __call(string $method, array $parameters)
    {
        return $this->store()->$method(...$parameters);
    }
}
