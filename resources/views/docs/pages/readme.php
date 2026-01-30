<?php
/**
 * README Documentation Page
 *
 * Framework overview and quick start guide.
 */

$pageTitle = 'SO Framework';
$pageIcon = 'rocket-launch';
$toc = [
    ['id' => 'features', 'title' => 'Features', 'level' => 2],
    ['id' => 'requirements', 'title' => 'Requirements', 'level' => 2],
    ['id' => 'quick-install', 'title' => 'Quick Install', 'level' => 2],
    ['id' => 'architecture', 'title' => 'Architecture', 'level' => 2],
    ['id' => 'configuration', 'title' => 'Configuration', 'level' => 2],
    ['id' => 'directory-structure', 'title' => 'Directory Structure', 'level' => 2],
    ['id' => 'usage-examples', 'title' => 'Usage Examples', 'level' => 2],
    ['id' => 'security', 'title' => 'Security', 'level' => 2],
    ['id' => 'documentation', 'title' => 'Documentation', 'level' => 2],
];
$prevPage = null;
$nextPage = ['url' => '/docs/setup', 'title' => 'Setup Guide'];
$breadcrumbs = [['label' => 'README']];
$lastUpdated = '2026-01-30';

include __DIR__ . '/../_layout.php';
?>

<!-- Hero Section -->
<h1 id="so-framework" class="heading heading-1">
    <span class="mdi mdi-rocket-launch heading-icon"></span>
    <span class="heading-text">SO Framework</span>
</h1>

<p class="text-lead">
    A production-ready PHP framework with Laravel-style routing, comprehensive security features, and an API-first architecture.
</p>

<?= callout('info', 'See the <a href="/docs/index" class="link">Documentation Index</a> for complete navigation.', 'Full Documentation') ?>

<!-- Features Section -->
<h2 id="features" class="heading heading-2">
    <span class="mdi mdi-star heading-icon"></span>
    <span class="heading-text">Features</span>
</h2>

<?= featureGrid([
    ['icon' => 'routes', 'title' => 'Advanced Routing', 'description' => 'Laravel-style routing with groups, named routes, middleware support'],
    ['icon' => 'view-dashboard', 'title' => 'MVC Architecture', 'description' => 'Clean separation of Models, Views, Controllers'],
    ['icon' => 'api', 'title' => 'API-First Design', 'description' => 'Unified internal API layer for web, mobile, cron, and external APIs'],
    ['icon' => 'shield-lock', 'title' => 'Security', 'description' => 'CSRF, XSS prevention, SQL injection prevention, JWT auth, rate limiting'],
    ['icon' => 'database', 'title' => 'Database Layer', 'description' => 'Query builder with prepared statements, migrations, relationships'],
    ['icon' => 'filter', 'title' => 'Middleware System', 'description' => 'Flexible middleware pipeline for request processing'],
    ['icon' => 'key', 'title' => 'Session Management', 'description' => 'Multiple drivers (file, database, Redis)'],
    ['icon' => 'check-decagram', 'title' => 'Validation', 'description' => 'Comprehensive input validation system'],
    ['icon' => 'needle', 'title' => 'Dependency Injection', 'description' => 'Auto-resolving DI container'],
    ['icon' => 'language-php', 'title' => 'Modern PHP', 'description' => 'Built for PHP 8.3+ with typed properties and modern features'],
    ['icon' => 'cog', 'title' => 'Configurable', 'description' => 'Change framework name in one place, affects everywhere'],
]) ?>

<!-- Requirements Section -->
<h2 id="requirements" class="heading heading-2">
    <span class="mdi mdi-clipboard-check heading-icon"></span>
    <span class="heading-text">Requirements</span>
</h2>

<?= dataTable(['Requirement', 'Version'], [
    ['PHP', '8.3 or higher'],
    ['MySQL', '8.0+ or PostgreSQL 14+'],
    ['Composer', 'Latest'],
    ['Extensions', 'PDO, JSON, mbstring, OpenSSL'],
]) ?>

<!-- Quick Install Section -->
<h2 id="quick-install" class="heading heading-2">
    <span class="mdi mdi-download heading-icon"></span>
    <span class="heading-text">Quick Install</span>
</h2>

<?= codeBlock('bash', '# 1. Install dependencies
composer install

# 2. Configure
cp .env.example .env
nano .env  # Set your database credentials

# 3. Setup database
mysql -u root -p < database/migrations/setup.sql

# 4. Test
php -S localhost:8000 -t public
curl http://localhost:8000/api/test') ?>

<?= callout('tip', 'See the <a href="/docs/setup" class="link">Setup Guide</a> for detailed installation instructions.', 'Detailed Instructions') ?>

<!-- Architecture Section -->
<h2 id="architecture" class="heading heading-2">
    <span class="mdi mdi-sitemap heading-icon"></span>
    <span class="heading-text">Architecture</span>
</h2>

<h3 class="heading heading-3">
    <span class="mdi mdi-api heading-icon"></span>
    <span class="heading-text">API-First Design</span>
</h3>

<p class="paragraph">All interfaces route through a unified internal API layer:</p>

<div class="code-container">
    <div class="code-header">
        <span class="code-lang">ARCHITECTURE</span>
    </div>
    <pre class="code-block"><code>Web Interface (Session Auth) --+
Mobile Apps (JWT Auth) --------+--> Internal API Layer --> Services --> Models --> Database
Cron Jobs (Signature Auth) ----+
External APIs (API Key+JWT) ---+</code></pre>
</div>

<p class="paragraph">Each interface has distinct permissions, rate limits, and guardrails enforced at the internal API layer.</p>

<!-- Configuration Section -->
<h2 id="configuration" class="heading heading-2">
    <span class="mdi mdi-cog heading-icon"></span>
    <span class="heading-text">Configuration</span>
</h2>

<p class="paragraph"><strong>Change framework name in ONE place:</strong></p>

<?= codeBlock('bash', '# Edit .env
APP_NAME="Your Framework Name"
DB_DATABASE=your-database

# Regenerate SQL
php database/migrations/generate-setup.php') ?>

<div class="flex gap-2 flex-wrap mt-2">
    <a href="/docs/configuration" class="feature-card" style="text-decoration: none; flex: 1; min-width: 200px;">
        <div class="feature-card-header">
            <div class="feature-card-icon"><span class="mdi mdi-wrench"></span></div>
            <div class="feature-card-title">Configuration Guide</div>
        </div>
        <div class="feature-card-description">Complete configuration reference</div>
    </a>
    <a href="/docs/quick-start" class="feature-card" style="text-decoration: none; flex: 1; min-width: 200px;">
        <div class="feature-card-header">
            <div class="feature-card-icon"><span class="mdi mdi-flash"></span></div>
            <div class="feature-card-title">Quick Start</div>
        </div>
        <div class="feature-card-description">Fast reference guide</div>
    </a>
</div>

<!-- Directory Structure Section -->
<h2 id="directory-structure" class="heading heading-2">
    <span class="mdi mdi-folder-multiple heading-icon"></span>
    <span class="heading-text">Directory Structure</span>
</h2>

<?= codeBlock('text', '├── app/                 # Application code
│   ├── Controllers/     # HTTP controllers
│   ├── Models/          # Database models
│   ├── Middleware/      # Application middleware
│   └── Services/        # Business logic
├── core/                # Framework core
│   ├── Database/        # Query builder, connections
│   ├── Http/            # Request, Response, Session
│   ├── Routing/         # Router implementation
│   └── Security/        # CSRF, JWT, hashing
├── config/              # Configuration files
├── routes/              # Route definitions
├── public/              # Web root
├── docs/                # Complete documentation
└── storage/             # Logs, cache, sessions') ?>

<?= callout('info', 'See <a href="/docs/project-structure" class="link">Project Structure</a> for detailed explanation of each folder and file.') ?>

<!-- Usage Examples Section -->
<h2 id="usage-examples" class="heading heading-2">
    <span class="mdi mdi-code-braces heading-icon"></span>
    <span class="heading-text">Usage Examples</span>
</h2>

<h3 class="heading heading-3">
    <span class="mdi mdi-routes heading-icon"></span>
    <span class="heading-text">Defining Routes</span>
</h3>

<?= codeBlockWithFile('php', "<?php
// routes/web.php
use Core\Routing\Router;

Router::get('/', [HomeController::class, 'index']);
Router::get('/users/{id}', [UserController::class, 'show']);

Router::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Router::get('/dashboard', [AdminController::class, 'dashboard']);
});", 'routes/web.php') ?>

<h3 class="heading heading-3">
    <span class="mdi mdi-database heading-icon"></span>
    <span class="heading-text">Creating Models</span>
</h3>

<?= codeBlockWithFile('php', "<?php
namespace App\Models;

use Core\Model\Model;

class User extends Model
{
    protected static string \$table = 'users';
    protected array \$fillable = ['name', 'email', 'password'];

    public function posts()
    {
        return \$this->hasMany(Post::class);
    }
}", 'app/Models/User.php') ?>

<h3 class="heading heading-3">
    <span class="mdi mdi-cog heading-icon"></span>
    <span class="heading-text">Building Controllers</span>
</h3>

<?= codeBlockWithFile('php', "<?php
namespace App\Controllers\Api\V1;

use Core\Http\Request;
use Core\Http\JsonResponse;

class UserController
{
    public function index(Request \$request): JsonResponse
    {
        \$users = User::all();
        return JsonResponse::success(\$users);
    }
}", 'app/Controllers/Api/V1/UserController.php') ?>

<!-- Security Section -->
<h2 id="security" class="heading heading-2">
    <span class="mdi mdi-shield-lock heading-icon"></span>
    <span class="heading-text">Security</span>
</h2>

<p class="paragraph">The framework includes comprehensive security features:</p>

<?= featureList([
    ['icon' => 'shield-check', 'title' => 'CSRF Protection', 'description' => 'Token-based protection for state-changing requests'],
    ['icon' => 'shield-alert', 'title' => 'XSS Prevention', 'description' => 'Automatic output escaping'],
    ['icon' => 'database-lock', 'title' => 'SQL Injection Prevention', 'description' => 'All queries use prepared statements'],
    ['icon' => 'lock', 'title' => 'Password Hashing', 'description' => 'Argon2ID with configurable rounds'],
    ['icon' => 'speedometer', 'title' => 'Rate Limiting', 'description' => 'Per-route and per-user limiting'],
    ['icon' => 'key', 'title' => 'JWT Authentication', 'description' => 'For API endpoints'],
    ['icon' => 'cookie', 'title' => 'Session Security', 'description' => 'HTTPOnly, Secure, SameSite cookies'],
]) ?>

<?= callout('tip', 'See <a href="/docs/security-layer" class="link">Security Layer</a> for detailed security documentation.') ?>

<!-- Documentation Section -->
<h2 id="documentation" class="heading heading-2">
    <span class="mdi mdi-book-open-variant heading-icon"></span>
    <span class="heading-text">Documentation</span>
</h2>

<?= dataTable(['Document', 'Description'], [
    ['<a href="/docs/index" class="link">Documentation Index</a>', 'Complete documentation navigation'],
    ['<a href="/docs/setup" class="link">Setup Guide</a>', 'Installation and setup guide'],
    ['<a href="/docs/configuration" class="link">Configuration</a>', 'Configuration system guide'],
    ['<a href="/docs/quick-start" class="link">Quick Start</a>', 'Fast reference guide'],
    ['<a href="/docs/security-layer" class="link">Security Layer</a>', 'Security documentation'],
    ['<a href="/docs/routing-system" class="link">Routing System</a>', 'Routing documentation'],
    ['<a href="/docs/project-structure" class="link">Project Structure</a>', 'Folder and file reference'],
]) ?>

<div class="callout callout-success mt-3">
    <span class="mdi mdi-rocket-launch callout-icon"></span>
    <div class="callout-content">
        <div class="callout-title">Ready to Start?</div>
        <div class="callout-text">
            Head to the <a href="/docs/setup" class="link">Setup Guide</a> to begin building with SO Framework.
        </div>
    </div>
</div>

<?php include __DIR__ . '/../_layout-end.php'; ?>
