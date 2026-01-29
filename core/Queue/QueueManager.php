<?php

namespace Core\Queue;

use Core\Database\Connection;

/**
 * Queue Manager
 *
 * Manages queue connections and provides unified API
 */
class QueueManager
{
    protected Connection $connection;
    protected array $config;
    protected array $queues = [];
    protected ?string $default = null;

    public function __construct(Connection $connection, array $config)
    {
        $this->connection = $connection;
        $this->config = $config;
        $this->default = $config['default'] ?? 'database';
    }

    /**
     * Get a queue connection
     */
    public function connection(?string $name = null): DatabaseQueue
    {
        $name = $name ?? $this->default;

        if (isset($this->queues[$name])) {
            return $this->queues[$name];
        }

        return $this->queues[$name] = $this->resolve($name);
    }

    /**
     * Resolve a queue connection
     */
    protected function resolve(string $name): DatabaseQueue
    {
        $config = $this->config['connections'][$name] ?? [];

        if (empty($config)) {
            throw new \InvalidArgumentException("Queue connection [{$name}] not configured.");
        }

        $driver = $config['driver'] ?? 'database';

        return match($driver) {
            'database' => new DatabaseQueue($this->connection, $config),
            'sync' => new SyncQueue(),
            default => throw new \InvalidArgumentException("Unsupported queue driver [{$driver}]."),
        };
    }

    /**
     * Push a job onto the default queue
     */
    public function push(Job $job, ?string $queue = null): string
    {
        return $this->connection()->push($job, $queue);
    }

    /**
     * Push a job onto the queue with a delay
     */
    public function later(Job $job, int $delay, ?string $queue = null): string
    {
        return $this->connection()->later($job, $delay, $queue);
    }

    /**
     * Pop the next job off the queue
     */
    public function pop(?string $queue = null): ?Job
    {
        return $this->connection()->pop($queue);
    }

    /**
     * Get the size of a queue
     */
    public function size(?string $queue = null): int
    {
        return $this->connection()->size($queue);
    }

    /**
     * Push multiple jobs onto the queue
     */
    public function bulk(array $jobs, ?string $queue = null): array
    {
        $jobIds = [];

        foreach ($jobs as $job) {
            $jobIds[] = $this->push($job, $queue);
        }

        return $jobIds;
    }
}
