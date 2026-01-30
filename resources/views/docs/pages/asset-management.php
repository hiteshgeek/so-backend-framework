<?php
/**
 * Asset Management Documentation Page
 *
 * Static asset management with cache busting, CDN support, and priority loading.
 */

$pageTitle = 'Asset Management';
$pageIcon = 'package-variant-closed';
$toc = [
    ['id' => 'introduction', 'title' => 'Introduction', 'level' => 2],
    ['id' => 'quick-start', 'title' => 'Quick Start', 'level' => 2],
    ['id' => 'asset-url-generation', 'title' => 'Asset URL Generation', 'level' => 2],
    ['id' => 'registering-css', 'title' => 'Registering CSS Files', 'level' => 2],
    ['id' => 'registering-js', 'title' => 'Registering JS Files', 'level' => 2],
    ['id' => 'cdn-assets', 'title' => 'CDN Assets', 'level' => 2],
    ['id' => 'rendering-assets', 'title' => 'Rendering Assets', 'level' => 2],
    ['id' => 'named-stacks', 'title' => 'Named Stacks', 'level' => 2],
    ['id' => 'js-modules', 'title' => 'JS Modules', 'level' => 2],
    ['id' => 'configuration', 'title' => 'Configuration', 'level' => 2],
    ['id' => 'directory-structure', 'title' => 'Directory Structure', 'level' => 2],
    ['id' => 'helpers', 'title' => 'Helper Functions', 'level' => 2],
    ['id' => 'best-practices', 'title' => 'Best Practices', 'level' => 2],
    ['id' => 'api-reference', 'title' => 'API Reference', 'level' => 2],
];
$prevPage = ['url' => '/docs/view-templates', 'title' => 'View Templates'];
$nextPage = ['url' => '/docs/auth-system', 'title' => 'Authentication System'];
$breadcrumbs = [['label' => 'Asset Management']];
$lastUpdated = '2026-01-30';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="asset-management" class="heading heading-1">
    <span class="mdi mdi-package-variant-closed heading-icon"></span>
    <span class="heading-text">Asset Management</span>
</h1>

<p class="text-lead">
    Centralized CSS, JavaScript, fonts, and image management with automatic cache busting, CDN support, priority-based loading, and named content stacks.
</p>

<div class="flex gap-2 mb-4">
    <?= badge('Production Ready', 'stable') ?>
    <?= badge('Cache Busting', 'success') ?>
    <?= badge('CDN Support', 'info') ?>
</div>

<!-- Introduction -->
<h2 id="introduction" class="heading heading-2">
    <span class="mdi mdi-information heading-icon"></span>
    <span class="heading-text">Introduction</span>
</h2>

<h4 class="heading heading-4">Key Features</h4>

<?= featureGrid([
    ['icon' => 'refresh', 'title' => 'Cache Busting', 'description' => 'Automatic ?v=filemtime() query strings change on every file update'],
    ['icon' => 'cloud', 'title' => 'CDN Support', 'description' => 'Set ASSET_URL in .env to prefix all asset URLs with your CDN'],
    ['icon' => 'sort-ascending', 'title' => 'Priority Loading', 'description' => 'Lower number = loaded first. CDN fonts before local CSS'],
    ['icon' => 'monitor', 'title' => 'Position Control', 'description' => 'Place assets in head or body_end for optimal loading'],
    ['icon' => 'layers', 'title' => 'Named Stacks', 'description' => 'Push inline CSS/JS to named stacks, render in layout'],
    ['icon' => 'language-javascript', 'title' => 'JS Modules', 'description' => 'Support for type="module", defer, async via attributes'],
]) ?>

<?= callout('info', 'The Asset Manager is registered as a singleton — all views share the same instance during a request. Register assets anywhere, render once in your layout.') ?>

<!-- Quick Start -->
<h2 id="quick-start" class="heading heading-2">
    <span class="mdi mdi-rocket-launch heading-icon"></span>
    <span class="heading-text">Quick Start</span>
</h2>

<h4 class="heading heading-4">1. Register assets in your view</h4>

<?= codeBlock('php', '<?php
assets()->cdn(\'https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css\', \'css\', \'head\', 5);
assets()->css(\'css/app.css\', \'head\', 10);
assets()->js(\'js/app.js\', \'body_end\', 10);
?>') ?>

<h4 class="heading heading-4">2. Render in your layout</h4>

<?= codeBlock('php', '<head>
    <?= render_assets(\'head\') ?>
</head>
<body>
    <!-- content -->
    <?= render_assets(\'body_end\') ?>
</body>') ?>

<h4 class="heading heading-4">3. Generated HTML output</h4>

<?= codeBlock('html', '<head>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="http://yourapp.com/assets/css/app.css?v=1706620800" rel="stylesheet">
</head>
<body>
    ...
    <script src="http://yourapp.com/assets/js/app.js?v=1706620800"></script>
</body>') ?>

<!-- Asset URL Generation -->
<h2 id="asset-url-generation" class="heading heading-2">
    <span class="mdi mdi-link-variant heading-icon"></span>
    <span class="heading-text">Asset URL Generation</span>
</h2>

<p>Generate a versioned URL to any file in <code class="code-inline">public/assets/</code>:</p>

<?= codeBlock('php', '// Basic usage
$url = asset(\'css/app.css\');
// → http://yourapp.com/assets/css/app.css?v=1706620800

// In HTML tags
<img src="<?= asset(\'images/logo.png\') ?>">
<link rel="icon" href="<?= asset(\'images/favicon.ico\') ?>">') ?>

<h4 class="heading heading-4">CDN Support</h4>

<p>Set <code class="code-inline">ASSET_URL</code> in your <code class="code-inline">.env</code> to prefix all asset URLs:</p>

<?= codeBlock('bash', '# .env
ASSET_URL=https://cdn.example.com', 'Environment') ?>

<?= codeBlock('php', 'asset(\'css/app.css\')
// → https://cdn.example.com/assets/css/app.css?v=1706620800') ?>

<h4 class="heading heading-4">Disable Versioning</h4>

<?= codeBlock('bash', '# Globally via .env
ASSET_VERSIONING=false', 'Environment') ?>

<?= codeBlock('php', '// Per-call override
app(\'assets\')->url(\'css/app.css\', false);
// → /assets/css/app.css (no ?v= parameter)') ?>

<!-- Registering CSS -->
<h2 id="registering-css" class="heading heading-2">
    <span class="mdi mdi-language-css3 heading-icon"></span>
    <span class="heading-text">Registering CSS Files</span>
</h2>

<?= methodSignature('public', 'css', [
    ['string', '$path', null],
    ['string', '$position', "'head'"],
    ['int', '$priority', '50'],
    ['array', '$attributes', '[]'],
], 'void') ?>

<?= dataTable(
    ['Parameter', 'Type', 'Default', 'Description'],
    [
        ['<code class="code-inline">$path</code>', 'string', '—', 'Path relative to <code class="code-inline">public/assets/</code>'],
        ['<code class="code-inline">$position</code>', 'string', '<code class="code-inline">head</code>', '<code class="code-inline">head</code> or <code class="code-inline">body_end</code>'],
        ['<code class="code-inline">$priority</code>', 'int', '<code class="code-inline">50</code>', 'Lower = loaded first'],
        ['<code class="code-inline">$attributes</code>', 'array', '<code class="code-inline">[]</code>', 'Extra HTML attributes'],
    ]
) ?>

<?= codeBlock('php', '// Basic — loads in <head> with default priority 50
assets()->css(\'css/app.css\');

// With priority — loads before default CSS
assets()->css(\'css/reset.css\', \'head\', 5);

// With attributes
assets()->css(\'css/print.css\', \'head\', 50, [\'media\' => \'print\']);

// Multiple files with priority ordering
assets()->css(\'css/base.css\', \'head\', 10);     // Loads first
assets()->css(\'css/layout.css\', \'head\', 20);    // Loads second
assets()->css(\'css/theme.css\', \'head\', 30);     // Loads third
assets()->css(\'css/page.css\', \'head\', 50);      // Loads last') ?>

<!-- Registering JS -->
<h2 id="registering-js" class="heading heading-2">
    <span class="mdi mdi-language-javascript heading-icon"></span>
    <span class="heading-text">Registering JS Files</span>
</h2>

<?= methodSignature('public', 'js', [
    ['string', '$path', null],
    ['string', '$position', "'body_end'"],
    ['int', '$priority', '50'],
    ['array', '$attributes', '[]'],
], 'void') ?>

<?= codeBlock('php', '// Basic — loads before </body>
assets()->js(\'js/app.js\');

// In head with defer
assets()->js(\'js/analytics.js\', \'head\', 5, [\'defer\' => true]);

// With async
assets()->js(\'js/tracking.js\', \'head\', 5, [\'async\' => true]);

// Priority ordering
assets()->js(\'js/vendor.js\', \'body_end\', 10);   // Loads first
assets()->js(\'js/app.js\', \'body_end\', 50);       // Loads after vendor') ?>

<!-- CDN Assets -->
<h2 id="cdn-assets" class="heading heading-2">
    <span class="mdi mdi-cloud heading-icon"></span>
    <span class="heading-text">CDN Assets</span>
</h2>

<p>Register external assets from CDNs (full URLs, no versioning applied):</p>

<?= methodSignature('public', 'cdn', [
    ['string', '$url', null],
    ['string', '$type', "'css'"],
    ['string', '$position', "'head'"],
    ['int', '$priority', '10'],
    ['array', '$attributes', '[]'],
], 'void') ?>

<?= codeBlock('php', '// CSS from CDN
assets()->cdn(\'https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css\', \'css\', \'head\', 5);

// Google Fonts
assets()->cdn(\'https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap\', \'css\', \'head\', 5);

// JS from CDN
assets()->cdn(\'https://cdn.jsdelivr.net/npm/chart.js\', \'js\', \'body_end\', 5);

// CDN with integrity check
assets()->cdn(\'https://cdn.example.com/lib.js\', \'js\', \'body_end\', 5, [
    \'integrity\' => \'sha384-abc123...\',
    \'crossorigin\' => \'anonymous\'
]);') ?>

<?= callout('tip', '<strong>CDN default priority is 10</strong> — CDN resources (fonts, icon libraries) load before local CSS (default 50) so your styles can reference them immediately.') ?>

<!-- Rendering Assets -->
<h2 id="rendering-assets" class="heading heading-2">
    <span class="mdi mdi-code-tags heading-icon"></span>
    <span class="heading-text">Rendering Assets</span>
</h2>

<?= codeBlock('php', '// Typical layout pattern
<!DOCTYPE html>
<html>
<head>
    <?php
    assets()->cdn(\'https://fonts.googleapis.com/css2?family=Inter\', \'css\', \'head\', 5);
    assets()->css(\'css/app.css\', \'head\', 10);
    assets()->js(\'js/app.js\', \'body_end\', 10);
    ?>
    <?= render_assets(\'head\') ?>
    <?= render_stack(\'styles\') ?>
</head>
<body>
    <!-- Page content -->

    <?= render_assets(\'body_end\') ?>
    <?= render_stack(\'scripts\') ?>
</body>
</html>', 'Layout Template') ?>

<h4 class="heading heading-4">Priority Loading Order</h4>

<?= dataTable(
    ['Priority', 'Usage', 'Example'],
    [
        ['<code class="code-inline">5</code>', 'CDN dependencies', 'Fonts, icon libraries'],
        ['<code class="code-inline">10</code>', 'Base framework CSS/JS', 'app.css, app.js'],
        ['<code class="code-inline">20</code>', 'Layout CSS', 'layout.css'],
        ['<code class="code-inline">50</code>', 'Page-specific (default)', 'dashboard.css'],
    ]
) ?>

<!-- Named Stacks -->
<h2 id="named-stacks" class="heading heading-2">
    <span class="mdi mdi-layers heading-icon"></span>
    <span class="heading-text">Named Stacks</span>
</h2>

<p>Push raw content to named stacks and render them in your layout. Similar to Laravel's <code class="code-inline">@push</code> / <code class="code-inline">@stack</code> directives.</p>

<h4 class="heading heading-4">Push Content</h4>

<?= codeBlock('php', '// Push inline styles
push_stack(\'styles\', \'<style>.highlight { background: yellow; }</style>\');

// Push with priority
push_stack(\'styles\', \'<style>.critical { color: red; }</style>\', 10);') ?>

<h4 class="heading heading-4">Block Capture</h4>

<?= codeBlock('php', '<?php assets()->startPush(\'scripts\'); ?>
<script>
    document.addEventListener(\'DOMContentLoaded\', function() {
        initializeCharts();
    });
</script>
<?php assets()->endPush(); ?>') ?>

<h4 class="heading heading-4">Render in Layout</h4>

<?= codeBlock('php', '<head>
    <?= render_assets(\'head\') ?>
    <?= render_stack(\'styles\') ?>
</head>
<body>
    <?= render_assets(\'body_end\') ?>
    <?= render_stack(\'scripts\') ?>
</body>') ?>

<h4 class="heading heading-4">Conditional Stack Rendering</h4>

<?= codeBlock('php', '<?php if (assets()->hasStack(\'charts\')): ?>
    <div id="chart-container"></div>
    <?= render_stack(\'charts\') ?>
<?php endif; ?>') ?>

<!-- JS Modules -->
<h2 id="js-modules" class="heading heading-2">
    <span class="mdi mdi-nodejs heading-icon"></span>
    <span class="heading-text">JS Modules</span>
</h2>

<p>ES modules and other script attributes are supported via the <code class="code-inline">$attributes</code> parameter:</p>

<?= codeBlock('php', '// ES Module
assets()->js(\'js/app.mjs\', \'body_end\', 50, [\'type\' => \'module\']);
// → <script src="/assets/js/app.mjs?v=..." type="module"></script>

// Legacy fallback
assets()->js(\'js/app-legacy.js\', \'body_end\', 50, [\'nomodule\' => true]);
// → <script src="/assets/js/app-legacy.js?v=..." nomodule></script>

// Defer / Async
assets()->js(\'js/app.js\', \'head\', 50, [\'defer\' => true]);
assets()->js(\'js/analytics.js\', \'head\', 5, [\'async\' => true]);') ?>

<!-- Configuration -->
<h2 id="configuration" class="heading heading-2">
    <span class="mdi mdi-cog heading-icon"></span>
    <span class="heading-text">Configuration</span>
</h2>

<?= codeBlockWithFile('php', "return [
    // CDN base URL (empty = use app.url)
    'asset_url' => env('ASSET_URL', ''),

    // Cache busting via filemtime
    'asset_versioning' => env('ASSET_VERSIONING', true),
];", 'config/app.php') ?>

<?= codeBlockWithFile('bash', '# CDN prefix for all asset URLs
ASSET_URL=https://cdn.example.com

# Disable versioning (if CDN handles cache invalidation)
ASSET_VERSIONING=false', '.env') ?>

<!-- Directory Structure -->
<h2 id="directory-structure" class="heading heading-2">
    <span class="mdi mdi-folder-open heading-icon"></span>
    <span class="heading-text">Directory Structure</span>
</h2>

<?= codeBlock('text', 'public/
└── assets/
    ├── css/           ← Stylesheets
    │   ├── app.css
    │   ├── auth.css
    │   ├── dashboard.css
    │   └── docs.css
    ├── js/            ← JavaScript
    │   ├── app.js
    │   ├── dashboard.js
    │   └── docs.js
    ├── images/        ← Images (PNG, SVG, etc.)
    │   └── logo.png
    └── fonts/         ← Custom fonts
        └── custom.woff2') ?>

<?= callout('info', 'All files under <code class="code-inline">public/assets/</code> are served directly by Apache. The <code class="code-inline">asset()</code> helper generates URLs pointing to this directory.') ?>

<!-- Helper Functions -->
<h2 id="helpers" class="heading heading-2">
    <span class="mdi mdi-function heading-icon"></span>
    <span class="heading-text">Helper Functions</span>
</h2>

<?= dataTable(
    ['Helper', 'Returns', 'Description'],
    [
        ['<code class="code-inline">asset($path)</code>', 'string', 'Generate versioned URL to <code class="code-inline">public/assets/$path</code>'],
        ['<code class="code-inline">assets()</code>', 'AssetManager', 'Get the AssetManager singleton instance'],
        ['<code class="code-inline">render_assets($position)</code>', 'string', 'Render all assets for a position (<code class="code-inline">head</code> / <code class="code-inline">body_end</code>)'],
        ['<code class="code-inline">render_stack($name)</code>', 'string', 'Render a named content stack'],
        ['<code class="code-inline">push_stack($name, $content, $priority)</code>', 'void', 'Push content to a named stack'],
    ]
) ?>

<!-- Best Practices -->
<h2 id="best-practices" class="heading heading-2">
    <span class="mdi mdi-check-decagram heading-icon"></span>
    <span class="heading-text">Best Practices</span>
</h2>

<h4 class="heading heading-4">Use Consistent Priority Levels</h4>

<?= codeBlock('text', 'Priority  5  — CDN dependencies (fonts, icon libraries)
Priority 10  — Base/framework CSS and JS
Priority 20  — Layout CSS
Priority 50  — Page-specific CSS/JS (default)') ?>

<h4 class="heading heading-4">DashboardConfig Pattern for PHP Values in JS</h4>

<p>When JavaScript needs PHP-generated values, use a small inline config block instead of putting PHP in <code class="code-inline">.js</code> files:</p>

<?= codeBlock('php', '<!-- In your view -->
<script>
window.AppConfig = {
    userId: <?= $user->id ?>,
    csrfToken: \'<?= e(csrf_token()) ?>\',
    apiUrl: \'<?= e(url(\'/api\')) ?>\'
};
</script>
<?= render_assets(\'body_end\') ?>

<!-- In your external JS file, reference: -->
// AppConfig.userId, AppConfig.csrfToken, etc.') ?>

<?= callout('success', '<strong>External CSS over inline</strong> — Move all <code class="code-inline">&lt;style&gt;</code> blocks to external <code class="code-inline">.css</code> files. External files are cached by browsers, shared across pages, and versioned automatically.') ?>

<?= callout('tip', '<strong>CDN for third-party, local for your code</strong> — Use CDN for libraries (fonts, Chart.js) and local files for your own CSS/JS. This gives you CDN caching for libraries and full version control for your code.') ?>

<!-- API Reference -->
<h2 id="api-reference" class="heading heading-2">
    <span class="mdi mdi-api heading-icon"></span>
    <span class="heading-text">API Reference</span>
</h2>

<p><strong>Class:</strong> <code class="code-inline">Core\Support\AssetManager</code></p>

<?= dataTable(
    ['Method', 'Parameters', 'Returns', 'Description'],
    [
        ['<code class="code-inline">url()</code>', '$path, ?$version', 'string', 'Generate versioned asset URL'],
        ['<code class="code-inline">css()</code>', '$path, $position, $priority, $attributes', 'void', 'Register a CSS file'],
        ['<code class="code-inline">js()</code>', '$path, $position, $priority, $attributes', 'void', 'Register a JS file'],
        ['<code class="code-inline">cdn()</code>', '$url, $type, $position, $priority, $attributes', 'void', 'Register an external CDN asset'],
        ['<code class="code-inline">renderAssets()</code>', '$position', 'string', 'Render registered assets as HTML'],
        ['<code class="code-inline">push()</code>', '$name, $content, $priority', 'void', 'Push content to a named stack'],
        ['<code class="code-inline">startPush()</code>', '$name, $priority', 'void', 'Start capturing output for a stack'],
        ['<code class="code-inline">endPush()</code>', '—', 'void', 'End capturing and push to stack'],
        ['<code class="code-inline">renderStack()</code>', '$name', 'string', 'Render a named stack'],
        ['<code class="code-inline">hasStack()</code>', '$name', 'bool', 'Check if stack has content'],
        ['<code class="code-inline">flush()</code>', '—', 'void', 'Reset all assets and stacks'],
    ]
) ?>

<?php include __DIR__ . '/../_layout-end.php'; ?>
