<?php

namespace Core\Support;

/**
 * Asset Manager
 *
 * Manages static asset registration, ordering, and rendering.
 * Provides URL generation with cache busting and CDN support,
 * file-based asset registration with position and priority,
 * and named content stacks for inline CSS/JS.
 *
 * Usage:
 *   // Register assets
 *   assets()->css('css/app.css');                        // head, priority 50
 *   assets()->js('js/app.js');                           // body_end, priority 50
 *   assets()->cdn('https://cdn.example.com/lib.css');    // head, priority 10
 *
 *   // Generate URL
 *   asset('css/app.css')  →  /assets/css/app.css?v=1706620800
 *
 *   // Render in layout
 *   <?= render_assets('head') ?>
 *   <?= render_assets('body_end') ?>
 *
 *   // Push/render custom stacks
 *   push_stack('styles', '<style>.foo{}</style>');
 *   <?= render_stack('styles') ?>
 */
class AssetManager
{
    /**
     * Registered asset files keyed by position ('head' or 'body_end')
     */
    protected array $assets = [];

    /**
     * Named stacks of raw content
     */
    protected array $stacks = [];

    /**
     * Track items that have been pushed once (prevents duplicates)
     */
    protected array $pushedOnce = [];

    /**
     * Base URL for assets (CDN or empty for local)
     */
    protected string $assetBaseUrl;

    /**
     * Whether to append cache-busting version query strings
     */
    protected bool $versioning;

    /**
     * Temporary context for startPush/endPush
     */
    protected ?array $pushContext = null;

    public function __construct(string $assetBaseUrl = '', bool $versioning = true)
    {
        $this->assetBaseUrl = rtrim($assetBaseUrl, '/');
        $this->versioning = $versioning;
    }

    // =========================================
    // Asset URL Generation
    // =========================================

    /**
     * Generate a URL to a public asset with optional cache busting.
     *
     * @param string $path Relative path within public/assets/ (e.g., 'css/base.css')
     * @param bool|null $version Override versioning for this call
     * @return string Full URL like '/assets/css/base.css?v=1706620800'
     */
    public function url(string $path, ?bool $version = null): string
    {
        $path = ltrim($path, '/');

        // External URLs pass through unchanged
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Use CDN base URL if set, otherwise app URL
        $base = $this->assetBaseUrl ?: rtrim(config('app.url', ''), '/');
        $url = $base . '/assets/' . $path;

        // Cache busting via file modification time
        $shouldVersion = $version ?? $this->versioning;
        if ($shouldVersion) {
            $filePath = public_path('assets/' . $path);
            if (file_exists($filePath)) {
                $url .= '?v=' . filemtime($filePath);
            }
        }

        return $url;
    }

    // =========================================
    // Asset Registration (CSS/JS files)
    // =========================================

    /**
     * Register a CSS file.
     *
     * @param string $path       Asset path relative to public/assets/
     * @param string $position   'head' (default) or 'body_end'
     * @param int    $priority   Lower = loaded first (default 50)
     * @param array  $attributes Extra HTML attributes (e.g., ['media' => 'print'])
     */
    public function css(string $path, string $position = 'head', int $priority = 50, array $attributes = []): void
    {
        $this->assets[$position][] = [
            'type'       => 'css',
            'path'       => $path,
            'priority'   => $priority,
            'attributes' => $attributes,
        ];
    }

    /**
     * Register a JS file.
     *
     * @param string $path       Asset path relative to public/assets/
     * @param string $position   'body_end' (default) or 'head'
     * @param int    $priority   Lower = loaded first (default 50)
     * @param array  $attributes Extra attributes (e.g., ['defer' => true, 'async' => true])
     */
    public function js(string $path, string $position = 'body_end', int $priority = 50, array $attributes = []): void
    {
        $this->assets[$position][] = [
            'type'       => 'js',
            'path'       => $path,
            'priority'   => $priority,
            'attributes' => $attributes,
        ];
    }

    /**
     * Register an external CDN asset (full URL, no versioning).
     *
     * @param string $url       Full CDN URL
     * @param string $type      'css' or 'js'
     * @param string $position  'head' (default) or 'body_end'
     * @param int    $priority  Lower = loaded first (default 10)
     * @param array  $attributes Extra HTML attributes
     */
    public function cdn(string $url, string $type = 'css', string $position = 'head', int $priority = 10, array $attributes = []): void
    {
        $this->assets[$position][] = [
            'type'       => $type,
            'path'       => $url,
            'external'   => true,
            'priority'   => $priority,
            'attributes' => $attributes,
        ];
    }

    /**
     * Render all registered assets for a given position as HTML tags.
     *
     * @param string $position 'head' or 'body_end'
     * @return string HTML output
     */
    public function renderAssets(string $position): string
    {
        if (empty($this->assets[$position])) {
            return '';
        }

        // Sort by priority (lower number = earlier in output)
        $items = $this->assets[$position];
        usort($items, fn($a, $b) => $a['priority'] <=> $b['priority']);

        $html = '';
        foreach ($items as $item) {
            $isExternal = !empty($item['external']);
            $url = $isExternal ? $item['path'] : $this->url($item['path']);
            $attrs = $this->buildAttributes($item['attributes'] ?? []);

            if ($item['type'] === 'css') {
                $html .= '    <link href="' . e($url) . '" rel="stylesheet"' . $attrs . '>' . "\n";
            } else {
                $html .= '    <script src="' . e($url) . '"' . $attrs . '></script>' . "\n";
            }
        }

        return $html;
    }

    // =========================================
    // Named Stacks (push/render pattern)
    // =========================================

    /**
     * Push raw content onto a named stack.
     *
     * @param string $name     Stack name (e.g., 'styles', 'scripts')
     * @param string $content  Raw HTML/CSS/JS content
     * @param int    $priority Lower = rendered first (default 50)
     */
    public function push(string $name, string $content, int $priority = 50): void
    {
        $this->stacks[$name][] = [
            'content'  => $content,
            'priority' => $priority,
        ];
    }

    /**
     * Start capturing output to push onto a stack.
     * Must be paired with endPush().
     */
    public function startPush(string $name, int $priority = 50): void
    {
        ob_start();
        $this->pushContext = ['name' => $name, 'priority' => $priority];
    }

    /**
     * End capturing and push the buffered content onto the stack.
     */
    public function endPush(): void
    {
        $content = ob_get_clean();
        if ($this->pushContext !== null) {
            // Check if this is a pushOnce operation
            if (!empty($this->pushContext['once'])) {
                $this->pushOnce(
                    $this->pushContext['name'],
                    $content,
                    $this->pushContext['key'] ?? null,
                    $this->pushContext['priority']
                );
            } elseif (!empty($this->pushContext['prepend'])) {
                $this->prepend(
                    $this->pushContext['name'],
                    $content,
                    $this->pushContext['priority']
                );
            } else {
                $this->push($this->pushContext['name'], $content, $this->pushContext['priority']);
            }
            $this->pushContext = null;
        }
    }

    /**
     * Push content onto a stack only once (prevents duplicates).
     *
     * Useful for partials or components that may be included multiple times
     * but should only add their dependencies once.
     *
     * @param string $name Stack name
     * @param string $content Content to push
     * @param string|null $key Unique identifier (defaults to md5 of content)
     * @param int $priority Priority (lower = first)
     */
    public function pushOnce(string $name, string $content, ?string $key = null, int $priority = 50): void
    {
        $key = $key ?? md5($content);
        $stackKey = $name . ':' . $key;

        if (isset($this->pushedOnce[$stackKey])) {
            return;
        }

        $this->pushedOnce[$stackKey] = true;
        $this->push($name, $content, $priority);
    }

    /**
     * Start capturing content for pushOnce.
     *
     * @param string $name Stack name
     * @param string|null $key Unique identifier
     * @param int $priority Priority
     */
    public function startPushOnce(string $name, ?string $key = null, int $priority = 50): void
    {
        ob_start();
        $this->pushContext = [
            'name' => $name,
            'priority' => $priority,
            'once' => true,
            'key' => $key,
        ];
    }

    /**
     * Prepend content to a stack (appears before existing items).
     *
     * Uses a negative priority by default to appear before normal pushes.
     *
     * @param string $name Stack name
     * @param string $content Content to prepend
     * @param int $priority Priority (default -50 to appear before normal pushes)
     */
    public function prepend(string $name, string $content, int $priority = -50): void
    {
        $this->push($name, $content, $priority);
    }

    /**
     * Start capturing content to prepend.
     *
     * @param string $name Stack name
     * @param int $priority Priority (default -50)
     */
    public function startPrepend(string $name, int $priority = -50): void
    {
        ob_start();
        $this->pushContext = [
            'name' => $name,
            'priority' => $priority,
            'prepend' => true,
        ];
    }

    /**
     * Check if content has been pushed once with a specific key.
     *
     * @param string $name Stack name
     * @param string $key Unique key
     * @return bool
     */
    public function hasPushedOnce(string $name, string $key): bool
    {
        return isset($this->pushedOnce[$name . ':' . $key]);
    }

    /**
     * Clear the once-pushed tracking (useful for testing).
     */
    public function clearOnce(): void
    {
        $this->pushedOnce = [];
    }

    /**
     * Render all content from a named stack.
     *
     * @param string $name Stack name
     * @return string Concatenated content sorted by priority
     */
    public function renderStack(string $name): string
    {
        if (empty($this->stacks[$name])) {
            return '';
        }

        $items = $this->stacks[$name];
        usort($items, fn($a, $b) => $a['priority'] <=> $b['priority']);

        $output = '';
        foreach ($items as $item) {
            $output .= $item['content'] . "\n";
        }

        return $output;
    }

    /**
     * Check if a stack has any content.
     */
    public function hasStack(string $name): bool
    {
        return !empty($this->stacks[$name]);
    }

    // =========================================
    // Internal Helpers
    // =========================================

    /**
     * Build HTML attribute string from key-value pairs.
     */
    protected function buildAttributes(array $attributes): string
    {
        $html = '';
        foreach ($attributes as $key => $value) {
            if ($value === true) {
                $html .= ' ' . e($key);
            } elseif ($value !== false && $value !== null) {
                $html .= ' ' . e($key) . '="' . e($value) . '"';
            }
        }
        return $html;
    }

    /**
     * Reset all registered assets and stacks.
     */
    public function flush(): void
    {
        $this->assets = [];
        $this->stacks = [];
        $this->pushedOnce = [];
    }
}
