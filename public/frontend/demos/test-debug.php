<?php
require_once 'includes/config.php';

echo "<h1>Debug Configuration</h1>";
echo "<pre>";
echo "SO_DEMO_BASE: " . SO_DEMO_BASE . "\n";
echo "PROJECT_ROOT: " . PROJECT_ROOT . "\n";
echo "SO_DIST_PATH: " . SO_DIST_PATH . "\n";
echo "\$_SERVER['PHP_SELF']: " . $_SERVER['PHP_SELF'] . "\n";
echo "getcwd(): " . getcwd() . "\n";
echo "__DIR__: " . __DIR__ . "\n";
echo "\n\nget_current_page_path(): " . get_current_page_path() . "\n";
echo "</pre>";

echo "<h2>Test Sidebar URL Generation</h2>";
echo "<pre>";

$demoBase = defined('SO_DEMO_BASE') ? SO_DEMO_BASE : '/demo/';
echo "demoBase: " . $demoBase . "\n";

$testUrls = [
    'elements/alerts-toasts.php',
    'ui-engine/form/autocomplete.php'
];

foreach ($testUrls as $testUrl) {
    $url = preg_replace('/\.php$/', '', $testUrl);
    $finalUrl = $demoBase . $url;
    echo "\nOriginal: $testUrl\n";
    echo "Processed: $url\n";
    echo "Final URL: $finalUrl\n";
}

echo "</pre>";
