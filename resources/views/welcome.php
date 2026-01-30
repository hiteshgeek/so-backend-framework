<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(config('app.name')) ?></title>
    <?php assets()->css('css/welcome.css', 'head', 10); ?>
    <?= render_assets('head') ?>
</head>
<body>
    <div class="container">
        <h1>🚀 <?= htmlspecialchars(config('app.name')) ?></h1>
        <p>A production-ready PHP framework with modern features, security, and best practices built-in.</p>

        <div class="features">
            <div class="feature">
                <div class="feature-icon">🛣️</div>
                <div class="feature-title">Routing</div>
                <div class="feature-desc">Laravel-style routing</div>
            </div>
            <div class="feature">
                <div class="feature-icon">🔒</div>
                <div class="feature-title">Security</div>
                <div class="feature-desc">CSRF, XSS, SQL injection protection</div>
            </div>
            <div class="feature">
                <div class="feature-icon">🗄️</div>
                <div class="feature-title">Database</div>
                <div class="feature-desc">Query builder & ORM</div>
            </div>
            <div class="feature">
                <div class="feature-icon">🎯</div>
                <div class="feature-title">MVC</div>
                <div class="feature-desc">Clean architecture</div>
            </div>
        </div>

        <div class="links">
            <a href="<?= htmlspecialchars(config('app.url')) ?>/login">Login</a>
            <a href="<?= htmlspecialchars(config('app.url')) ?>/api/test">Test API</a>
            <a href="<?= htmlspecialchars(config('app.url')) ?>/docs">Documentation</a>
        </div>

        <div class="version">
            Version 1.0.0 | PHP <?= PHP_VERSION ?> | <?= php_sapi_name() ?>
        </div>
    </div>
</body>
</html>
