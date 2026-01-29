<?php

namespace Core\Queue;

/**
 * Sync Queue Driver
 *
 * Executes jobs immediately without queuing (useful for development/testing)
 */
class SyncQueue
{
    /**
     * Push a job (execute immediately)
     */
    public function push(Job $job, ?string $queue = null): string
    {
        try {
            $job->handle();
            return 'sync-' . uniqid();
        } catch (\Exception $e) {
            $job->failed($e);
            throw $e;
        }
    }

    /**
     * Push a job with delay (execute immediately anyway)
     */
    public function later(Job $job, int $delay, ?string $queue = null): string
    {
        return $this->push($job, $queue);
    }

    /**
     * Pop a job (always returns null for sync)
     */
    public function pop(?string $queue = null): ?Job
    {
        return null;
    }

    /**
     * Get queue size (always 0 for sync)
     */
    public function size(?string $queue = null): int
    {
        return 0;
    }
}
