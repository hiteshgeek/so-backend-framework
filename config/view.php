<?php

/**
 * View/Template Configuration
 *
 * Configuration for the SOTemplate engine - a compiled template system
 * with Blade-like syntax for high-performance view rendering.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Array of paths where view templates are stored. The view system will
    | search these paths in order when resolving template names.
    |
    */
    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This is the path where compiled SOTemplate templates will be stored.
    | Compiled templates are cached PHP files for optimal performance.
    |
    */
    'compiled' => storage_path('views/compiled'),

    /*
    |--------------------------------------------------------------------------
    | Auto-Reload Templates
    |--------------------------------------------------------------------------
    |
    | When enabled, templates are automatically recompiled when the source
    | file changes. Should be enabled in development, disabled in production
    | for maximum performance.
    |
    */
    'auto_reload' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Template Extension
    |--------------------------------------------------------------------------
    |
    | The file extension for SOTemplate files. Templates with this extension
    | will be processed by the SOTemplate compiler. Regular .php templates
    | continue to work as plain PHP includes.
    |
    */
    'extension' => '.sot.php',

    /*
    |--------------------------------------------------------------------------
    | Component Configuration
    |--------------------------------------------------------------------------
    |
    | Configure component namespaces and paths for the component system.
    | Anonymous components are loaded from 'paths', class-based components
    | use the 'namespace' for autoloading.
    |
    */
    'components' => [
        // Namespace for class-based components
        'namespace' => 'App\\Components',

        // Paths for anonymous (file-based) components
        'paths' => [
            resource_path('views/components'),
        ],

        // Component aliases (e.g., 'btn' => 'button')
        'aliases' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the template cache behavior.
    |
    */
    'cache' => [
        // Enable/disable caching (should be true in production)
        'enabled' => true,

        // Cache driver: 'file' or 'opcache'
        'driver' => 'file',

        // Time-to-live for cached templates (0 = forever until cleared)
        'ttl' => 0,
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Directives
    |--------------------------------------------------------------------------
    |
    | Register custom directives for the SOTemplate compiler.
    | Each directive maps to a callable that receives the expression.
    |
    | Example:
    | 'datetime' => function($expression) {
    |     return "<?php echo date('Y-m-d H:i:s', strtotime($expression)); ?>";
    | }
    |
    */
    'directives' => [],

    /*
    |--------------------------------------------------------------------------
    | View Composers
    |--------------------------------------------------------------------------
    |
    | Automatically register view composers. Each key is a view pattern
    | (supports wildcards) and the value is the composer class.
    |
    | Example:
    | 'admin.*' => App\ViewComposers\AdminComposer::class,
    |
    */
    'composers' => [],

    /*
    |--------------------------------------------------------------------------
    | Shared Data
    |--------------------------------------------------------------------------
    |
    | Data that should be shared with all views. Use sparingly as this
    | data is available in every template.
    |
    */
    'shared' => [],
];
