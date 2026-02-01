<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>422 - Validation Error</title>
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
            color: #f59e0b;
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
        .validation-errors {
            background: var(--background);
            border-left: 4px solid #dc2626;
            padding: var(--space-3);
            margin-bottom: var(--space-5);
            text-align: left;
            border-radius: var(--radius-sm);
        }
        .validation-errors ul {
            list-style: none;
            padding: 0;
        }
        .validation-errors li {
            padding: var(--space-1) 0;
            color: #dc2626;
            font-size: 14px;
        }
        .validation-errors li:before {
            content: "• ";
            font-weight: bold;
            margin-right: var(--space-1);
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
            <path d="M9 11L12 14L22 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #f59e0b;"/>
            <path d="M21 12V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V5C3 3.89543 3.89543 3 5 3H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="color: #f59e0b;"/>
            <circle cx="12" cy="12" r="2" fill="#dc2626"/>
        </svg>

        <div class="error-code">422</div>
        <h1 class="error-title">Validation Failed</h1>
        <p class="error-message">
            The data you provided didn't pass validation. Please correct the errors below and try again.
        </p>

        <?php if (isset($errors) && !empty($errors)): ?>
        <div class="validation-errors">
            <strong>Validation Errors:</strong>
            <ul>
                <?php foreach ($errors as $field => $messages): ?>
                    <?php foreach ((array)$messages as $message): ?>
                        <li><?= htmlspecialchars($message) ?></li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <div class="error-actions">
            <a href="javascript:history.back()" class="btn btn-primary">Go Back and Fix</a>
            <a href="<?= htmlspecialchars(config('app.url')) ?>" class="btn btn-secondary">Go to Homepage</a>
        </div>
    </div>
</body>
</html>
