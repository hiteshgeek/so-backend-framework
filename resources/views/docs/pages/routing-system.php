<?php
/**
 * Routing System Documentation Page
 *
 * Complete routing system documentation with Laravel-style routing.
 */

$pageTitle = 'Routing System';
$pageIcon = 'routes';
$toc = [
    ['id' => 'basic-routing', 'title' => 'Basic Routing', 'level' => 2],
    ['id' => 'route-parameters', 'title' => 'Route Parameters', 'level' => 2],
    ['id' => 'parameter-constraints', 'title' => 'Parameter Constraints', 'level' => 2],
    ['id' => 'named-routes', 'title' => 'Named Routes', 'level' => 2],
    ['id' => 'route-groups', 'title' => 'Route Groups', 'level' => 2],
    ['id' => 'middleware', 'title' => 'Middleware', 'level' => 2],
    ['id' => 'resource-routes', 'title' => 'Resource Routes', 'level' => 2],
    ['id' => 'api-resources', 'title' => 'API Resources', 'level' => 2],
    ['id' => 'route-model-binding', 'title' => 'Route Model Binding', 'level' => 2],
    ['id' => 'special-routes', 'title' => 'Special Routes', 'level' => 2],
    ['id' => 'current-route-helpers', 'title' => 'Current Route Helpers', 'level' => 2],
    ['id' => 'best-practices', 'title' => 'Best Practices', 'level' => 2],
    ['id' => 'quick-reference', 'title' => 'Quick Reference', 'level' => 2],
];
$prevPage = ['url' => '/docs/project-structure', 'title' => 'Project Structure'];
$nextPage = ['url' => '/docs/auth-system', 'title' => 'Authentication System'];
$breadcrumbs = [['label' => 'Routing System']];
$lastUpdated = '2026-01-30';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="routing-system" class="heading heading-1">
    <span class="mdi mdi-routes heading-icon"></span>
    <span class="heading-text">Routing System</span>
</h1>

<p class="text-lead">
    The SO Framework provides a powerful Laravel-style routing system. Routes define how your application responds to HTTP requests by mapping URLs to controller actions.
</p>

<!-- Basic Routing -->
<h2 id="basic-routing" class="heading heading-2">
    <span class="mdi mdi-link heading-icon"></span>
    <span class="heading-text">Basic Routing</span>
</h2>

<p>Routes are defined in <?= filePath('routes/web.php') ?> for web routes and <?= filePath('routes/api.php') ?> for API routes.</p>

<h4 class="heading heading-4">HTTP Methods</h4>

<?= codeBlock('php', 'use Core\Routing\Router;

// GET request
Router::get(\'/users\', [UserController::class, \'index\']);

// POST request
Router::post(\'/users\', [UserController::class, \'store\']);

// PUT request
Router::put(\'/users/{id}\', [UserController::class, \'update\']);

// DELETE request
Router::delete(\'/users/{id}\', [UserController::class, \'destroy\']);

// PATCH request
Router::patch(\'/users/{id}\', [UserController::class, \'patch\']);

// Match any HTTP method
Router::any(\'/contact\', [ContactController::class, \'handle\']);

// Match specific HTTP methods
Router::match([\'GET\', \'POST\'], \'/form\', [FormController::class, \'handle\']);') ?>

<h4 class="heading heading-4 mt-4">Closure Routes</h4>

<p>For simple routes, you can use closures instead of controllers:</p>

<?= codeBlock('php', 'Router::get(\'/hello\', function () {
    return response(\'Hello, World!\');
});

Router::get(\'/user/{id}\', function ($id) {
    return json([\'user_id\' => $id]);
});') ?>

<!-- Route Parameters -->
<h2 id="route-parameters" class="heading heading-2">
    <span class="mdi mdi-variable heading-icon"></span>
    <span class="heading-text">Route Parameters</span>
</h2>

<h4 class="heading heading-4">Required Parameters</h4>

<p>Capture URI segments using curly braces:</p>

<?= codeBlock('php', 'Router::get(\'/users/{id}\', function ($id) {
    return json([\'user_id\' => $id]);
});

Router::get(\'/posts/{post}/comments/{comment}\', function ($post, $comment) {
    return json([\'post\' => $post, \'comment\' => $comment]);
});') ?>

<h4 class="heading heading-4 mt-4">Optional Parameters</h4>

<p>Add <code class="code-inline">?</code> after the parameter name:</p>

<?= codeBlock('php', 'Router::get(\'/users/{name?}\', function ($name = \'Guest\') {
    return response("Hello, {$name}!");
});') ?>

<!-- Parameter Constraints -->
<h2 id="parameter-constraints" class="heading heading-2">
    <span class="mdi mdi-regex heading-icon"></span>
    <span class="heading-text">Parameter Constraints</span>
</h2>

<p>Constrain route parameters using regex patterns for enhanced security.</p>

<h4 class="heading heading-4">Built-in Constraint Methods</h4>

<?= dataTable(
    ['Method', 'Pattern', 'Example'],
    [
        ['<code class="code-inline">whereNumber()</code>', '[0-9]+', 'IDs, counts'],
        ['<code class="code-inline">whereAlpha()</code>', '[a-zA-Z]+', 'Names, categories'],
        ['<code class="code-inline">whereAlphaNumeric()</code>', '[a-zA-Z0-9]+', 'Product codes'],
        ['<code class="code-inline">whereUuid()</code>', 'UUID format', 'Unique identifiers'],
        ['<code class="code-inline">whereSlug()</code>', '[a-z0-9-]+', 'URL slugs'],
        ['<code class="code-inline">whereIn()</code>', 'Specific values', 'Status types'],
    ]
) ?>

<?= codeBlock('php', '// Numeric only
Router::get(\'/users/{id}\', [UserController::class, \'show\'])
    ->whereNumber(\'id\');

// Alphabetic only
Router::get(\'/categories/{name}\', [CategoryController::class, \'show\'])
    ->whereAlpha(\'name\');

// UUID format
Router::get(\'/orders/{uuid}\', [OrderController::class, \'show\'])
    ->whereUuid(\'uuid\');

// Specific values only
Router::get(\'/status/{type}\', [StatusController::class, \'show\'])
    ->whereIn(\'type\', [\'pending\', \'active\', \'completed\']);

// Custom regex
Router::get(\'/posts/{slug}\', [PostController::class, \'show\'])
    ->where(\'slug\', \'[a-z0-9-]+\');

// Multiple constraints
Router::get(\'/users/{user}/posts/{post}\', [PostController::class, \'show\'])
    ->whereNumber(\'user\', \'post\');') ?>

<!-- Named Routes -->
<h2 id="named-routes" class="heading heading-2">
    <span class="mdi mdi-tag heading-icon"></span>
    <span class="heading-text">Named Routes</span>
</h2>

<p>Assign names to routes for easy URL generation:</p>

<?= codeBlock('php', 'Router::get(\'/users/{id}\', [UserController::class, \'show\'])
    ->name(\'users.show\');

Router::post(\'/login\', [AuthController::class, \'login\'])
    ->name(\'auth.login\');') ?>

<h4 class="heading heading-4 mt-4">Generating URLs</h4>

<?= codeTabs([
    ['label' => 'PHP', 'lang' => 'php', 'code' => '// Using route() helper
$url = route(\'users.show\', [\'id\' => 1]);
// Result: http://yoursite.com/users/1'],
    ['label' => 'View', 'lang' => 'php', 'code' => '<a href="<?= route(\'users.show\', [\'id\' => $user->id]) ?>">
    View User
</a>'],
]) ?>

<!-- Route Groups -->
<h2 id="route-groups" class="heading heading-2">
    <span class="mdi mdi-group heading-icon"></span>
    <span class="heading-text">Route Groups</span>
</h2>

<p>Group routes that share common attributes like prefixes or middleware.</p>

<?= codeTabs([
    ['label' => 'Prefix', 'lang' => 'php', 'code' => 'Router::group([\'prefix\' => \'admin\'], function () {
    Router::get(\'/dashboard\', [AdminController::class, \'dashboard\']);
    Router::get(\'/users\', [AdminController::class, \'users\']);
});
// Results in: /admin/dashboard, /admin/users'],
    ['label' => 'Middleware', 'lang' => 'php', 'code' => 'Router::group([\'middleware\' => [AuthMiddleware::class]], function () {
    Router::get(\'/profile\', [ProfileController::class, \'show\']);
    Router::put(\'/profile\', [ProfileController::class, \'update\']);
});'],
    ['label' => 'Combined', 'lang' => 'php', 'code' => 'Router::group([
    \'prefix\' => \'api/v1\',
    \'middleware\' => [ApiAuthMiddleware::class, ThrottleMiddleware::class]
], function () {
    Router::get(\'/users\', [ApiUserController::class, \'index\']);
    Router::post(\'/users\', [ApiUserController::class, \'store\']);
});'],
]) ?>

<!-- Middleware -->
<h2 id="middleware" class="heading heading-2">
    <span class="mdi mdi-filter heading-icon"></span>
    <span class="heading-text">Middleware</span>
</h2>

<?= codeBlock('php', '// Route-level middleware
Router::get(\'/dashboard\', [DashboardController::class, \'index\'])
    ->middleware([AuthMiddleware::class]);

// Multiple middleware
Router::post(\'/admin/users\', [AdminController::class, \'store\'])
    ->middleware([AuthMiddleware::class, AdminMiddleware::class]);

// Global middleware for all routes
Router::globalMiddleware([
    CsrfMiddleware::class,
    SessionMiddleware::class
]);') ?>

<!-- Resource Routes -->
<h2 id="resource-routes" class="heading heading-2">
    <span class="mdi mdi-view-grid heading-icon"></span>
    <span class="heading-text">Resource Routes</span>
</h2>

<p>Quickly generate all CRUD routes:</p>

<?= codeBlock('php', 'Router::resource(\'posts\', PostController::class);') ?>

<p class="mt-3">This generates:</p>

<?= dataTable(
    ['Method', 'URI', 'Action', 'Description'],
    [
        ['<span class="badge badge-get">GET</span>', '/posts', 'index', 'List all posts'],
        ['<span class="badge badge-get">GET</span>', '/posts/create', 'create', 'Show create form'],
        ['<span class="badge badge-post">POST</span>', '/posts', 'store', 'Store new post'],
        ['<span class="badge badge-get">GET</span>', '/posts/{id}', 'show', 'Show single post'],
        ['<span class="badge badge-get">GET</span>', '/posts/{id}/edit', 'edit', 'Show edit form'],
        ['<span class="badge badge-put">PUT</span>', '/posts/{id}', 'update', 'Update post'],
        ['<span class="badge badge-delete">DELETE</span>', '/posts/{id}', 'destroy', 'Delete post'],
    ]
) ?>

<!-- API Resources -->
<h2 id="api-resources" class="heading heading-2">
    <span class="mdi mdi-api heading-icon"></span>
    <span class="heading-text">API Resources</span>
</h2>

<p>For API routes (without create/edit form routes):</p>

<?= codeBlock('php', 'Router::apiResource(\'posts\', PostApiController::class);') ?>

<p class="mt-3">This generates 5 routes (no create/edit):</p>

<?= dataTable(
    ['Method', 'URI', 'Action'],
    [
        ['<span class="badge badge-get">GET</span>', '/posts', 'index'],
        ['<span class="badge badge-post">POST</span>', '/posts', 'store'],
        ['<span class="badge badge-get">GET</span>', '/posts/{id}', 'show'],
        ['<span class="badge badge-put">PUT</span>', '/posts/{id}', 'update'],
        ['<span class="badge badge-delete">DELETE</span>', '/posts/{id}', 'destroy'],
    ]
) ?>

<!-- Route Model Binding -->
<h2 id="route-model-binding" class="heading heading-2">
    <span class="mdi mdi-link-variant heading-icon"></span>
    <span class="heading-text">Route Model Binding</span>
</h2>

<p>Automatically inject model instances based on the route parameter:</p>

<?= codeBlock('php', '// Route definition
Router::get(\'/users/{user}\', function (\App\Models\User $user) {
    // $user is automatically fetched where id = {user}
    return json($user->toArray());
});

// Controller method
class UserController
{
    public function show(\App\Models\User $user)
    {
        // $user is automatically resolved
        // 404 thrown if not found
        return json($user->toArray());
    }
}') ?>

<?= callout('info', 'The framework inspects type hints and fetches the model by ID. If not found, a 404 response is returned.') ?>

<!-- Special Routes -->
<h2 id="special-routes" class="heading heading-2">
    <span class="mdi mdi-star heading-icon"></span>
    <span class="heading-text">Special Routes</span>
</h2>

<div class="grid grid-2 gap-4">
    <div>
        <h4 class="heading heading-4">Fallback Routes</h4>
        <p class="text-muted">Catch-all for unmatched requests</p>
        <?= codeBlock('php', 'Router::fallback(function () {
    return Response::view(\'errors.404\', [], 404);
});') ?>
    </div>
    <div>
        <h4 class="heading heading-4">Redirect Routes</h4>
        <p class="text-muted">Redirect to other URLs</p>
        <?= codeBlock('php', '// Temporary (302)
Router::redirect(\'/old\', \'/new\');

// Permanent (301)
Router::permanentRedirect(\'/legacy\', \'/modern\');') ?>
    </div>
    <div>
        <h4 class="heading heading-4">View Routes</h4>
        <p class="text-muted">Return view without controller</p>
        <?= codeBlock('php', 'Router::view(\'/about\', \'about\');

Router::view(\'/welcome\', \'welcome\', [
    \'name\' => \'Guest\'
]);') ?>
    </div>
</div>

<!-- Current Route Helpers -->
<h2 id="current-route-helpers" class="heading heading-2">
    <span class="mdi mdi-map-marker heading-icon"></span>
    <span class="heading-text">Current Route Helpers</span>
</h2>

<?= codeBlock('php', '// Get current route instance
$route = Router::current();

// Get current route name
$name = Router::currentRouteName();

// Get current route action
$action = Router::currentRouteAction();

// Check if route matches name(s)
if (Router::is(\'users.*\')) {
    // Current route starts with "users."
}

if (Router::is(\'users.show\', \'users.edit\')) {
    // Current route is either "users.show" or "users.edit"
}

// Helper functions
$route = current_route();
$name = current_route_name();
if (route_is(\'dashboard\')) { /* ... */ }') ?>

<!-- Best Practices -->
<h2 id="best-practices" class="heading heading-2">
    <span class="mdi mdi-check-decagram heading-icon"></span>
    <span class="heading-text">Best Practices</span>
</h2>

<div class="space-y-3">
    <?= callout('success', '
        <strong>1. Always use named routes</strong><br>
        <code class="code-inline">Router::get(\'/users/{id}\', ...)->name(\'users.show\');</code>
    ') ?>

    <?= callout('success', '
        <strong>2. Apply parameter constraints</strong><br>
        Validate at routing level with <code class="code-inline">->whereNumber(\'id\')</code>
    ') ?>

    <?= callout('success', '
        <strong>3. Group related routes</strong><br>
        Use prefixes and shared middleware for organization
    ') ?>

    <?= callout('success', '
        <strong>4. Use route model binding</strong><br>
        Let the framework handle model fetching and 404s
    ') ?>

    <?= callout('success', '
        <strong>5. Define fallback route</strong><br>
        Handle 404 cases gracefully at the end of routes
    ') ?>
</div>

<!-- Quick Reference -->
<h2 id="quick-reference" class="heading heading-2">
    <span class="mdi mdi-lightning-bolt heading-icon"></span>
    <span class="heading-text">Quick Reference</span>
</h2>

<?= dataTable(
    ['Feature', 'Syntax'],
    [
        ['GET route', '<code class="code-inline">Router::get(\'/path\', $action)</code>'],
        ['POST route', '<code class="code-inline">Router::post(\'/path\', $action)</code>'],
        ['Any method', '<code class="code-inline">Router::any(\'/path\', $action)</code>'],
        ['Multiple methods', '<code class="code-inline">Router::match([\'GET\', \'POST\'], \'/path\', $action)</code>'],
        ['Required param', '<code class="code-inline">Router::get(\'/users/{id}\', ...)</code>'],
        ['Optional param', '<code class="code-inline">Router::get(\'/users/{id?}\', ...)</code>'],
        ['Number constraint', '<code class="code-inline">->whereNumber(\'id\')</code>'],
        ['Named route', '<code class="code-inline">->name(\'users.show\')</code>'],
        ['Middleware', '<code class="code-inline">->middleware([AuthMiddleware::class])</code>'],
        ['Route group', '<code class="code-inline">Router::group([\'prefix\' => ...], fn)</code>'],
        ['Resource', '<code class="code-inline">Router::resource(\'posts\', Controller::class)</code>'],
        ['API resource', '<code class="code-inline">Router::apiResource(\'posts\', Controller::class)</code>'],
        ['Fallback', '<code class="code-inline">Router::fallback($action)</code>'],
        ['Redirect', '<code class="code-inline">Router::redirect(\'/from\', \'/to\')</code>'],
        ['View route', '<code class="code-inline">Router::view(\'/about\', \'about\')</code>'],
    ]
) ?>

<?php include __DIR__ . '/../_layout-end.php'; ?>
