<?php

namespace Core\Console\Commands;

use Core\Console\Command;
use Core\Queue\Worker;

/**
 * Queue Work Command
 *
 * Processes jobs from the queue
 * Usage: php artisan queue:work --queue=default --sleep=3
 */
class QueueWorkCommand extends Command
{
    protected string $signature = 'queue:work {--queue=default} {--sleep=3} {--tries=3} {--timeout=60} {--once}';

    protected string $description = 'Process jobs from the queue';

    public function handle(): int
    {
        $queue = $this->option('queue', 'default');
        $sleep = (int)$this->option('sleep', 3);
        $tries = (int)$this->option('tries', 3);
        $timeout = (int)$this->option('timeout', 60);
        $once = $this->option('once', false);

        $worker = app('queue.worker');

        if ($once) {
            // Process a single job and exit
            $this->info("Processing one job from queue: {$queue}");
            $processed = $worker->runNextJob($queue, [
                'max_tries' => $tries,
                'timeout' => $timeout,
            ]);

            return $processed ? 0 : 1;
        }

        // Run in daemon mode
        $worker->daemon($queue, [
            'sleep' => $sleep,
            'max_tries' => $tries,
            'timeout' => $timeout,
        ]);

        return 0;
    }
}
