<?php
/**
 * Setup Page
 *
 * Displayed when the application is not fully configured.
 * This page works without Composer or database dependencies.
 */

// Determine what's missing
$missing = defined('SETUP_MISSING') ? SETUP_MISSING : 'composer';
$error = defined('SETUP_ERROR') ? SETUP_ERROR : null;

// Get app name from .env if available
$appName = 'SO Backend Framework';
if (file_exists(__DIR__ . '/../.env')) {
    $envContent = file_get_contents(__DIR__ . '/../.env');
    if (preg_match('/^APP_NAME=(.+)$/m', $envContent, $matches)) {
        $appName = trim($matches[1], '"\'');
    }
}

// Determine current step
$steps = [
    'composer' => [
        'title' => 'Install Dependencies',
        'status' => file_exists(__DIR__ . '/../vendor/autoload.php') ? 'complete' : 'current',
        'command' => 'composer install',
        'description' => 'Install PHP dependencies using Composer.'
    ],
    'env' => [
        'title' => 'Configure Environment',
        'status' => file_exists(__DIR__ . '/../.env') ? 'complete' : ($missing === 'env' ? 'current' : 'pending'),
        'command' => 'cp .env.example .env',
        'description' => 'Copy the example environment file and configure your settings.'
    ],
    'database' => [
        'title' => 'Setup Database',
        'status' => $missing === 'database' ? 'current' : 'pending',
        'command' => 'Edit .env file with database credentials',
        'description' => 'Configure your database connection in the .env file.'
    ],
    'ready' => [
        'title' => 'Ready to Go!',
        'status' => 'pending',
        'command' => null,
        'description' => 'Your application will be ready to use.'
    ]
];

// Update statuses based on what's missing
if ($missing === 'composer') {
    $steps['env']['status'] = 'pending';
    $steps['database']['status'] = 'pending';
} elseif ($missing === 'env') {
    $steps['composer']['status'] = 'complete';
    $steps['database']['status'] = 'pending';
} elseif ($missing === 'database') {
    $steps['composer']['status'] = 'complete';
    $steps['env']['status'] = 'complete';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup - <?= htmlspecialchars($appName) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-light: #3b82f6;
            --primary-bg: #eff6ff;
            --success: #10b981;
            --success-bg: #d1fae5;
            --warning: #f59e0b;
            --warning-bg: #fef3c7;
            --error: #ef4444;
            --error-bg: #fee2e2;
            --text: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --background: #f8fafc;
            --surface: #ffffff;
            --border: #e2e8f0;
            --code-bg: #f1f5f9;
            --radius: 12px;
            --radius-sm: 8px;
            --shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --primary: #3b82f6;
                --primary-light: #60a5fa;
                --primary-bg: #1e3a5f;
                --success: #34d399;
                --success-bg: #064e3b;
                --warning: #fbbf24;
                --warning-bg: #78350f;
                --error: #f87171;
                --error-bg: #7f1d1d;
                --text: #f1f5f9;
                --text-secondary: #94a3b8;
                --text-muted: #64748b;
                --background: #0f172a;
                --surface: #1e293b;
                --border: #334155;
                --code-bg: #0f172a;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--background);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            line-height: 1.6;
        }

        .setup-container {
            max-width: 600px;
            width: 100%;
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .setup-header {
            padding: 32px 32px 24px;
            text-align: center;
            border-bottom: 1px solid var(--border);
        }

        .setup-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .setup-header p {
            color: var(--text-secondary);
            font-size: 15px;
        }

        .setup-content {
            padding: 32px;
        }

        .setup-steps {
            list-style: none;
        }

        .setup-step {
            display: flex;
            gap: 16px;
            padding: 16px 0;
            border-bottom: 1px solid var(--border);
        }

        .setup-step:last-child {
            border-bottom: none;
        }

        .step-indicator {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
            flex-shrink: 0;
        }

        .step-indicator.complete {
            background: var(--success-bg);
            color: var(--success);
        }

        .step-indicator.current {
            background: var(--primary);
            color: white;
            animation: pulse 2s infinite;
        }

        .step-indicator.pending {
            background: var(--code-bg);
            color: var(--text-muted);
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .step-content {
            flex: 1;
        }

        .step-title {
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 4px;
        }

        .step-description {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 8px;
        }

        .step-command {
            background: var(--code-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 10px 14px;
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
            font-size: 13px;
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .step-command code {
            flex: 1;
        }

        .copy-btn {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }

        .copy-btn:hover {
            background: var(--primary-light);
        }

        .copy-btn.copied {
            background: var(--success);
        }

        .error-box {
            background: var(--error-bg);
            border: 1px solid var(--error);
            border-radius: var(--radius-sm);
            padding: 16px;
            margin-bottom: 24px;
        }

        .error-box-title {
            font-weight: 600;
            color: var(--error);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .error-box-message {
            font-size: 13px;
            color: var(--text-secondary);
            font-family: 'Consolas', 'Monaco', monospace;
            word-break: break-all;
        }

        .env-config {
            background: var(--code-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 16px;
            margin-top: 12px;
        }

        .env-config-title {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-secondary);
            margin-bottom: 12px;
        }

        .env-config pre {
            font-family: 'Consolas', 'Monaco', monospace;
            font-size: 12px;
            line-height: 1.8;
            color: var(--text);
            white-space: pre-wrap;
        }

        .env-key {
            color: var(--primary);
        }

        .env-value {
            color: var(--success);
        }

        .setup-footer {
            padding: 16px 32px;
            background: var(--code-bg);
            border-top: 1px solid var(--border);
            text-align: center;
        }

        .setup-footer p {
            font-size: 12px;
            color: var(--text-muted);
        }

        .checkmark {
            display: inline-block;
        }

        .checkmark::before {
            content: '✓';
        }

        @media (max-width: 480px) {
            .setup-container {
                border-radius: 0;
            }

            .setup-header, .setup-content, .setup-footer {
                padding: 20px;
            }

            .setup-header h1 {
                font-size: 22px;
            }

            .step-command {
                flex-direction: column;
                align-items: stretch;
            }

            .copy-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="setup-container">
        <div class="setup-header">
            <h1><?= htmlspecialchars($appName) ?></h1>
            <p>Complete the setup steps below to get started</p>
        </div>

        <div class="setup-content">
            <?php if ($error && $missing === 'database'): ?>
            <div class="error-box">
                <div class="error-box-title">
                    <span>⚠</span> Database Connection Error
                </div>
                <div class="error-box-message"><?= htmlspecialchars($error) ?></div>
            </div>
            <?php elseif ($error): ?>
            <div class="error-box">
                <div class="error-box-title">
                    <span>⚠</span> Configuration Error
                </div>
                <div class="error-box-message"><?= htmlspecialchars($error) ?></div>
            </div>
            <?php endif; ?>

            <ul class="setup-steps">
                <?php $stepNum = 1; foreach ($steps as $key => $step): ?>
                <li class="setup-step">
                    <div class="step-indicator <?= $step['status'] ?>">
                        <?php if ($step['status'] === 'complete'): ?>
                            <span class="checkmark"></span>
                        <?php else: ?>
                            <?= $stepNum ?>
                        <?php endif; ?>
                    </div>
                    <div class="step-content">
                        <div class="step-title"><?= htmlspecialchars($step['title']) ?></div>
                        <div class="step-description"><?= htmlspecialchars($step['description']) ?></div>

                        <?php if ($step['command'] && $step['status'] === 'current'): ?>
                            <?php if ($key === 'database'): ?>
                                <div class="env-config">
                                    <div class="env-config-title">Edit .env file</div>
                                    <pre><span class="env-key">DB_HOST</span>=<span class="env-value">127.0.0.1</span>
<span class="env-key">DB_PORT</span>=<span class="env-value">3306</span>
<span class="env-key">DB_DATABASE</span>=<span class="env-value">your_database</span>
<span class="env-key">DB_USERNAME</span>=<span class="env-value">your_username</span>
<span class="env-key">DB_PASSWORD</span>=<span class="env-value">your_password</span></pre>
                                </div>
                            <?php else: ?>
                                <div class="step-command">
                                    <code><?= htmlspecialchars($step['command']) ?></code>
                                    <button class="copy-btn" onclick="copyCommand(this, '<?= htmlspecialchars($step['command']) ?>')">Copy</button>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </li>
                <?php $stepNum++; endforeach; ?>
            </ul>
        </div>

        <div class="setup-footer">
            <p>Framework v2.0.0 | PHP <?= PHP_VERSION ?></p>
        </div>
    </div>

    <script>
    function copyCommand(btn, text) {
        navigator.clipboard.writeText(text).then(function() {
            btn.textContent = 'Copied!';
            btn.classList.add('copied');
            setTimeout(function() {
                btn.textContent = 'Copy';
                btn.classList.remove('copied');
            }, 2000);
        });
    }
    </script>
</body>
</html>
