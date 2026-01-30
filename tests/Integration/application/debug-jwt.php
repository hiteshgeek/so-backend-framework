<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../bootstrap/app.php';

use Core\Http\Request;
use Core\Http\JsonResponse;

$_ENV['JWT_SECRET'] = 'test-secret-key-for-middleware-testing-32chars';

$jwt = new \Core\Security\JWT('test-secret-key-for-middleware-testing-32chars');
$token = $jwt->encode(['user_id' => 123], 3600);

echo "Token: " . substr($token, 0, 50) . "...\n";

$server = [
    'REQUEST_METHOD' => 'GET',
    'REQUEST_URI' => '/api/profile',
    'HTTP_AUTHORIZATION' => 'Bearer ' . $token,
];

$request = new Request($server, [], [], [], []);

echo "Request URI: " . $request->uri() . "\n";
echo "Bearer Token from request: " . ($request->bearerToken() ? substr($request->bearerToken(), 0, 50) . "..." : 'NULL') . "\n";
echo "Expects JSON: " . ($request->expectsJson() ? 'YES' : 'NO') . "\n";

$middleware = new \App\Middleware\AuthMiddleware();

$response = $middleware->handle($request, function($req) {
    echo "Inside callback - JWT: " . (isset($req->jwt) ? 'SET' : 'NOT SET') . "\n";
    echo "Inside callback - User ID: " . ($req->user_id ?? 'NOT SET') . "\n";
    return new JsonResponse(['message' => 'Authenticated via JWT']);
});

echo "Response Status: " . $response->getStatusCode() . "\n";
echo "Response Content: " . $response->getContent() . "\n";
