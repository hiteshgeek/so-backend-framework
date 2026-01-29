<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Http\Request;

// Bootstrap the application
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Load routes
require_once __DIR__ . '/../routes/web.php';
require_once __DIR__ . '/../routes/api.php';

// Create request from globals
$request = Request::createFromGlobals();

// Handle request
$response = $app->handleWebRequest($request);

// Send response
$response->send();

// Terminate application
$app->terminate();
