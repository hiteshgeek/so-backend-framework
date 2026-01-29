<?php

/**
 * Documentation Routes
 */

use Core\Routing\Router;
use App\Controllers\DocsController;

Router::get('/docs', [DocsController::class, 'index'])->name('docs.index');
Router::get('/docs/comprehensive', [DocsController::class, 'comprehensive'])->name('docs.comprehensive');
Router::get('/docs/{file}', [DocsController::class, 'show'])->name('docs.show');
