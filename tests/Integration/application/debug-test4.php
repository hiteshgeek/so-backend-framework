<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../bootstrap/app.php';

use Core\Http\Request;
use Core\Http\Response;

$_SESSION = [];

$request = new Request([], [], [
    'REQUEST_METHOD' => 'GET',
    'REQUEST_URI' => '/api/users',
    'HTTP_ACCEPT' => 'application/json',
], [], []);

echo "Request URI: " . $request->uri() . "\n";
echo "Expects JSON: " . ($request->expectsJson() ? 'YES' : 'NO') . "\n";
echo "Starts with api/: " . (str_starts_with($request->uri(), 'api/') ? 'YES' : 'NO') . "\n";

$middleware = new \App\Middleware\AuthMiddleware();

$response = $middleware->handle($request, function($req) {
    return new Response('Should not reach here');
});

echo "Status Code: " . $response->getStatusCode() . "\n";
echo "Response Content: " . $response->getContent() . "\n";

$content = json_decode($response->getContent(), true);
echo "JSON decoded: " . print_r($content, true) . "\n";
echo "Has 'error' key: " . (isset($content['error']) ? 'YES' : 'NO') . "\n";
