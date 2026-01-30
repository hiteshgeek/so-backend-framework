<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../bootstrap/app.php';

use Core\Http\Request;
use Core\Security\InternalApiGuard;

$guard = new InternalApiGuard('test-secret-key');
$timestamp = time();
$body = '{"name":"John"}';

$signature = $guard->generateSignature('POST', '/api/users', $timestamp, $body);

echo "Generated signature: " . $signature . "\n";
echo "Timestamp: " . $timestamp . "\n";

$request = new Request([], [], [
    'REQUEST_METHOD' => 'POST',
    'REQUEST_URI' => '/api/users',
    'HTTP_X_SIGNATURE' => $signature,
    'HTTP_X_TIMESTAMP' => (string) $timestamp,
], [], []);

echo "Request Method: " . $request->method() . "\n";
echo "Request URI: " . $request->uri() . "\n";
echo "X-Signature header: " . $request->header('X-SIGNATURE') . "\n";
echo "X-Timestamp header: " . $request->header('X-TIMESTAMP') . "\n";

// Set body
$reflection = new ReflectionClass($request);
$property = $reflection->getProperty('content');
$property->setAccessible(true);
$property->setValue($request, $body);

echo "Request body: " . $request->getContent() . "\n";

// Try to verify
$result = $guard->verify($request);
echo "Verification result: " . ($result ? 'TRUE' : 'FALSE') . "\n";

// Debug: manually compute signature
$expectedSig = $guard->generateSignature($request->method(), $request->uri(), (int)$request->header('X-TIMESTAMP'), $request->getContent());
echo "Expected signature: " . $expectedSig . "\n";
echo "Received signature: " . $request->header('X-SIGNATURE') . "\n";
echo "Signatures match: " . ($expectedSig === $request->header('X-SIGNATURE') ? 'YES' : 'NO') . "\n";
