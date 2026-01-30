<?php
/**
 * Setup Guide Documentation Page
 *
 * Installation and configuration guide.
 */

$pageTitle = 'Setup Guide';
$pageIcon = 'cog';
$toc = [
    ['id' => 'quick-start', 'title' => 'Quick Start', 'level' => 2],
    ['id' => 'configure-environment', 'title' => 'Configure Environment', 'level' => 3],
    ['id' => 'create-database', 'title' => 'Create Database', 'level' => 3],
    ['id' => 'import-schema', 'title' => 'Import Schema', 'level' => 3],
    ['id' => 'test-framework', 'title' => 'Test Framework', 'level' => 3],
    ['id' => 'api-endpoints', 'title' => 'Testing API Endpoints', 'level' => 2],
    ['id' => 'framework-structure', 'title' => 'Framework Structure', 'level' => 2],
    ['id' => 'creating-models', 'title' => 'Creating Models', 'level' => 3],
    ['id' => 'creating-controllers', 'title' => 'Creating Controllers', 'level' => 3],
    ['id' => 'defining-routes', 'title' => 'Defining Routes', 'level' => 3],
    ['id' => 'security', 'title' => 'Security Features', 'level' => 2],
    ['id' => 'troubleshooting', 'title' => 'Troubleshooting', 'level' => 2],
];
$prevPage = ['url' => '/docs/readme', 'title' => 'README'];
$nextPage = ['url' => '/docs/quick-start', 'title' => 'Quick Start'];
$breadcrumbs = [['label' => 'Setup Guide']];
$lastUpdated = '2026-01-30';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="setup-guide" class="heading heading-1">
    <span class="mdi mdi-cog heading-icon"></span>
    <span class="heading-text">Setup Guide</span>
</h1>

<p class="text-lead">
    Get the SO Framework up and running in your development environment.
</p>

<!-- Quick Start Section -->
<h2 id="quick-start" class="heading heading-2">
    <span class="mdi mdi-rocket-launch heading-icon"></span>
    <span class="heading-text">Quick Start</span>
</h2>

<h3 id="configure-environment" class="heading heading-3">
    <span class="heading-text">1. Configure Environment</span>
</h3>

<p>Edit the <code class="code-inline">.env</code> file with your database credentials:</p>

<?= codeBlock('bash', 'DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password', '.env') ?>

<h3 id="create-database" class="heading heading-3">
    <span class="heading-text">2. Create Database</span>
</h3>

<p>Create your database with UTF-8 support:</p>

<?= codeBlock('bash', 'mysql -u root -p
CREATE DATABASE framework CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;') ?>

<h3 id="import-schema" class="heading heading-3">
    <span class="heading-text">3. Import Database Schema</span>
</h3>

<p>Import the sample schema:</p>

<?= codeBlock('bash', 'mysql -u root -p framework < database/migrations/setup.sql') ?>

<h3 id="test-framework" class="heading heading-3">
    <span class="heading-text">4. Test the Framework</span>
</h3>

<?= tabs([
    [
        'label' => 'PHP Built-in Server',
        'content' => '<p>Start the development server:</p>' .
            codeBlock('bash', 'php -S localhost:8000 -t public') .
            '<p class="mt-3">Then visit:</p>
            <ul class="list">
                <li>Homepage: <a href="http://localhost:8000" class="link">http://localhost:8000</a></li>
                <li>API Test: <a href="http://localhost:8000/api/test" class="link">http://localhost:8000/api/test</a></li>
                <li>User by ID: <a href="http://localhost:8000/users/1" class="link">http://localhost:8000/users/1</a></li>
            </ul>'
    ],
    [
        'label' => 'Apache/Nginx',
        'content' => '<p>Configure your web server to point to the <code class="code-inline">public</code> directory as the document root.</p>
            <p>Example Apache VirtualHost:</p>' .
            codeBlock('apache', '<VirtualHost *:80>
    DocumentRoot /var/www/html/so-backend-framework/public
    ServerName framework.local

    <Directory /var/www/html/so-backend-framework/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>')
    ]
], 'server-options') ?>

<!-- Testing API Endpoints -->
<h2 id="api-endpoints" class="heading heading-2">
    <span class="mdi mdi-api heading-icon"></span>
    <span class="heading-text">Testing API Endpoints</span>
</h2>

<?= apiEndpointGroup('User API', [
    ['method' => 'GET', 'path' => '/api/v1/users', 'description' => 'Get all users'],
    ['method' => 'GET', 'path' => '/api/v1/users/{id}', 'description' => 'Get single user by ID'],
    ['method' => 'POST', 'path' => '/api/v1/users', 'description' => 'Create new user'],
    ['method' => 'PUT', 'path' => '/api/v1/users/{id}', 'description' => 'Update existing user'],
    ['method' => 'DELETE', 'path' => '/api/v1/users/{id}', 'description' => 'Delete user'],
]) ?>

<h4 class="heading heading-4 mt-4">Example Requests</h4>

<?= codeTabs([
    ['label' => 'Get All', 'lang' => 'bash', 'code' => 'curl http://localhost:8000/api/v1/users'],
    ['label' => 'Get One', 'lang' => 'bash', 'code' => 'curl http://localhost:8000/api/v1/users/1'],
    ['label' => 'Create', 'lang' => 'bash', 'code' => 'curl -X POST http://localhost:8000/api/v1/users \
  -H "Content-Type: application/json" \
  -d \'{
    "name": "Test User",
    "email": "test@example.com",
    "password": "securepassword123"
  }\''],
    ['label' => 'Update', 'lang' => 'bash', 'code' => 'curl -X PUT http://localhost:8000/api/v1/users/1 \
  -H "Content-Type: application/json" \
  -d \'{"name": "Updated Name"}\''],
]) ?>

<!-- Framework Structure -->
<h2 id="framework-structure" class="heading heading-2">
    <span class="mdi mdi-folder-outline heading-icon"></span>
    <span class="heading-text">Framework Structure</span>
</h2>

<?= featureGrid([
    ['icon' => 'application-cog', 'title' => 'Application.php', 'description' => 'DI container and application lifecycle'],
    ['icon' => 'routes', 'title' => 'Router', 'description' => 'Laravel-style routing with groups and middleware'],
    ['icon' => 'database', 'title' => 'QueryBuilder', 'description' => 'Fluent query builder with prepared statements'],
    ['icon' => 'cube-outline', 'title' => 'Model', 'description' => 'Active Record ORM with relationships'],
    ['icon' => 'swap-horizontal', 'title' => 'Request/Response', 'description' => 'HTTP abstractions'],
    ['icon' => 'account-key', 'title' => 'Session', 'description' => 'Session management'],
], 3) ?>

<h3 id="creating-models" class="heading heading-3">
    <span class="heading-text">Creating a New Model</span>
</h3>

<?= codeBlockWithFile('php', '<?php

namespace App\Models;

use Core\Model\Model;

class Product extends Model
{
    protected static string $table = \'products\';

    protected array $fillable = [
        \'name\',
        \'price\',
        \'description\',
    ];

    // Mutator - automatically round price
    protected function setPriceAttribute(float $value): void
    {
        $this->attributes[\'price\'] = round($value, 2);
    }

    // Accessor - format name
    protected function getNameAttribute(?string $value): string
    {
        return $value ? strtoupper($value) : \'\';
    }
}', 'app/Models/Product.php') ?>

<h3 id="creating-controllers" class="heading heading-3">
    <span class="heading-text">Creating a New Controller</span>
</h3>

<?= codeBlockWithFile('php', '<?php

namespace App\Controllers\Api\V1;

use Core\Http\Request;
use Core\Http\JsonResponse;
use App\Models\Product;

class ProductController
{
    public function index(Request $request): JsonResponse
    {
        $products = Product::all();
        return JsonResponse::success([
            \'products\' => array_map(fn($p) => $p->toArray(), $products)
        ]);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return JsonResponse::error(\'Product not found\', 404);
        }

        return JsonResponse::success($product->toArray());
    }
}', 'app/Controllers/Api/V1/ProductController.php') ?>

<h3 id="defining-routes" class="heading heading-3">
    <span class="heading-text">Defining Routes</span>
</h3>

<?= codeBlockWithFile('php', '<?php

use Core\Routing\Router;
use App\Controllers\Api\V1\ProductController;

// Basic routes
Router::get(\'/products\', [ProductController::class, \'index\']);
Router::get(\'/products/{id}\', [ProductController::class, \'show\']);

// Route groups
Router::group([\'prefix\' => \'api/v1\'], function () {
    Router::get(\'/products\', [ProductController::class, \'index\']);
    Router::post(\'/products\', [ProductController::class, \'store\']);
});

// RESTful resource (creates all 7 routes)
Router::resource(\'products\', ProductController::class);', 'routes/web.php') ?>

<!-- Security Features -->
<h2 id="security" class="heading heading-2">
    <span class="mdi mdi-shield-lock heading-icon"></span>
    <span class="heading-text">Security Features</span>
</h2>

<div class="grid grid-3 gap-3">
    <div>
        <h4 class="heading heading-4">SQL Injection Prevention</h4>
        <p class="text-muted">All queries use prepared statements automatically.</p>
        <?= codeBlock('php', '// Safe - uses prepared statements
User::where(\'email\', \'=\', $email)->first();

// Query builder also safe
app(\'db\')->table(\'users\')
    ->where(\'email\', \'=\', $email)
    ->first();') ?>
    </div>
    <div>
        <h4 class="heading heading-4">Password Hashing</h4>
        <p class="text-muted">Argon2ID hashing in User model.</p>
        <?= codeBlock('php', 'protected function setPasswordAttribute(string $value): void
{
    $this->attributes[\'password\'] = password_hash(
        $value,
        PASSWORD_ARGON2ID
    );
}') ?>
    </div>
    <div>
        <h4 class="heading heading-4">XSS Prevention</h4>
        <p class="text-muted">Always escape output in views.</p>
        <?= codeBlock('php', '<!-- Using helper -->
<h1><?= e($title) ?></h1>

<!-- Or htmlspecialchars -->
<p><?= htmlspecialchars($content, ENT_QUOTES, \'UTF-8\') ?></p>') ?>
    </div>
</div>

<!-- Troubleshooting -->
<h2 id="troubleshooting" class="heading heading-2">
    <span class="mdi mdi-wrench heading-icon"></span>
    <span class="heading-text">Troubleshooting</span>
</h2>

<div class="space-y-3">
    <?= callout('danger', '
        <strong>Database Connection Errors</strong>
        <ol class="list mt-2">
            <li>Check your <code class="code-inline">.env</code> file has correct credentials</li>
            <li>Ensure the database exists</li>
            <li>Verify MySQL/MariaDB is running: <code class="code-inline">sudo systemctl status mysql</code></li>
        </ol>
    ', null, 'database-off') ?>

    <?= callout('warning', '
        <strong>404 Errors</strong>
        <ol class="list mt-2">
            <li>Enable Apache mod_rewrite: <code class="code-inline">sudo a2enmod rewrite && sudo systemctl restart apache2</code></li>
            <li>Check <code class="code-inline">.htaccess</code> exists in the <code class="code-inline">public</code> directory</li>
        </ol>
    ', null, 'file-find') ?>

    <?= callout('info', '
        <strong>Permission Errors</strong>
        <pre class="code-block mt-2"><code>chmod -R 755 /var/www/html/so-backend-framework
chmod -R 775 storage</code></pre>
    ', null, 'lock-open') ?>
</div>

<?php include __DIR__ . '/../_layout-end.php'; ?>
