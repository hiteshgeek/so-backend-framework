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
     * Show comprehensive guide
     */
    public function comprehensive(Request $request): Response
    {
        $markdown = file_get_contents(__DIR__ . '/../../docs/md/COMPREHENSIVE-GUIDE.md');
        $markdown = str_replace('{{APP_VERSION}}', config('app.version'), $markdown);

        return Response::view('docs/comprehensive', [
            'title' => 'Comprehensive Guide - ' . config('app.name'),
            'markdown' => $markdown
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
            'quick-start' => 'QUICK-START.md',
            'readme' => 'README.md',
            'index' => 'INDEX.md',

            // Customization
            'rename' => 'RENAME-PROCESS.md',
            'branding' => 'FRAMEWORK-BRANDING.md',

            // Security & Validation
            'security-layer' => 'SECURITY-LAYER.md',
            'validation-system' => 'VALIDATION-SYSTEM.md',
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
            'view-templates' => 'VIEW-TEMPLATES.md',
            'routing-system' => 'ROUTING-SYSTEM.md',
            'project-structure' => 'PROJECT-STRUCTURE.md',

            // Testing & Quality Assurance
            'test-documentation' => 'TEST-DOCUMENTATION.md',
            'testing-guide' => 'TESTING-GUIDE.md',

            // Visual Guides
            'request-flow' => 'REQUEST-FLOW.md',

            // Meta Documentation
            'documentation-review' => 'DOCUMENTATION-REVIEW.md',
            'documentation-structure' => 'DOCUMENTATION-STRUCTURE.md',

            // Development Guides
            'dev-first-page' => 'DEV-FIRST-PAGE.md',
            'dev-crud-module' => 'DEV-CRUD-MODULE.md',
            'dev-routes' => 'DEV-ROUTES.md',
            'dev-route-params' => 'DEV-ROUTE-PARAMS.md',
            'dev-web-controllers' => 'DEV-WEB-CONTROLLERS.md',
            'dev-api-controllers' => 'DEV-API-CONTROLLERS.md',
            'dev-forms-validation' => 'DEV-FORMS-VALIDATION.md',
            'dev-assets' => 'DEV-ASSETS.md',
            'dev-auth' => 'DEV-AUTH.md',
            'dev-security' => 'DEV-SECURITY.md',
            'dev-custom-middleware' => 'DEV-CUSTOM-MIDDLEWARE.md',
            'dev-models' => 'DEV-MODELS.md',
            'dev-model-advanced' => 'DEV-MODEL-ADVANCED.md',

            // API & Architecture
            'api-versioning' => 'API-VERSIONING.md',

            // Test Documentation (from tests/ folder)
            'middleware' => '../../tests/MIDDLEWARE_IMPLEMENTATION_SUMMARY.md',
            'internal-api' => '../../tests/INTERNAL_API_LAYER_SUMMARY.md',
            'model-enhancements' => '../../tests/MODEL_ENHANCEMENTS_SUMMARY.md',
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
}
