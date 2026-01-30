<?php
/**
 * Project Structure Documentation Page
 *
 * Detailed explanation of framework folder and file organization.
 */

$pageTitle = 'Project Structure';
$pageIcon = 'folder-multiple';
$toc = [
    ['id' => 'root-directory', 'title' => 'Root Directory', 'level' => 2],
    ['id' => 'app-directory', 'title' => 'app/ - Application Code', 'level' => 2],
    ['id' => 'core-directory', 'title' => 'core/ - Framework Core', 'level' => 2],
    ['id' => 'config-directory', 'title' => 'config/ - Configuration', 'level' => 2],
    ['id' => 'routes-directory', 'title' => 'routes/ - Route Definitions', 'level' => 2],
    ['id' => 'resources-directory', 'title' => 'resources/ - Views & Assets', 'level' => 2],
    ['id' => 'public-directory', 'title' => 'public/ - Web Root', 'level' => 2],
    ['id' => 'storage-directory', 'title' => 'storage/ - File Storage', 'level' => 2],
    ['id' => 'quick-reference', 'title' => 'Quick Reference', 'level' => 2],
    ['id' => 'naming-conventions', 'title' => 'Naming Conventions', 'level' => 2],
];
$prevPage = ['url' => '/docs/quick-start', 'title' => 'Quick Start'];
$nextPage = ['url' => '/docs/routing-system', 'title' => 'Routing System'];
$breadcrumbs = [['label' => 'Project Structure']];
$lastUpdated = '2026-01-30';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="project-structure" class="heading heading-1">
    <span class="mdi mdi-folder-multiple heading-icon"></span>
    <span class="heading-text">Project Structure</span>
</h1>

<p class="text-lead">
    A detailed explanation of every folder and file in the SO Framework, helping developers understand the codebase organization.
</p>

<!-- Root Directory -->
<h2 id="root-directory" class="heading heading-2">
    <span class="mdi mdi-folder heading-icon"></span>
    <span class="heading-text">Root Directory</span>
</h2>

<?= codeBlock('text', 'so-backend-framework/
├── .env                    # Environment configuration
├── .env.example            # Example environment file
├── .gitignore              # Git ignore rules
├── .htaccess               # Apache URL rewriting
├── composer.json           # PHP dependencies
├── composer.lock           # Locked dependency versions
├── sixorbit                # CLI tool
├── sixorbit.local.conf     # Apache virtual host config
├── rename-framework.sh     # Framework rename script
└── debug-login.php         # Debug tool') ?>

<h4 class="heading heading-4 mt-4">Key Root Files</h4>

<?= dataTable(
    ['File', 'Purpose'],
    [
        [filePath('.env'), 'Contains all environment-specific settings (database, app URL, secrets). <span class="badge badge-danger">Never commit</span>'],
        [filePath('.env.example'), 'Template showing required environment variables. <span class="badge badge-success">Commit this</span>'],
        [filePath('composer.json'), 'Defines PHP dependencies and PSR-4 autoloading namespaces.'],
        [filePath('sixorbit', 'bash'), 'CLI entry point. Run <code class="code-inline">php sixorbit &lt;command&gt;</code> for console commands.'],
        [filePath('rename-framework.sh', 'bash'), 'Bash script to rename "SO Framework" to your custom name.'],
    ]
) ?>

<!-- App Directory -->
<h2 id="app-directory" class="heading heading-2">
    <span class="mdi mdi-application heading-icon"></span>
    <span class="heading-text">app/ - Application Code</span>
</h2>

<p>Your application code lives here. This is where you write controllers, models, middleware, and other business logic.</p>

<?= codeBlock('text', 'app/
├── Controllers/            # HTTP request handlers
│   ├── Api/V1/
│   │   └── UserController.php
│   ├── AuthController.php
│   ├── DashboardController.php
│   ├── DocsController.php
│   └── PasswordController.php
│
├── Jobs/                   # Background job classes
│   └── TestJob.php
│
├── Middleware/             # HTTP middleware
│   ├── AuthMiddleware.php
│   ├── CorsMiddleware.php
│   ├── CsrfMiddleware.php
│   ├── GuestMiddleware.php
│   ├── JwtMiddleware.php
│   ├── LogRequestMiddleware.php
│   └── ThrottleMiddleware.php
│
├── Models/                 # Database models
│   └── User.php
│
├── Notifications/          # Notification classes
│   ├── OrderApprovalNotification.php
│   └── WelcomeNotification.php
│
└── Providers/              # Service providers
    ├── ActivityLogServiceProvider.php
    ├── CacheServiceProvider.php
    ├── NotificationServiceProvider.php
    ├── QueueServiceProvider.php
    └── SessionServiceProvider.php') ?>

<h4 class="heading heading-4 mt-4">Controllers</h4>

<p>Controllers handle HTTP requests and return responses. They should be thin - delegate business logic to services or models.</p>

<?= codeBlockWithFile('php', 'class UserController
{
    public function index(Request $request): Response
    {
        $users = User::all();
        return Response::view(\'users/index\', [\'users\' => $users]);
    }
}', 'app/Controllers/UserController.php') ?>

<h4 class="heading heading-4 mt-4">Models</h4>

<p>Models represent database tables and handle data operations.</p>

<?= codeBlockWithFile('php', 'class User extends Model
{
    protected string $table = \'users\';
    protected array $fillable = [\'name\', \'email\', \'password\'];
    protected array $hidden = [\'password\'];
}', 'app/Models/User.php') ?>

<h4 class="heading heading-4 mt-4">Middleware</h4>

<p>Middleware filters HTTP requests before they reach controllers.</p>

<?= codeBlockWithFile('php', 'class AuthMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        if (!auth()->check()) {
            return redirect(\'/login\');
        }
        return $next($request);
    }
}', 'app/Middleware/AuthMiddleware.php') ?>

<!-- Core Directory -->
<h2 id="core-directory" class="heading heading-2">
    <span class="mdi mdi-cogs heading-icon"></span>
    <span class="heading-text">core/ - Framework Core</span>
</h2>

<p>The framework's internal components. You typically don't modify these files unless extending the framework.</p>

<?= featureGrid([
    ['icon' => 'application-cog', 'title' => 'Application.php', 'description' => 'Main app class, boots the framework'],
    ['icon' => 'routes', 'title' => 'Routing/', 'description' => 'Router and Route classes'],
    ['icon' => 'swap-horizontal', 'title' => 'Http/', 'description' => 'Request, Response, Session'],
    ['icon' => 'database', 'title' => 'Database/', 'description' => 'Connection and QueryBuilder'],
    ['icon' => 'cube-outline', 'title' => 'Model/', 'description' => 'Base model and traits'],
    ['icon' => 'shield-lock', 'title' => 'Security/', 'description' => 'CSRF, JWT, Rate limiting'],
    ['icon' => 'check-decagram', 'title' => 'Validation/', 'description' => 'Validator with 27+ rules'],
    ['icon' => 'console', 'title' => 'Console/', 'description' => 'CLI commands system'],
], 4) ?>

<h4 class="heading heading-4 mt-4">Key Core Classes</h4>

<?= dataTable(
    ['Class', 'Purpose'],
    [
        ['<code class="code-inline">Application.php</code>', 'Main app class, boots the framework, manages services'],
        ['<code class="code-inline">Router.php</code>', 'Matches URLs to controllers, handles groups/middleware'],
        ['<code class="code-inline">Request.php</code>', 'Wraps $_GET, $_POST, $_FILES, headers'],
        ['<code class="code-inline">Response.php</code>', 'Builds HTTP responses (HTML, JSON, redirects)'],
        ['<code class="code-inline">Model.php</code>', 'Active Record ORM base class'],
        ['<code class="code-inline">QueryBuilder.php</code>', 'Fluent SQL query building'],
        ['<code class="code-inline">Validator.php</code>', 'Data validation with 27+ built-in rules'],
        ['<code class="code-inline">Auth.php</code>', 'Authentication (login, logout, check, user)'],
    ]
) ?>

<!-- Config Directory -->
<h2 id="config-directory" class="heading heading-2">
    <span class="mdi mdi-cog heading-icon"></span>
    <span class="heading-text">config/ - Configuration Files</span>
</h2>

<p>Application configuration. Values can be overridden by environment variables.</p>

<?= codeBlock('text', 'config/
├── activity.php            # Activity logging settings
├── api.php                 # API configuration
├── app.php                 # Application settings
├── cache.php               # Cache driver settings
├── database.php            # Database connection
├── notifications.php       # Notification settings
├── queue.php               # Queue driver settings
├── security.php            # Security settings
└── session.php             # Session configuration') ?>

<h4 class="heading heading-4 mt-4">Accessing Configuration</h4>

<?= codeBlock('php', '// Get single value
$appName = config(\'app.name\');

// Get with default
$debug = config(\'app.debug\', false);

// Get entire file
$dbConfig = config(\'database\');') ?>

<!-- Routes Directory -->
<h2 id="routes-directory" class="heading heading-2">
    <span class="mdi mdi-routes heading-icon"></span>
    <span class="heading-text">routes/ - Route Definitions</span>
</h2>

<?= codeBlock('text', 'routes/
├── web.php                 # Main web routes loader
├── api.php                 # Main API routes loader
├── web/                    # Web route modules
│   ├── auth.php            # Authentication routes
│   ├── dashboard.php       # Dashboard routes
│   └── docs.php            # Documentation routes
└── api/                    # API route modules
    ├── users.php           # User API endpoints
    ├── products.php        # Product API
    └── orders.php          # Order API') ?>

<?= callout('info', 'The main files (<code class="code-inline">web.php</code>, <code class="code-inline">api.php</code>) load modular route files for better organization.') ?>

<!-- Resources Directory -->
<h2 id="resources-directory" class="heading heading-2">
    <span class="mdi mdi-palette heading-icon"></span>
    <span class="heading-text">resources/ - Views & Assets</span>
</h2>

<?= codeBlock('text', 'resources/
└── views/                  # PHP view templates
    ├── auth/               # Authentication views
    │   ├── login.php
    │   ├── register.php
    │   ├── forgot.php
    │   └── reset.php
    ├── dashboard/          # Dashboard views
    │   ├── index.php
    │   ├── create.php
    │   └── edit.php
    ├── docs/               # Documentation views
    │   ├── index.php
    │   ├── show.php
    │   └── pages/          # Converted doc pages
    └── welcome.php         # Home page') ?>

<h4 class="heading heading-4 mt-4">View Rendering</h4>

<?= codeTabs([
    ['label' => 'Controller', 'lang' => 'php', 'code' => 'return Response::view(\'dashboard/index\', [
    \'users\' => $users,
    \'title\' => \'Dashboard\'
]);'],
    ['label' => 'View', 'lang' => 'php', 'code' => '<h1><?= e($title) ?></h1>
<?php foreach ($users as $user): ?>
    <p><?= e($user->name) ?></p>
<?php endforeach; ?>'],
]) ?>

<!-- Public Directory -->
<h2 id="public-directory" class="heading heading-2">
    <span class="mdi mdi-web heading-icon"></span>
    <span class="heading-text">public/ - Web Root</span>
</h2>

<p>The web server's document root. <strong>Only this folder is publicly accessible.</strong></p>

<?= codeBlock('text', 'public/
├── index.php               # Application entry point
├── .htaccess               # Apache rewrite rules
└── assets/                 # Static assets (CSS, JS, images)') ?>

<?= callout('warning', 'Never place sensitive files in the <code class="code-inline">public/</code> directory. It is directly accessible via web browser.') ?>

<!-- Storage Directory -->
<h2 id="storage-directory" class="heading heading-2">
    <span class="mdi mdi-folder-lock heading-icon"></span>
    <span class="heading-text">storage/ - File Storage</span>
</h2>

<p>Application-generated files. <strong>Must be writable by web server.</strong></p>

<?= codeBlock('text', 'storage/
├── cache/                  # Cache files
├── framework/              # Framework-generated files
│   ├── views/              # Compiled views
│   └── sessions/           # Session files
├── logs/                   # Application logs
│   └── app.log
└── sessions/               # Session files') ?>

<?= codeBlock('bash', '# Fix permissions
chmod -R 775 storage/
chown -R www-data:www-data storage/', 'Storage Permissions') ?>

<!-- Quick Reference -->
<h2 id="quick-reference" class="heading heading-2">
    <span class="mdi mdi-lightning-bolt heading-icon"></span>
    <span class="heading-text">Quick Reference: Where to Add What</span>
</h2>

<?= dataTable(
    ['What you\'re adding', 'Where to put it'],
    [
        ['New controller', filePath('app/Controllers/')],
        ['New model', filePath('app/Models/')],
        ['New middleware', filePath('app/Middleware/')],
        ['New service provider', filePath('app/Providers/')],
        ['New job', filePath('app/Jobs/')],
        ['New notification', filePath('app/Notifications/')],
        ['New route file', filePath('routes/web/') . ' or ' . filePath('routes/api/')],
        ['New view', filePath('resources/views/')],
        ['New config file', filePath('config/')],
        ['New console command', filePath('core/Console/Commands/')],
        ['New migration', filePath('database/migrations/')],
        ['Static assets', filePath('public/assets/')],
    ]
) ?>

<!-- Naming Conventions -->
<h2 id="naming-conventions" class="heading heading-2">
    <span class="mdi mdi-format-letter-case heading-icon"></span>
    <span class="heading-text">Naming Conventions</span>
</h2>

<?= dataTable(
    ['Type', 'Convention', 'Example'],
    [
        ['Controllers', 'PascalCase + Controller', '<code class="code-inline">UserController.php</code>'],
        ['Models', 'PascalCase (singular)', '<code class="code-inline">User.php</code>'],
        ['Middleware', 'PascalCase + Middleware', '<code class="code-inline">AuthMiddleware.php</code>'],
        ['Providers', 'PascalCase + ServiceProvider', '<code class="code-inline">CacheServiceProvider.php</code>'],
        ['Config files', 'lowercase', '<code class="code-inline">database.php</code>'],
        ['Route files', 'lowercase', '<code class="code-inline">users.php</code>'],
        ['Views', 'lowercase with folders', '<code class="code-inline">auth/login.php</code>'],
        ['Migrations', 'numbered + description', '<code class="code-inline">001_initial_setup.sql</code>'],
    ]
) ?>

<?php include __DIR__ . '/../_layout-end.php'; ?>
