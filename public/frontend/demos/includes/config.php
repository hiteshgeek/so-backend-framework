<?php

/**
 * SixOrbit UI Demo - Configuration
 */

// Load Composer autoloader and .env (use frontend's vendor for .env support)
require_once dirname(__DIR__, 4) . '/frontend/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 4));
$dotenv->load();

// Framework info
define('SO_VERSION', '1.0.0');
define('SO_PREFIX', 'so');

// Base URL from .env or fallback to auto-detect
define('APP_URL', $_ENV['APP_URL'] ?? '//' . $_SERVER['HTTP_HOST']);

// Filesystem root path
define('PROJECT_ROOT', dirname(__DIR__, 4)); // Backend framework root

// URL paths (absolute from document root)
define('SO_DIST_PATH', '/frontend/dist');
define('SO_DATA_PATH', '/frontend/demos/data');
define('SO_DEMO_BASE', '/frontend/'); // Base path for demo routes

// Demo company info
define('DEMO_COMPANY_NAME', 'Trove Innovation');
define('DEMO_COMPANY_INITIALS', 'TI');
define('DEMO_USER_NAME', 'Rajeev');
define('DEMO_USER_EMAIL', 'rajeev@trove.com');

// Load manifest for versioned assets
function loadManifest()
{
    $manifestPath = PROJECT_ROOT . '/public/frontend/dist/manifest.json';
    if (file_exists($manifestPath)) {
        return json_decode(file_get_contents($manifestPath), true);
    }
    return ['css' => [], 'js' => []];
}

$GLOBALS['manifest'] = loadManifest();

/**
 * Get asset path from manifest
 * @param string $type - 'css' or 'js'
 * @param string $name - Asset name without extension
 * @return string - Full path to asset
 */
function so_asset($type, $name)
{
    $manifest = $GLOBALS['manifest'] ?? [];
    $key = $name;

    // Get versioned filename from manifest
    $filename = $manifest[$type][$key] ?? null;

    if ($filename) {
        return SO_DIST_PATH . '/' . $filename;
    }

    // Fallback to non-versioned
    return SO_DIST_PATH . "/{$type}/{$name}.{$type}";
}

/**
 * Get page-specific asset path from manifest
 * @param string $page - Page name (e.g., 'search')
 * @param string $type - 'css' or 'js'
 * @return string|null - Full path to asset or null if not found
 */
function so_page_asset($page, $type)
{
    $manifest = $GLOBALS['manifest'] ?? [];

    // Get versioned filename from manifest pages section
    $filename = $manifest['pages'][$page][$type] ?? null;

    if ($filename) {
        return SO_DIST_PATH . '/' . $filename;
    }

    // Fallback to non-versioned path
    $fallbackPath = "/pages/{$page}/{$page}.{$type}";
    if (file_exists(PROJECT_ROOT . '/public/frontend/dist' . $fallbackPath)) {
        return SO_DIST_PATH . $fallbackPath;
    }

    return null;
}

/**
 * Load JSON data file
 * @param string $filename - File name without path
 * @return array - Parsed JSON data
 */
function load_data($filename)
{
    $path = PROJECT_ROOT . '/public/frontend/demos/data/' . $filename;
    if (file_exists($path)) {
        return json_decode(file_get_contents($path), true);
    }
    return [];
}

/**
 * Get current page name
 * @return string - Current page name without extension
 */
function get_current_page()
{
    return basename($_SERVER['PHP_SELF'], '.php');
}

/**
 * Get current page path relative to demo directory
 * @return string - Current page path (e.g., "ui-engine/navigation/collapse.php")
 */
function get_current_page_path()
{
    $path = $_SERVER['PHP_SELF'];
    // Extract path after /demo/
    if (preg_match('#/demo/(.+)$#', $path, $matches)) {
        return $matches[1];
    }
    return basename($path);
}

/**
 * Check if current page matches
 * @param string|array $pages - Page name(s) to check
 * @return bool - Whether current page matches
 */
function is_page($pages)
{
    $current = get_current_page();
    if (is_array($pages)) {
        return in_array($current, $pages);
    }
    return $current === $pages;
}

/**
 * Generate a single-language code block
 * @param string $code - The code to display (will be HTML escaped)
 * @param string $language - Language for syntax highlighting (html, css, javascript, php, etc.)
 * @return string - HTML for the code block
 */
function so_code_block($code, $language = 'html')
{
    $escaped = htmlspecialchars($code, ENT_QUOTES, 'UTF-8');
    $label = strtoupper($language);
    return <<<HTML
<div class="so-code-block">
    <div class="so-code-header">
        <span class="so-code-label"><span class="material-icons">code</span> {$label}</span>
        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
    </div>
    <pre class="so-code-content"><code class="language-{$language}">{$escaped}</code></pre>
</div>
HTML;
}

/**
 * Generate a tabbed code block with multiple languages
 * @param string $id - Unique ID for the tabs
 * @param array $tabs - Array of tabs: [['label' => 'HTML', 'language' => 'html', 'icon' => 'code', 'code' => '...'], ...]
 * @return string - HTML for the tabbed code block
 */
function so_code_tabs($id, $tabs)
{
    $tabButtons = '';
    $tabPanes = '';

    foreach ($tabs as $index => $tab) {
        $isActive = $index === 0 ? ' so-active' : '';
        $label = $tab['label'] ?? strtoupper($tab['language']);
        $icon = $tab['icon'] ?? ($tab['language'] === 'javascript' ? 'javascript' : 'code');
        $escaped = htmlspecialchars($tab['code'], ENT_QUOTES, 'UTF-8');
        // Use index to ensure unique IDs even when multiple tabs have the same language
        $paneId = "{$id}-tab-{$index}";

        $tabButtons .= <<<HTML
            <button class="so-code-tab{$isActive}" data-so-target="#{$paneId}">
                <span class="material-icons">{$icon}</span> {$label}
            </button>
HTML;

        $tabPanes .= <<<HTML
        <div class="so-code-pane{$isActive}" id="{$paneId}">
            <pre class="so-code-content"><code class="language-{$tab['language']}">{$escaped}</code></pre>
        </div>
HTML;
    }

    return <<<HTML
<div class="so-code-block so-code-block-tabbed">
    <div class="so-code-header">
        <div class="so-code-tabs">
{$tabButtons}
        </div>
        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
    </div>
    <div class="so-code-body">
{$tabPanes}
    </div>
</div>
HTML;
}

/**
 * Generate 3-tab UiEngine code block (PHP, JS, HTML)
 * Shorthand helper for UiEngine element demos
 * @param string $id - Unique ID for the tabs
 * @param string $phpCode - PHP code example
 * @param string $jsCode - JavaScript code example
 * @param string $htmlOutput - HTML output example
 * @return string - HTML for the tabbed code block
 */
function so_uiengine_code($id, $phpCode, $jsCode, $htmlOutput)
{
    return so_code_tabs($id, [
        ['label' => 'PHP', 'language' => 'php', 'icon' => 'data_object', 'code' => $phpCode],
        ['label' => 'JavaScript', 'language' => 'javascript', 'icon' => 'javascript', 'code' => $jsCode],
        ['label' => 'HTML Output', 'language' => 'html', 'icon' => 'code', 'code' => $htmlOutput]
    ]);
}

/**
 * Generate 3-tab code block with JS, PHP, HTML (alternative parameter order)
 * Alias for so_uiengine_code with different parameter order
 * @param string $id - Unique ID for the tabs
 * @param string $jsCode - JavaScript code example
 * @param string $phpCode - PHP code example
 * @param string $htmlOutput - HTML output example
 * @return string - HTML for the tabbed code block
 */
function so_code_tabs_multi($id, $jsCode, $phpCode, $htmlOutput)
{
    return so_code_tabs($id, [
        ['label' => 'JavaScript', 'language' => 'javascript', 'icon' => 'javascript', 'code' => $jsCode],
        ['label' => 'PHP', 'language' => 'php', 'icon' => 'data_object', 'code' => $phpCode],
        ['label' => 'HTML Output', 'language' => 'html', 'icon' => 'code', 'code' => $htmlOutput]
    ]);
}

/**
 * Generate SixOrbit tabs component
 * Uses the built-in SOTabs JavaScript component for consistent tab behavior
 * @param string $id - Unique ID for the tab group
 * @param array $tabs - Array of tabs: [['id' => 'tab-id', 'label' => 'Tab Label', 'icon' => 'icon_name', 'active' => true, 'content' => '...'], ...]
 * @return string - HTML for the tabs
 */
function so_tabs($id, $tabs)
{
    $tabButtons = '';
    $tabPanes = '';

    foreach ($tabs as $index => $tab) {
        $isActive = ($tab['active'] ?? false);
        $activeClass = $isActive ? ' so-active' : '';
        $showClass = $isActive ? ' so-show so-active' : '';
        $ariaSelected = $isActive ? 'true' : 'false';
        $label = $tab['label'] ?? 'Tab ' . ($index + 1);
        $icon = $tab['icon'] ?? null;
        $tabId = $tab['id'] ?? "{$id}-{$index}";
        $content = $tab['content'] ?? '';

        // Tab button
        $iconHtml = $icon ? "<span class=\"material-icons\">{$icon}</span> " : '';
        $tabButtons .= "<button class=\"so-tab{$activeClass}\" role=\"tab\" data-so-target=\"#{$tabId}\" aria-selected=\"{$ariaSelected}\" aria-controls=\"{$tabId}\">{$iconHtml}{$label}</button>\n";

        // Tab pane
        $tabPanes .= "<div class=\"so-tab-pane so-fade{$showClass}\" id=\"{$tabId}\" role=\"tabpanel\">\n{$content}\n</div>\n";
    }

    return <<<HTML
<div class="so-tabs" role="tablist" data-so-tabs>
{$tabButtons}</div>
<div class="so-tab-content">
{$tabPanes}</div>
HTML;
}

/**
 * Generate a callout/alert box
 * @param string $type - Callout type (info, warning, danger, success)
 * @param string $message - Message content (can include HTML)
 * @return string - HTML for the callout
 */
function callout($type = 'info', $message = '')
{
    $typeClass = 'so-alert-' . $type;
    $icons = [
        'info' => 'info',
        'warning' => 'warning',
        'danger' => 'error',
        'success' => 'check_circle'
    ];
    $icon = $icons[$type] ?? 'info';

    return <<<HTML
<div class="so-alert {$typeClass} so-mb-4">
    <span class="material-icons so-alert-icon">{$icon}</span>
    <div class="so-alert-content">{$message}</div>
</div>
HTML;
}

/**
 * Generate random demo data
 * @param string $type - Type of data (name, email, amount, etc.)
 * @return string - Random value
 */
function demo_random($type = 'name')
{
    $names = ['Ajay Kumar', 'Priya Sharma', 'Rahul Singh', 'Meera Patel', 'Vikash Gupta'];
    $companies = ['Tech Solutions', 'Global Traders', 'Sunrise Exports', 'Metro Industries'];

    switch ($type) {
        case 'name':
            return $names[array_rand($names)];
        case 'company':
            return $companies[array_rand($companies)];
        case 'amount':
            return number_format(rand(1000, 100000), 2);
        case 'date':
            return date('d M Y', strtotime('-' . rand(0, 30) . ' days'));
        default:
            return '';
    }
}
