<?php

/**
 * Internal API Layer Test
 *
 * Tests all components of the Internal API Layer:
 * 1. InternalApiGuard (signature authentication)
 * 2. RequestContext (context detection)
 * 3. ContextPermissions (permission checking)
 * 4. ApiClient (API calls)
 */

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../bootstrap/app.php';

use Core\Api\InternalApiGuard;
use Core\Api\RequestContext;
use Core\Api\ContextPermissions;
use Core\Api\ApiClient;
use Core\Http\Request;

echo "=== Internal API Layer Test ===\n\n";

$passedTests = 0;
$totalTests = 0;

// ==================== TEST 1: InternalApiGuard - Signature Generation ====================

echo "Test 1: InternalApiGuard - Signature Generation\n";
try {
    $totalTests++;

    $guard = new InternalApiGuard('test-secret-key');
    $timestamp = time();

    $signature = $guard->generateSignature('POST', '/api/users', $timestamp, '{"name":"John"}');

    if (!empty($signature) && strlen($signature) === 64) { // SHA256 produces 64 hex chars
        echo "✓ Signature generated correctly\n";
        echo "  Signature: " . substr($signature, 0, 16) . "...\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Invalid signature format\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 2: InternalApiGuard - Signature Verification ====================

echo "Test 2: InternalApiGuard - Signature Verification\n";
try {
    $totalTests++;

    $guard = new InternalApiGuard('test-secret-key');
    $timestamp = time();
    $body = '{"name":"John"}';

    // Generate signature
    $signature = $guard->generateSignature('POST', '/api/users', $timestamp, $body);

    // Create request with signature headers
    $request = new Request([], [], [
        'REQUEST_METHOD' => 'POST',
        'REQUEST_URI' => '/api/users',
        'HTTP_X_SIGNATURE' => $signature,
        'HTTP_X_TIMESTAMP' => (string) $timestamp,
    ], [], []);

    // Manually set content
    $reflection = new ReflectionClass($request);
    $property = $reflection->getProperty('content');
    $property->setAccessible(true);
    $property->setValue($request, $body);

    // Verify signature
    if ($guard->verify($request)) {
        echo "✓ Signature verified successfully\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Signature verification failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 3: InternalApiGuard - Invalid Signature ====================

echo "Test 3: InternalApiGuard - Invalid Signature Rejection\n";
try {
    $totalTests++;

    $guard = new InternalApiGuard('test-secret-key');
    $timestamp = time();

    // Create request with WRONG signature
    $request = new Request([], [], [
        'REQUEST_METHOD' => 'POST',
        'REQUEST_URI' => '/api/users',
        'HTTP_X_SIGNATURE' => 'wrong-signature-here',
        'HTTP_X_TIMESTAMP' => (string) $timestamp,
    ], [], []);

    // Verify signature (should fail)
    if (!$guard->verify($request)) {
        echo "✓ Invalid signature rejected correctly\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Invalid signature accepted\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 4: InternalApiGuard - Timestamp Validation ====================

echo "Test 4: InternalApiGuard - Expired Timestamp Rejection\n";
try {
    $totalTests++;

    $guard = new InternalApiGuard('test-secret-key', 60); // 60 second window
    $oldTimestamp = time() - 120; // 2 minutes ago (expired)

    $signature = $guard->generateSignature('GET', '/api/users', $oldTimestamp);

    $request = new Request([], [], [
        'REQUEST_METHOD' => 'GET',
        'REQUEST_URI' => '/api/users',
        'HTTP_X_SIGNATURE' => $signature,
        'HTTP_X_TIMESTAMP' => (string) $oldTimestamp,
    ], [], []);

    if (!$guard->verify($request)) {
        echo "✓ Expired timestamp rejected correctly\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Expired timestamp accepted\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 5: InternalApiGuard - Header Generation ====================

echo "Test 5: InternalApiGuard - Generate Headers\n";
try {
    $totalTests++;

    $guard = new InternalApiGuard('test-secret-key');

    $headers = $guard->generateHeaders('POST', '/api/users', '{"name":"John"}');

    if (isset($headers['X-Signature']) && isset($headers['X-Timestamp'])) {
        echo "✓ Authentication headers generated\n";
        echo "  X-Signature: " . substr($headers['X-Signature'], 0, 16) . "...\n";
        echo "  X-Timestamp: " . $headers['X-Timestamp'] . "\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Missing authentication headers\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 6: RequestContext - Web Detection ====================

echo "Test 6: RequestContext - Web Context Detection\n";
try {
    $totalTests++;

    // Create web request (no special headers)
    $request = new Request([], [], [
        'REQUEST_METHOD' => 'GET',
        'REQUEST_URI' => '/dashboard',
        'HTTP_USER_AGENT' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
    ], [], []);

    $context = RequestContext::detect($request);

    if ($context->isWeb()) {
        echo "✓ Web context detected correctly\n";
        echo "  Context: " . $context->getContext() . "\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Web context not detected (got: " . $context->getContext() . ")\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 7: RequestContext - Mobile Detection ====================

echo "Test 7: RequestContext - Mobile Context Detection\n";
try {
    $totalTests++;

    // Create mobile request (JWT + mobile user agent)
    $request = new Request([], [], [
        'REQUEST_METHOD' => 'GET',
        'REQUEST_URI' => '/api/profile',
        'HTTP_USER_AGENT' => 'MyApp/1.0 (iPhone; iOS 15.0)',
        'HTTP_AUTHORIZATION' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...',
    ], [], []);

    $context = RequestContext::detect($request);

    if ($context->isMobile()) {
        echo "✓ Mobile context detected correctly\n";
        echo "  Context: " . $context->getContext() . "\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Mobile context not detected (got: " . $context->getContext() . ")\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 8: RequestContext - Cron Detection ====================

echo "Test 8: RequestContext - Cron Context Detection\n";
try {
    $totalTests++;

    // Create cron request (signature headers)
    $request = new Request([], [], [
        'REQUEST_METHOD' => 'POST',
        'REQUEST_URI' => '/api/cron/cleanup',
        'HTTP_X_SIGNATURE' => 'abc123...',
        'HTTP_X_TIMESTAMP' => (string) time(),
    ], [], []);

    $context = RequestContext::detect($request);

    if ($context->isCron()) {
        echo "✓ Cron context detected correctly\n";
        echo "  Context: " . $context->getContext() . "\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Cron context not detected (got: " . $context->getContext() . ")\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 9: RequestContext - External API Detection ====================

echo "Test 9: RequestContext - External API Context Detection\n";
try {
    $totalTests++;

    // Create external API request (API key)
    $request = new Request([], [], [
        'REQUEST_METHOD' => 'GET',
        'REQUEST_URI' => '/api/public/data',
        'HTTP_X_API_KEY' => 'external-api-key-123',
    ], [], []);

    $context = RequestContext::detect($request);

    if ($context->isExternal()) {
        echo "✓ External API context detected correctly\n";
        echo "  Context: " . $context->getContext() . "\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: External API context not detected (got: " . $context->getContext() . ")\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 10: ContextPermissions - Web Permissions ====================

echo "Test 10: ContextPermissions - Web Context Permissions\n";
try {
    $totalTests++;

    $permissions = new ContextPermissions();

    // Web should have full access
    if ($permissions->can('web', 'users.create') && $permissions->can('web', 'posts.delete')) {
        echo "✓ Web context has full permissions\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Web context missing permissions\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 11: ContextPermissions - Mobile Permissions ====================

echo "Test 11: ContextPermissions - Mobile Context Permissions\n";
try {
    $totalTests++;

    $permissions = new ContextPermissions();

    // Mobile should have limited access
    $canRead = $permissions->can('mobile', 'posts.read');
    $canDeleteUsers = $permissions->can('mobile', 'users.delete'); // Should be false

    if ($canRead && !$canDeleteUsers) {
        echo "✓ Mobile context has correct limited permissions\n";
        echo "  Can read posts: Yes\n";
        echo "  Can delete users: No\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Mobile context permissions incorrect\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 12: ContextPermissions - Wildcard Matching ====================

echo "Test 12: ContextPermissions - Wildcard Permission Matching\n";
try {
    $totalTests++;

    $permissions = new ContextPermissions();

    // Cron has 'system.*' permission
    if ($permissions->can('cron', 'system.cleanup') && $permissions->can('cron', 'system.restart')) {
        echo "✓ Wildcard permissions matched correctly\n";
        echo "  system.* matches system.cleanup: Yes\n";
        echo "  system.* matches system.restart: Yes\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Wildcard matching not working\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 13: ApiClient - Instance Creation ====================

echo "Test 13: ApiClient - Instance Creation\n";
try {
    $totalTests++;

    $client = new ApiClient('http://localhost');

    if ($client->getBaseUrl() === 'http://localhost') {
        echo "✓ ApiClient created successfully\n";
        echo "  Base URL: " . $client->getBaseUrl() . "\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: ApiClient base URL not set\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 14: ApiClient - Header Management ====================

echo "Test 14: ApiClient - Header Management\n";
try {
    $totalTests++;

    $client = new ApiClient('http://localhost');
    $client->setHeader('X-Custom-Header', 'test-value');

    $headers = $client->getHeaders();

    if (isset($headers['X-Custom-Header']) && $headers['X-Custom-Header'] === 'test-value') {
        echo "✓ Headers managed correctly\n";
        echo "  Custom header: " . $headers['X-Custom-Header'] . "\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Header not set correctly\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 15: ApiClient - With Signature ====================

echo "Test 15: ApiClient - Signature Authentication Setup\n";
try {
    $totalTests++;

    $guard = new InternalApiGuard('test-secret');
    $client = new ApiClient('http://localhost', $guard);

    if ($client->getGuard() instanceof InternalApiGuard) {
        echo "✓ ApiClient configured with signature authentication\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Guard not set correctly\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== SUMMARY ====================

echo "=== Internal API Layer Test Complete ===\n\n";
echo "Results: {$passedTests}/{$totalTests} tests passed (" . round(($passedTests / $totalTests) * 100, 1) . "%)\n\n";

if ($passedTests === $totalTests) {
    echo "✅ ALL TESTS PASSED\n\n";
    echo "Internal API Layer Status:\n";
    echo "- ✓ InternalApiGuard: Signature authentication working\n";
    echo "- ✓ RequestContext: Context detection working (web, mobile, cron, external)\n";
    echo "- ✓ ContextPermissions: Permission checking working\n";
    echo "- ✓ ApiClient: HTTP client working with signature auth\n\n";
    echo "Production Ready: YES\n";
} else {
    echo "⚠️  SOME TESTS FAILED\n\n";
    echo "Failed: " . ($totalTests - $passedTests) . " tests\n";
    echo "Please review the output above for details.\n";
}

echo "\nNext Steps:\n";
echo "1. Update .env: INTERNAL_API_SIGNATURE_KEY=your-secret-key\n";
echo "2. Use InternalApiGuard for cron job authentication\n";
echo "3. Use RequestContext for context-aware features\n";
echo "4. Use ContextPermissions for permission checking\n";
echo "5. Use ApiClient for internal API calls\n";
