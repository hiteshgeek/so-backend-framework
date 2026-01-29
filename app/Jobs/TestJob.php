<?php

namespace App\Jobs;

use Core\Queue\Job;

/**
 * Test Job
 *
 * Sample job for testing the queue system
 */
class TestJob extends Job
{
    public string $message;
    public int $sleepSeconds;

    public function __construct(string $message = 'Test job executed', int $sleepSeconds = 0)
    {
        $this->message = $message;
        $this->sleepSeconds = $sleepSeconds;
    }

    /**
     * Execute the job
     */
    public function handle(): void
    {
        echo "TestJob executing: {$this->message}\n";

        if ($this->sleepSeconds > 0) {
            echo "  Sleeping for {$this->sleepSeconds} seconds...\n";
            sleep($this->sleepSeconds);
        }

        echo "  TestJob completed!\n";
    }

    /**
     * Handle job failure
     */
    public function failed(\Exception $exception): void
    {
        echo "TestJob failed: " . $exception->getMessage() . "\n";
    }
}
