<?php

/**
 * Media Routes
 *
 * File access and media management routes.
 *
 * Public Access:
 * - Direct file URLs: /rpkfiles/folder/file.jpg (via web server)
 *
 * Secure Access (via controller):
 * - /files/{id} - View file with authentication
 * - /files/{id}/download - Download file with authentication
 */

use Core\Routing\Router;
use App\Http\Controllers\MediaController;

// ==========================================
// Secure File Access (with authentication)
// ==========================================

Router::group(['prefix' => '/files'], function () {
    // List media files
    Router::get('/', [MediaController::class, 'index'])->name('files.index');

    // Upload file
    Router::post('/upload', [MediaController::class, 'upload'])->name('files.upload');

    // View file details
    Router::get('/{id}', [MediaController::class, 'details'])
        ->name('files.details')
        ->whereNumber('id');

    // Serve file for viewing
    Router::get('/{id}/view', [MediaController::class, 'show'])
        ->name('files.show')
        ->whereNumber('id');

    // Download file
    Router::get('/{id}/download', [MediaController::class, 'download'])
        ->name('files.download')
        ->whereNumber('id');

    // Delete file
    Router::delete('/{id}', [MediaController::class, 'destroy'])
        ->name('files.destroy')
        ->whereNumber('id');
});

// Note: Direct file access via /rpkfiles/* is handled by web server configuration
// Files stored in /var/www/html/rpkfiles/ are accessible directly for better performance
