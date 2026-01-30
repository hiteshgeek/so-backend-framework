# Dev Guide: Managing CSS and JS Assets

A step-by-step guide to managing CSS and JavaScript assets in the SO Backend Framework using the `AssetManager`.

## Table of Contents

1. [Overview](#overview)
2. [Directory Structure](#directory-structure)
3. [Registering CSS](#registering-css)
4. [Registering JS](#registering-js)
5. [CDN Assets](#cdn-assets)
6. [Priority System](#priority-system)
7. [Rendering Assets](#rendering-assets)
8. [Cache Busting](#cache-busting)
9. [Complete Example](#complete-example)

---

## Overview

The `AssetManager` is the central service for registering, ordering, and rendering CSS and JavaScript files. It is registered as a singleton in `bootstrap/app.php` and accessed through the `assets()` helper.

What it handles for you:

- **Registration** -- queue CSS and JS files with a position (`head` or `body_end`) and a priority number.
- **Ordering** -- assets are sorted by priority at render time. Lower numbers load first.
- **Cache busting** -- every local asset URL gets a `?v=<filemtime>` query string so browsers always fetch the latest version after a deploy.
- **CDN support** -- external libraries are registered with their full URL and skip versioning.
- **Rendering** -- a single `render_assets()` call in your layout outputs all the `<link>` and `<script>` tags for a given position.

### How It Is Wired Up

The singleton is created in `bootstrap/app.php`:

```php
$app->singleton('assets', function ($app) {
    $config = $app->make('config');
    return new \Core\Support\AssetManager(
        $config->get('app.asset_url', ''),
        $config->get('app.asset_versioning', true)
    );
});
```

You never instantiate `AssetManager` directly. Use the helpers instead:

| Helper | Returns | Purpose |
|--------|---------|---------|
| `assets()` | `AssetManager` | Access the singleton to register assets |
| `asset($path)` | `string` | Generate a versioned URL for a file in `public/assets/` |
| `render_assets($position)` | `string` | Output all HTML tags for a position |

---

## Directory Structure

All static files live under `public/assets/`, organized by module:

```
public/
└── assets/
    ├── css/
    │   ├── base.css                 ← shared variables, reset, dark mode
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
    ├── js/
    │   ├── theme.js                 ← dark/light mode toggle
    │   ├── dashboard/
    │   │   └── dashboard.js
    │   ├── docs/
    │   │   └── docs.js
    │   └── tools/
    │       └── route-tester.js
    ├── images/
    └── fonts/
```

When you add a new page or module, create a matching subdirectory. For example, a "reports" module would get `css/reports/` and `js/reports/`.

---

## Registering CSS

Use `assets()->css()` to queue a stylesheet.

```php
assets()->css(string $path, string $position = 'head', int $priority = 50, array $attributes = []);
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$path` | string | -- | Path relative to `public/assets/` |
| `$position` | string | `'head'` | Where the `<link>` tag is rendered |
| `$priority` | int | `50` | Lower number loads first |
| `$attributes` | array | `[]` | Extra HTML attributes |

### Examples

```php
// Basic -- renders in <head> at default priority 50
assets()->css('css/pages/welcome.css');

// Explicit position and priority
assets()->css('css/base.css', 'head', 8);

// Page-specific CSS at priority 10
assets()->css('css/dashboard/dashboard.css', 'head', 10);

// Print stylesheet with a media attribute
assets()->css('css/print.css', 'head', 50, ['media' => 'print']);
```

Each call adds the file to an internal queue. Nothing is output until `render_assets()` is called in the layout.

---

## Registering JS

Use `assets()->js()` to queue a script.

```php
assets()->js(string $path, string $position = 'body_end', int $priority = 50, array $attributes = []);
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$path` | string | -- | Path relative to `public/assets/` |
| `$position` | string | `'body_end'` | Where the `<script>` tag is rendered |
| `$priority` | int | `50` | Lower number loads first |
| `$attributes` | array | `[]` | Extra HTML attributes (`defer`, `async`, `type`) |

### Examples

```php
// Basic -- renders before </body> at default priority 50
assets()->js('js/docs/docs.js');

// Explicit position and priority
assets()->js('js/dashboard/dashboard.js', 'body_end', 10);

// Script in <head> with defer
assets()->js('js/analytics.js', 'head', 5, ['defer' => true]);

// ES module
assets()->js('js/app.mjs', 'body_end', 50, ['type' => 'module']);
```

The default position for JS is `'body_end'`, which places scripts right before `</body>` so they do not block page rendering.

---

## CDN Assets

Use `assets()->cdn()` to register an external library by its full URL. CDN assets skip versioning because you do not control the file on disk.

```php
assets()->cdn(string $url, string $type = 'css', string $position = 'head', int $priority = 10, array $attributes = []);
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$url` | string | -- | Full CDN URL |
| `$type` | string | `'css'` | `'css'` or `'js'` |
| `$position` | string | `'head'` | `'head'` or `'body_end'` |
| `$priority` | int | `10` | Lower = loaded first |
| `$attributes` | array | `[]` | Extra HTML attributes |

### Examples

```php
// Icon font from CDN
assets()->cdn(
    'https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css',
    'css',
    'head',
    5
);

// Google Fonts
assets()->cdn(
    'https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap',
    'css',
    'head',
    5
);

// Chart.js from CDN
assets()->cdn('https://cdn.jsdelivr.net/npm/chart.js', 'js', 'body_end', 5);

// CDN script with integrity hash
assets()->cdn('https://cdn.example.com/lib.js', 'js', 'body_end', 5, [
    'integrity'   => 'sha384-abc123...',
    'crossorigin' => 'anonymous',
]);
```

CDN assets default to priority `10`, which is lower (earlier) than the local-file default of `50`. This ensures external fonts and libraries are available before your own stylesheets reference them.

---

## Priority System

Priority determines load order within a position. Lower numbers render first.

| Priority | Use For | Example |
|----------|---------|---------|
| 5 | CDN dependencies (fonts, icon libraries) | Google Fonts, Material Design Icons |
| 8 | Base/framework CSS | `css/base.css` |
| 10 | Page-level CSS and JS | `css/dashboard/dashboard.css`, `js/dashboard/dashboard.js` |
| 50 | Default (anything not explicitly prioritized) | One-off or low-importance assets |

### How It Works Internally

When `render_assets()` is called, the `AssetManager` sorts the queued items by priority using PHP's spaceship operator:

```php
usort($items, fn($a, $b) => $a['priority'] <=> $b['priority']);
```

Items with the same priority render in the order they were registered.

### Recommended Pattern

```php
// 1. CDN fonts load first (priority 5)
assets()->cdn('https://fonts.googleapis.com/css2?family=Inter', 'css', 'head', 5);

// 2. Base styles load second (priority 8)
assets()->css('css/base.css', 'head', 8);

// 3. Page styles load third (priority 10)
assets()->css('css/dashboard/dashboard.css', 'head', 10);
```

This guarantees that when `dashboard.css` references the Inter font family, the font is already declared.

---

## Rendering Assets

Place `render_assets()` in your layout to output all queued tags for a position.

### In `<head>` -- CSS link tags and any head-positioned JS

```html
<head>
    <meta charset="UTF-8">
    <title>My App</title>
    <?= render_assets('head') ?>
</head>
```

### Before `</body>` -- body-end JS script tags

```html
    <?= render_assets('body_end') ?>
</body>
```

### What Gets Output

Given these registrations:

```php
assets()->cdn('https://fonts.googleapis.com/css2?family=Inter', 'css', 'head', 5);
assets()->css('css/base.css', 'head', 8);
assets()->css('css/dashboard/dashboard.css', 'head', 10);
assets()->js('js/dashboard/dashboard.js', 'body_end', 10);
```

`render_assets('head')` outputs:

```html
    <link href="https://fonts.googleapis.com/css2?family=Inter" rel="stylesheet">
    <link href="/assets/css/base.css?v=1706620800" rel="stylesheet">
    <link href="/assets/css/dashboard/dashboard.css?v=1706620800" rel="stylesheet">
```

`render_assets('body_end')` outputs:

```html
    <script src="/assets/js/dashboard/dashboard.js?v=1706620800"></script>
```

Notice that CDN URLs have no `?v=` parameter, and local files do.

---

## Cache Busting

Every local asset URL is automatically appended with a version query string based on the file's modification time on disk.

### How It Works

The `asset()` helper (and internal rendering) calls `AssetManager::url()`, which does this:

```php
$filePath = public_path('assets/' . $path);
if (file_exists($filePath)) {
    $url .= '?v=' . filemtime($filePath);
}
```

So `asset('css/base.css')` produces:

```
/assets/css/base.css?v=1706620800
```

When you edit and save `base.css`, its `filemtime` changes, and the next page load produces a new URL like:

```
/assets/css/base.css?v=1706625000
```

Browsers treat this as a different resource and download the fresh copy instead of serving a stale cached version.

### Using `asset()` Directly

The `asset()` helper is useful outside of `css()`/`js()` registration -- for example, images or favicons:

```php
<img src="<?= asset('images/logo.png') ?>" alt="Logo">
<link rel="icon" href="<?= asset('images/favicon.ico') ?>">
```

### Disabling Versioning

Globally in `.env`:

```
ASSET_VERSIONING=false
```

Per-call override:

```php
app('assets')->url('css/base.css', false);
// => /assets/css/base.css  (no ?v= parameter)
```

---

## Complete Example

This example sets up a new "reports" page with a CDN font, base CSS, page-specific CSS, a CDN charting library, and page-specific JS.

### Step 1: Create the Asset Files

```
public/assets/css/reports/reports.css
public/assets/js/reports/reports.js
```

### Step 2: Register Assets in the Controller or View

```php
<?php
// In app/Controllers/ReportController.php or in the view file

// CDN: Google Fonts (priority 5 -- loads first)
assets()->cdn(
    'https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap',
    'css',
    'head',
    5
);

// CDN: Chart.js library (priority 5 -- loads before page JS)
assets()->cdn('https://cdn.jsdelivr.net/npm/chart.js', 'js', 'body_end', 5);

// Base CSS (priority 8 -- loads after fonts, before page CSS)
assets()->css('css/base.css', 'head', 8);

// Page CSS (priority 10 -- loads after base)
assets()->css('css/reports/reports.css', 'head', 10);

// Page JS (priority 10 -- loads after Chart.js)
assets()->js('js/reports/reports.js', 'body_end', 10);
```

### Step 3: Render in the Layout

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <?= render_assets('head') ?>
</head>
<body>

    <h1>Monthly Report</h1>
    <canvas id="reportChart"></canvas>

    <?= render_assets('body_end') ?>
</body>
</html>
```

### Step 4: Resulting HTML Output

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="/assets/css/base.css?v=1706620800" rel="stylesheet">
    <link href="/assets/css/reports/reports.css?v=1706620800" rel="stylesheet">
</head>
<body>

    <h1>Monthly Report</h1>
    <canvas id="reportChart"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/assets/js/reports/reports.js?v=1706620800"></script>
</body>
</html>
```

The load order is:

1. Google Fonts CSS (CDN, priority 5)
2. `base.css` (local, priority 8, versioned)
3. `reports.css` (local, priority 10, versioned)
4. Chart.js (CDN, priority 5)
5. `reports.js` (local, priority 10, versioned)

Head and body_end are independent queues. Within each queue, priority controls the order.
