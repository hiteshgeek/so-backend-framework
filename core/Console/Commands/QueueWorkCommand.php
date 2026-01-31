<?php

namespace Core\Console\Commands;

use Core\Console\Command;
use Core\Queue\Worker;

/**
 * Queue Work Command
 *
 * Processes jobs from the queue
 *
 * Usage:
 *   php sixorbit queue:work
 *   php sixorbit queue:work --queue=emails --sleep=3
 *   php sixorbit queue:work --once (process one job and exit)
 *   php sixorbit queue:work --verbose (detailed output)
 *   php sixorbit queue:work --quiet (suppress all output except errors)
 */
class QueueWorkCommand extends Command
{
    protected string $signature = 'queue:work {--queue=default} {--sleep=3} {--tries=3} {--timeout=60} {--once} {--verbose} {--v} {--quiet} {--q}';

    protected string $description = 'Process jobs from the queue';

    protected int $processedJobs = 0;
    protected int $failedJobs = 0;
    protected float $startTime = 0;

    public function handle(): int
    {
        $queue = $this->option('queue', 'default');
        $sleep = (int)$this->option('sleep', 3);
        $tries = (int)$this->option('tries', 3);
        $timeout = (int)$this->option('timeout', 60);
        $once = $this->option('once', false);
        $verbose = $this->option('verbose', false) || $this->option('v', false);
        $quiet = $this->option('quiet', false) || $this->option('q', false);

        $this->startTime = microtime(true);

        $worker = app('queue.worker');

        if (!$quiet) {
            $this->info("Queue worker started for queue: {$queue}");
            if ($verbose) {
                $this->info("Configuration:");
                $this->info("  - Sleep: {$sleep}s between jobs");
                $this->info("  - Max tries: {$tries}");
                $this->info("  - Timeout: {$timeout}s");
                $this->info("  - Mode: " . ($once ? 'Single job' : 'Daemon'));
            }
        }

        if ($once) {
            // Process a single job and exit
            return $this->processSingleJob($worker, $queue, $tries, $timeout, $verbose, $quiet);
        }

        // Run in daemon mode
        return $this->runDaemon($worker, $queue, $sleep, $tries, $timeout, $verbose, $quiet);
    }

    /**
     * Process a single job
     */
    protected function processSingleJob(Worker $worker, string $queue, int $tries, int $timeout, bool $verbose, bool $quiet): int
    {
        if ($verbose && !$quiet) {
            $this->info("Processing one job from queue: {$queue}");
        }

        try {
            $processed = $worker->runNextJob($queue, [
                'max_tries' => $tries,
                'timeout' => $timeout,
            ]);

            if ($processed) {
                $this->processedJobs++;
                if ($verbose && !$quiet) {
                    $this->info("Job processed successfully.");
                }
                $this->showStatistics($quiet);
                return 0;
            } else {
                if (!$quiet) {
                    $this->comment("No jobs available in queue.");
                }
                return 1;
            }
        } catch (\Exception $e) {
            $this->failedJobs++;
            if (!$quiet) {
                $this->error("Job failed: " . $e->getMessage());
                if ($verbose) {
                    $this->error($e->getTraceAsString());
                }
            }
            $this->showStatistics($quiet);
            return 1;
        }
    }

    /**
     * Run queue worker in daemon mode
     */
    protected function runDaemon(Worker $worker, string $queue, int $sleep, int $tries, int $timeout, bool $verbose, bool $quiet): int
    {
        // Set up signal handlers for graceful shutdown
        if (function_exists('pcntl_signal')) {
            pcntl_signal(SIGTERM, function() use ($quiet) {
                if (!$quiet) {
                    $this->info("\nReceived shutdown signal. Stopping after current job...");
                }
                $this->showStatistics($quiet);
                exit(0);
            });

            pcntl_signal(SIGINT, function() use ($quiet) {
                if (!$quiet) {
                    $this->info("\nReceived interrupt signal. Stopping after current job...");
                }
                $this->showStatistics($quiet);
                exit(0);
            });
        }

        try {
            while (true) {
                if (function_exists('pcntl_signal_dispatch')) {
                    pcntl_signal_dispatch();
                }

                try {
                    $processed = $worker->runNextJob($queue, [
                        'max_tries' => $tries,
                        'timeout' => $timeout,
                    ]);

                    if ($processed) {
                        $this->processedJobs++;
                        if ($verbose && !$quiet) {
                            $this->info("[" . date('Y-m-d H:i:s') . "] Job processed. Total: {$this->processedJobs}");
                        } elseif (!$quiet && $this->processedJobs % 10 == 0) {
                            // Show progress every 10 jobs in normal mode
                            $this->info("Processed {$this->processedJobs} jobs...");
                        }
                    } else {
                        // No jobs available, sleep
                        if ($verbose && !$quiet) {
                            $this->comment("[" . date('Y-m-d H:i:s') . "] No jobs available. Sleeping for {$sleep}s...");
                        }
                        sleep($sleep);
                    }
                } catch (\Exception $e) {
                    $this->failedJobs++;
                    if (!$quiet) {
                        $this->error("[" . date('Y-m-d H:i:s') . "] Job failed: " . $e->getMessage());
                        if ($verbose) {
                            $this->error($e->getTraceAsString());
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            if (!$quiet) {
                $this->error("Worker error: " . $e->getMessage());
                if ($verbose) {
                    $this->error($e->getTraceAsString());
                }
            }
            $this->showStatistics($quiet);
            return 1;
        }

        return 0;
    }

    /**
     * Display job processing statistics
     */
    protected function showStatistics(bool $quiet): void
    {
        if ($quiet) {
            return;
        }

        $duration = microtime(true) - $this->startTime;
        $this->info("\nQueue Worker Statistics:");
        $this->info("  - Processed: {$this->processedJobs} jobs");
        $this->info("  - Failed: {$this->failedJobs} jobs");
        $this->info("  - Duration: " . round($duration, 2) . "s");
        if ($this->processedJobs > 0) {
            $avgTime = round($duration / $this->processedJobs, 2);
            $this->info("  - Average: {$avgTime}s per job");
        }
    }
}
