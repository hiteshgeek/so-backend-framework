# Asset Management

**Static Asset Management with Cache Busting, CDN Support, and Priority Loading**

The Asset Management system provides centralized control over CSS, JavaScript, fonts, and images with automatic cache busting, CDN prefix support, loading priority, and named content stacks.

---

## Table of Contents

1. [Introduction](#introduction)
2. [Quick Start](#quick-start)
3. [Asset URL Generation](#asset-url-generation)
4. [Registering CSS Files](#registering-css-files)
5. [Registering JS Files](#registering-js-files)
6. [CDN Assets](#cdn-assets)
7. [Rendering Assets](#rendering-assets)
8. [Named Stacks](#named-stacks)
9. [JS Modules](#js-modules)
10. [Configuration](#configuration)
11. [Directory Structure](#directory-structure)
12. [Helper Functions](#helper-functions)
13. [Best Practices](#best-practices)

---

## Introduction

### Why Asset Management?

Without an asset manager, you end up with:
- **Inline `<style>` blocks** scattered across views — hard to cache, duplicated CSS
- **No cache busting** — users see stale CSS/JS after deployments
- **No CDN support** — assets always served from origin
- **No loading order control** — CDN fonts might load after page CSS
- **No structure** — CSS/JS mixed into views with no organization

The Asset Manager solves all of these with a clean, Laravel-inspired API.

### Key Features

| Feature | Description |
|---------|-------------|
| **Cache Busting** | Automatic `?v=filemtime()` query strings — changes on every file update |
| **CDN Support** | Set `ASSET_URL` in `.env` to prefix all asset URLs with your CDN |
| **Priority Loading** | Lower number = loaded first — CDN fonts before local CSS |
| **Position Control** | Place assets in `head` or `body_end` |
| **Named Stacks** | Push inline content to named stacks — render in layout |
| **JS Modules** | Support for `type="module"`, `defer`, `async` via attributes |

---

## Quick Start

### 1. Register assets in your view

```php
<?php
assets()->cdn('https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css', 'css', 'head', 5);
assets()->css('css/app.css', 'head', 10);
assets()->js('js/app.js', 'body_end', 10);
?>
```

### 2. Render in head

```php
<head>
    <?= render_assets('head') ?>
</head>
```

### 3. Render at body end

```php
    <?= render_assets('body_end') ?>
</body>
```

### Output

```html
<head>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="http://yourapp.com/assets/css/app.css?v=1706620800" rel="stylesheet">
</head>
<body>
    ...
    <script src="http://yourapp.com/assets/js/app.js?v=1706620800"></script>
</body>
```

---

## Asset URL Generation

Generate a versioned URL to any file in `public/assets/`:

```php
// Basic usage
$url = asset('css/app.css');
// → http://yourapp.com/assets/css/app.css?v=1706620800

// In HTML
<img src="<?= asset('images/logo.png') ?>">
<link rel="icon" href="<?= asset('images/favicon.ico') ?>">
```

### How Versioning Works

The `?v=` parameter is the file's `filemtime()` — it changes whenever the file is modified. This forces browsers to download the new version instead of serving a stale cached copy.

```php
// Version is based on file modification time
asset('css/app.css')  →  /assets/css/app.css?v=1706620800

// Edit css/app.css and save...
asset('css/app.css')  →  /assets/css/app.css?v=1706625000  // New version!
```

### CDN Support

Set `ASSET_URL` in your `.env` to prefix all asset URLs:

```env
ASSET_URL=https://cdn.example.com
```

```php
asset('css/app.css')
// → https://cdn.example.com/assets/css/app.css?v=1706620800
```

### Disable Versioning

```php
// Globally via .env
ASSET_VERSIONING=false

// Per-call override
app('assets')->url('css/app.css', false);
// → /assets/css/app.css (no ?v= parameter)
```

---

## Registering CSS Files

```php
assets()->css(string $path, string $position = 'head', int $priority = 50, array $attributes = []);
```

### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$path` | string | — | Path relative to `public/assets/` |
| `$position` | string | `'head'` | `'head'` or `'body_end'` |
| `$priority` | int | `50` | Lower = loaded first |
| `$attributes` | array | `[]` | Extra HTML attributes |

### Examples

```php
// Basic — loads in <head> with default priority 50
assets()->css('css/app.css');

// With priority — loads before default CSS
assets()->css('css/reset.css', 'head', 5);

// With attributes
assets()->css('css/print.css', 'head', 50, ['media' => 'print']);

// Multiple files with priority ordering
assets()->css('css/base.css', 'head', 10);     // Loads first
assets()->css('css/layout.css', 'head', 20);    // Loads second
assets()->css('css/theme.css', 'head', 30);     // Loads third
assets()->css('css/page.css', 'head', 50);      // Loads last
```

---

## Registering JS Files

```php
assets()->js(string $path, string $position = 'body_end', int $priority = 50, array $attributes = []);
```

### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$path` | string | — | Path relative to `public/assets/` |
| `$position` | string | `'body_end'` | `'head'` or `'body_end'` |
| `$priority` | int | `50` | Lower = loaded first |
| `$attributes` | array | `[]` | Extra HTML attributes |

### Examples

```php
// Basic — loads before </body> with default priority 50
assets()->js('js/app.js');

// In head with defer
assets()->js('js/analytics.js', 'head', 5, ['defer' => true]);

// With async
assets()->js('js/tracking.js', 'head', 5, ['async' => true]);

// Priority ordering
assets()->js('js/vendor.js', 'body_end', 10);   // Loads first
assets()->js('js/app.js', 'body_end', 50);       // Loads after vendor
```

---

## CDN Assets

Register external assets (full URLs, no versioning applied):

```php
assets()->cdn(string $url, string $type = 'css', string $position = 'head', int $priority = 10, array $attributes = []);
```

### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$url` | string | — | Full CDN URL |
| `$type` | string | `'css'` | `'css'` or `'js'` |
| `$position` | string | `'head'` | `'head'` or `'body_end'` |
| `$priority` | int | `10` | Lower = loaded first (default 10, before local assets) |
| `$attributes` | array | `[]` | Extra HTML attributes |

### Examples

```php
// CSS from CDN
assets()->cdn('https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css', 'css', 'head', 5);

// Google Fonts
assets()->cdn('https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap', 'css', 'head', 5);

// JS from CDN
assets()->cdn('https://cdn.jsdelivr.net/npm/chart.js', 'js', 'body_end', 5);

// CDN with attributes
assets()->cdn('https://cdn.example.com/lib.js', 'js', 'body_end', 5, ['crossorigin' => 'anonymous']);
```

### Why CDN Default Priority is 10

CDN resources (fonts, icon libraries) should load before local CSS so your styles can reference them. The default priority 10 ensures CDN assets appear before local assets (default 50).

---

## Rendering Assets

Render all registered assets for a position:

```php
<?= render_assets('head') ?>     // All CSS links + head JS
<?= render_assets('body_end') ?> // All body-end JS scripts
```

### Typical Layout Pattern

```php
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Page</title>
    <?php
    assets()->cdn('https://fonts.googleapis.com/css2?family=Inter', 'css', 'head', 5);
    assets()->css('css/app.css', 'head', 10);
    assets()->js('js/app.js', 'body_end', 10);
    ?>
    <?= render_assets('head') ?>
</head>
<body>
    <!-- Page content -->

    <?= render_assets('body_end') ?>
</body>
</html>
```

### Rendering Order

Assets are sorted by priority (lower number first), then by registration order for same priority:

```
Priority 5:  CDN fonts, icon libraries
Priority 10: Local base CSS, CDN JS
Priority 20: Layout CSS
Priority 50: Page-specific CSS/JS (default)
```

---

## Named Stacks

Push raw content (inline CSS/JS) to named stacks and render them in your layout. This is similar to Laravel's `@push` / `@stack` directives.

### Push Content

```php
// Push inline styles
push_stack('styles', '<style>.highlight { background: yellow; }</style>');

// Push inline scripts
push_stack('scripts', '<script>console.log("loaded");</script>');

// With priority
push_stack('styles', '<style>.critical { color: red; }</style>', 10);
```

### Block Capture

Capture a block of HTML/CSS/JS and push it to a stack:

```php
<?php assets()->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        initializeCharts();
    });
</script>
<?php assets()->endPush(); ?>
```

### Render Stacks in Layout

```php
<head>
    <?= render_assets('head') ?>
    <?= render_stack('styles') ?>
</head>
<body>
    <!-- content -->
    <?= render_assets('body_end') ?>
    <?= render_stack('scripts') ?>
</body>
```

### Check If Stack Has Content

```php
<?php if (assets()->hasStack('charts')): ?>
    <div id="chart-container"></div>
    <?= render_stack('charts') ?>
<?php endif; ?>
```

---

## JS Modules

ES modules are supported via the attributes parameter:

```php
// ES Module
assets()->js('js/app.mjs', 'body_end', 50, ['type' => 'module']);
// → <script src="/assets/js/app.mjs?v=..." type="module"></script>

// Legacy fallback with nomodule
assets()->js('js/app-legacy.js', 'body_end', 50, ['nomodule' => true]);
// → <script src="/assets/js/app-legacy.js?v=..." nomodule></script>

// Module + crossorigin
assets()->js('js/app.mjs', 'body_end', 50, [
    'type' => 'module',
    'crossorigin' => 'anonymous'
]);
```

### Common Attribute Patterns

```php
// Defer loading
assets()->js('js/app.js', 'head', 50, ['defer' => true]);

// Async loading
assets()->js('js/analytics.js', 'head', 5, ['async' => true]);

// Subresource integrity
assets()->cdn('https://cdn.example.com/lib.js', 'js', 'body_end', 5, [
    'integrity' => 'sha384-abc123...',
    'crossorigin' => 'anonymous'
]);

// CSS media query
assets()->css('css/print.css', 'head', 50, ['media' => 'print']);
```

---

## Configuration

### config/app.php

```php
return [
    // CDN base URL (empty = use app.url)
    'asset_url' => env('ASSET_URL', ''),

    // Cache busting via filemtime
    'asset_versioning' => env('ASSET_VERSIONING', true),
];
```

### .env Variables

```env
# CDN prefix for all asset URLs
ASSET_URL=https://cdn.example.com

# Disable versioning (e.g., if CDN handles cache invalidation)
ASSET_VERSIONING=false
```

### How It's Registered

The `AssetManager` is registered as a singleton in `bootstrap/app.php`:

```php
$app->singleton('assets', function ($app) {
    $config = $app->make('config');
    return new \Core\Support\AssetManager(
        $config->get('app.asset_url', ''),
        $config->get('app.asset_versioning', true)
    );
});
```

---

## Directory Structure

```
public/
└── assets/
    ├── css/                  ← Stylesheets (organized by module)
    │   ├── base.css              ← Shared base (variables, reset, dark mode)
    │   ├── auth/
    │   │   └── auth.css
    │   ├── dashboard/
    │   │   ├── dashboard.css
    │   │   └── dashboard-form.css
    │   ├── docs/
    │   │   ├── docs.css
    │   │   └── docs-index.css
    │   ├── pages/
    │   │   └── welcome.css
    │   └── tools/
    │       └── route-tester.css
    ├── js/                   ← JavaScript (organized by module)
    │   ├── theme.js              ← Dark/light mode toggle
    │   ├── dashboard/
    │   │   └── dashboard.js
    │   ├── docs/
    │   │   └── docs.js
    │   └── tools/
    │       └── route-tester.js
    ├── images/               ← Images (PNG, SVG, etc.)
    │   └── logo.png
    └── fonts/                ← Custom fonts
        └── custom.woff2
```

All files under `public/assets/` are served directly by Apache. The `asset()` helper generates URLs pointing to this directory.

---

## Helper Functions

Five global helpers are available:

| Helper | Returns | Description |
|--------|---------|-------------|
| `asset($path)` | `string` | Generate versioned URL to `public/assets/$path` |
| `assets()` | `AssetManager` | Get the AssetManager instance |
| `render_assets($position)` | `string` | Render all assets for position (`head` / `body_end`) |
| `render_stack($name)` | `string` | Render a named stack |
| `push_stack($name, $content, $priority)` | `void` | Push content to a named stack |

### Usage Examples

```php
// In any view — generate image URL
<img src="<?= asset('images/logo.png') ?>" alt="Logo">

// In a layout head
<?= render_assets('head') ?>

// In a child view — push page-specific CSS
<?php push_stack('styles', '<style>.page-hero { height: 400px; }</style>'); ?>

// In layout — render pushed styles
<?= render_stack('styles') ?>
```

---

## Best Practices

### 1. Use Priority Levels Consistently

```
 5  — CDN dependencies (fonts, icon libraries)
10  — Base/framework CSS and JS
20  — Layout CSS
50  — Page-specific CSS/JS (default)
```

### 2. External CSS in Files, Not Inline

Move all `<style>` blocks to external `.css` files in `public/assets/css/`. External files are cached by browsers, shared across pages, and versioned automatically.

### 3. Use the DashboardConfig Pattern for PHP Values in JS

When JavaScript needs PHP values, don't put PHP in your `.js` files. Use a small inline config block:

```php
<!-- In your view -->
<script>
window.AppConfig = {
    userId: <?= $user->id ?>,
    csrfToken: '<?= e(csrf_token()) ?>',
    apiUrl: '<?= e(url('/api')) ?>'
};
</script>
<?= render_assets('body_end') ?>
```

Then reference `AppConfig.userId` in your external JS file.

### 4. CDN for Third-Party, Local for Your Code

```php
// Third-party → CDN (cached globally, no build needed)
assets()->cdn('https://cdn.jsdelivr.net/npm/chart.js', 'js', 'body_end', 5);

// Your code → local files (versioned, full control)
assets()->js('js/charts-init.js', 'body_end', 10);
```

### 5. Use Stacks for Page-Specific Inline Content

```php
// Child view pushes page-specific script
<?php assets()->startPush('scripts'); ?>
<script>
    const chart = new Chart(document.getElementById('myChart'), { ... });
</script>
<?php assets()->endPush(); ?>

// Layout renders it in the right place
<?= render_stack('scripts') ?>
```

---

## API Reference

### AssetManager Class

**Namespace:** `Core\Support\AssetManager`

| Method | Parameters | Returns | Description |
|--------|-----------|---------|-------------|
| `url()` | `string $path, ?bool $version` | `string` | Generate versioned asset URL |
| `css()` | `string $path, string $position, int $priority, array $attributes` | `void` | Register a CSS file |
| `js()` | `string $path, string $position, int $priority, array $attributes` | `void` | Register a JS file |
| `cdn()` | `string $url, string $type, string $position, int $priority, array $attributes` | `void` | Register an external CDN asset |
| `renderAssets()` | `string $position` | `string` | Render registered assets as HTML |
| `push()` | `string $name, string $content, int $priority` | `void` | Push content to a named stack |
| `startPush()` | `string $name, int $priority` | `void` | Start capturing output for a stack |
| `endPush()` | — | `void` | End capturing and push to stack |
| `renderStack()` | `string $name` | `string` | Render a named stack |
| `hasStack()` | `string $name` | `bool` | Check if stack has content |
| `flush()` | — | `void` | Reset all assets and stacks |
