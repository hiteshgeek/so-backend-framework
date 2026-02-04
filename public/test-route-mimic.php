<?php
$_SERVER['PHP_SELF'] = "/demo/ui-engine/display/progress.php";
$_SERVER['SCRIPT_NAME'] = "/demo/ui-engine/display/progress.php";
$_SERVER['REQUEST_URI'] = "/demo/ui-engine/display/progress.php";

$file = __DIR__ . '/frontend/demos/ui-engine/display/progress.php';
$oldDir = getcwd();
chdir(dirname($file));
require basename($file);
chdir($oldDir);
