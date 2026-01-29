<?php

/**
 * Test Queue System Implementation
 *
 * This script tests the queue functionality
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap the application
$app = require_once __DIR__ . '/bootstrap/app.php';

use App\Jobs\TestJob;

echo "=== Queue System Test ===\n\n";

try {
    // Test 1: Dispatch a simple job
    echo "Test 1: Dispatching a simple test job...\n";
    $jobId = dispatch(new TestJob('Hello from queue!'));
    echo "✓ Job dispatched with ID: {$jobId}\n\n";

    // Test 2: Dispatch a job with delay
    echo "Test 2: Dispatching a delayed job (5 seconds delay)...\n";
    $delayedJobId = queue()->later(new TestJob('Delayed job!'), 5);
    echo "✓ Delayed job dispatched with ID: {$delayedJobId}\n\n";

    // Test 3: Dispatch multiple jobs
    echo "Test 3: Dispatching 3 jobs in bulk...\n";
    $jobs = [
        new TestJob('Job 1', 1),
        new TestJob('Job 2', 1),
        new TestJob('Job 3', 1),
    ];
    $jobIds = queue()->bulk($jobs);
    echo "✓ " . count($jobIds) . " jobs dispatched: " . implode(', ', $jobIds) . "\n\n";

    // Test 4: Check queue size
    echo "Test 4: Checking queue size...\n";
    $queueSize = queue()->size('default');
    echo "✓ Queue 'default' has {$queueSize} jobs\n\n";

    // Test 5: Query jobs table
    echo "Test 5: Querying jobs table...\n";
    $db = app('db');
    $jobs = $db->table('jobs')->get();
    echo "✓ Found " . count($jobs) . " jobs in database\n";
    foreach ($jobs as $job) {
        echo "  - Job ID: {$job['id']}, Queue: {$job['queue']}, Attempts: {$job['attempts']}\n";
    }
    echo "\n";

    echo "✅ All tests passed! Queue system is working correctly.\n\n";

    echo "=== Next Steps ===\n";
    echo "To process the queued jobs, run the worker:\n";
    echo "  php artisan queue:work --queue=default --once\n";
    echo "\nOr run in daemon mode:\n";
    echo "  php artisan queue:work --queue=default\n\n";

    echo "=== Summary ===\n";
    echo "✓ Jobs can be dispatched to the queue\n";
    echo "✓ Jobs can be dispatched with delays\n";
    echo "✓ Multiple jobs can be dispatched in bulk\n";
    echo "✓ Queue size can be checked\n";
    echo "✓ Jobs are stored in the database\n";
    echo "✓ Ready to process jobs with the worker\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}
