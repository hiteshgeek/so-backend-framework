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
            $this->push($this->pushContext['name'], $content, $this->pushContext['priority']);
            $this->pushContext = null;
        }
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
    }
}
