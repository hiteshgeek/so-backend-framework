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

        return Response::view('docs/comprehensive', [
            'title' => 'Comprehensive Guide - ' . config('app.name'),
            'markdown' => $markdown
        ]);
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

            // Enterprise Features
            'activity-logging' => 'ACTIVITY-LOGGING.md',
            'queue-system' => 'QUEUE-SYSTEM.md',
            'notification-system' => 'NOTIFICATION-SYSTEM.md',
            'cache-system' => 'CACHE-SYSTEM.md',
            'session-system' => 'SESSION-SYSTEM.md',
            'framework-features' => 'FRAMEWORK-FEATURES.md',

            // Technical Documentation
            'asset-management' => 'ASSET-MANAGEMENT.md',
            'auth-system' => 'AUTH-SYSTEM.md',
            'console-commands' => 'CONSOLE-COMMANDS.md',
            'view-templates' => 'VIEW-TEMPLATES.md',
            'routing-system' => 'ROUTING-SYSTEM.md',
            'project-structure' => 'PROJECT-STRUCTURE.md',

            // Meta Documentation
            'documentation-review' => 'DOCUMENTATION-REVIEW.md',
            'documentation-structure' => 'DOCUMENTATION-STRUCTURE.md',

            // Test Documentation (from tests/ folder)
            'middleware' => '../../tests/MIDDLEWARE_IMPLEMENTATION_SUMMARY.md',
            'internal-api' => '../../tests/INTERNAL_API_LAYER_SUMMARY.md',
            'model-enhancements' => '../../tests/MODEL_ENHANCEMENTS_SUMMARY.md',
        ];

        if (!isset($allowedFiles[$file])) {
            return Response::view('errors/404', [], 404);
        }

        // Check if a PHP view exists for this documentation
        $phpViewPath = __DIR__ . '/../../resources/views/docs/pages/' . $file . '.php';
        if (file_exists($phpViewPath)) {
            return Response::view('docs/pages/' . $file, [
                'title' => ucwords(str_replace('-', ' ', $file)) . ' - ' . config('app.name')
            ]);
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

        return Response::view('docs/show', [
            'title' => ucwords(str_replace('-', ' ', $file)) . ' - ' . config('app.name'),
            'markdown' => $markdown,
            'filename' => $allowedFiles[$file]
        ]);
    }
}
