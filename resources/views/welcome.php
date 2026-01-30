<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(config('app.name')) ?></title>
    <?php
    assets()->cdn('https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css', 'css', 'head', 5);
    assets()->cdn('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', 'css', 'head', 5);
    assets()->css('css/base.css', 'head', 8);
    assets()->css('css/pages/welcome.css', 'head', 10);
    assets()->js('js/theme.js', 'body_end', 10);
    ?>
    <script>(function(){var t=localStorage.getItem("theme");if(!t&&window.matchMedia("(prefers-color-scheme:dark)").matches)t="dark";if(t)document.documentElement.setAttribute("data-theme",t);})()</script>
    <?= render_assets('head') ?>
</head>
<body>
    <div class="welcome-container">
        <div class="welcome-icon">
            <span class="mdi mdi-rocket-launch"></span>
        </div>
        <h1><?= htmlspecialchars(config('app.name', 'SO Framework')) ?></h1>
        <p class="welcome-subtitle">A production-ready PHP framework with modern features, security, and best practices built-in.</p>

        <div class="features">
            <div class="feature">
                <span class="mdi mdi-routes feature-icon"></span>
                <div class="feature-title">Routing</div>
                <div class="feature-desc">Laravel-style routing</div>
            </div>
            <div class="feature">
                <span class="mdi mdi-shield-lock feature-icon"></span>
                <div class="feature-title">Security</div>
                <div class="feature-desc">CSRF, XSS, SQL injection protection</div>
            </div>
            <div class="feature">
                <span class="mdi mdi-database feature-icon"></span>
                <div class="feature-title">Database</div>
                <div class="feature-desc">Query builder & ORM</div>
            </div>
            <div class="feature">
                <span class="mdi mdi-target feature-icon"></span>
                <div class="feature-title">MVC</div>
                <div class="feature-desc">Clean architecture</div>
            </div>
        </div>

        <div class="links">
            <a href="<?= htmlspecialchars(config('app.url')) ?>/login" class="link-btn">
                <span class="mdi mdi-login"></span> Login
            </a>
            <a href="<?= htmlspecialchars(config('app.url')) ?>/api/test" class="link-btn link-btn--outline">
                <span class="mdi mdi-api"></span> Test API
            </a>
            <a href="<?= htmlspecialchars(config('app.url')) ?>/docs" class="link-btn link-btn--outline">
                <span class="mdi mdi-book-open-variant"></span> Documentation
            </a>
        </div>

        <div class="version">
            <?= htmlspecialchars(config('app.name', 'SO Framework')) ?> v<?= htmlspecialchars(config('app.version', '2.0.0')) ?> | PHP <?= PHP_VERSION ?>
        </div>
    </div>
</body>
</html>
