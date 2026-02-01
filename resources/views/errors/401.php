<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>401 - Unauthorized</title>
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
            color: var(--primary);
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
            <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2" style="color: var(--primary);"/>
            <path d="M6 21V19C6 16.7909 7.79086 15 10 15H14C16.2091 15 18 16.7909 18 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="color: var(--primary);"/>
            <path d="M15 8L17 10L15 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary);"/>
        </svg>

        <div class="error-code">401</div>
        <h1 class="error-title">Authentication Required</h1>
        <p class="error-message">
            You need to be logged in to access this page. Please sign in to continue.
        </p>

        <div class="error-actions">
            <a href="<?= htmlspecialchars(config('app.url')) ?>/auth/login" class="btn btn-primary">Login</a>
            <a href="<?= htmlspecialchars(config('app.url')) ?>" class="btn btn-secondary">Go to Homepage</a>
        </div>
    </div>
</body>
</html>
