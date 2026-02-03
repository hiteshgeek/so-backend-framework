<?php

namespace Core\View\SOTemplate;

use Core\View\View;
use Core\View\ViewException;
use Core\View\LoopHelper;
use Throwable;

/**
 * SOTemplate Engine
 *
 * Main engine class that orchestrates template compilation, caching,
 * and rendering. Integrates with the View class for template management.
 */
class SOTemplateEngine
{
    /**
     * The template compiler
     */
    protected SOTemplateCompiler $compiler;

    /**
     * The component tag compiler
     */
    protected ComponentTagCompiler $tagCompiler;

    /**
     * The compiled view cache
     */
    protected CompiledViewCache $cache;

    /**
     * Base path for views
     */
    protected string $viewPath;

    /**
     * Template file extension
     */
    protected string $extension = '.sot.php';

    /**
     * The View instance for rendering
     */
    protected ?View $view = null;

    /**
     * Loop stack for nested loops
     */
    protected array $loopStack = [];

    /**
     * Component stack for nested components
     */
    protected array $componentStack = [];

    /**
     * Section content storage
     */
    protected array $sections = [];

    /**
     * Section stack for nesting
     */
    protected array $sectionStack = [];

    /**
     * Current layout being extended
     */
    protected ?string $currentLayout = null;

    /**
     * Layout data
     */
    protected array $layoutData = [];

    /**
     * Stack storage (push/prepend)
     */
    protected array $stacks = [];

    /**
     * Pushed once keys
     */
    protected array $pushedOnce = [];

    /**
     * Create a new engine instance
     */
    public function __construct(
        string $viewPath,
        string $cachePath,
        bool $autoReload = false,
        string $extension = '.sot.php'
    ) {
        $this->viewPath = rtrim($viewPath, '/');
        $this->extension = $extension;
        $this->compiler = new SOTemplateCompiler();
        $this->tagCompiler = new ComponentTagCompiler();
        $this->cache = new CompiledViewCache($cachePath, $autoReload);
    }

    /**
     * Set the View instance
     */
    public function setView(View $view): void
    {
        $this->view = $view;
    }

    /**
     * Get the compiler instance
     */
    public function getCompiler(): SOTemplateCompiler
    {
        return $this->compiler;
    }

    /**
     * Get the cache instance
     */
    public function getCache(): CompiledViewCache
    {
        return $this->cache;
    }

    /**
     * Register a custom directive
     */
    public function directive(string $name, callable $handler): void
    {
        $this->compiler->directive($name, $handler);
    }

    /**
     * Render a template
     */
    public function render(string $template, array $data = []): string
    {
        $templatePath = $this->resolvePath($template);

        if (!file_exists($templatePath)) {
            throw new ViewException("Template not found: {$template} ({$templatePath})");
        }

        // Reset state for new render
        $this->currentLayout = null;
        $this->layoutData = [];

        // Compile and render
        $compiledPath = $this->compileIfNeeded($templatePath);
        $content = $this->evaluate($compiledPath, $data);

        // If extending a layout, render the layout with sections
        if ($this->currentLayout !== null) {
            $layoutPath = $this->resolvePath($this->currentLayout);
            $layoutCompiledPath = $this->compileIfNeeded($layoutPath);

            // Merge layout data with sections for layout rendering
            $layoutRenderData = array_merge($data, $this->layoutData, [
                '__sections' => $this->sections,
            ]);

            $content = $this->evaluate($layoutCompiledPath, $layoutRenderData);
        }

        return $content;
    }

    /**
     * Compile template if needed
     */
    protected function compileIfNeeded(string $templatePath): string
    {
        $compiledPath = $this->cache->getCompiledPath($templatePath);

        if ($this->cache->isExpired($templatePath, $compiledPath)) {
            $content = file_get_contents($templatePath);

            // Compile component tags first
            $content = $this->tagCompiler->compile($content);

            // Then compile directives
            $compiled = $this->compiler->compile($content);

            $this->cache->put($compiledPath, $compiled);
        }

        return $compiledPath;
    }

    /**
     * Evaluate a compiled template
     */
    protected function evaluate(string $compiledPath, array $data): string
    {
        // Make the engine available as $__view
        $data['__view'] = $this;

        // Extract data to local scope
        extract($data, EXTR_SKIP);

        ob_start();

        try {
            include $compiledPath;
        } catch (Throwable $e) {
            ob_end_clean();
            throw ViewException::fromException($e, $compiledPath);
        }

        return ob_get_clean();
    }

    /**
     * Resolve template name to file path
     */
    protected function resolvePath(string $template): string
    {
        // Convert dot notation to path
        $path = str_replace('.', '/', $template);

        // Try SOTemplate extension first
        $sotPath = $this->viewPath . '/' . $path . $this->extension;
        if (file_exists($sotPath)) {
            return $sotPath;
        }

        // Fall back to .php
        $phpPath = $this->viewPath . '/' . $path . '.php';
        if (file_exists($phpPath)) {
            return $phpPath;
        }

        return $sotPath; // Return expected path for error message
    }

    /**
     * Check if a template exists
     */
    public function exists(string $template): bool
    {
        $path = str_replace('.', '/', $template);
        return file_exists($this->viewPath . '/' . $path . $this->extension)
            || file_exists($this->viewPath . '/' . $path . '.php');
    }

    // ========== Layout Methods ==========

    /**
     * Extend a layout
     */
    public function extends(string $layout, array $data = []): void
    {
        $this->currentLayout = $layout;
        $this->layoutData = $data;
    }

    /**
     * Start a section
     */
    public function startSection(string $name, ?string $content = null): void
    {
        if ($content !== null) {
            $this->sections[$name] = $content;
            return;
        }

        $this->sectionStack[] = $name;
        ob_start();
    }

    /**
     * End the current section
     */
    public function endSection(): void
    {
        if (empty($this->sectionStack)) {
            throw new ViewException('Cannot end section without starting one');
        }

        $name = array_pop($this->sectionStack);
        $this->sections[$name] = ob_get_clean();
    }

    /**
     * Yield a section
     */
    public function yield(string $name, string $default = ''): string
    {
        return $this->sections[$name] ?? $default;
    }

    /**
     * Yield the current section and end it
     */
    public function yieldSection(): string
    {
        if (empty($this->sectionStack)) {
            return '';
        }

        $this->endSection();
        return $this->yield(end($this->sectionStack));
    }

    /**
     * Get parent content placeholder
     */
    public function parentPlaceholder(): string
    {
        return '@parent';
    }

    // ========== Include Methods ==========

    /**
     * Include a partial template
     */
    public function include(string $template, array $data = []): string
    {
        return $this->render($template, $data);
    }

    /**
     * Include when condition is true
     */
    public function includeWhen(bool $condition, string $template, array $data = []): string
    {
        if (!$condition) {
            return '';
        }

        return $this->render($template, $data);
    }

    /**
     * Include first existing template
     */
    public function includeFirst(array $templates, array $data = []): string
    {
        foreach ($templates as $template) {
            if ($this->exists($template)) {
                return $this->render($template, $data);
            }
        }

        throw new ViewException('None of the templates exist: ' . implode(', ', $templates));
    }

    // ========== Component Methods ==========

    /**
     * Render a component
     */
    public function component(string $name, array $props = [], mixed $slot = '', array $slots = []): string
    {
        // Delegate to View's ComponentManager if available
        if ($this->view !== null) {
            return $this->view->component($name, $props, $slot, $slots);
        }

        // Fallback: render component template directly
        $templatePath = $this->resolvePath('components.' . $name);

        if (!file_exists($templatePath)) {
            throw new ViewException("Component not found: {$name}");
        }

        // Create ComponentSlot for the slot
        $slotObject = new \Core\View\ComponentSlot($slot, $slots);

        // Build component data
        $data = array_merge($props, [
            '__slot' => $slotObject,
            '__props' => $props,
        ]);

        // Create attributes bag from non-prop attributes
        if (!isset($data['attributes'])) {
            $data['attributes'] = new ComponentAttributes([]);
        }

        return $this->render('components.' . $name, $data);
    }

    /**
     * Start a component
     */
    public function startComponent(string $name, array $props = []): void
    {
        $this->componentStack[] = [
            'name' => $name,
            'props' => $props,
            'slots' => [],
            'currentSlot' => null,
        ];

        ob_start();
    }

    /**
     * Render the current component
     */
    public function renderComponent(): string
    {
        if (empty($this->componentStack)) {
            throw new ViewException('Cannot render component without starting one');
        }

        $defaultSlot = ob_get_clean();
        $component = array_pop($this->componentStack);

        return $this->component(
            $component['name'],
            $component['props'],
            $defaultSlot,
            $component['slots']
        );
    }

    /**
     * Start a slot
     */
    public function slot(string $name): void
    {
        if (empty($this->componentStack)) {
            throw new ViewException('Cannot start slot outside of component');
        }

        // Store current buffer as previous slot or default content
        $current = &$this->componentStack[count($this->componentStack) - 1];
        $current['currentSlot'] = $name;

        ob_start();
    }

    /**
     * End the current slot
     */
    public function endSlot(): void
    {
        if (empty($this->componentStack)) {
            return;
        }

        $current = &$this->componentStack[count($this->componentStack) - 1];

        if ($current['currentSlot'] !== null) {
            $current['slots'][$current['currentSlot']] = ob_get_clean();
            $current['currentSlot'] = null;
        }
    }

    /**
     * Compile slot content from callback
     */
    public function compileSlotContent(callable $callback): string
    {
        ob_start();
        $callback();
        return ob_get_clean();
    }

    /**
     * Extract props and create attributes
     */
    public function extractProps(array $definedProps, array $allVars): array
    {
        $result = ComponentAttributes::fromProps($definedProps, $allVars);

        // Return extracted props merged with attributes for the view
        return array_merge($result['props'], [
            'attributes' => $result['attributes'],
        ]);
    }

    // ========== Loop Methods ==========

    /**
     * Add a loop to the stack
     */
    public function addLoop(iterable $data): void
    {
        $count = is_countable($data) ? count($data) : iterator_count($data);

        $loop = new LoopHelper($count, count($this->loopStack) + 1);

        if (!empty($this->loopStack)) {
            $loop->parent = end($this->loopStack);
        }

        $this->loopStack[] = $loop;
    }

    /**
     * Increment loop indices
     */
    public function incrementLoopIndices(): void
    {
        if (!empty($this->loopStack)) {
            $this->loopStack[count($this->loopStack) - 1]->increment();
        }
    }

    /**
     * Pop a loop from the stack
     */
    public function popLoop(): void
    {
        array_pop($this->loopStack);
    }

    /**
     * Get the last loop
     */
    public function getLastLoop(): ?LoopHelper
    {
        return empty($this->loopStack) ? null : end($this->loopStack);
    }

    // ========== Stack Methods ==========

    /**
     * Start pushing to a stack
     */
    public function startPush(string $name): void
    {
        $this->sectionStack[] = ['type' => 'push', 'name' => $name];
        ob_start();
    }

    /**
     * End pushing to stack
     */
    public function endPush(): void
    {
        if (empty($this->sectionStack)) {
            return;
        }

        $item = array_pop($this->sectionStack);
        $content = ob_get_clean();

        if (!isset($this->stacks[$item['name']])) {
            $this->stacks[$item['name']] = [];
        }

        if ($item['type'] === 'prepend') {
            array_unshift($this->stacks[$item['name']], $content);
        } else {
            $this->stacks[$item['name']][] = $content;
        }
    }

    /**
     * Start prepending to a stack
     */
    public function startPrepend(string $name): void
    {
        $this->sectionStack[] = ['type' => 'prepend', 'name' => $name];
        ob_start();
    }

    /**
     * Check if already pushed once
     */
    public function hasPushedOnce(string $name): bool
    {
        return isset($this->pushedOnce[$name]);
    }

    /**
     * Mark as pushed once
     */
    public function markPushedOnce(string $name): void
    {
        $this->pushedOnce[$name] = true;
    }

    /**
     * Render a stack
     */
    public function renderStack(string $name): string
    {
        if (!isset($this->stacks[$name])) {
            return '';
        }

        return implode('', $this->stacks[$name]);
    }

    /**
     * Clear all caches
     */
    public function clearCache(): int
    {
        return $this->cache->clear();
    }

    /**
     * Get cache statistics
     */
    public function getCacheStats(): array
    {
        return $this->cache->stats();
    }
}
