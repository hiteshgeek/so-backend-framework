<?php
/**
 * Frontend Demo Routes
 * Routes for SixOrbit UI Engine demos and frontend showcases
 */

use Core\Routing\Router;

// Frontend demo index (handle both with and without trailing slash)
Router::get('/frontend', function() {
    require_once __DIR__ . '/../../public/frontend/demos/index.php';
});

Router::get('/frontend/', function() {
    require_once __DIR__ . '/../../public/frontend/demos/index.php';
});

// Frontend demo gallery
Router::get('/frontend/demos', function() {
    require_once __DIR__ . '/../../public/frontend/demos/demo-index.php';
});

// Test route
Router::get('/frontend/test/{name}', function(\Core\Http\Request $request, $name) {
    echo "Test route works! Parameter: $name";
});

// Simple file test
Router::get('/frontend/test-file', function() {
    require_once __DIR__ . '/../../public/frontend/demos/test-simple.php';
});

// Test config file
Router::get('/frontend/test-config', function() {
    require_once __DIR__ . '/../../public/frontend/demos/test-config.php';
});

// Test header file
Router::get('/frontend/test-header', function() {
    require_once __DIR__ . '/../../public/frontend/demos/test-header.php';
});

// Test sidebar file
Router::get('/frontend/test-sidebar', function() {
    $_SERVER['PHP_SELF'] = "/demo/test.php";
    require_once __DIR__ . '/../../public/frontend/demos/test-sidebar.php';
});

// UI Engine form element demos
Router::get('/frontend/ui-engine/form/{component}', function(\Core\Http\Request $request, $component) {
    $file = __DIR__ . "/../../public/frontend/demos/ui-engine/form/{$component}.php";
    if (file_exists($file)) {
        $_SERVER['PHP_SELF'] = "/demo/ui-engine/form/{$component}.php";
        $_SERVER['SCRIPT_NAME'] = "/demo/ui-engine/form/{$component}.php";
        $_SERVER['REQUEST_URI'] = "/demo/ui-engine/form/{$component}.php";
        $oldDir = getcwd();
        chdir(dirname($file));
        ob_start();
        require basename($file);
        $content = ob_get_clean();
        chdir($oldDir);
        return response($content);
    } else {
        abort(404);
    }
});

// UI Engine navigation element demos
Router::get('/frontend/ui-engine/navigation/{component}', function(\Core\Http\Request $request, $component) {
    $file = __DIR__ . "/../../public/frontend/demos/ui-engine/navigation/{$component}.php";
    if (file_exists($file)) {
        $_SERVER['PHP_SELF'] = "/demo/ui-engine/navigation/{$component}.php";
        $_SERVER['SCRIPT_NAME'] = "/demo/ui-engine/navigation/{$component}.php";
        $_SERVER['REQUEST_URI'] = "/demo/ui-engine/navigation/{$component}.php";
        $oldDir = getcwd();
        chdir(dirname($file));
        ob_start();
        require basename($file);
        $content = ob_get_clean();
        chdir($oldDir);
        return response($content);
    } else {
        abort(404);
    }
});

// UI Engine layout element demos
Router::get('/frontend/ui-engine/layout/{component}', function(\Core\Http\Request $request, $component) {
    $file = __DIR__ . "/../../public/frontend/demos/ui-engine/layout/{$component}.php";
    if (file_exists($file)) {
        $_SERVER['PHP_SELF'] = "/demo/ui-engine/layout/{$component}.php";
        $_SERVER['SCRIPT_NAME'] = "/demo/ui-engine/layout/{$component}.php";
        $_SERVER['REQUEST_URI'] = "/demo/ui-engine/layout/{$component}.php";
        $oldDir = getcwd();
        chdir(dirname($file));
        ob_start();
        require basename($file);
        $content = ob_get_clean();
        chdir($oldDir);
        return response($content);
    } else {
        abort(404);
    }
});

// UI Engine display element demos
Router::get('/frontend/ui-engine/display/{component}', function(\Core\Http\Request $request, $component) {
    $file = __DIR__ . "/../../public/frontend/demos/ui-engine/display/{$component}.php";
    if (file_exists($file)) {
        // Set $_SERVER vars so demo config works correctly
        $_SERVER['PHP_SELF'] = "/demo/ui-engine/display/{$component}.php";
        $_SERVER['SCRIPT_NAME'] = "/demo/ui-engine/display/{$component}.php";
        $_SERVER['REQUEST_URI'] = "/demo/ui-engine/display/{$component}.php";

        // Change working directory so relative includes work
        $oldDir = getcwd();
        chdir(dirname($file));
        ob_start();
        require basename($file);
        $content = ob_get_clean();
        chdir($oldDir);
        return response($content);
    } else {
        abort(404);
    }
});

// UI Engine form demos (custom forms directory)
Router::get('/frontend/ui-engine-form/{component}', function(\Core\Http\Request $request, $component) {
    $file = __DIR__ . "/../../public/frontend/demos/ui-engine-form/{$component}.php";
    if (file_exists($file)) {
        // Set $_SERVER vars so demo config works correctly
        $_SERVER['PHP_SELF'] = "/demo/ui-engine-form/{$component}.php";
        $_SERVER['SCRIPT_NAME'] = "/demo/ui-engine-form/{$component}.php";
        $_SERVER['REQUEST_URI'] = "/demo/ui-engine-form/{$component}.php";

        // Change working directory so relative includes work
        $oldDir = getcwd();
        chdir(dirname($file));
        ob_start();
        require basename($file);
        $content = ob_get_clean();
        chdir($oldDir);
        return response($content);
    } else {
        abort(404);
    }
});

// Elements demos (separate directory)
Router::get('/frontend/elements/{component}', function(\Core\Http\Request $request, $component) {
    $file = __DIR__ . "/../../public/frontend/demos/elements/{$component}.php";
    if (file_exists($file)) {
        // Set $_SERVER vars so demo config works correctly
        $_SERVER['PHP_SELF'] = "/demo/elements/{$component}.php";
        $_SERVER['SCRIPT_NAME'] = "/demo/elements/{$component}.php";
        $_SERVER['REQUEST_URI'] = "/demo/elements/{$component}.php";

        // Change working directory so relative includes work
        $oldDir = getcwd();
        chdir(dirname($file));
        ob_start();
        require basename($file);
        $content = ob_get_clean();
        chdir($oldDir);
        return response($content);
    } else {
        abort(404);
    }
});

// Grid system demos
Router::get('/frontend/grid/{component}', function(\Core\Http\Request $request, $component) {
    $file = __DIR__ . "/../../public/frontend/demos/grid/{$component}.php";
    if (file_exists($file)) {
        // Set $_SERVER vars so demo config works correctly
        $_SERVER['PHP_SELF'] = "/demo/grid/{$component}.php";
        $_SERVER['SCRIPT_NAME'] = "/demo/grid/{$component}.php";
        $_SERVER['REQUEST_URI'] = "/demo/grid/{$component}.php";

        // Change working directory so relative includes work
        $oldDir = getcwd();
        chdir(dirname($file));
        ob_start();
        require basename($file);
        $content = ob_get_clean();
        chdir($oldDir);
        return response($content);
    } else {
        abort(404);
    }
});

// Standalone demo pages in root demos directory
Router::get('/frontend/{page}', function(\Core\Http\Request $request, $page) {
    $file = __DIR__ . "/../../public/frontend/demos/{$page}.php";
    if (file_exists($file)) {
        // Set $_SERVER vars so demo config works correctly
        $_SERVER['PHP_SELF'] = "/demo/{$page}.php";
        $_SERVER['SCRIPT_NAME'] = "/demo/{$page}.php";
        $_SERVER['REQUEST_URI'] = "/demo/{$page}.php";

        // Change working directory so relative includes work
        $oldDir = getcwd();
        chdir(dirname($file));
        ob_start();
        require basename($file);
        $content = ob_get_clean();
        chdir($oldDir);
        return response($content);
    } else {
        abort(404);
    }
});

// Test full demo structure
Router::get('/frontend/test-full', function() {
    $_SERVER['PHP_SELF'] = "/demo/test.php";
    $_SERVER['SCRIPT_NAME'] = "/demo/test.php";
    $_SERVER['REQUEST_URI'] = "/demo/test.php";
    require __DIR__ . '/../../public/frontend/demos/test-full.php';
});

// Debug test
Router::get('/frontend/test-debug', function() {
    $_SERVER['PHP_SELF'] = "/demo/test-debug.php";
    $_SERVER['SCRIPT_NAME'] = "/demo/test-debug.php";
    $_SERVER['REQUEST_URI'] = "/demo/test-debug.php";
    ob_start();
    require __DIR__ . '/../../public/frontend/demos/test-debug.php';
    $content = ob_get_clean();
    return response($content);
});
