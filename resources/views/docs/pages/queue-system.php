<?php
/**
 * Queue System Documentation Page
 *
 * Background job processing for heavy operations.
 */

$pageTitle = 'Queue System';
$pageIcon = 'tray-full';
$toc = [
    ['id' => 'introduction', 'title' => 'Introduction', 'level' => 2],
    ['id' => 'quick-start', 'title' => 'Quick Start', 'level' => 2],
    ['id' => 'architecture', 'title' => 'Architecture', 'level' => 2],
    ['id' => 'creating-jobs', 'title' => 'Creating Jobs', 'level' => 2],
    ['id' => 'dispatching-jobs', 'title' => 'Dispatching Jobs', 'level' => 2],
    ['id' => 'running-workers', 'title' => 'Running Workers', 'level' => 2],
    ['id' => 'failed-jobs', 'title' => 'Failed Jobs', 'level' => 2],
    ['id' => 'configuration', 'title' => 'Configuration', 'level' => 2],
    ['id' => 'erp-use-cases', 'title' => 'ERP Use Cases', 'level' => 2],
    ['id' => 'best-practices', 'title' => 'Best Practices', 'level' => 2],
];
$breadcrumbs = [['label' => 'Queue System']];
$lastUpdated = '2026-01-30';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="queue-system" class="heading heading-1">
    <span class="mdi mdi-tray-full heading-icon"></span>
    <span class="heading-text">Queue System</span>
</h1>

<p class="text-lead">
    Background job processing for heavy operations. The Queue System enables asynchronous task execution, preventing timeouts and improving user experience.
</p>

<!-- Introduction -->
<h2 id="introduction" class="heading heading-2">
    <span class="mdi mdi-information heading-icon"></span>
    <span class="heading-text">Introduction</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">What is a Queue System?</span>
</h3>

<p>A queue system allows you to defer time-consuming tasks (jobs) to be processed in the background:</p>

<ol class="list list-number">
    <li><strong>User makes request</strong> → Application responds immediately</li>
    <li><strong>Job queued</strong> → Stored in database with status "pending"</li>
    <li><strong>Worker processes</strong> → Picks up job and executes it</li>
    <li><strong>Job completes</strong> → Removed from queue (or moved to failed_jobs on error)</li>
</ol>

<h3 class="heading heading-3">
    <span class="heading-text">Why Essential for ERP?</span>
</h3>

<div class="space-y-3">
    <?= callout('danger', '<strong>Problems Solved:</strong><br>
    <ul class="mt-2">
        <li>⏱️ <strong>Timeouts</strong>: Large reports taking 5-10 minutes cause PHP timeouts</li>
        <li>🐌 <strong>Poor UX</strong>: Users wait while imports process 50,000 records</li>
        <li>🚫 <strong>Resource blocking</strong>: Heavy operations monopolize server resources</li>
        <li>❌ <strong>No retry logic</strong>: Transient failures (API down) cause data loss</li>
    </ul>', 'Problems') ?>

    <?= callout('success', '<strong>Solutions Provided:</strong><br>
    <ul class="mt-2">
        <li>⚡ <strong>Instant response</strong>: User gets confirmation immediately</li>
        <li>🔄 <strong>Background processing</strong>: Heavy work happens asynchronously</li>
        <li>🔁 <strong>Automatic retry</strong>: Failed jobs retry 3 times automatically</li>
        <li>📊 <strong>Job tracking</strong>: Monitor progress and failures</li>
        <li>⚙️ <strong>Resource management</strong>: Control concurrent job execution</li>
    </ul>', 'Solutions') ?>
</div>

<!-- Quick Start -->
<h2 id="quick-start" class="heading heading-2">
    <span class="mdi mdi-lightning-bolt heading-icon"></span>
    <span class="heading-text">Quick Start</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">1. Create Your First Job</span>
</h3>

<p>Create a job class in <?= filePath('app/Jobs/') ?>:</p>

<?= codeBlockWithFile('php', '<?php

namespace App\Jobs;

use Core\Queue\Job;

class SendWelcomeEmail extends Job
{
    protected string $email;
    protected string $name;

    public function __construct(string $email, string $name)
    {
        $this->email = $email;
        $this->name = $name;
    }

    public function handle(): void
    {
        // This runs in the background
        $emailService = app(\'email\');
        $emailService->send($this->email, \'Welcome!\', [
            \'name\' => $this->name
        ]);

        echo "Email sent to {$this->email}\n";
    }
}', 'app/Jobs/SendWelcomeEmail.php') ?>

<h3 class="heading heading-3">
    <span class="heading-text">2. Dispatch the Job</span>
</h3>

<?= codeBlock('php', '// In your controller
public function register(Request $request)
{
    $user = User::create($request->all());

    // Dispatch job (returns immediately)
    dispatch(new SendWelcomeEmail($user->email, $user->name));

    return JsonResponse::success([
        \'message\' => \'Registration successful! Check your email.\',
        \'user\' => $user
    ]);
}') ?>

<h3 class="heading heading-3">
    <span class="heading-text">3. Run the Worker</span>
</h3>

<p>Start the queue worker to process jobs:</p>

<?= codeBlock('bash', 'php sixorbit queue:work

# Output:
# Processing: App\Jobs\SendWelcomeEmail
# Email sent to john@example.com
# Processed:  App\Jobs\SendWelcomeEmail (0.5s)') ?>

<p class="mt-2">That's it! Jobs are now processed in the background.</p>

<!-- Architecture -->
<h2 id="architecture" class="heading heading-2">
    <span class="mdi mdi-sitemap heading-icon"></span>
    <span class="heading-text">Architecture</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Components</span>
</h3>

<?= featureGrid([
    ['icon' => 'file-code', 'title' => 'Job Classes', 'description' => 'Define work to be done (app/Jobs/*.php)'],
    ['icon' => 'cog-transfer', 'title' => 'QueueManager', 'description' => 'Manages connections and dispatching'],
    ['icon' => 'database', 'title' => 'DatabaseQueue', 'description' => 'Stores jobs in database with locking'],
    ['icon' => 'worker', 'title' => 'Worker', 'description' => 'Daemon that processes queued jobs'],
    ['icon' => 'console', 'title' => 'Console Command', 'description' => 'CLI interface (queue:work)'],
]) ?>

<h3 class="heading heading-3">
    <span class="heading-text">Job Lifecycle</span>
</h3>

<div class="job-lifecycle-diagram">
    <div class="jlc-box jlc-dispatched">
        <div class="jlc-box-icon"><span class="mdi mdi-arrow-down-circle"></span></div>
        <div class="jlc-box-title">Dispatched</div>
        <div class="jlc-box-meta">Job created and stored in jobs table</div>
    </div>

    <div class="jlc-arrow-down"><span class="mdi mdi-arrow-down"></span></div>

    <div class="jlc-box jlc-queued">
        <div class="jlc-box-icon"><span class="mdi mdi-clock-outline"></span></div>
        <div class="jlc-box-title">Queued</div>
        <div class="jlc-box-meta">Waiting in database (status: pending)</div>
    </div>

    <div class="jlc-arrow-down"><span class="mdi mdi-arrow-down"></span></div>

    <div class="jlc-box jlc-processing">
        <div class="jlc-box-icon"><span class="mdi mdi-cog"></span></div>
        <div class="jlc-box-title">Processing</div>
        <div class="jlc-box-meta">Worker picks up and executes job</div>
    </div>

    <div class="jlc-arrow-split">
        <div class="jlc-arrow-split-label">Decision</div>
    </div>

    <div class="jlc-split-row">
        <div class="jlc-split-branch">
            <div class="jlc-arrow-down"><span class="mdi mdi-arrow-down"></span></div>
            <div class="jlc-box jlc-success">
                <div class="jlc-box-icon"><span class="mdi mdi-check-circle"></span></div>
                <div class="jlc-box-title">Success</div>
                <div class="jlc-box-meta">Job deleted from table</div>
            </div>
        </div>

        <div class="jlc-split-branch">
            <div class="jlc-arrow-down"><span class="mdi mdi-arrow-down"></span></div>
            <div class="jlc-box jlc-failure">
                <div class="jlc-box-icon"><span class="mdi mdi-alert-circle"></span></div>
                <div class="jlc-box-title">Failure</div>
                <div class="jlc-box-meta">Error occurred during execution</div>
            </div>

            <div class="jlc-arrow-down"><span class="mdi mdi-arrow-down"></span></div>

            <div class="jlc-box jlc-retry">
                <div class="jlc-box-icon"><span class="mdi mdi-refresh"></span></div>
                <div class="jlc-box-title">Retry Logic</div>
                <div class="jlc-box-meta">Attempts < max_tries?</div>
            </div>

            <div class="jlc-retry-paths">
                <div class="jlc-path jlc-path-yes">
                    <div class="jlc-path-label">
                        <span class="mdi mdi-check-circle"></span>
                        <span>Yes (Retry)</span>
                    </div>
                    <div class="jlc-arrow-curve">
                        <span class="mdi mdi-arrow-u-left-top"></span>
                    </div>
                    <div class="jlc-path-note">Back to Queued with delay</div>
                </div>

                <div class="jlc-path jlc-path-no">
                    <div class="jlc-path-label">
                        <span class="mdi mdi-close-circle"></span>
                        <span>No (Max attempts)</span>
                    </div>
                    <div class="jlc-arrow-down"><span class="mdi mdi-arrow-down"></span></div>
                    <div class="jlc-box jlc-failed-jobs">
                        <div class="jlc-box-icon"><span class="mdi mdi-database-remove"></span></div>
                        <div class="jlc-box-title">failed_jobs</div>
                        <div class="jlc-box-meta">Moved to failed jobs table</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<h3 class="heading heading-3">
    <span class="heading-text">Database Schema</span>
</h3>

<?= codeTabs([
    ['label' => 'jobs table', 'lang' => 'sql', 'code' => 'CREATE TABLE jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts TINYINT UNSIGNED NOT NULL,
    reserved_at INT UNSIGNED,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL,
    INDEX idx_queue_reserved (queue, reserved_at)
);'],
    ['label' => 'failed_jobs table', 'lang' => 'sql', 'code' => 'CREATE TABLE failed_jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);'],
]) ?>

<!-- Creating Jobs -->
<h2 id="creating-jobs" class="heading heading-2">
    <span class="mdi mdi-plus-box heading-icon"></span>
    <span class="heading-text">Creating Jobs</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Basic Job Structure</span>
</h3>

<?= codeBlockWithFile('php', '<?php

namespace App\Jobs;

use Core\Queue\Job;

class ProcessLargeImport extends Job
{
    // Job configuration
    public int $tries = 3;        // Max retry attempts
    public int $timeout = 300;    // 5 minutes timeout
    public string $queue = \'default\';  // Queue name

    // Job data (will be serialized)
    protected string $filePath;
    protected int $userId;

    public function __construct(string $filePath, int $userId)
    {
        $this->filePath = $filePath;
        $this->userId = $userId;
    }

    public function handle(): void
    {
        // Main job logic here
        $importer = app(\'importer\');
        $importer->process($this->filePath, $this->userId);
    }

    public function failed(\Exception $exception): void
    {
        // Called when job fails after all retries
        // Send notification, log error, etc.
        $user = User::find($this->userId);
        $user->notify(new ImportFailed($this->filePath, $exception->getMessage()));
    }
}', 'app/Jobs/ProcessLargeImport.php') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Job Properties</span>
</h3>

<?= dataTable(
    ['Property', 'Description', 'Example'],
    [
        ['<code class="code-inline">$tries</code>', 'Maximum retry attempts', '<code class="code-inline">public int $tries = 3;</code>'],
        ['<code class="code-inline">$timeout</code>', 'Maximum execution time (seconds)', '<code class="code-inline">public int $timeout = 300;</code>'],
        ['<code class="code-inline">$queue</code>', 'Queue name for priority', '<code class="code-inline">public string $queue = \'high-priority\';</code>'],
    ]
) ?>

<!-- Dispatching Jobs -->
<h2 id="dispatching-jobs" class="heading heading-2">
    <span class="mdi mdi-send heading-icon"></span>
    <span class="heading-text">Dispatching Jobs</span>
</h2>

<?= codeTabs([
    ['label' => 'Basic Dispatch', 'lang' => 'php', 'code' => '// Simple dispatch
dispatch(new SendEmail($user->email));

// With queue name
$job = new GenerateReport($reportId);
$job->queue = \'high-priority\';
dispatch($job);'],
    ['label' => 'Conditional', 'lang' => 'php', 'code' => 'if ($order->total > 10000) {
    // High-value orders: notify immediately
    dispatch(new NotifyManagement($order));
}

if ($import->rows > 100000) {
    // Large imports: use low-priority queue
    $job = new ProcessImport($import->id);
    $job->queue = \'low-priority\';
    dispatch($job);
}'],
]) ?>

<!-- Running Workers -->
<h2 id="running-workers" class="heading heading-2">
    <span class="mdi mdi-worker heading-icon"></span>
    <span class="heading-text">Running Workers</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Start Worker</span>
</h3>

<?= codeBlock('bash', '# Basic worker
php sixorbit queue:work

# Specify queue
php sixorbit queue:work --queue=high-priority

# Multiple queues (priority order)
php sixorbit queue:work --queue=high-priority,default,low-priority

# Set sleep time (seconds between job checks)
php sixorbit queue:work --sleep=3

# Set max tries
php sixorbit queue:work --tries=5') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Production: Supervisor</span>
</h3>

<p>For production, use Supervisor to keep workers running:</p>

<?= codeBlockWithFile('ini', '[program:so-framework-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/so-backend-framework/sixorbit queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/html/so-backend-framework/storage/logs/worker.log
stopwaitsecs=3600', '/etc/supervisor/conf.d/so-framework-worker.conf') ?>

<?= codeBlock('bash', '# Install and start
sudo apt-get install supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start so-framework-worker:*') ?>

<!-- Failed Jobs -->
<h2 id="failed-jobs" class="heading heading-2">
    <span class="mdi mdi-alert-circle heading-icon"></span>
    <span class="heading-text">Failed Jobs</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">View Failed Jobs</span>
</h3>

<?= codeBlock('sql', 'SELECT * FROM failed_jobs ORDER BY failed_at DESC;') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Failed Job Handler</span>
</h3>

<?= codeBlock('php', 'class SendInvoice extends Job
{
    public function failed(\Exception $exception): void
    {
        // Log to system
        logger()->error(\'Invoice send failed\', [
            \'invoice_id\' => $this->invoiceId,
            \'error\' => $exception->getMessage()
        ]);

        // Notify admin
        $admin = User::find(1);
        $admin->notify(new JobFailedNotification(\'SendInvoice\', $exception));

        // Update invoice status
        Invoice::find($this->invoiceId)->update([
            \'send_status\' => \'failed\',
            \'send_error\' => $exception->getMessage()
        ]);
    }
}') ?>

<!-- Configuration -->
<h2 id="configuration" class="heading heading-2">
    <span class="mdi mdi-cog heading-icon"></span>
    <span class="heading-text">Configuration</span>
</h2>

<?= codeBlockWithFile('php', '<?php

return [
    // Default queue connection
    \'default\' => env(\'QUEUE_CONNECTION\', \'database\'),

    // Queue connections
    \'connections\' => [
        \'sync\' => [
            \'driver\' => \'sync\',  // Immediate execution (no queue)
        ],

        \'database\' => [
            \'driver\' => \'database\',
            \'table\' => \'jobs\',
            \'queue\' => \'default\',
            \'retry_after\' => 90,  // Seconds before job considered failed
        ],
    ],

    // Failed job configuration
    \'failed\' => [
        \'table\' => \'failed_jobs\',
    ],
];', 'config/queue.php') ?>

<!-- ERP Use Cases -->
<h2 id="erp-use-cases" class="heading heading-2">
    <span class="mdi mdi-briefcase heading-icon"></span>
    <span class="heading-text">ERP Use Cases</span>
</h2>

<?= featureGrid([
    ['icon' => 'file-chart', 'title' => 'Large Report Generation', 'description' => 'Monthly sales reports that take 8+ minutes'],
    ['icon' => 'database-import', 'title' => 'Bulk Data Import', 'description' => 'Importing 50,000+ products from CSV'],
    ['icon' => 'email-multiple', 'title' => 'Email Notifications', 'description' => 'Sending 1,000+ order confirmations'],
    ['icon' => 'file-pdf-box', 'title' => 'Invoice PDF Generation', 'description' => 'Generating complex invoice PDFs'],
]) ?>

<h3 class="heading heading-3">
    <span class="heading-text">Example: Large Report Generation</span>
</h3>

<p><strong>Problem</strong>: Monthly sales report takes 8 minutes, causes timeout.</p>

<?= codeBlock('php', 'class GenerateMonthlySalesReport extends Job
{
    public int $timeout = 600; // 10 minutes
    protected int $month;
    protected int $year;

    public function handle(): void
    {
        $reportService = app(\'report.service\');

        // Generate report (heavy operation)
        $report = $reportService->generateSales($this->month, $this->year);

        // Save to file
        $filePath = "reports/sales-{$this->year}-{$this->month}.pdf";
        file_put_contents($filePath, $report->toPdf());

        // Notify user
        $user = User::find($this->userId);
        $user->notify(new ReportReady($filePath));
    }
}

// Controller: Instant response
public function generateReport(Request $request)
{
    dispatch(new GenerateMonthlySalesReport(
        $request->input(\'month\'),
        $request->input(\'year\'),
        $request->user()->id
    ));

    return JsonResponse::success([
        \'message\' => \'Report generation started. You will be notified when ready.\'
    ]);
}') ?>

<!-- Best Practices -->
<h2 id="best-practices" class="heading heading-2">
    <span class="mdi mdi-check-decagram heading-icon"></span>
    <span class="heading-text">Best Practices</span>
</h2>

<div class="space-y-3">
    <?= callout('success', '<strong>Keep Jobs Small and Focused</strong><br>Create specific, focused jobs rather than one giant job that does everything.') ?>

    <?= callout('info', '<strong>Make Jobs Idempotent</strong><br>Jobs should be safe to run multiple times. Check if work is already done before processing.') ?>

    <?= callout('warning', '<strong>Use Appropriate Timeouts</strong><br>Set realistic timeouts: 30s for quick tasks, 30 minutes for heavy reports.') ?>

    <?= callout('danger', '<strong>Handle Failures Gracefully</strong><br>Always implement the <code class="code-inline">failed()</code> method to notify and log errors.') ?>
</div>

<h3 class="heading heading-3">
    <span class="heading-text">Monitor Queue Health</span>
</h3>

<?= codeBlock('bash', '# Check jobs table size
SELECT COUNT(*) FROM jobs WHERE queue = \'default\';

# Check failed jobs
SELECT COUNT(*) FROM failed_jobs;

# Average processing time
SELECT AVG(UNIX_TIMESTAMP() - created_at) as avg_time
FROM jobs
WHERE reserved_at IS NOT NULL;') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Use Queue Names Strategically</span>
</h3>

<?= codeBlock('php', '// Critical: Process immediately
$job = new ProcessPayment($orderId);
$job->queue = \'critical\';

// Reports: Can wait
$job = new GenerateReport($month);
$job->queue = \'low-priority\';') ?>

<!-- Summary -->
<div class="mt-6">
    <?= callout('info', '<strong>Summary</strong><br>
    The Queue System enables background processing, automatic retry, job tracking, scalability, and priority queues. Essential for ERP systems with large report generation, bulk data operations, email notifications, PDF generation, and API integrations.<br><br>
    <strong>Start queuing jobs today for better user experience and system reliability.</strong>') ?>
</div>

<?php include __DIR__ . '/../_layout-end.php'; ?>
