<?php

namespace Core\View;

/**
 * Debug helper for view rendering
 *
 * Provides debugging tools for templates including:
 * - Render stack tracking
 * - Variable dumping
 * - Detailed error pages
 */
class ViewDebugger
{
    /**
     * Whether debugging is enabled
     */
    protected bool $enabled;

    /**
     * Stack of templates being rendered
     * @var array<array{name: string, path: string, start: float}>
     */
    protected array $renderStack = [];

    /**
     * Render timing data
     * @var array<array{name: string, duration: float}>
     */
    protected array $renderTimings = [];

    /**
     * Create a new ViewDebugger instance
     *
     * @param bool $enabled Whether debugging is enabled
     */
    public function __construct(bool $enabled = false)
    {
        $this->enabled = $enabled;
    }

    /**
     * Enable debug mode
     *
     * @return void
     */
    public function enable(): void
    {
        $this->enabled = true;
    }

    /**
     * Disable debug mode
     *
     * @return void
     */
    public function disable(): void
    {
        $this->enabled = false;
    }

    /**
     * Check if debugging is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Push a template onto the render stack
     *
     * @param string $name Template name
     * @param string $path Template path
     * @return void
     */
    public function pushTemplate(string $name, string $path): void
    {
        $this->renderStack[] = [
            'name' => $name,
            'path' => $path,
            'start' => microtime(true),
        ];
    }

    /**
     * Pop a template from the render stack
     *
     * @return array|null
     */
    public function popTemplate(): ?array
    {
        $template = array_pop($this->renderStack);

        if ($template) {
            $template['duration'] = microtime(true) - $template['start'];
            $this->renderTimings[] = $template;
        }

        return $template;
    }

    /**
     * Get current template being rendered
     *
     * @return array|null
     */
    public function currentTemplate(): ?array
    {
        return end($this->renderStack) ?: null;
    }

    /**
     * Get the full render stack
     *
     * @return array
     */
    public function getRenderStack(): array
    {
        return $this->renderStack;
    }

    /**
     * Get render timings
     *
     * @return array
     */
    public function getTimings(): array
    {
        return $this->renderTimings;
    }

    /**
     * Dump variables available in current view context
     *
     * @param array $data Variables to dump (use get_defined_vars())
     * @return string HTML output
     */
    public function dumpVariables(array $data): string
    {
        if (!$this->enabled) {
            return '';
        }

        $html = '<div class="view-debug" style="background:#f8f9fa;border:1px solid #dee2e6;padding:15px;margin:10px 0;font-family:monospace;font-size:12px;border-radius:4px;">';
        $html .= '<strong style="color:#495057;">View Variables:</strong>';
        $html .= '<pre style="margin:10px 0;max-height:300px;overflow:auto;">';

        foreach ($data as $key => $value) {
            // Skip internal variables
            if (in_array($key, ['view', '__slot', '__props', '__data'])) {
                continue;
            }

            $html .= '<span style="color:#0066cc;">$' . htmlspecialchars($key) . '</span>: ';
            $html .= '<span style="color:#28a745;">' . htmlspecialchars($this->formatValue($value)) . '</span>' . "\n";
        }

        $html .= '</pre></div>';

        return $html;
    }

    /**
     * Format a value for display
     *
     * @param mixed $value
     * @return string
     */
    protected function formatValue(mixed $value): string
    {
        if (is_null($value)) {
            return 'null';
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_string($value)) {
            $truncated = strlen($value) > 100 ? substr($value, 0, 100) . '...' : $value;
            return '"' . $truncated . '"';
        }

        if (is_array($value)) {
            return 'array(' . count($value) . ')';
        }

        if (is_object($value)) {
            return get_class($value);
        }

        if (is_numeric($value)) {
            return (string) $value;
        }

        return gettype($value);
    }

    /**
     * Render a detailed error page for view exceptions
     *
     * @param ViewException $e
     * @return string HTML error page
     */
    public function renderException(ViewException $e): string
    {
        $templatePath = $e->getTemplatePath();
        $templateLine = $e->getTemplateLine();
        $templateName = $e->getTemplateName();
        $data = $e->getViewData();

        // Read template source for context
        $sourceLines = file_exists($templatePath) ? file($templatePath) : [];
        $contextStart = max(0, $templateLine - 5);
        $contextEnd = min(count($sourceLines), $templateLine + 5);

        $html = '<!DOCTYPE html><html><head><title>View Error</title>';
        $html .= '<style>
            body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
            .error-container { max-width: 1200px; margin: 0 auto; }
            .error-header { background: #dc3545; color: white; padding: 20px; border-radius: 8px 8px 0 0; }
            .error-header h1 { margin: 0 0 10px; font-size: 24px; }
            .error-header p { margin: 0; opacity: 0.9; }
            .error-body { background: white; padding: 20px; border-radius: 0 0 8px 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
            .error-meta { margin-bottom: 20px; }
            .error-meta p { margin: 5px 0; color: #495057; }
            .error-meta strong { color: #212529; }
            .source-code { background: #282c34; color: #abb2bf; padding: 15px; border-radius: 4px; overflow-x: auto; font-family: "Fira Code", monospace; font-size: 13px; }
            .source-line { display: block; padding: 2px 0; }
            .source-line.error { background: #5c1a1a; color: #ff6b6b; }
            .line-number { color: #636d83; margin-right: 15px; user-select: none; display: inline-block; width: 30px; text-align: right; }
            .variables { margin-top: 20px; }
            .variables h3 { margin: 0 0 10px; color: #333; font-size: 16px; }
            .var-table { width: 100%; border-collapse: collapse; font-size: 13px; }
            .var-table th, .var-table td { padding: 8px 12px; text-align: left; border-bottom: 1px solid #eee; }
            .var-table th { background: #f8f9fa; font-weight: 600; }
            .var-name { font-family: monospace; color: #0066cc; }
            .var-type { font-family: monospace; color: #666; font-size: 11px; }
            .stack-trace { margin-top: 20px; }
            .stack-trace h3 { margin: 0 0 10px; color: #333; font-size: 16px; }
            .stack-trace pre { background: #f8f9fa; padding: 15px; border-radius: 4px; overflow: auto; font-size: 11px; max-height: 300px; }
        </style></head><body>';

        $html .= '<div class="error-container">';
        $html .= '<div class="error-header">';
        $html .= '<h1>View Error</h1>';
        $html .= '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
        $html .= '</div>';

        $html .= '<div class="error-body">';
        $html .= '<div class="error-meta">';
        $html .= '<p><strong>Template:</strong> ' . htmlspecialchars($templateName) . '</p>';
        $html .= '<p><strong>File:</strong> ' . htmlspecialchars($templatePath) . '</p>';
        if ($templateLine > 0) {
            $html .= '<p><strong>Line:</strong> ' . $templateLine . '</p>';
        }
        $html .= '</div>';

        // Source code context
        if (!empty($sourceLines) && $templateLine > 0) {
            $html .= '<div class="source-code">';
            for ($i = $contextStart; $i < $contextEnd; $i++) {
                $lineNum = $i + 1;
                $isError = $lineNum === $templateLine;
                $class = $isError ? 'source-line error' : 'source-line';
                $html .= '<span class="' . $class . '">';
                $html .= '<span class="line-number">' . $lineNum . '</span>';
                $html .= htmlspecialchars(rtrim($sourceLines[$i] ?? ''));
                $html .= '</span>';
            }
            $html .= '</div>';
        }

        // Variables available in view
        if (!empty($data)) {
            $html .= '<div class="variables">';
            $html .= '<h3>View Variables</h3>';
            $html .= '<table class="var-table">';
            $html .= '<tr><th>Variable</th><th>Type</th><th>Value</th></tr>';

            foreach ($data as $key => $value) {
                if (in_array($key, ['view', '__slot', '__props'])) {
                    continue;
                }

                $html .= '<tr>';
                $html .= '<td class="var-name">$' . htmlspecialchars($key) . '</td>';
                $html .= '<td class="var-type">' . gettype($value) . '</td>';
                $html .= '<td>' . htmlspecialchars($this->formatValue($value)) . '</td>';
                $html .= '</tr>';
            }

            $html .= '</table></div>';
        }

        // Stack trace
        $html .= '<div class="stack-trace">';
        $html .= '<h3>Stack Trace</h3>';
        $html .= '<pre>';
        $html .= htmlspecialchars($e->getPrevious() ? $e->getPrevious()->getTraceAsString() : $e->getTraceAsString());
        $html .= '</pre></div>';

        $html .= '</div></div></body></html>';

        return $html;
    }

    /**
     * Clear all debug data
     *
     * @return void
     */
    public function clear(): void
    {
        $this->renderStack = [];
        $this->renderTimings = [];
    }
}
