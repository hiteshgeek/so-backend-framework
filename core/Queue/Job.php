<?php

namespace Core\Queue;

/**
 * Job Base Class
 *
 * Abstract base class for all queue jobs
 * Essential for ERP background processing (reports, imports, exports)
 */
abstract class Job
{
    /**
     * Number of times the job may be attempted
     */
    public int $tries = 3;

    /**
     * Number of seconds the job can run before timing out
     */
    public int $timeout = 60;

    /**
     * The name of the queue the job should be sent to
     */
    public string $queue = 'default';

    /**
     * Number of seconds to wait before retrying the job
     */
    public int $retryAfter = 90;

    /**
     * The job's unique ID (set by the queue)
     */
    public ?string $jobId = null;

    /**
     * Number of attempts made
     */
    protected int $attempts = 0;

    /**
     * Execute the job
     */
    abstract public function handle(): void;

    /**
     * Handle a job failure
     */
    public function failed(\Exception $exception): void
    {
        // Override in child class to handle failures
    }

    /**
     * Get the number of times this job has been attempted
     */
    public function attempts(): int
    {
        return $this->attempts;
    }

    /**
     * Set the number of attempts
     */
    public function setAttempts(int $attempts): void
    {
        $this->attempts = $attempts;
    }

    /**
     * Determine if the job should be retried
     */
    public function shouldRetry(): bool
    {
        return $this->attempts < $this->tries;
    }

    /**
     * Serialize the job for storage
     */
    public function serialize(): string
    {
        return serialize([
            'class' => get_class($this),
            'data' => get_object_vars($this),
        ]);
    }

    /**
     * Unserialize a job from storage
     */
    public static function unserialize(string $serialized): self
    {
        $data = unserialize($serialized);
        $job = new $data['class']();

        foreach ($data['data'] as $key => $value) {
            if (property_exists($job, $key)) {
                $job->$key = $value;
            }
        }

        return $job;
    }

    /**
     * Get display name for the job
     */
    public function displayName(): string
    {
        return class_basename($this);
    }
}
