<?php
// Simulate route environment
$_SERVER['PHP_SELF'] = "/demo/ui-engine/display/progress.php";
$_SERVER['SCRIPT_NAME'] = "/demo/ui-engine/display/progress.php";
$_SERVER['REQUEST_URI'] = "/demo/ui-engine/display/progress.php";

$file = __DIR__ . '/frontend/demos/ui-engine/display/progress.php';
$oldDir = getcwd();
chdir(dirname($file));

echo "Current working directory: " . getcwd() . "<br>\n";
echo "Config file location: " . realpath('../../includes/config.php') . "<br>\n";

require_once '../../includes/config.php';

echo "PROJECT_ROOT: " . PROJECT_ROOT . "<br>\n";
echo "Manifest path: " . PROJECT_ROOT . '/public/frontend/dist/manifest.json' . "<br>\n";
echo "Manifest exists: " . (file_exists(PROJECT_ROOT . '/public/frontend/dist/manifest.json') ? 'YES' : 'NO') . "<br>\n";
echo "Manifest loaded: " . (empty($manifest) ? 'NO' : 'YES') . "<br>\n";
echo "Manifest CSS count: " . count($manifest['css'] ?? []) . "<br>\n";
echo "<br>\n";

echo "so_asset('css', 'sixorbit-full'): " . so_asset('css', 'sixorbit-full') . "<br>\n";
echo "so_asset('js', 'sixorbit-full'): " . so_asset('js', 'sixorbit-full') . "<br>\n";

chdir($oldDir);
