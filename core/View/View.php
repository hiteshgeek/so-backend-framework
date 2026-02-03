<?php

namespace Core\View;

use Core\View\SOTemplate\SOTemplateEngine;
use Core\View\SOTemplate\ComponentAttributes;

/**
 * View Service with PHP Templates and SOTemplate Engine
 *
 * Provides template rendering with native PHP templates and SOTemplate (.sot.php) supporting:
 * - Template inheritance (extends/sections/yield)
 * - View composers (auto-inject data)
 * - Components with props and slots
 * - SOTemplate compilation and caching
 * - Debug mode with detailed error reporting
 */
class View
{
    protected string $viewsPath;
    protected array $shared = [];
    protected array $sections = [];
    protected array $sectionStack = [];
    protected ?string $currentLayout = null;
    protected array $layoutData = [];

    /**
     * Component manager instance
     */
    protected ?ComponentManager $components = null;

    /**
     * Composer manager instance
     */
    protected ?ViewComposerManager $composers = null;

    /**
     * Debugger instance
     */
    protected ?ViewDebugger $debugger = null;

    /**
     * SOTemplate engine instance
     */
    protected ?SOTemplateEngine $sotEngine = null;

    /**
     * Loop stack for nested loops
     */
    protected array $loopStack = [];

    /**
     * Stack storage (push/prepend)
     */
    protected array $stacks = [];

    /**
     * Pushed once keys
     */
    protected array $pushedOnce = [];

    public function __construct(string $viewsPath)
    {
        $this->viewsPath = rtrim($viewsPath, '/\\');
    }

    /**
     * Set the SOTemplate engine
     */
    public function setSOTemplateEngine(SOTemplateEngine $engine): void
    {
        $this->sotEngine = $engine;
        $this->sotEngine->setView($this);
    }

    /**
     * Get the SOTemplate engine
     */
    public function getSOTemplateEngine(): ?SOTemplateEngine
    {
        return $this->sotEngine;
    }

    /**
     * Set the component manager
     *
     * @param ComponentManager $manager
     * @return void
     */
    public function setComponentManager(ComponentManager $manager): void
    {
        $this->components = $manager;
    }

    /**
     * Get the component manager
     *
     * @return ComponentManager|null
     */
    public function getComponentManager(): ?ComponentManager
    {
        return $this->components;
    }

    /**
     * Set the composer manager
     *
     * @param ViewComposerManager $manager
     * @return void
     */
    public function setComposerManager(ViewComposerManager $manager): void
    {
        $this->composers = $manager;
    }

    /**
     * Get the composer manager
     *
     * @return ViewComposerManager|null
     */
    public function getComposerManager(): ?ViewComposerManager
    {
        return $this->composers;
    }

    /**
     * Set the debugger
     *
     * @param ViewDebugger $debugger
     * @return void
     */
    public function setDebugger(ViewDebugger $debugger): void
    {
        $this->debugger = $debugger;
    }

    /**
     * Get the debugger
     *
     * @return ViewDebugger|null
     */
    public function getDebugger(): ?ViewDebugger
    {
        return $this->debugger;
    }

    /**
     * Render a template with layout inheritance support
     *
     * @param string $template Template name (dot notation supported)
     * @param array $data Data to pass to the template
     * @return string Rendered content
     */
    public function render(string $template, array $data = []): string
    {
        // Check for .sot.php file first
        $sotPath = $this->resolveSOTemplatePath($template);

        if ($sotPath !== null && $this->sotEngine !== null) {
            // Use SOTemplate engine for .sot.php files
            $data = array_merge($this->shared, $data);

            // Apply view composers
            if ($this->composers) {
                $data = $this->composers->compose($template, $data);
            }

            return $this->sotEngine->render($template, $data);
        }

        // Fall back to standard PHP template
        $viewPath = $this->resolveViewPath($template);

        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View not found: {$template}");
        }

        // Merge shared data with view data (view data takes precedence)
        $data = array_merge($this->shared, $data);

        // Apply view composers
        if ($this->composers) {
            $data = $this->composers->compose($template, $data);
        }

        // Reset layout state for this render
        $this->currentLayout = null;
        $this->sections = [];
        $this->sectionStack = [];

        // Render the child view (it may call extends() to set a layout)
        $content = $this->renderViewFile($viewPath, $data, $template);

        // If child called extends(), render the layout with sections
        if ($this->currentLayout !== null) {
            $layoutPath = $this->resolveViewPath($this->currentLayout);
            if (!file_exists($layoutPath)) {
                throw new \RuntimeException("Layout not found: {$this->currentLayout}");
            }

            // Store child body content as 'content' section if not defined
            if (!isset($this->sections['content'])) {
                $this->sections['content'] = $content;
            }

            // Apply composers to layout too
            $layoutData = array_merge($data, $this->layoutData);
            if ($this->composers) {
                $layoutData = $this->composers->compose($this->currentLayout, $layoutData);
            }

            $content = $this->renderViewFile($layoutPath, $layoutData, $this->currentLayout);
        }

        return $content;
    }

    /**
     * Resolve SOTemplate path (.sot.php)
     *
     * @param string $template Template name
     * @return string|null Path if exists, null otherwise
     */
    protected function resolveSOTemplatePath(string $template): ?string
    {
        $template = str_replace('.', DIRECTORY_SEPARATOR, $template);
        $sotPath = $this->viewsPath . DIRECTORY_SEPARATOR . $template . '.sot.php';

        return file_exists($sotPath) ? $sotPath : null;
    }

    /**
     * Render a PHP view file and capture output
     *
     * @param string $viewPath Full path to view file
     * @param array $data Data to extract into view scope
     * @param string $templateName Template name for debugging
     * @return string Rendered content
     */
    protected function renderViewFile(string $viewPath, array $data, string $templateName = ''): string
    {
        // Track template for debugging
        if ($this->debugger && $this->debugger->isEnabled()) {
            $this->debugger->pushTemplate($templateName, $viewPath);
        }

        extract($data);

        // Make $view available in templates for calling section/yield/extends
        $view = $this;

        ob_start();
        try {
            require $viewPath;
            $content = ob_get_clean();

            if ($this->debugger && $this->debugger->isEnabled()) {
                $this->debugger->popTemplate();
            }

            return $content;
        } catch (\Throwable $e) {
            ob_end_clean();

            if ($this->debugger && $this->debugger->isEnabled()) {
                $this->debugger->popTemplate();
            }

            // Wrap in ViewException with template context
            $viewException = ViewException::fromException($e, $viewPath, $templateName, $data);

            // In debug mode, render detailed error page
            if (config('app.debug', false) && $this->debugger) {
                echo $this->debugger->renderException($viewException);
                exit(1);
            }

            throw $viewException;
        }
    }

    /**
     * Set the layout this view extends
     *
     * Call from a child view: $view->extends('layouts.app')
     */
    public function extends(string $layout, array $data = []): void
    {
        $this->currentLayout = $layout;
        $this->layoutData = $data;
    }

    /**
     * Start a named section
     *
     * Call from a child view: $view->section('title')
     */
    public function section(string $name): void
    {
        $this->sectionStack[] = $name;
        ob_start();
    }

    /**
     * End the current section
     */
    public function endSection(): void
    {
        if (empty($this->sectionStack)) {
            throw new \RuntimeException('Cannot end a section without starting one.');
        }

        $name = array_pop($this->sectionStack);
        $this->sections[$name] = ob_get_clean();
    }

    /**
     * Yield a section's content in a layout
     *
     * Call from layout: <?= $view->yield('title', 'Default Title') ?>
     */
    public function yield(string $name, string $default = ''): string
    {
        return $this->sections[$name] ?? $default;
    }

    /**
     * Include a partial view
     *
     * Call from any view: <?php $view->include('partials.nav', ['active' => 'home']) ?>
     */
    public function include(string $template, array $data = []): void
    {
        $viewPath = $this->resolveViewPath($template);

        if (!file_exists($viewPath)) {
            throw new \RuntimeException("Partial not found: {$template}");
        }

        $data = array_merge($this->shared, $data);

        // Apply composers to partials too
        if ($this->composers) {
            $data = $this->composers->compose($template, $data);
        }

        $data['view'] = $this;
        extract($data);

        require $viewPath;
    }

    /**
     * Render a component
     *
     * @param string $name Component name
     * @param array $props Component properties
     * @param string|callable|null $slot Default slot content
     * @param array $slots Named slots
     * @return string Rendered HTML
     */
    public function component(string $name, array $props = [], string|callable|null $slot = null, array $slots = []): string
    {
        if (!$this->components) {
            throw new \RuntimeException('Component manager not configured. Register view.components in bootstrap.');
        }

        return $this->components->render($name, $props, $slot, $slots);
    }

    /**
     * Loop iterator helper - provides $loop variable with iteration info
     *
     * Usage:
     *   <?php foreach ($view->each($items) as $item => $loop): ?>
     *       <?= $loop->iteration ?>. <?= $item ?>
     *   <?php endforeach; ?>
     *
     * @param iterable $items Items to iterate
     * @return \Generator
     */
    public function each(iterable $items): \Generator
    {
        return loop($items);
    }

    /**
     * Resolve a dot-notation template name to a file path
     */
    protected function resolveViewPath(string $template): string
    {
        $template = str_replace('.', DIRECTORY_SEPARATOR, $template);
        return $this->viewsPath . DIRECTORY_SEPARATOR . $template . '.php';
    }

    /**
     * Add a global variable to all templates
     *
     * @param string $name Variable name
     * @param mixed $value Variable value
     * @return void
     */
    public function share(string $name, mixed $value): void
    {
        $this->shared[$name] = $value;
    }

    /**
     * Add multiple shared variables
     *
     * @param array $data Array of key-value pairs
     * @return void
     */
    public function shareMany(array $data): void
    {
        $this->shared = array_merge($this->shared, $data);
    }

    /**
     * Check if a view exists
     *
     * @param string $template Template name
     * @return bool
     */
    public function exists(string $template): bool
    {
        $template = str_replace('.', DIRECTORY_SEPARATOR, $template);
        $viewPath = $this->viewsPath . DIRECTORY_SEPARATOR . $template . '.php';

        return file_exists($viewPath);
    }

    /**
     * Get the views path
     *
     * @return string
     */
    public function getViewsPath(): string
    {
        return $this->viewsPath;
    }

    /**
     * Register a view composer
     *
     * Shortcut for: app('view.composers')->composer(...)
     *
     * @param string|array $views View pattern(s)
     * @param callable|string $composer Composer callback or class
     * @return void
     */
    public function composer(string|array $views, callable|string $composer): void
    {
        if (!$this->composers) {
            throw new \RuntimeException('Composer manager not configured. Register view.composers in bootstrap.');
        }

        $this->composers->composer($views, $composer);
    }

    // ========== Loop Helper Methods for SOTemplate ==========

    /**
     * Add a loop to the stack
     */
    public function addLoop(iterable $data): void
    {
        $count = is_countable($data) ? count($data) : iterator_count($data);
        $depth = count($this->loopStack) + 1;

        $loop = new LoopHelper($count, $depth);

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

    // ========== Stack Methods for SOTemplate ==========

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

    // ========== Section Methods for SOTemplate ==========

    /**
     * Start a section (alias for section())
     */
    public function startSection(string $name, ?string $content = null): void
    {
        if ($content !== null) {
            $this->sections[$name] = $content;
            return;
        }

        $this->section($name);
    }

    /**
     * Yield the current section
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

    // ========== Include Methods for SOTemplate ==========

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

        throw new \RuntimeException('None of the templates exist: ' . implode(', ', $templates));
    }

    // ========== Component Methods for SOTemplate ==========

    /**
     * Start a component
     */
    protected array $componentStack = [];

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
            throw new \RuntimeException('Cannot render component without starting one');
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
            throw new \RuntimeException('Cannot start slot outside of component');
        }

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
     * Extract props and create attributes bag
     */
    public function extractProps(array $definedProps, array $allVars): array
    {
        $result = ComponentAttributes::fromProps($definedProps, $allVars);

        return array_merge($result['props'], [
            'attributes' => $result['attributes'],
        ]);
    }

    /**
     * Clear view cache
     */
    public function clearCache(): int
    {
        if ($this->sotEngine) {
            return $this->sotEngine->clearCache();
        }
        return 0;
    }

    /**
     * Get cache statistics
     */
    public function getCacheStats(): array
    {
        if ($this->sotEngine) {
            return $this->sotEngine->getCacheStats();
        }
        return [];
    }
}
