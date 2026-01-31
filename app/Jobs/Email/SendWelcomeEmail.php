<?php

namespace App\Jobs\Email;

use Core\Queue\Job;

/**
 * SendWelcomeEmail
 *
 * Queue job for background processing
 */
class SendWelcomeEmail extends Job
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
     * Create a new job instance
     */
    public function __construct()
    {
        // Initialize job properties
    }

    /**
     * Execute the job
     *
     * @return void
     */
    public function handle(): void
    {
        // Implement job logic here
    }

    /**
     * Handle a job failure
     *
     * @param \Exception $exception
     * @return void
     */
    public function failed(\Exception $exception): void
    {
        // Handle job failure
        // Log error, send notification, etc.
    }
}