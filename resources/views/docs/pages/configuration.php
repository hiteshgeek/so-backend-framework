<?php
/**
 * Configuration Documentation Page
 *
 * Guide to framework configuration and environment variables.
 */

$pageTitle = 'Configuration';
$pageIcon = 'cog';
$toc = [
    ['id' => 'overview', 'title' => 'Overview', 'level' => 2],
    ['id' => 'quick-config', 'title' => 'Quick Configuration', 'level' => 2],
    ['id' => 'env-reference', 'title' => 'Environment Variables', 'level' => 2],
    ['id' => 'using-config', 'title' => 'Using Configuration', 'level' => 2],
    ['id' => 'config-files', 'title' => 'Configuration Files', 'level' => 2],
    ['id' => 'renaming', 'title' => 'Renaming Framework', 'level' => 2],
    ['id' => 'best-practices', 'title' => 'Best Practices', 'level' => 2],
];
$breadcrumbs = [['label' => 'Configuration']];
$lastUpdated = '2026-01-30';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="configuration" class="heading heading-1">
    <span class="mdi mdi-cog heading-icon"></span>
    <span class="heading-text">Configuration Guide</span>
</h1>

<p class="text-lead">
    The framework uses a centralized configuration system where all settings can be changed in one place and automatically affect the entire application.
</p>

<?= callout('tip', 'Change the framework name <strong>once</strong> in <code class="code-inline">.env</code> and it works <strong>everywhere</strong> automatically!', 'Single Source of Truth') ?>

<!-- Quick Configuration -->
<h2 id="quick-config" class="heading heading-2">
    <span class="mdi mdi-lightning-bolt heading-icon"></span>
    <span class="heading-text">Quick Configuration</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">1. Framework Name</span>
</h3>

<?= codeBlock('bash', 'APP_NAME="Your Framework Name"', '.env') ?>

<p class="mt-2">This automatically updates:</p>
<ul class="list list-check">
    <li>Page titles</li>
    <li>Welcome page heading</li>
    <li>Error pages</li>
    <li>Logs and debugging output</li>
    <li>Any place using <code class="code-inline">config('app.name')</code></li>
</ul>

<h3 class="heading heading-3">
    <span class="heading-text">2. Database Name</span>
</h3>

<?= codeBlock('bash', 'DB_DATABASE=your-database-name', '.env') ?>

<p class="mt-2">After changing, regenerate the SQL:</p>

<?= codeBlock('bash', 'php database/migrations/generate-setup.php') ?>

<h3 class="heading heading-3">
    <span class="heading-text">3. Application URL</span>
</h3>

<?= codeBlock('bash', 'APP_URL=https://yourdomain.com', '.env') ?>

<p class="mt-2">This affects URL generation via <code class="code-inline">url()</code> helper, asset URLs, and redirects.</p>

<!-- Environment Variables Reference -->
<h2 id="env-reference" class="heading heading-2">
    <span class="mdi mdi-file-document heading-icon"></span>
    <span class="heading-text">Environment Variables Reference</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Application Settings</span>
</h3>

<?= dataTable(
    ['Variable', 'Default', 'Description'],
    [
        ['<code class="code-inline">APP_NAME</code>', '"SO Framework"', 'Framework display name'],
        ['<code class="code-inline">APP_ENV</code>', 'production', 'Environment (development/production/testing)'],
        ['<code class="code-inline">APP_DEBUG</code>', 'false', 'Enable debug mode'],
        ['<code class="code-inline">APP_URL</code>', 'http://localhost', 'Base URL'],
        ['<code class="code-inline">APP_KEY</code>', '(empty)', 'Application encryption key'],
    ]
) ?>

<h3 class="heading heading-3">
    <span class="heading-text">Database Settings</span>
</h3>

<?= dataTable(
    ['Variable', 'Default', 'Description'],
    [
        ['<code class="code-inline">DB_CONNECTION</code>', 'mysql', 'Database driver (mysql/pgsql)'],
        ['<code class="code-inline">DB_HOST</code>', '127.0.0.1', 'Database host'],
        ['<code class="code-inline">DB_PORT</code>', '3306', 'Database port'],
        ['<code class="code-inline">DB_DATABASE</code>', 'so-framework', '<strong>Database name</strong>'],
        ['<code class="code-inline">DB_USERNAME</code>', 'root', 'Database username'],
        ['<code class="code-inline">DB_PASSWORD</code>', '(empty)', 'Database password'],
    ]
) ?>

<h3 class="heading heading-3">
    <span class="heading-text">Session Settings</span>
</h3>

<?= dataTable(
    ['Variable', 'Default', 'Description'],
    [
        ['<code class="code-inline">SESSION_DRIVER</code>', 'file', 'Session storage driver'],
        ['<code class="code-inline">SESSION_LIFETIME</code>', '120', 'Session lifetime (minutes)'],
        ['<code class="code-inline">SESSION_SECURE</code>', 'false', 'HTTPS only'],
        ['<code class="code-inline">SESSION_HTTPONLY</code>', 'true', 'HTTP only (no JavaScript)'],
        ['<code class="code-inline">SESSION_SAMESITE</code>', 'strict', 'SameSite cookie attribute'],
    ]
) ?>

<!-- Using Configuration -->
<h2 id="using-config" class="heading heading-2">
    <span class="mdi mdi-code-braces heading-icon"></span>
    <span class="heading-text">Using Configuration in Code</span>
</h2>

<?= codeTabs([
    ['label' => 'Read Config', 'lang' => 'php', 'code' => '// Get app name
$name = config(\'app.name\');

// Get database name
$database = config(\'database.connections.mysql.database\');

// With default value
$timezone = config(\'app.timezone\', \'UTC\');

// Check if exists
if (config()->has(\'app.debug\')) {
    // ...
}'],
    ['label' => 'In Views', 'lang' => 'php', 'code' => '<!DOCTYPE html>
<html>
<head>
    <title><?= e(config(\'app.name\')) ?></title>
</head>
<body>
    <h1>Welcome to <?= e(config(\'app.name\')) ?></h1>

    <?php if (config(\'app.debug\')): ?>
        <div class="debug-info">Debug Mode Active</div>
    <?php endif; ?>
</body>
</html>'],
    ['label' => 'In Controllers', 'lang' => 'php', 'code' => 'class HomeController
{
    public function index(Request $request): Response
    {
        return Response::view(\'home\', [
            \'title\' => config(\'app.name\'),
            \'version\' => app()->version(),
        ]);
    }
}'],
]) ?>

<!-- Configuration Files -->
<h2 id="config-files" class="heading heading-2">
    <span class="mdi mdi-folder-cog heading-icon"></span>
    <span class="heading-text">Configuration Files</span>
</h2>

<p>The framework loads configuration from the <?= filePath('config/') ?> directory:</p>

<?= codeTabs([
    ['label' => 'config/app.php', 'lang' => 'php', 'code' => '<?php

return [
    \'name\' => env(\'APP_NAME\', \'Framework\'),
    \'env\' => env(\'APP_ENV\', \'production\'),
    \'debug\' => env(\'APP_DEBUG\', false),
    \'url\' => env(\'APP_URL\', \'http://localhost\'),
    // ...
];'],
    ['label' => 'config/database.php', 'lang' => 'php', 'code' => '<?php

return [
    \'default\' => env(\'DB_CONNECTION\', \'mysql\'),
    \'connections\' => [
        \'mysql\' => [
            \'host\' => env(\'DB_HOST\', \'127.0.0.1\'),
            \'database\' => env(\'DB_DATABASE\', \'framework\'),
            // ...
        ],
    ],
];'],
]) ?>

<!-- Renaming Framework -->
<h2 id="renaming" class="heading heading-2">
    <span class="mdi mdi-pencil heading-icon"></span>
    <span class="heading-text">Renaming Your Framework</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">1. Update Environment</span>
</h3>

<?= codeBlock('bash', 'APP_NAME="My Awesome Framework"
DB_DATABASE=my-awesome-framework', '.env') ?>

<h3 class="heading heading-3">
    <span class="heading-text">2. Regenerate Database Setup</span>
</h3>

<?= codeBlock('bash', 'php database/migrations/generate-setup.php') ?>

<h3 class="heading heading-3">
    <span class="heading-text">3. Update Composer (Optional)</span>
</h3>

<?= codeBlock('json', '{
    "name": "vendor/my-awesome-framework",
    "description": "Your custom description"
}', 'composer.json') ?>

<p class="mt-2">Then run: <code class="code-inline">composer dump-autoload</code></p>

<h3 class="heading heading-3">
    <span class="heading-text">4. Test Changes</span>
</h3>

<?= codeBlock('bash', 'curl http://localhost:8000       # Test homepage
curl http://localhost:8000/api/test  # Test API') ?>

<!-- Best Practices -->
<h2 id="best-practices" class="heading heading-2">
    <span class="mdi mdi-check-decagram heading-icon"></span>
    <span class="heading-text">Best Practices</span>
</h2>

<div class="space-y-3">
    <?= callout('danger', '<strong>Never Commit .env</strong><br>The <code class="code-inline">.env</code> file contains secrets. It\'s in <code class="code-inline">.gitignore</code> by default.') ?>

    <?= callout('success', '<strong>Use config() in Code</strong><br>Always use <code class="code-inline">config()</code> instead of <code class="code-inline">env()</code> - it\'s cached and optimized.') ?>

    <?= callout('info', '<strong>Keep .env.example Updated</strong><br>Document all required variables in <code class="code-inline">.env.example</code> for new installations.') ?>

    <?= callout('warning', '<strong>Type Cast Environment Values</strong><br>Environment variables are strings. Use <code class="code-inline">(bool)</code>, <code class="code-inline">(int)</code> in config files.') ?>
</div>

<h3 class="heading heading-3">
    <span class="heading-text">Environment-Specific Configuration</span>
</h3>

<?= codeTabs([
    ['label' => 'Development', 'lang' => 'bash', 'code' => 'APP_ENV=development
APP_DEBUG=true
LOG_LEVEL=debug'],
    ['label' => 'Production', 'lang' => 'bash', 'code' => 'APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error
SESSION_SECURE=true'],
    ['label' => 'Testing', 'lang' => 'bash', 'code' => 'APP_ENV=testing
APP_DEBUG=true
DB_DATABASE=framework_test'],
]) ?>

<h3 class="heading heading-3">
    <span class="heading-text">Helper Functions</span>
</h3>

<?= codeBlock('php', '// Get configuration value
config(\'app.name\')

// Get environment variable
env(\'APP_DEBUG\')

// Get application instance
app()

// Get from container
app(\'db\')

// Base path
base_path(\'storage/logs\')

// Config path
config_path(\'database.php\')') ?>

<?php include __DIR__ . '/../_layout-end.php'; ?>
