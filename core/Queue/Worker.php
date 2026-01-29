<?php

namespace Core\Queue;

/**
 * Queue Worker
 *
 * Processes jobs from the queue in a daemon loop
 */
class Worker
{
    protected QueueManager $manager;
    protected bool $shouldQuit = false;

    public function __construct(QueueManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Run the worker in daemon mode
     */
    public function daemon(string $queue = 'default', array $options = []): void
    {
        $sleep = $options['sleep'] ?? 3;
        $maxTries = $options['max_tries'] ?? 3;
        $timeout = $options['timeout'] ?? 60;

        echo "Queue worker started. Processing queue: {$queue}\n";
        echo "Press Ctrl+C to stop.\n\n";

        // Register signal handlers
        if (function_exists('pcntl_signal')) {
            pcntl_signal(SIGTERM, fn() => $this->shouldQuit = true);
            pcntl_signal(SIGINT, fn() => $this->shouldQuit = true);
        }

        while (!$this->shouldQuit) {
            // Check for signals
            if (function_exists('pcntl_signal_dispatch')) {
                pcntl_signal_dispatch();
            }

            // Pop a job from the queue
            $job = $this->manager->pop($queue);

            if ($job === null) {
                // No job available, sleep
                echo ".";
                sleep($sleep);
                continue;
            }

            // Process the job
            $this->process($job, $maxTries, $timeout);
        }

        echo "\n\nWorker stopped.\n";
    }

    /**
     * Process a single job
     */
    public function process(Job $job, int $maxTries = 3, int $timeout = 60): void
    {
        $jobName = $job->displayName();

        echo "\n[" . date('Y-m-d H:i:s') . "] Processing: {$jobName} (Attempt {$job->attempts()}/{$maxTries})\n";

        try {
            // Set timeout if supported
            if (function_exists('set_time_limit')) {
                set_time_limit($timeout);
            }

            // Execute the job
            $job->handle();

            // Job succeeded, delete it
            $queue = $this->manager->connection();
            if ($job->jobId) {
                $queue->delete($job->jobId);
            }

            echo "[" . date('Y-m-d H:i:s') . "] ✓ Processed: {$jobName}\n";

        } catch (\Exception $e) {
            echo "[" . date('Y-m-d H:i:s') . "] ✗ Failed: {$jobName}\n";
            echo "  Error: " . $e->getMessage() . "\n";

            $this->handleFailedJob($job, $e, $maxTries);
        }
    }

    /**
     * Handle a failed job
     */
    protected function handleFailedJob(Job $job, \Exception $exception, int $maxTries): void
    {
        $queue = $this->manager->connection();

        // Check if job should be retried
        if ($job->attempts() < $maxTries && $job->shouldRetry()) {
            echo "  → Retrying in {$job->retryAfter} seconds...\n";
            $queue->release($job, $job->retryAfter);
        } else {
            echo "  → Max attempts reached. Moving to failed jobs table.\n";

            // Call the job's failed method
            try {
                $job->failed($exception);
            } catch (\Exception $e) {
                echo "  → Job failed() method threw exception: " . $e->getMessage() . "\n";
            }

            // Move to failed jobs
            $queue->failed($job, $exception);
        }
    }

    /**
     * Stop the worker
     */
    public function stop(): void
    {
        $this->shouldQuit = true;
    }

    /**
     * Process the next job in the queue (run once)
     */
    public function runNextJob(string $queue = 'default', array $options = []): bool
    {
        $maxTries = $options['max_tries'] ?? 3;
        $timeout = $options['timeout'] ?? 60;

        $job = $this->manager->pop($queue);

        if ($job === null) {
            echo "No jobs available.\n";
            return false;
        }

        $this->process($job, $maxTries, $timeout);
        return true;
    }
}
