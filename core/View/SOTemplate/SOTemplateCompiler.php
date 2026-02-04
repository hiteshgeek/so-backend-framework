<?php

namespace Core\View\SOTemplate;

/**
 * SOTemplate Compiler
 *
 * Compiles SOTemplate (.sot.php) templates into optimized PHP code.
 * Supports Blade-like syntax with all common directives.
 */
class SOTemplateCompiler
{
    /**
     * Opening tag for raw output
     */
    protected string $rawOpenTag = '{!!';

    /**
     * Closing tag for raw output
     */
    protected string $rawCloseTag = '!!}';

    /**
     * Opening tag for escaped output
     */
    protected string $echoOpenTag = '{{';

    /**
     * Closing tag for escaped output
     */
    protected string $echoCloseTag = '}}';

    /**
     * Comment opening tag
     */
    protected string $commentOpenTag = '{{--';

    /**
     * Comment closing tag
     */
    protected string $commentCloseTag = '--}}';

    /**
     * Custom directive handlers
     */
    protected array $customDirectives = [];

    /**
     * Verbatim placeholder for escaped content
     */
    protected array $verbatimBlocks = [];

    /**
     * PHP blocks placeholder
     */
    protected array $phpBlocks = [];

    /**
     * Compile template content to PHP
     */
    public function compile(string $content): string
    {
        // Reset state
        $this->verbatimBlocks = [];
        $this->phpBlocks = [];

        // Extract and protect special blocks
        $content = $this->extractVerbatimBlocks($content);
        $content = $this->extractPhpBlocks($content);

        // Compile in order
        $content = $this->compileComments($content);
        $content = $this->compileEchos($content);
        $content = $this->compileDirectives($content);
        $content = $this->compileComponentTags($content);

        // Restore protected blocks
        $content = $this->restorePhpBlocks($content);
        $content = $this->restoreVerbatimBlocks($content);

        return $content;
    }

    /**
     * Register a custom directive
     */
    public function directive(string $name, callable $handler): void
    {
        $this->customDirectives[$name] = $handler;
    }

    /**
     * Extract @verbatim blocks
     */
    protected function extractVerbatimBlocks(string $content): string
    {
        return preg_replace_callback(
            '/@verbatim(.*?)@endverbatim/s',
            function ($matches) {
                $key = '__VERBATIM_' . count($this->verbatimBlocks) . '__';
                $this->verbatimBlocks[$key] = $matches[1];
                return $key;
            },
            $content
        );
    }

    /**
     * Restore @verbatim blocks
     */
    protected function restoreVerbatimBlocks(string $content): string
    {
        foreach ($this->verbatimBlocks as $key => $block) {
            $content = str_replace($key, $block, $content);
        }
        return $content;
    }

    /**
     * Extract @php blocks
     */
    protected function extractPhpBlocks(string $content): string
    {
        return preg_replace_callback(
            '/@php(.*?)@endphp/s',
            function ($matches) {
                $key = '__PHP_BLOCK_' . count($this->phpBlocks) . '__';
                $this->phpBlocks[$key] = '<?php ' . trim($matches[1]) . ' ?>';
                return $key;
            },
            $content
        );
    }

    /**
     * Restore @php blocks
     */
    protected function restorePhpBlocks(string $content): string
    {
        foreach ($this->phpBlocks as $key => $block) {
            $content = str_replace($key, $block, $content);
        }
        return $content;
    }

    /**
     * Compile comments {{-- --}}
     */
    protected function compileComments(string $content): string
    {
        return preg_replace(
            '/' . preg_quote($this->commentOpenTag, '/') . '.*?' . preg_quote($this->commentCloseTag, '/') . '/s',
            '',
            $content
        );
    }

    /**
     * Compile echo statements
     */
    protected function compileEchos(string $content): string
    {
        // Compile escaped echo {{ }} but not @{{ }}
        $content = preg_replace_callback(
            '/(?<!@)' . preg_quote($this->echoOpenTag, '/') . '\s*(.+?)\s*' . preg_quote($this->echoCloseTag, '/') . '/s',
            function ($matches) {
                return '<?php echo e(' . $matches[1] . '); ?>';
            },
            $content
        );

        // Compile raw echo {!! !!}
        $content = preg_replace_callback(
            '/' . preg_quote($this->rawOpenTag, '/') . '\s*(.+?)\s*' . preg_quote($this->rawCloseTag, '/') . '/s',
            function ($matches) {
                return '<?php echo ' . $matches[1] . '; ?>';
            },
            $content
        );

        // Handle escaped @{{ }} - just remove the @
        $content = str_replace('@{{', '{{', $content);

        return $content;
    }

    /**
     * Compile all directives
     */
    protected function compileDirectives(string $content): string
    {
        // Order matters: compile opening/closing pairs properly
        $directives = [
            // Control Flow
            'if' => fn($e) => "<?php if({$e}): ?>",
            'elseif' => fn($e) => "<?php elseif({$e}): ?>",
            'else' => fn() => '<?php else: ?>',
            'endif' => fn() => '<?php endif; ?>',
            'unless' => fn($e) => "<?php if(!({$e})): ?>",
            'endunless' => fn() => '<?php endif; ?>',

            // Conditionals
            'isset' => fn($e) => "<?php if(isset({$e})): ?>",
            'endisset' => fn() => '<?php endif; ?>',
            'empty' => fn($e) => "<?php if(empty({$e})): ?>",
            'endempty' => fn() => '<?php endif; ?>',

            // Switch
            'switch' => fn($e) => "<?php switch({$e}): ?>",
            'case' => fn($e) => "<?php case {$e}: ?>",
            'break' => fn() => '<?php break; ?>',
            'default' => fn() => '<?php default: ?>',
            'endswitch' => fn() => '<?php endswitch; ?>',

            // Loops - handled specially for $loop variable
            'foreach' => [$this, 'compileForeach'],
            'endforeach' => [$this, 'compileEndforeach'],
            'forelse' => [$this, 'compileForelse'],
            'empty_forelse' => [$this, 'compileEmptyForelse'], // Special handling for @empty in forelse
            'endforelse' => [$this, 'compileEndforelse'],
            'for' => fn($e) => "<?php for({$e}): ?>",
            'endfor' => fn() => '<?php endfor; ?>',
            'while' => fn($e) => "<?php while({$e}): ?>",
            'endwhile' => fn() => '<?php endwhile; ?>',
            'continue' => fn($e) => $e ? "<?php if({$e}) continue; ?>" : '<?php continue; ?>',

            // Auth
            'auth' => fn($e) => $e ? "<?php if(is_auth() && auth()->guard({$e})->check()): ?>" : '<?php if(is_auth()): ?>',
            'endauth' => fn() => '<?php endif; ?>',
            'guest' => fn($e) => $e ? "<?php if(is_guest() || !auth()->guard({$e})->check()): ?>" : '<?php if(is_guest()): ?>',
            'endguest' => fn() => '<?php endif; ?>',
            'can' => fn($e) => "<?php if(can({$e})): ?>",
            'cannot' => fn($e) => "<?php if(cannot({$e})): ?>",
            'endcan' => fn() => '<?php endif; ?>',
            'endcannot' => fn() => '<?php endif; ?>',

            // Layout
            'extends' => [$this, 'compileExtends'],
            'section' => [$this, 'compileSection'],
            'endsection' => fn() => '<?php $__view->endSection(); ?>',
            'show' => fn() => '<?php echo $__view->yieldSection(); ?>',
            'yield' => fn($e) => "<?php echo \$__view->yield({$e}); ?>",
            'parent' => fn() => '<?php echo $__view->parentPlaceholder(); ?>',
            'include' => fn($e) => "<?php echo \$__view->include({$e}); ?>",
            'includeIf' => fn($e) => "<?php if(\$__view->exists(explode(',', {$e})[0])) echo \$__view->include({$e}); ?>",
            'includeWhen' => [$this, 'compileIncludeWhen'],
            'includeFirst' => [$this, 'compileIncludeFirst'],

            // Components
            'component' => [$this, 'compileComponent'],
            'endcomponent' => fn() => '<?php echo $__view->renderComponent(); ?>',
            'slot' => [$this, 'compileSlot'],
            'endslot' => fn() => '<?php $__view->endSlot(); ?>',
            'props' => [$this, 'compileProps'],

            // Stacks
            'push' => fn($e) => "<?php \$__view->startPush({$e}); ?>",
            'endpush' => fn() => '<?php $__view->endPush(); ?>',
            'prepend' => fn($e) => "<?php \$__view->startPrepend({$e}); ?>",
            'endprepend' => fn() => '<?php $__view->endPrepend(); ?>',
            'pushOnce' => fn($e) => "<?php if(!\$__view->hasPushedOnce({$e})): \$__view->startPush({$e}); ?>",
            'endPushOnce' => fn() => '<?php $__view->endPush(); endif; ?>',
            'stack' => fn($e) => "<?php echo \$__view->renderStack({$e}); ?>",

            // Forms
            'csrf' => fn() => '<?php echo csrf_field(); ?>',
            'method' => fn($e) => "<?php echo method_field({$e}); ?>",
            'error' => [$this, 'compileError'],
            'enderror' => fn() => '<?php endif; ?>',

            // Form Attributes
            'checked' => fn($e) => "<?php if({$e}): ?> checked<?php endif; ?>",
            'selected' => fn($e) => "<?php if({$e}): ?> selected<?php endif; ?>",
            'disabled' => fn($e) => "<?php if({$e}): ?> disabled<?php endif; ?>",
            'readonly' => fn($e) => "<?php if({$e}): ?> readonly<?php endif; ?>",
            'required' => fn($e) => "<?php if({$e}): ?> required<?php endif; ?>",
            'class' => [$this, 'compileClass'],

            // Other
            'json' => [$this, 'compileJson'],
            'once' => fn() => '<?php if(!isset($__once)): $__once = true; ?>',
            'endonce' => fn() => '<?php endif; ?>',
            'env' => fn($e) => "<?php if(app()->environment({$e})): ?>",
            'endenv' => fn() => '<?php endif; ?>',
            'production' => fn() => "<?php if(app()->environment('production')): ?>",
            'endproduction' => fn() => '<?php endif; ?>',
            'dd' => fn($e) => "<?php dd({$e}); ?>",
            'dump' => fn($e) => "<?php dump({$e}); ?>",
        ];

        // Compile custom directives
        foreach ($this->customDirectives as $name => $handler) {
            $directives[$name] = $handler;
        }

        // Handle @empty specially (it's used in @forelse context)
        $content = preg_replace_callback(
            '/@empty(?!\s*\()/s',
            function () {
                return '<?php endforeach; if(empty($__forelseEmpty)): ?>';
            },
            $content
        );

        // Compile each directive
        foreach ($directives as $name => $handler) {
            if ($name === 'empty_forelse') continue; // Skip internal directive

            // Match @directive or @directive(expression)
            $pattern = '/@' . preg_quote($name, '/') . '(?:\s*\(((?:[^()]+|\((?:[^()]+|\([^()]*\))*\))*)\))?/s';

            $content = preg_replace_callback($pattern, function ($matches) use ($handler, $name) {
                $expression = $matches[1] ?? '';

                if (is_callable($handler)) {
                    return $handler($expression);
                }

                return '';
            }, $content);
        }

        return $content;
    }

    /**
     * Compile @foreach with $loop variable support
     */
    protected function compileForeach(string $expression): string
    {
        // Parse the foreach expression to extract the loop variable
        preg_match('/\s*(.+?)\s+as\s+(\$\w+)(?:\s*=>\s*(\$\w+))?/', $expression, $matches);

        $iteratee = $matches[1] ?? $expression;
        $key = isset($matches[3]) ? $matches[2] : null;
        $value = $matches[3] ?? $matches[2] ?? '$item';

        $php = '<?php ';
        $php .= '$__currentLoopData = ' . $iteratee . '; ';
        $php .= '$__view->addLoop($__currentLoopData); ';
        $php .= 'foreach($__currentLoopData as ' . ($key ? $key . ' => ' : '') . $value . '): ';
        $php .= '$__view->incrementLoopIndices(); ';
        $php .= '$loop = $__view->getLastLoop(); ';
        $php .= '?>';

        return $php;
    }

    /**
     * Compile @endforeach
     */
    protected function compileEndforeach(string $expression): string
    {
        return '<?php endforeach; $__view->popLoop(); $loop = $__view->getLastLoop(); ?>';
    }

    /**
     * Compile @forelse
     */
    protected function compileForelse(string $expression): string
    {
        preg_match('/\s*(.+?)\s+as\s+(\$\w+)(?:\s*=>\s*(\$\w+))?/', $expression, $matches);

        $iteratee = $matches[1] ?? $expression;
        $key = isset($matches[3]) ? $matches[2] : null;
        $value = $matches[3] ?? $matches[2] ?? '$item';

        $php = '<?php ';
        $php .= '$__currentLoopData = ' . $iteratee . '; ';
        $php .= '$__forelseEmpty = empty($__currentLoopData); ';
        $php .= 'if(!$__forelseEmpty): ';
        $php .= '$__view->addLoop($__currentLoopData); ';
        $php .= 'foreach($__currentLoopData as ' . ($key ? $key . ' => ' : '') . $value . '): ';
        $php .= '$__view->incrementLoopIndices(); ';
        $php .= '$loop = $__view->getLastLoop(); ';
        $php .= '?>';

        return $php;
    }

    /**
     * Compile @empty for forelse
     */
    protected function compileEmptyForelse(string $expression): string
    {
        return '<?php endforeach; $__view->popLoop(); endif; if($__forelseEmpty): ?>';
    }

    /**
     * Compile @endforelse
     */
    protected function compileEndforelse(string $expression): string
    {
        return '<?php endif; ?>';
    }

    /**
     * Compile @extends
     */
    protected function compileExtends(string $expression): string
    {
        return "<?php \$__view->extends({$expression}); ?>";
    }

    /**
     * Compile @section
     */
    protected function compileSection(string $expression): string
    {
        // Check if it's inline: @section('name', 'content')
        if (preg_match('/,/', $expression)) {
            return "<?php \$__view->startSection({$expression}); \$__view->endSection(); ?>";
        }

        return "<?php \$__view->startSection({$expression}); ?>";
    }

    /**
     * Compile @includeWhen
     */
    protected function compileIncludeWhen(string $expression): string
    {
        // @includeWhen($condition, 'view', $data)
        return "<?php echo \$__view->includeWhen({$expression}); ?>";
    }

    /**
     * Compile @includeFirst
     */
    protected function compileIncludeFirst(string $expression): string
    {
        return "<?php echo \$__view->includeFirst({$expression}); ?>";
    }

    /**
     * Compile @component
     */
    protected function compileComponent(string $expression): string
    {
        return "<?php \$__view->startComponent({$expression}); ?>";
    }

    /**
     * Compile @slot
     */
    protected function compileSlot(string $expression): string
    {
        return "<?php \$__view->slot({$expression}); ?>";
    }

    /**
     * Compile @props
     */
    protected function compileProps(string $expression): string
    {
        return "<?php \$__props = {$expression}; extract(\$__view->extractProps(\$__props, get_defined_vars())); ?>";
    }

    /**
     * Compile @error
     */
    protected function compileError(string $expression): string
    {
        $variable = trim($expression, "\"'");
        return "<?php if(isset(\$errors) && isset(\$errors[{$expression}])): \$message = \$errors[{$expression}]; ?>";
    }

    /**
     * Compile @class
     */
    protected function compileClass(string $expression): string
    {
        return "<?php echo 'class=\"' . \\Core\\Support\\Helpers::classList({$expression}) . '\"'; ?>";
    }

    /**
     * Compile @json
     */
    protected function compileJson(string $expression): string
    {
        // Support @json($data) and @json($data, JSON_PRETTY_PRINT)
        $parts = explode(',', $expression, 2);
        $data = trim($parts[0]);
        $flags = isset($parts[1]) ? trim($parts[1]) : 'JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT';

        return "<?php echo json_encode({$data}, {$flags}); ?>";
    }

    /**
     * Compile <x-component> tags
     */
    protected function compileComponentTags(string $content): string
    {
        // This is a simplified version - ComponentTagCompiler handles complex cases
        // Match self-closing: <x-component-name />
        $content = preg_replace_callback(
            '/<x-([a-zA-Z0-9\-_:\.]+)([^>]*?)\/>/s',
            function ($matches) {
                $name = $this->normalizeComponentName($matches[1]);
                $attributes = $this->parseComponentAttributes($matches[2]);
                return "<?php echo \$__view->component('{$name}', {$attributes}); ?>";
            },
            $content
        );

        // Match opening/closing: <x-component>...</x-component>
        // This is handled by ComponentTagCompiler for complex slot parsing
        // Basic implementation here for simple cases
        $content = preg_replace_callback(
            '/<x-([a-zA-Z0-9\-_:\.]+)([^>]*)>(.*?)<\/x-\1>/s',
            function ($matches) {
                $name = $this->normalizeComponentName($matches[1]);
                $attributes = $this->parseComponentAttributes($matches[2]);
                $slot = addslashes($matches[3]);
                return "<?php echo \$__view->component('{$name}', {$attributes}, \"{$slot}\"); ?>";
            },
            $content
        );

        return $content;
    }

    /**
     * Normalize component name (kebab-case to dot notation)
     */
    protected function normalizeComponentName(string $name): string
    {
        // Convert namespace separator
        $name = str_replace('::', '.', $name);
        // Convert hyphens to dots for path resolution
        return str_replace('-', '.', $name);
    }

    /**
     * Parse component attributes to PHP array
     */
    protected function parseComponentAttributes(string $attributeString): string
    {
        $attributes = [];

        // Match attribute patterns
        preg_match_all('/
            (?:
                :(\w+)="([^"]*)"         # Dynamic attribute :name="$var"
                |
                (\w+)="([^"]*)"          # Static attribute name="value"
                |
                (\w+)                     # Boolean attribute
            )
        /x', $attributeString, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            if (!empty($match[1])) {
                // Dynamic attribute
                $attributes[] = "'{$match[1]}' => {$match[2]}";
            } elseif (!empty($match[3])) {
                // Static attribute
                $attributes[] = "'{$match[3]}' => '{$match[4]}'";
            } elseif (!empty($match[5])) {
                // Boolean attribute
                $attributes[] = "'{$match[5]}' => true";
            }
        }

        return '[' . implode(', ', $attributes) . ']';
    }
}
