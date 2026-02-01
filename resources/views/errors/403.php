<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Access Forbidden</title>
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
            color: #ea580c;
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
            <rect x="5" y="11" width="14" height="10" rx="2" stroke="currentColor" stroke-width="2" style="color: #ea580c;"/>
            <path d="M7 11V7C7 4.79086 8.79086 3 11 3H13C15.2091 3 17 4.79086 17 7V11" stroke="currentColor" stroke-width="2" style="color: #ea580c;"/>
            <circle cx="12" cy="16" r="1.5" fill="#ea580c"/>
        </svg>

        <div class="error-code">403</div>
        <h1 class="error-title">Access Forbidden</h1>
        <p class="error-message">
            You don't have permission to access this resource. Please contact your administrator if you believe this is an error.
        </p>

        <div class="error-actions">
            <a href="<?= htmlspecialchars(config('app.url')) ?>" class="btn btn-primary">Go to Homepage</a>
            <a href="javascript:history.back()" class="btn btn-secondary">Go Back</a>
        </div>
    </div>
</body>
</html>
