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
        $markdown = file_get_contents(__DIR__ . '/../../documentation/md/COMPREHENSIVE-GUIDE.md');

        return Response::view('docs/comprehensive', [
            'title' => 'Comprehensive Guide - ' . config('app.name'),
            'markdown' => $markdown
        ]);
    }

    /**
     * Show specific documentation file
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

        // Handle relative paths that start with '../'
        $filename = $allowedFiles[$file];
        if (str_starts_with($filename, '../')) {
            $filePath = __DIR__ . '/../../documentation/md/' . $filename;
        } else {
            $filePath = __DIR__ . '/../../documentation/md/' . $filename;
        }
        $filePath = realpath($filePath) ?: $filePath;

        if (!file_exists($filePath)) {
            return Response::view('errors/404', [], 404);
        }

        $markdown = file_get_contents($filePath);

        return Response::view('docs/show', [
            'title' => $file . ' - ' . config('app.name'),
            'markdown' => $markdown,
            'filename' => $allowedFiles[$file]
        ]);
    }
}
