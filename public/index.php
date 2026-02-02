<?php

/**
 * Application Entry Point
 *
 * Handles setup detection and bootstraps the framework.
 */

// ==========================================
// Setup Detection - Show friendly setup page
// ==========================================

// Check if composer dependencies are installed
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/setup.php';
    exit;
}

// Check if .env file exists
if (!file_exists(__DIR__ . '/../.env')) {
    define('SETUP_MISSING', 'env');
    require_once __DIR__ . '/setup.php';
    exit;
}

// ==========================================
// Bootstrap Application
// ==========================================

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Http\Request;

try {
    // Bootstrap the application
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    // Load routes
    require_once __DIR__ . '/../routes/web.php';
    require_once __DIR__ . '/../routes/api.php';

    // Create request from globals
    $request = Request::createFromGlobals();

    // Age flash data from previous request
    session()->ageFlashData();

    // Handle request
    $response = $app->handleWebRequest($request);

    // Send response
    $response->send();

    // Terminate application
    $app->terminate();

} catch (PDOException $e) {
    // Database connection error - show setup page
    define('SETUP_MISSING', 'database');
    define('SETUP_ERROR', $e->getMessage());
    require_once __DIR__ . '/setup.php';
    exit;
} catch (RuntimeException $e) {
    // Check if it's a database connection error
    if (stripos($e->getMessage(), 'database') !== false || stripos($e->getMessage(), 'connection') !== false) {
        define('SETUP_MISSING', 'database');
        define('SETUP_ERROR', $e->getMessage());
        require_once __DIR__ . '/setup.php';
        exit;
    }
    // Re-throw other runtime exceptions
    throw $e;
} catch (Exception $e) {
    // Check for common database/config errors
    $message = $e->getMessage();
    if (stripos($message, 'SQLSTATE') !== false ||
        stripos($message, 'database') !== false ||
        stripos($message, 'connection refused') !== false ||
        stripos($message, 'access denied') !== false) {
        define('SETUP_MISSING', 'database');
        define('SETUP_ERROR', $message);
        require_once __DIR__ . '/setup.php';
        exit;
    }
    // Re-throw other exceptions
    throw $e;
}
