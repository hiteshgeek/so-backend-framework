<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error</title>
    <link rel="stylesheet" href="<?= htmlspecialchars(config('app.url')) ?>/assets/css/base.css">
    <style>
        body {
            background: var(--background);
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: var(--space-4);
        }
        .error-container {
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            max-width: 600px;
            width: 100%;
            padding: var(--space-6) var(--space-5);
            text-align: center;
        }
        .error-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto var(--space-4);
            opacity: 0.9;
        }
        .error-code {
            font-size: 120px;
            font-weight: 800;
            color: #dc2626;
            line-height: 1;
            margin-bottom: var(--space-3);
        }
        .error-title {
            font-size: 32px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: var(--space-2);
        }
        .error-message {
            font-size: 16px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: var(--space-5);
        }
        .error-details {
            background: var(--background);
            border-left: 4px solid #dc2626;
            padding: var(--space-3);
            margin-bottom: var(--space-5);
            text-align: left;
            border-radius: var(--radius-sm);
            display: none;
        }
        .error-details.show {
            display: block;
        }
        .error-details pre {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: var(--text);
            overflow-x: auto;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .error-actions {
            display: flex;
            gap: var(--space-2);
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn {
            padding: var(--space-2) var(--space-4);
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
        }
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
            opacity: 0.9;
        }
        .btn-secondary {
            background: var(--border);
            color: var(--text);
        }
        .btn-secondary:hover {
            background: var(--text-secondary);
            color: var(--surface);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <svg class="error-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" style="color: #dc2626;"/>
            <path d="M12 8V12" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="color: #dc2626;"/>
            <circle cx="12" cy="16" r="1" fill="#dc2626"/>
        </svg>

        <div class="error-code">500</div>
        <h1 class="error-title">Internal Server Error</h1>
        <p class="error-message">
            Oops! Something went wrong on our end. We've been notified and are working to fix the issue.
        </p>

        <?php if (config('app.debug') && isset($exception)): ?>
        <div class="error-details show">
            <strong>Error Details (Debug Mode):</strong>
            <pre><?= htmlspecialchars($exception->getMessage()) ?>

File: <?= htmlspecialchars($exception->getFile()) ?>:<?= $exception->getLine() ?>

<?php if (method_exists($exception, 'getTraceAsString')): ?>
Stack Trace:
<?= htmlspecialchars($exception->getTraceAsString()) ?>
<?php endif; ?></pre>
        </div>
        <?php endif; ?>

        <div class="error-actions">
            <a href="<?= htmlspecialchars(config('app.url')) ?>" class="btn btn-primary">Go to Homepage</a>
            <a href="javascript:location.reload()" class="btn btn-secondary">Try Again</a>
        </div>
    </div>
</body>
</html>
