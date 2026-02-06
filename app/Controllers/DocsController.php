<?php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;

/**
 * Documentation Controller
 *
 * Serves framework documentation
 */
class DocsController
{
    /**
     * Show documentation index
     */
    public function index(Request $request): Response
    {
        return Response::view('docs/index', [
            'title' => 'Documentation - ' . config('app.name')
        ]);
    }

    /**
     * Get navigation data for a specific page
     *
     * @param string $currentKey Current page key
     * @return array{prevPage: array|null, nextPage: array|null}
     */
    private function getNavigation(string $currentKey): array
    {
        $navigation = require __DIR__ . '/../../config/docs-navigation.php';

        $currentIndex = null;
        foreach ($navigation as $index => $page) {
            if ($page['key'] === $currentKey) {
                $currentIndex = $index;
                break;
            }
        }

        if ($currentIndex === null) {
            return ['prevPage' => null, 'nextPage' => null];
        }

        $prevPage = isset($navigation[$currentIndex - 1])
            ? ['url' => $navigation[$currentIndex - 1]['url'], 'title' => $navigation[$currentIndex - 1]['title']]
            : null;

        $nextPage = isset($navigation[$currentIndex + 1])
            ? ['url' => $navigation[$currentIndex + 1]['url'], 'title' => $navigation[$currentIndex + 1]['title']]
            : null;

        return ['prevPage' => $prevPage, 'nextPage' => $nextPage];
    }

    /**
     * Show specific documentation file
     *
     * Checks for PHP view first, falls back to markdown parsing
     */
    public function show(Request $request, string $file): Response
    {
        $allowedFiles = [
            // Getting Started
            'setup' => 'SETUP.md',
            'configuration' => 'CONFIGURATION.md',
            'env-configuration' => 'ENV-CONFIGURATION.md',
            'quick-start' => 'QUICK-START.md',
            'readme' => 'README.md',
            'index' => 'INDEX.md',

            // Customization
            'rename' => 'RENAME-PROCESS.md',
            'branding' => 'FRAMEWORK-BRANDING.md',

            // Security & Validation
            'security-layer' => 'SECURITY-LAYER.md',
            'validation-system' => 'VALIDATION-SYSTEM.md',
            'error-reporter' => 'ERROR-REPORTER.md',
            'auth-lockout' => 'AUTH-LOCKOUT.md',

            // Enterprise Features
            'activity-logging' => 'ACTIVITY-LOGGING.md',
            'queue-system' => 'QUEUE-SYSTEM.md',
            'notification-system' => 'NOTIFICATION-SYSTEM.md',
            'cache-system' => 'CACHE-SYSTEM.md',
            'file-cache' => 'FILE-CACHE.md',
            'session-system' => 'SESSION-SYSTEM.md',
            'session-encryption' => 'SESSION-ENCRYPTION.md',
            'framework-features' => 'FRAMEWORK-FEATURES.md',

            // Technical Documentation
            'asset-management' => 'ASSET-MANAGEMENT.md',
            'auth-system' => 'AUTH-SYSTEM.md',
            'console-commands' => 'CONSOLE-COMMANDS.md',
            'profiler' => 'PROFILER.md',
            'view-templates' => 'VIEW-TEMPLATES.md',
            'routing-system' => 'ROUTING-SYSTEM.md',
            'project-structure' => 'PROJECT-STRUCTURE.md',

            // Testing & Quality Assurance
            'test-documentation' => 'TEST-DOCUMENTATION.md',
            'testing-guide' => 'TESTING-GUIDE.md',

            // Visual Guides
            'request-flow' => 'REQUEST-FLOW.md',

            // Development Guides
            'dev-first-page' => 'DEV-FIRST-PAGE.md',
            'dev-crud-module' => 'DEV-CRUD-MODULE.md',
            'dev-routes' => 'DEV-ROUTES.md',
            'dev-route-params' => 'DEV-ROUTE-PARAMS.md',
            'dev-web-controllers' => 'DEV-WEB-CONTROLLERS.md',
            'dev-api-controllers' => 'DEV-API-CONTROLLERS.md',
            'dev-forms-validation' => 'DEV-FORMS-VALIDATION.md',
            'dev-error-reporter' => 'DEV-ERROR-REPORTER.md',
            'dev-assets' => 'DEV-ASSETS.md',
            'dev-auth' => 'DEV-AUTH.md',
            'dev-security' => 'DEV-SECURITY.md',
            'dev-custom-middleware' => 'DEV-CUSTOM-MIDDLEWARE.md',
            'dev-models' => 'DEV-MODELS.md',
            'dev-model-advanced' => 'DEV-MODEL-ADVANCED.md',
            'dev-cli-commands' => 'DEV-CLI-COMMANDS.md',
            'dev-migrations' => 'DEV-MIGRATIONS.md',
            'dev-seeders' => 'DEV-SEEDERS.md',
            'dev-mail' => 'DEV-MAIL.md',
            'dev-queues' => 'DEV-QUEUES.md',
            'dev-events' => 'DEV-EVENTS.md',
            'dev-services-repositories' => 'DEV-SERVICES-REPOSITORIES.md',
            'dev-file-uploads' => 'DEV-FILE-UPLOADS.md',
            'dev-caching' => 'DEV-CACHING.md',
            'dev-pagination' => 'DEV-PAGINATION.md',
            'dev-logging' => 'DEV-LOGGING.md',
            'dev-api-auth' => 'DEV-API-AUTH.md',
            'dev-testing' => 'DEV-TESTING.md',
            'dev-error-handling' => 'DEV-ERROR-HANDLING.md',
            'dev-helpers' => 'DEV-HELPERS.md',
            'dev-localization' => 'DEV-LOCALIZATION.md',

            // API & Architecture
            'api-versioning' => 'API-VERSIONING.md',
            'service-layer' => 'SERVICE-LAYER.md',

            // Model Features
            'status-field-trait' => 'STATUS-FIELD-TRAIT.md',
            'timestamps-userstamps' => 'TIMESTAMPS-USERSTAMPS.md',
            'dev-timestamps' => 'DEV-TIMESTAMPS.md',

            // Security & Password
            'dev-password-migration' => 'DEV-PASSWORD-MIGRATION.md',

            // Test Documentation (from tests/ folder)
            'middleware' => '../../tests/MIDDLEWARE_IMPLEMENTATION_SUMMARY.md',
            'internal-api' => '../../tests/INTERNAL_API_LAYER_SUMMARY.md',
            'model-enhancements' => '../../tests/MODEL_ENHANCEMENTS_SUMMARY.md',

            // Comprehensive References
            'comprehensive-security' => 'COMPREHENSIVE-SECURITY.md',

            // Internationalization
            'localization' => 'LOCALIZATION.md',

            // Phase 6 Core Enhancements
            'core-enhancements' => 'CORE-ENHANCEMENTS.md',
            'dev-core-enhancements' => 'DEV-CORE-ENHANCEMENTS.md',

            // View System
            'view-components' => 'VIEW-COMPONENTS.md',
            'dev-view-components' => 'DEV-VIEW-COMPONENTS.md',
            'sotemplate' => 'SOTEMPLATE.md',
            'dev-sotemplate' => 'DEV-SOTEMPLATE.md',

            // UiEngine
            'ui-engine' => 'UI-ENGINE.md',
            'dev-ui-engine' => 'DEV-UI-ENGINE.md',
            'dev-ui-engine-forms' => 'DEV-UI-ENGINE-FORMS.md',
            'dev-ui-engine-layouts' => 'DEV-UI-ENGINE-LAYOUTS.md',
            'dev-ui-engine-tables' => 'DEV-UI-ENGINE-TABLES.md',
            'dev-ui-engine-elements' => 'DEV-UI-ENGINE-ELEMENTS.md',
            'dev-ui-engine-advanced' => 'DEV-UI-ENGINE-ADVANCED.md',

            // Database & Schema
            'schema-builder' => 'SCHEMA-BUILDER.md',
            'multi-database' => 'MULTI-DATABASE.md',
            'model-observers' => 'MODEL-OBSERVERS.md',

            // Security Additions
            'password-reset' => 'PASSWORD-RESET.md',
            'encrypter' => 'ENCRYPTER.md',

            // Enterprise Features
            'context-permissions' => 'CONTEXT-PERMISSIONS.md',

            // Internationalization (i18n)
            'pluralization' => 'PLURALIZATION.md',
            'rtl-support' => 'RTL-SUPPORT.md',
            'icu-messageformat' => 'ICU-MESSAGEFORMAT.md',
            'dev-locale-validation' => 'DEV-LOCALE-VALIDATION.md',
            'dev-translation-cli' => 'DEV-TRANSLATION-CLI.md',
            'dev-translation-commands' => 'DEV-TRANSLATION-COMMANDS.md',
            'dev-rtl-layouts' => 'DEV-RTL-LAYOUTS.md',

            // Media & Files
            'chunked-uploads' => 'CHUNKED-UPLOADS.md',
            'webp-conversion' => 'WEBP-CONVERSION.md',
            'video-processing' => 'VIDEO-PROCESSING.md',
            'cdn-integration' => 'CDN-INTEGRATION.md',
            'dev-chunked-uploads' => 'DEV-CHUNKED-UPLOADS.md',
            'dev-video-processing' => 'DEV-VIDEO-PROCESSING.md',
        ];

        if (!isset($allowedFiles[$file])) {
            return Response::view('errors/404', [], 404);
        }

        // Get navigation data
        $navigation = $this->getNavigation($file);

        // Check if a PHP view exists for this documentation
        $phpViewPath = __DIR__ . '/../../resources/views/docs/pages/' . $file . '.php';
        if (file_exists($phpViewPath)) {
            return Response::view('docs/pages/' . $file, array_merge([
                'title' => ucwords(str_replace('-', ' ', $file)) . ' - ' . config('app.name')
            ], $navigation));
        }

        // Fallback to markdown parsing
        $filename = $allowedFiles[$file];
        if (str_starts_with($filename, '../')) {
            $filePath = __DIR__ . '/../../docs/md/' . $filename;
        } else {
            $filePath = __DIR__ . '/../../docs/md/' . $filename;
        }
        $filePath = realpath($filePath) ?: $filePath;

        if (!file_exists($filePath)) {
            return Response::view('errors/404', [], 404);
        }

        $markdown = file_get_contents($filePath);
        $markdown = str_replace('{{APP_VERSION}}', config('app.version'), $markdown);

        return Response::view('docs/show', array_merge([
            'title' => ucwords(str_replace('-', ' ', $file)) . ' - ' . config('app.name'),
            'markdown' => $markdown,
            'filename' => $allowedFiles[$file]
        ], $navigation));
    }

    /**
     * Show nested documentation file (e.g., /docs/features/file-uploads)
     */
    public function showNested(Request $request, string $folder, string $file): Response
    {
        $allowedPaths = [
            'features/file-uploads' => 'features/file-uploads.md',
            'api/media-api' => 'api/media-api.md',
            'uiengine/html' => 'UIENGINE-HTML.md',
            'uiengine/image' => 'UIENGINE-IMAGE.md',
        ];

        $path = $folder . '/' . $file;

        if (!isset($allowedPaths[$path])) {
            return Response::view('errors/404', [], 404);
        }

        $fileType = $allowedPaths[$path];

        // Get navigation data using the combined path as key
        $navigationKey = str_replace('/', '-', $path);
        $navigation = $this->getNavigation($navigationKey);

        // Build file path for markdown
        $filePath = __DIR__ . '/../../docs/' . $fileType;
        $filePath = realpath($filePath) ?: $filePath;

        if (!file_exists($filePath)) {
            return Response::view('errors/404', [], 404);
        }

        $markdown = file_get_contents($filePath);
        $markdown = str_replace('{{APP_VERSION}}', config('app.version'), $markdown);

        return Response::view('docs/show', array_merge([
            'title' => ucwords(str_replace(['-', '/'], ' ', $path)) . ' - ' . config('app.name'),
            'markdown' => $markdown,
            'filename' => $fileType
        ], $navigation));
    }
}
