<?php

namespace Core\View;

use Core\View\SOTemplate\ComponentAttributes;

/**
 * Manages UI components with props and slots
 *
 * Supports two types of components:
 * - Anonymous components: Simple PHP files in resources/views/components/
 * - Class-based components: PHP classes extending Core\View\Component
 *
 * Features:
 * - Props and slots
 * - $attributes bag for forwarding HTML attributes
 * - Named slots with <x-slot:name> syntax
 * - Dynamic components
 *
 * Usage:
 *   // Anonymous component
 *   $components->render('alert', ['type' => 'success'], 'Message');
 *
 *   // With named slots
 *   $components->render('card', ['title' => 'Users'], $body, ['footer' => $footer]);
 *
 *   // Class-based component
 *   $components->register('modal', \App\Components\Modal::class);
 *   $components->render('modal', ['size' => 'lg'], $content);
 *
 *   // With attributes forwarding
 *   $components->render('button', ['type' => 'submit', 'class' => 'btn-lg', 'wire:click' => 'save'], 'Submit');
 */
class ComponentManager
{
    /**
     * Path to anonymous component files
     */
    protected string $componentsPath;

    /**
     * Reference to View instance for rendering
     */
    protected View $view;

    /**
     * Registered class-based components
     * @var array<string, string>
     */
    protected array $classComponents = [];

    /**
     * Component aliases
     * @var array<string, string>
     */
    protected array $aliases = [];

    /**
     * Create a new ComponentManager instance
     *
     * @param View $view View instance
     * @param string $componentsPath Path to anonymous components directory
     */
    public function __construct(View $view, string $componentsPath)
    {
        $this->view = $view;
        $this->componentsPath = rtrim($componentsPath, '/\\');
    }

    /**
     * Register a class-based component
     *
     * @param string $name Component name
     * @param string $className Fully qualified class name
     * @return void
     */
    public function register(string $name, string $className): void
    {
        $this->classComponents[$name] = $className;
    }

    /**
     * Register an alias for a component
     *
     * @param string $alias Alias name
     * @param string $name Original component name
     * @return void
     */
    public function alias(string $alias, string $name): void
    {
        $this->aliases[$alias] = $name;
    }

    /**
     * Render a component
     *
     * @param string $name Component name (e.g., 'button', 'card', 'form.input')
     * @param array $props Component properties
     * @param string|callable|null $slot Default slot content
     * @param array $slots Named slots ['header' => '...', 'footer' => '...']
     * @return string Rendered HTML
     */
    public function render(string $name, array $props = [], string|callable|null $slot = null, array $slots = []): string
    {
        // Resolve alias
        $name = $this->aliases[$name] ?? $name;

        // Check for class-based component first
        if (isset($this->classComponents[$name])) {
            return $this->renderClassComponent($name, $props, $slot, $slots);
        }

        // Fall back to anonymous component (file-based)
        return $this->renderAnonymousComponent($name, $props, $slot, $slots);
    }

    /**
     * Render a class-based component
     *
     * @param string $name Component name
     * @param array $props Properties
     * @param string|callable|null $slot Default slot
     * @param array $slots Named slots
     * @return string
     */
    protected function renderClassComponent(string $name, array $props, $slot, array $slots): string
    {
        $className = $this->classComponents[$name];

        if (!class_exists($className)) {
            throw new \RuntimeException("Component class not found: {$className}");
        }

        /** @var Component $component */
        $component = new $className($props);

        // Pass slots to component
        $component->setSlot($slot);
        $component->setSlots($slots);

        return $component->render();
    }

    /**
     * Render a class-based component with explicit attributes separation
     *
     * @param string $name Component name
     * @param array $props Properties (defined props)
     * @param array $attributes Extra attributes
     * @param string|callable|null $slot Default slot
     * @param array $slots Named slots
     * @return string
     */
    protected function renderClassComponentWithAttributes(
        string $name,
        array $props,
        array $attributes,
        $slot,
        array $slots
    ): string {
        $className = $this->classComponents[$name];

        if (!class_exists($className)) {
            throw new \RuntimeException("Component class not found: {$className}");
        }

        /** @var Component $component */
        $component = new $className($props, $attributes);

        // Pass slots to component
        $component->setSlot($slot);
        $component->setSlots($slots);

        return $component->render();
    }

    /**
     * Render an anonymous (file-based) component
     *
     * @param string $name Component name
     * @param array $props Properties
     * @param string|callable|null $slot Default slot
     * @param array $slots Named slots
     * @return string
     */
    protected function renderAnonymousComponent(string $name, array $props, $slot, array $slots): string
    {
        $path = $this->resolveComponentPath($name);

        if (!file_exists($path)) {
            throw new \RuntimeException("Component not found: {$name} (looked in {$path})");
        }

        // Prepare slot helper
        $__slot = new ComponentSlot($slot, $slots);

        // Create default attributes bag
        $attributes = new ComponentAttributes([]);
        $__props = $props;

        // Extract props and make available in component
        extract($props);
        $view = $this->view;

        ob_start();
        try {
            require $path;
            return ob_get_clean();
        } catch (\Throwable $e) {
            ob_end_clean();
            throw new \RuntimeException(
                "Error rendering component '{$name}': " . $e->getMessage(),
                0,
                $e
            );
        }
    }

    /**
     * Render an anonymous component with props/attributes separation
     *
     * This is used when @props directive is present in the component template.
     *
     * @param string $name Component name
     * @param array $definedProps Defined prop names from @props
     * @param array $allData All passed data (props + attributes)
     * @param string|callable|null $slot Default slot
     * @param array $slots Named slots
     * @return string
     */
    public function renderAnonymousWithProps(
        string $name,
        array $definedProps,
        array $allData,
        $slot,
        array $slots
    ): string {
        $path = $this->resolveComponentPath($name);

        if (!file_exists($path)) {
            throw new \RuntimeException("Component not found: {$name} (looked in {$path})");
        }

        // Separate props from attributes using ComponentAttributes
        $extracted = ComponentAttributes::fromProps($definedProps, $allData);

        // Prepare slot helper
        $__slot = new ComponentSlot($slot, $slots);

        // Make attributes available
        $attributes = $extracted['attributes'];
        $__props = $extracted['props'];

        // Extract props and make available in component
        extract($extracted['props']);
        $view = $this->view;

        ob_start();
        try {
            require $path;
            return ob_get_clean();
        } catch (\Throwable $e) {
            ob_end_clean();
            throw new \RuntimeException(
                "Error rendering component '{$name}': " . $e->getMessage(),
                0,
                $e
            );
        }
    }

    /**
     * Resolve component path from name
     *
     * 'button' => components/button.php or components/button.sot.php
     * 'form.input' => components/form/input.php
     *
     * @param string $name Component name
     * @return string Full path
     */
    protected function resolveComponentPath(string $name): string
    {
        $name = str_replace('.', DIRECTORY_SEPARATOR, $name);
        $basePath = $this->componentsPath . DIRECTORY_SEPARATOR . $name;

        // Check for SOTemplate file first
        $sotPath = $basePath . '.sot.php';
        if (file_exists($sotPath)) {
            return $sotPath;
        }

        // Fall back to regular PHP file
        return $basePath . '.php';
    }

    /**
     * Check if a component exists
     *
     * @param string $name Component name
     * @return bool
     */
    public function exists(string $name): bool
    {
        // Resolve alias
        $name = $this->aliases[$name] ?? $name;

        // Check class-based components
        if (isset($this->classComponents[$name])) {
            return class_exists($this->classComponents[$name]);
        }

        // Check anonymous components (both .sot.php and .php)
        $baseName = str_replace('.', DIRECTORY_SEPARATOR, $name);
        $basePath = $this->componentsPath . DIRECTORY_SEPARATOR . $baseName;

        return file_exists($basePath . '.sot.php') || file_exists($basePath . '.php');
    }

    /**
     * Get all registered class-based components
     *
     * @return array
     */
    public function getRegistered(): array
    {
        return $this->classComponents;
    }

    /**
     * Get the components path
     *
     * @return string
     */
    public function getComponentsPath(): string
    {
        return $this->componentsPath;
    }
}
