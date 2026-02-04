<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Starting test...<br>\n";
flush();

$_SERVER['PHP_SELF'] = "/demo/ui-engine/display/progress.php";
$_SERVER['SCRIPT_NAME'] = "/demo/ui-engine/display/progress.php";
$_SERVER['REQUEST_URI'] = "/demo/ui-engine/display/progress.php";

echo "Including progress.php...<br>\n";
flush();

require_once __DIR__ . '/frontend/demos/ui-engine/display/progress.php';
