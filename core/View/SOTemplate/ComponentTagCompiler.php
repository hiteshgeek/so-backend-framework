<?php

namespace Core\View\SOTemplate;

/**
 * Component Tag Compiler
 *
 * Compiles <x-component> tag syntax into PHP component calls.
 * Handles props, slots, and dynamic attributes.
 */
class ComponentTagCompiler
{
    /**
     * Component namespace aliases
     */
    protected array $aliases = [];

    /**
     * Register a component alias
     */
    public function alias(string $alias, string $component): void
    {
        $this->aliases[$alias] = $component;
    }

    /**
     * Compile all component tags in content
     */
    public function compile(string $content): string
    {
        // Compile self-closing tags first
        $content = $this->compileSelfClosingTags($content);

        // Compile opening/closing tag pairs
        $content = $this->compileOpeningClosingTags($content);

        // Compile dynamic components
        $content = $this->compileDynamicComponents($content);

        return $content;
    }

    /**
     * Compile self-closing component tags: <x-name />
     */
    protected function compileSelfClosingTags(string $content): string
    {
        $pattern = '/<x-(?<name>[a-zA-Z0-9\-_:\.]+)(?<attributes>[^>]*?)\/>/s';

        return preg_replace_callback($pattern, function ($matches) {
            $name = $this->resolveComponentName($matches['name']);
            $attributesPHP = $this->compileAttributes(trim($matches['attributes']));

            return "<?php echo \$__view->component('{$name}', {$attributesPHP}); ?>";
        }, $content);
    }

    /**
     * Compile opening/closing tag pairs: <x-name>...</x-name>
     */
    protected function compileOpeningClosingTags(string $content): string
    {
        // Match component with content
        $pattern = '/<x-(?<name>[a-zA-Z0-9\-_:\.]+)(?<attributes>[^>]*)>(?<content>.*?)<\/x-\k<name>>/s';

        return preg_replace_callback($pattern, function ($matches) {
            $name = $this->resolveComponentName($matches['name']);
            $attributesPHP = $this->compileAttributes(trim($matches['attributes']));
            $innerContent = $matches['content'];

            // Parse named slots from content
            $slots = $this->parseSlots($innerContent);

            if (empty($slots['named'])) {
                // No named slots, just default slot
                $slotContent = $this->escapePhpInSlot($slots['default']);
                return "<?php echo \$__view->component('{$name}', {$attributesPHP}, \$__view->compileSlotContent(function() { ?>$slotContent<?php })); ?>";
            }

            // Has named slots
            $php = "<?php \$__slots = []; ?>";

            // Compile each named slot
            foreach ($slots['named'] as $slotName => $slotContent) {
                $escapedContent = $this->escapePhpInSlot($slotContent);
                $php .= "<?php \$__slots['{$slotName}'] = \$__view->compileSlotContent(function() { ?>$escapedContent<?php }); ?>";
            }

            // Default slot
            $defaultContent = $this->escapePhpInSlot($slots['default']);
            $php .= "<?php echo \$__view->component('{$name}', {$attributesPHP}, \$__view->compileSlotContent(function() { ?>$defaultContent<?php }), \$__slots); ?>";

            return $php;
        }, $content);
    }

    /**
     * Compile dynamic components: <x-dynamic-component :component="$name" />
     */
    protected function compileDynamicComponents(string $content): string
    {
        $pattern = '/<x-dynamic-component\s+:component="([^"]+)"([^>]*?)(?:\/>|>(.*?)<\/x-dynamic-component>)/s';

        return preg_replace_callback($pattern, function ($matches) {
            $componentExpr = $matches[1];
            $attributesPHP = $this->compileAttributes(trim($matches[2] ?? ''));
            $innerContent = $matches[3] ?? '';

            if (empty($innerContent)) {
                return "<?php echo \$__view->component({$componentExpr}, {$attributesPHP}); ?>";
            }

            $escapedContent = $this->escapePhpInSlot($innerContent);
            return "<?php echo \$__view->component({$componentExpr}, {$attributesPHP}, \$__view->compileSlotContent(function() { ?>$escapedContent<?php })); ?>";
        }, $content);
    }

    /**
     * Parse named slots from component content
     */
    protected function parseSlots(string $content): array
    {
        $slots = [
            'default' => '',
            'named' => [],
        ];

        // Match <x-slot:name> or <x-slot name="name">
        $pattern = '/<x-slot(?::(?<name1>\w+)|(?:\s+name="(?<name2>\w+)"))(?<attrs>[^>]*)>(?<content>.*?)<\/x-slot>/s';

        // Extract named slots
        $content = preg_replace_callback($pattern, function ($matches) use (&$slots) {
            $slotName = $matches['name1'] ?: $matches['name2'];
            $slots['named'][$slotName] = trim($matches['content']);
            return ''; // Remove from default content
        }, $content);

        // Remaining content is default slot
        $slots['default'] = trim($content);

        return $slots;
    }

    /**
     * Compile attribute string to PHP array
     */
    protected function compileAttributes(string $attributeString): string
    {
        if (empty($attributeString)) {
            return '[]';
        }

        $attributes = [];

        // Match different attribute patterns
        $patterns = [
            // Dynamic: :name="expression" or v-bind:name="expression"
            '/:(\w+(?:-\w+)*)="([^"]*)"/' => function ($m) {
                return ["'{$m[1]}' => {$m[2]}"];
            },
            // Wire/Alpine prefixed: wire:click="method" x-on:click="method"
            '/(\w+:\w+(?:-\w+)*)="([^"]*)"/' => function ($m) {
                return ["'{$m[1]}' => '{$m[2]}'"];
            },
            // Regular: name="value"
            '/(\w+(?:-\w+)*)="([^"]*)"/' => function ($m) {
                return ["'{$m[1]}' => '{$m[2]}'"];
            },
            // Boolean: disabled, required
            '/\s(\w+)(?=\s|$|\/?>)/' => function ($m) {
                return ["'{$m[1]}' => true"];
            },
        ];

        foreach ($patterns as $pattern => $handler) {
            preg_match_all($pattern, $attributeString, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $result = $handler($match);
                $attributes = array_merge($attributes, $result);
            }
        }

        return '[' . implode(', ', array_unique($attributes)) . ']';
    }

    /**
     * Resolve component name (handle aliases and namespaces)
     */
    protected function resolveComponentName(string $name): string
    {
        // Check aliases first
        if (isset($this->aliases[$name])) {
            return $this->aliases[$name];
        }

        // Convert namespace separator (::)
        $name = str_replace('::', '.', $name);

        // Convert kebab-case to dot notation
        $name = str_replace('-', '.', $name);

        return $name;
    }

    /**
     * Escape PHP code in slot content for safe embedding
     */
    protected function escapePhpInSlot(string $content): string
    {
        // Keep the content as-is since it may contain Blade/SOTemplate syntax
        // that will be compiled by the main compiler
        return $content;
    }
}
