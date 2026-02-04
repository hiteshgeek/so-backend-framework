<?php
// Test sidebar URL generation
define('SO_DEMO_BASE', '/frontend/');

$testUrls = [
    'elements/accordion.php',
    'ui-engine/display/accordion.php'
];

echo "Testing sidebar URL generation:\n\n";

$demoBase = SO_DEMO_BASE;

foreach ($testUrls as $url) {
    $original = $url;

    // Strip .php extension
    $url = preg_replace('/\.php$/', '', $url);

    // Prepend demo base
    $url = $demoBase . $url;

    echo "Original: $original\n";
    echo "Generated: $url\n\n";
}
