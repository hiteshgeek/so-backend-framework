# Queue System

**Background Job Processing for Heavy Operations**

The Queue System enables background processing of time-consuming tasks, preventing timeout and improving user experience by returning responses immediately while work continues asynchronously.

---

## Table of Contents

1. [Introduction](#introduction)
2. [Quick Start](#quick-start)
3. [Architecture](#architecture)
4. [Creating Jobs](#creating-jobs)
5. [Dispatching Jobs](#dispatching-jobs)
6. [Running Workers](#running-workers)
7. [Failed Jobs](#failed-jobs)
8. [Configuration](#configuration)
9. [ERP Use Cases](#erp-use-cases)
10. [Best Practices](#best-practices)

---

## Introduction

### What is a Queue System?

A queue system allows you to defer time-consuming tasks (jobs) to be processed in the background:

1. **User makes request** → Application responds immediately
2. **Job queued** → Stored in database with status "pending"
3. **Worker processes** → Picks up job and executes it
4. **Job completes** → Removed from queue (or moved to failed_jobs on error)

### Why Essential for ERP?

**Problems Solved**:
- ❌ **Timeouts**: Large reports taking 5-10 minutes cause PHP timeouts
- ❌ **Poor UX**: Users wait while imports process 50,000 records
- ❌ **Resource blocking**: Heavy operations monopolize server resources
- ❌ **No retry logic**: Transient failures (API down) cause data loss

**Solutions Provided**:
- ✅ **Instant response**: User gets confirmation immediately
- ✅ **Background processing**: Heavy work happens asynchronously
- ✅ **Automatic retry**: Failed jobs retry 3 times automatically
- ✅ **Job tracking**: Monitor progress and failures
- ✅ **Resource management**: Control concurrent job execution

---

## Quick Start

### Step 1: Create Your First Job

Create a job class in `app/Jobs/`:

```php
<?php

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
        $emailService = app('email');
        $emailService->send($this->email, 'Welcome!', [
            'name' => $this->name
        ]);

        echo "Email sent to {$this->email}\n";
    }
}
```

### Step 2: Dispatch the Job

```php
// In your controller
public function register(Request $request)
{
    $user = User::create($request->all());

    // Dispatch job (returns immediately)
    dispatch(new SendWelcomeEmail($user->email, $user->name));

    return JsonResponse::success([
        'message' => 'Registration successful! Check your email.',
        'user' => $user
    ]);
}
```

### Step 3: Run the Worker

Start the queue worker to process jobs:

```bash
php artisan queue:work

# Output:
# Processing: App\Jobs\SendWelcomeEmail
# Email sent to john@example.com
# Processed:  App\Jobs\SendWelcomeEmail (0.5s)
```

That's it! Jobs are now processed in the background.

---

## Architecture

### Components

**1. Job Classes** (`app/Jobs/*.php`)
- Define the work to be done
- Contain job-specific logic
- Serialized and stored in database

**2. QueueManager** (`core/Queue/QueueManager.php`)
- Manages queue connections
- Handles job dispatching
- Routes jobs to appropriate queue

**3. DatabaseQueue** (`core/Queue/DatabaseQueue.php`)
- Database queue driver
- Inserts jobs into `jobs` table
- Implements locking to prevent duplicate processing

**4. Worker** (`core/Queue/Worker.php`)
- Daemon that processes jobs
- Picks up jobs from queue
- Handles errors and retries
- Updates job status

**5. Console Command** (`core/Console/Commands/QueueWorkCommand.php`)
- CLI interface: `php artisan queue:work`
- Worker process control
- Options for queue selection, sleep time, etc.

### Job Lifecycle

```
┌─────────────┐
│ Dispatched  │ → Job created and stored in jobs table
└──────┬──────┘
       │
       v
┌─────────────┐
│   Queued    │ → Waiting in database (status: pending)
└──────┬──────┘
       │
       v
┌─────────────┐
│ Processing  │ → Worker picks up and executes job
└──────┬──────┘
       │
       ├─ Success → Job deleted from table
       │
       └─ Failure ┐
                  │
                  v
          ┌──────────────┐
          │ Retry Logic  │ → Attempts < max_tries?
          └──────┬───────┘
                 │
                 ├─ Yes → Back to Queued (with delay)
                 │
                 └─ No → Moved to failed_jobs table
```

### Database Schema

**jobs table**:
```sql
CREATE TABLE jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts TINYINT UNSIGNED NOT NULL,
    reserved_at INT UNSIGNED,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL,
    INDEX idx_queue_reserved (queue, reserved_at)
);
```

**failed_jobs table**:
```sql
CREATE TABLE failed_jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## Creating Jobs

### Basic Job Structure

```php
<?php

namespace App\Jobs;

use Core\Queue\Job;

class ProcessLargeImport extends Job
{
    // Job configuration
    public int $tries = 3;        // Max retry attempts
    public int $timeout = 300;    // 5 minutes timeout
    public string $queue = 'default';  // Queue name

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
        $importer = app('importer');
        $importer->process($this->filePath, $this->userId);
    }

    public function failed(\Exception $exception): void
    {
        // Called when job fails after all retries
        // Send notification, log error, etc.
        $user = User::find($this->userId);
        $user->notify(new ImportFailed($this->filePath, $exception->getMessage()));
    }
}
```

### Job Properties

**$tries** - Maximum retry attempts:
```php
public int $tries = 3;  // Default: 3 attempts
```

**$timeout** - Maximum execution time (seconds):
```php
public int $timeout = 60;   // 1 minute
public int $timeout = 300;  // 5 minutes
public int $timeout = 3600; // 1 hour
```

**$queue** - Queue name for priority:
```php
public string $queue = 'default';
public string $queue = 'high-priority';
public string $queue = 'low-priority';
```

### Dependency Injection

Jobs support constructor injection:

```php
class GenerateReport extends Job
{
    protected int $reportId;

    public function __construct(int $reportId)
    {
        $this->reportId = $reportId;
    }

    public function handle(): void
    {
        // Dependencies auto-resolved
        $reportService = app('report.service');
        $emailService = app('email');

        $report = $reportService->generate($this->reportId);
        $emailService->send($report);
    }
}
```

### Error Handling

```php
public function handle(): void
{
    try {
        // Risky operation
        $this->processPayment();
    } catch (PaymentGatewayException $e) {
        // Release back to queue (will retry)
        if ($this->attempts() < $this->tries) {
            throw $e;  // Let queue system handle retry
        }

        // Max retries reached - handle gracefully
        $this->logFailure($e);
    }
}
```

---

## Dispatching Jobs

### Basic Dispatch

```php
// Simple dispatch
dispatch(new SendEmail($user->email));

// With queue name
$job = new GenerateReport($reportId);
$job->queue = 'high-priority';
dispatch($job);
```

### Delayed Dispatch

Process job after specified delay:

```php
// Not implemented yet in current version
// Future feature:
// dispatch(new SendReminder($userId))->delay(3600); // 1 hour delay
```

### Conditional Dispatch

```php
if ($order->total > 10000) {
    // High-value orders: notify immediately
    dispatch(new NotifyManagement($order));
}

if ($import->rows > 100000) {
    // Large imports: use low-priority queue
    $job = new ProcessImport($import->id);
    $job->queue = 'low-priority';
    dispatch($job);
}
```

### Chaining Jobs

Process jobs in sequence (manual implementation):

```php
class ImportAndNotify extends Job
{
    public function handle(): void
    {
        // Step 1: Import data
        $importer = app('importer');
        $result = $importer->process($this->filePath);

        // Step 2: Dispatch notification job
        dispatch(new SendImportComplete($this->userId, $result));
    }
}
```

---

## Running Workers

### Start Worker

```bash
# Basic worker
php artisan queue:work

# Specify queue
php artisan queue:work --queue=high-priority

# Multiple queues (priority order)
php artisan queue:work --queue=high-priority,default,low-priority

# Set sleep time (seconds between job checks)
php artisan queue:work --sleep=3

# Set max tries
php artisan queue:work --tries=5
```

### Worker Options

```php
// In QueueWorkCommand.php
protected string $signature = 'queue:work {--queue=default} {--sleep=3} {--tries=3} {--timeout=60}';
```

**--queue**: Queue name(s) to process
**--sleep**: Seconds to wait when queue is empty
**--tries**: Override job max attempts
**--timeout**: Worker timeout (seconds)

### Production: Supervisor

For production, use Supervisor to keep worker running:

```ini
[program:so-framework-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/so-backend-framework/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/html/so-backend-framework/storage/logs/worker.log
stopwaitsecs=3600
```

Install and start:
```bash
sudo apt-get install supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start so-framework-worker:*
```

### Monitor Workers

```bash
# Check worker status
sudo supervisorctl status

# View worker logs
tail -f storage/logs/worker.log

# Restart workers (after code deploy)
sudo supervisorctl restart so-framework-worker:*
```

---

## Failed Jobs

### View Failed Jobs

```sql
SELECT * FROM failed_jobs ORDER BY failed_at DESC;
```

Output:
```
id | queue   | exception                              | failed_at
---+---------+----------------------------------------+---------------------
1  | default | PaymentGatewayException: Timeout       | 2026-01-29 10:15:00
2  | default | FileNotFoundException: import.csv      | 2026-01-29 09:30:00
```

### Retry Failed Job

Manual retry from database:

```php
// Get failed job
$failedJob = DB::table('failed_jobs')->where('id', 1)->first();

// Deserialize payload
$payload = json_decode($failedJob['payload'], true);

// Re-dispatch
$jobClass = $payload['displayName'];
$job = unserialize($payload['data']['command']);
dispatch($job);

// Delete from failed_jobs
DB::table('failed_jobs')->where('id', 1)->delete();
```

### Failed Job Handler

```php
class SendInvoice extends Job
{
    public function failed(\Exception $exception): void
    {
        // Log to system
        logger()->error('Invoice send failed', [
            'invoice_id' => $this->invoiceId,
            'error' => $exception->getMessage()
        ]);

        // Notify admin
        $admin = User::find(1);
        $admin->notify(new JobFailedNotification('SendInvoice', $exception));

        // Update invoice status
        Invoice::find($this->invoiceId)->update([
            'send_status' => 'failed',
            'send_error' => $exception->getMessage()
        ]);
    }
}
```

---

## Configuration

### config/queue.php

```php
<?php

return [
    // Default queue connection
    'default' => env('QUEUE_CONNECTION', 'database'),

    // Queue connections
    'connections' => [
        'sync' => [
            'driver' => 'sync',  // Immediate execution (no queue)
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,  // Seconds before job considered failed
        ],
    ],

    // Failed job configuration
    'failed' => [
        'table' => 'failed_jobs',
    ],
];
```

### Environment Variables

```env
QUEUE_CONNECTION=database
```

### Queue Names

Organize jobs by priority:

```php
// config/queue.php
'queues' => [
    'critical'     => 1,  // Process immediately
    'high'         => 2,  // Important
    'default'      => 3,  // Normal
    'low'          => 4,  // Can wait
    'maintenance'  => 5,  // Overnight jobs
]
```

Worker prioritization:
```bash
php artisan queue:work --queue=critical,high,default,low
```

---

## ERP Use Cases

### 1. Large Report Generation

**Problem**: Monthly sales report takes 8 minutes, causes timeout.

**Solution**:
```php
class GenerateMonthlySalesReport extends Job
{
    public int $timeout = 600; // 10 minutes
    protected int $month;
    protected int $year;

    public function handle(): void
    {
        $reportService = app('report.service');

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
        $request->input('month'),
        $request->input('year'),
        $request->user()->id
    ));

    return JsonResponse::success([
        'message' => 'Report generation started. You will be notified when ready.'
    ]);
}
```

### 2. Bulk Data Import

**Problem**: Importing 50,000 products from CSV takes 15 minutes.

**Solution**:
```php
class ImportProducts extends Job
{
    public int $timeout = 1800; // 30 minutes
    public int $tries = 1; // Don't retry (data may be partially imported)

    public function handle(): void
    {
        $csv = fopen($this->filePath, 'r');
        $imported = 0;
        $errors = [];

        while (($row = fgetcsv($csv)) !== false) {
            try {
                Product::create([
                    'sku' => $row[0],
                    'name' => $row[1],
                    'price' => $row[2],
                ]);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Row {$imported}: {$e->getMessage()}";
            }
        }

        fclose($csv);

        // Notify completion
        $user = User::find($this->userId);
        $user->notify(new ImportComplete($imported, $errors));
    }
}
```

### 3. Email Notifications

**Problem**: Sending 1,000 order confirmation emails blocks user response.

**Solution**:
```php
class SendBulkEmails extends Job
{
    protected array $recipients;
    protected string $subject;
    protected string $message;

    public function handle(): void
    {
        $emailService = app('email');

        foreach ($this->recipients as $recipient) {
            $emailService->send($recipient['email'], $this->subject, [
                'name' => $recipient['name'],
                'message' => $this->message
            ]);

            usleep(100000); // 0.1s delay between emails
        }
    }
}
```

### 4. Invoice PDF Generation

**Problem**: Generating invoice PDFs with complex layouts is slow.

**Solution**:
```php
class GenerateInvoicePdf extends Job
{
    protected int $invoiceId;

    public function handle(): void
    {
        $invoice = Invoice::with(['items', 'customer'])->find($this->invoiceId);

        $pdf = app('pdf.generator');
        $pdfContent = $pdf->generate('invoice', ['invoice' => $invoice]);

        // Save to storage
        $filePath = "invoices/INV-{$invoice->id}.pdf";
        file_put_contents(storage_path($filePath), $pdfContent);

        // Update invoice
        $invoice->update(['pdf_path' => $filePath]);

        // Notify customer
        $invoice->customer->notify(new InvoiceReady($invoice));
    }
}
```

---

## Best Practices

### 1. Keep Jobs Small and Focused

```php
// ❌ Bad: One giant job
class ProcessEverything extends Job { }

// ✅ Good: Specific, focused jobs
class ImportProducts extends Job { }
class GenerateReport extends Job { }
class SendEmailBatch extends Job { }
```

### 2. Make Jobs Idempotent

Jobs should be safe to run multiple times:

```php
public function handle(): void
{
    // Check if already processed
    $report = Report::find($this->reportId);
    if ($report->status === 'completed') {
        return; // Already done, skip
    }

    // Process
    $report->generate();
    $report->update(['status' => 'completed']);
}
```

### 3. Use Appropriate Timeouts

```php
class QuickTask extends Job {
    public int $timeout = 30;  // 30 seconds
}

class HeavyReport extends Job {
    public int $timeout = 1800;  // 30 minutes
}
```

### 4. Handle Failures Gracefully

```php
public function failed(\Exception $exception): void
{
    // Always notify someone
    $admin->notify(new JobFailedAlert($this, $exception));

    // Update related records
    $this->updateStatus('failed');

    // Log for debugging
    logger()->critical('Job failed', [
        'job' => static::class,
        'data' => $this->toArray(),
        'error' => $exception->getMessage()
    ]);
}
```

### 5. Monitor Queue Health

```bash
# Check jobs table size
SELECT COUNT(*) FROM jobs WHERE queue = 'default';

# Check failed jobs
SELECT COUNT(*) FROM failed_jobs;

# Average processing time
SELECT AVG(UNIX_TIMESTAMP() - created_at) as avg_time
FROM jobs
WHERE reserved_at IS NOT NULL;
```

### 6. Use Queue Names Strategically

```php
// Critical: Process immediately
$job = new ProcessPayment($orderId);
$job->queue = 'critical';

// Reports: Can wait
$job = new GenerateReport($month);
$job->queue = 'low-priority';
```

---

## Troubleshooting

### Jobs Not Processing

**1. Check worker is running**:
```bash
ps aux | grep "queue:work"
```

**2. Check jobs table**:
```sql
SELECT * FROM jobs LIMIT 10;
```

**3. Check worker logs**:
```bash
tail -f storage/logs/worker.log
```

### Worker Memory Issues

```bash
# Restart worker after X jobs
php artisan queue:work --max-jobs=1000

# Restart worker after X seconds
php artisan queue:work --max-time=3600
```

### Slow Job Processing

- Reduce job payload size (don't pass entire models)
- Split large jobs into smaller chunks
- Use dedicated queue for heavy jobs
- Add more workers

---

## Summary

The Queue System enables:

✅ **Background processing** - Heavy operations don't block users
✅ **Automatic retry** - Transient failures handled gracefully
✅ **Job tracking** - Monitor progress and failures
✅ **Scalability** - Add more workers as needed
✅ **Priority queues** - Critical jobs processed first

**Essential for ERP systems with:**
- Large report generation
- Bulk data operations
- Email notifications
- PDF generation
- API integrations

**Start queuing jobs today for better user experience and system reliability.**

---

**Next Steps**:
- Create your first job class in `app/Jobs/`
- Set up Supervisor for production workers
- Configure queue monitoring and alerts
- Review [FRAMEWORK-FEATURES.md](FRAMEWORK-FEATURES.md) for system overview

**Version**: 2.0.0 | **Last Updated**: 2026-01-29
