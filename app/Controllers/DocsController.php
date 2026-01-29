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
        $markdown = file_get_contents(__DIR__ . '/../../documentation/COMPREHENSIVE-GUIDE.md');

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
            'setup' => 'SETUP.md',
            'configuration' => 'CONFIGURATION.md',
            'quick-start' => 'QUICK-START.md',
            'rename' => 'RENAME-PROCESS.md',
            'branding' => 'FRAMEWORK-BRANDING.md',
            'index' => 'INDEX.md',
            'readme' => 'README.md',
            // Framework Features Documentation
            'activity-logging' => 'ACTIVITY-LOGGING.md',
            'queue-system' => 'QUEUE-SYSTEM.md',
            'notification-system' => 'NOTIFICATION-SYSTEM.md',
            'cache-system' => 'CACHE-SYSTEM.md',
            'session-system' => 'SESSION-SYSTEM.md',
            'framework-features' => 'FRAMEWORK-FEATURES.md',
        ];

        if (!isset($allowedFiles[$file])) {
            return Response::view('errors/404', [], 404);
        }

        $filePath = __DIR__ . '/../../documentation/' . $allowedFiles[$file];

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
