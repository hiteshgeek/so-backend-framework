<?php
/**
 * Quick Start Documentation Page
 *
 * Fast reference for common operations.
 */

$pageTitle = 'Quick Start';
$pageIcon = 'lightning-bolt';
$toc = [
    ['id' => 'change-name', 'title' => 'Change Framework Name', 'level' => 2],
    ['id' => 'auto-updates', 'title' => 'Auto-Updated Locations', 'level' => 2],
    ['id' => 'examples', 'title' => 'Examples', 'level' => 2],
    ['id' => 'test-changes', 'title' => 'Test Your Changes', 'level' => 2],
];
$prevPage = ['url' => '/docs/setup', 'title' => 'Setup Guide'];
$nextPage = ['url' => '/docs/project-structure', 'title' => 'Project Structure'];
$breadcrumbs = [['label' => 'Quick Start']];
$lastUpdated = '2026-01-30';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="quick-start-guide" class="heading heading-1">
    <span class="mdi mdi-lightning-bolt heading-icon"></span>
    <span class="heading-text">Quick Start Guide</span>
</h1>

<p class="text-lead">
    Get up and running with the SO Framework in under 5 minutes.
</p>

<?= callout('tip', 'Change the framework name <strong>once</strong> in <code class="code-inline">.env</code> and it works <strong>everywhere</strong> automatically!', 'One Place, Everywhere') ?>

<!-- Change Framework Name -->
<h2 id="change-name" class="heading heading-2">
    <span class="mdi mdi-pencil heading-icon"></span>
    <span class="heading-text">Change Framework Name in One Place</span>
</h2>

<div class="steps">
    <div class="step">
        <div class="step-number">1</div>
        <div class="step-content">
            <h4 class="step-title">Edit .env</h4>
            <?= codeBlock('bash', 'nano .env') ?>
            <p class="mt-2">Change these two lines:</p>
            <?= codeBlock('bash', 'APP_NAME="Your Framework Name Here"
DB_DATABASE=your-database-name', '.env') ?>
        </div>
    </div>

    <div class="step">
        <div class="step-number">2</div>
        <div class="step-content">
            <h4 class="step-title">Regenerate SQL (if database name changed)</h4>
            <?= codeBlock('bash', 'php database/migrations/generate-setup.php') ?>
        </div>
    </div>

    <div class="step">
        <div class="step-number">3</div>
        <div class="step-content">
            <h4 class="step-title">Import Database</h4>
            <?= codeBlock('bash', 'mysql -u root -p < database/migrations/setup.sql') ?>
        </div>
    </div>

    <div class="step">
        <div class="step-number">4</div>
        <div class="step-content">
            <h4 class="step-title">Done!</h4>
            <p>Your framework name now appears everywhere:</p>
            <ul class="list list-check">
                <li>Page titles</li>
                <li>Welcome page</li>
                <li>API responses</li>
                <li>Database name</li>
            </ul>
        </div>
    </div>
</div>

<!-- Auto-Updated Locations -->
<h2 id="auto-updates" class="heading heading-2">
    <span class="mdi mdi-sync heading-icon"></span>
    <span class="heading-text">What Gets Updated Automatically</span>
</h2>

<h4 class="heading heading-4">When you change <code class="code-inline">APP_NAME</code></h4>

<?= dataTable(
    ['Location', 'What Changes'],
    [
        ['<strong>Views</strong>', '<code class="code-inline">&lt;title&gt;</code>, <code class="code-inline">&lt;h1&gt;</code>, all references'],
        ['<strong>API</strong>', 'Response metadata'],
        ['<strong>Logs</strong>', 'Application name in logs'],
        ['<strong>Config</strong>', '<code class="code-inline">config(\'app.name\')</code> everywhere'],
    ]
) ?>

<h4 class="heading heading-4 mt-4">When you change <code class="code-inline">DB_DATABASE</code></h4>

<?= dataTable(
    ['Location', 'What Changes'],
    [
        ['<strong>Generated SQL</strong>', '<code class="code-inline">CREATE DATABASE mydb</code>'],
        ['<strong>Connections</strong>', 'All database connections'],
        ['<strong>Models</strong>', 'All model queries'],
    ]
) ?>

<!-- Examples -->
<h2 id="examples" class="heading heading-2">
    <span class="mdi mdi-code-tags heading-icon"></span>
    <span class="heading-text">Examples</span>
</h2>

<h4 class="heading heading-4">Change to "My Awesome API"</h4>

<?= codeBlock('bash', '# Edit .env
APP_NAME="My Awesome API"
DB_DATABASE=awesome-api

# Regenerate SQL
php database/migrations/generate-setup.php

# Import
mysql -u root -p < database/migrations/setup.sql') ?>

<p class="mt-3"><strong>Result:</strong></p>
<ul class="list list-check">
    <li>Pages show "My Awesome API"</li>
    <li>Database named <code class="code-inline">awesome-api</code></li>
    <li>Everything connected!</li>
</ul>

<h4 class="heading heading-4 mt-4">Use in Your Code</h4>

<?= codeTabs([
    ['label' => 'PHP', 'lang' => 'php', 'code' => '// Automatically gets "My Awesome API"
$name = config(\'app.name\');'],
    ['label' => 'Views', 'lang' => 'php', 'code' => '<title><?= config(\'app.name\') ?></title>'],
    ['label' => 'Controller', 'lang' => 'php', 'code' => 'return Response::view(\'home\', [
    \'appName\' => config(\'app.name\')
]);'],
]) ?>

<!-- Test Your Changes -->
<h2 id="test-changes" class="heading heading-2">
    <span class="mdi mdi-test-tube heading-icon"></span>
    <span class="heading-text">Test Your Changes</span>
</h2>

<?= codeBlock('bash', '# Test homepage
curl http://localhost:8000

# Test API
curl http://localhost:8000/api/test

# Check database
mysql -u root -p -e "SHOW DATABASES LIKE \'your-database-name\';"') ?>

<?= callout('success', 'For complete documentation, see the <a href="/docs/configuration" class="link">Configuration Guide</a>.', 'More Details') ?>

<?php include __DIR__ . '/../_layout-end.php'; ?>
