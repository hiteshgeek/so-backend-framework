<?php
require_once __DIR__ . '/frontend/demos/includes/config.php';

echo "Manifest loaded: " . (empty($manifest) ? "NO" : "YES") . "<br>\n";
echo "Manifest CSS count: " . count($manifest['css'] ?? []) . "<br>\n";
echo "Manifest JS count: " . count($manifest['js'] ?? []) . "<br>\n";
echo "<br>\n";

echo "so_asset('css', 'sixorbit-full'): " . so_asset('css', 'sixorbit-full') . "<br>\n";
echo "so_asset('js', 'sixorbit-full'): " . so_asset('js', 'sixorbit-full') . "<br>\n";
echo "so_asset('css', 'ui-engine'): " . so_asset('css', 'ui-engine') . "<br>\n";
