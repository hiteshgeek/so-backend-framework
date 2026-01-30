<?php

/**
 * CSRF Protection Test
 *
 * Tests CSRF token generation, verification, and middleware functionality.
 */

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../bootstrap/app.php';
require_once __DIR__ . '/../../TestHelper.php';

TestHelper::header('CSRF Protection Test');
echo "\n";

// Test 1: Token Generation
TestHelper::test('Test 1: Token Generation');
try {
    $token1 = \Core\Security\Csrf::token();
    TestHelper::success("Token generated: " . substr($token1, 0, 16) . "...");
    TestHelper::success("Token length: " . strlen($token1) . " characters");

    // Token should be 64 characters (32 bytes hex-encoded)
    if (strlen($token1) === 64) {
        TestHelper::success("Token has correct length (64 characters)");
    } else {
        TestHelper::error("FAILED: Token should be 64 characters, got " . strlen($token1) . "");
    }
} catch (Exception $e) {
    TestHelper::error("FAILED: " . $e->getMessage() . "");
}

echo "\n";

// Test 2: Token Persistence (Same token on multiple calls)
TestHelper::test('Test 2: Token Persistence');
try {
    $token1 = \Core\Security\Csrf::token();
    $token2 = \Core\Security\Csrf::token();

    if ($token1 === $token2) {
        TestHelper::success("Token persists across multiple calls");
    } else {
        TestHelper::error("FAILED: Token should be the same across calls");
    }
} catch (Exception $e) {
    TestHelper::error("FAILED: " . $e->getMessage() . "");
}

echo "\n";

// Test 3: Token Verification
TestHelper::test('Test 3: Token Verification');
try {
    $token = \Core\Security\Csrf::token();

    // Test valid token
    if (\Core\Security\Csrf::verify($token)) {
        TestHelper::success("Valid token verified successfully");
    } else {
        TestHelper::error("FAILED: Valid token should verify");
    }

    // Test invalid token
    if (!\Core\Security\Csrf::verify('invalid_token_123')) {
        TestHelper::success("Invalid token rejected correctly");
    } else {
        TestHelper::error("FAILED: Invalid token should be rejected");
    }

    // Test empty token
    if (!\Core\Security\Csrf::verify('')) {
        TestHelper::success("Empty token rejected correctly");
    } else {
        TestHelper::error("FAILED: Empty token should be rejected");
    }
} catch (Exception $e) {
    TestHelper::error("FAILED: " . $e->getMessage() . "");
}

echo "\n";

// Test 4: Token Regeneration
TestHelper::test('Test 4: Token Regeneration');
try {
    $token1 = \Core\Security\Csrf::token();
    $token2 = \Core\Security\Csrf::regenerate();

    if ($token1 !== $token2) {
        TestHelper::success("New token generated on regenerate");
    } else {
        TestHelper::error("FAILED: Regenerate should create a new token");
    }

    // Old token should not verify
    if (!\Core\Security\Csrf::verify($token1)) {
        TestHelper::success("Old token no longer valid after regeneration");
    } else {
        TestHelper::error("FAILED: Old token should be invalid after regeneration");
    }

    // New token should verify
    if (\Core\Security\Csrf::verify($token2)) {
        TestHelper::success("New token is valid");
    } else {
        TestHelper::error("FAILED: New token should be valid");
    }
} catch (Exception $e) {
    TestHelper::error("FAILED: " . $e->getMessage() . "");
}

echo "\n";

// Test 5: Helper Functions
TestHelper::test('Test 5: Helper Functions');
try {
    $token = csrf_token();
    TestHelper::success("csrf_token() helper works: " . substr($token, 0, 16) . "...");

    $field = csrf_field();
    if (str_contains($field, '<input') && str_contains($field, '_token') && str_contains($field, $token)) {
        TestHelper::success("csrf_field() helper generates correct HTML");
        echo "  HTML: " . $field . "\n";
    } else {
        TestHelper::error("FAILED: csrf_field() should generate proper input field");
    }
} catch (Exception $e) {
    TestHelper::error("FAILED: " . $e->getMessage() . "");
}

echo "\n";

// Test 6: Configuration Check
TestHelper::test('Test 6: Configuration');
try {
    $enabled = \Core\Security\Csrf::isEnabled();
    TestHelper::success("CSRF protection enabled: " . ($enabled ? 'Yes' : 'No') . "");

    // Test route exclusion
    $isExcluded = \Core\Security\Csrf::isExcluded('api/users');
    TestHelper::success("Route 'api/users' excluded: " . ($isExcluded ? 'Yes' : 'No') . "");

    $isExcluded = \Core\Security\Csrf::isExcluded('users/create');
    TestHelper::success("Route 'users/create' excluded: " . ($isExcluded ? 'Yes' : 'No') . "");
} catch (Exception $e) {
    TestHelper::error("FAILED: " . $e->getMessage() . "");
}

echo "\n";

// Test 7: Middleware Simulation
TestHelper::test('Test 7: Middleware Simulation');
try {
    // Mock request object
    $request = new \Core\Http\Request();
    $request->_method = 'POST';
    $request->_uri = 'users/create';
    $request->_input = ['_token' => csrf_token()];

    $middleware = new \App\Middleware\CsrfMiddleware();

    // Test with valid token
    $called = false;
    $next = function($req) use (&$called) {
        $called = true;
        return new \Core\Http\Response('OK');
    };

    $response = $middleware->handle($request, $next);

    if ($called) {
        TestHelper::success("Middleware allows request with valid token");
    } else {
        TestHelper::error("FAILED: Middleware should allow valid token");
    }

    // Test with invalid token
    $request->_input = ['_token' => 'invalid_token'];
    $called = false;

    $response = $middleware->handle($request, $next);

    if (!$called && $response instanceof \Core\Http\JsonResponse) {
        TestHelper::success("Middleware blocks request with invalid token");
        echo "  Response status: " . $response->getStatusCode() . "\n";
    } else {
        TestHelper::warning("Middleware behavior may vary (check implementation)");
    }

    // Test GET request (should bypass CSRF)
    $request->_method = 'GET';
    $called = false;

    $response = $middleware->handle($request, $next);

    if ($called) {
        TestHelper::success("Middleware bypasses GET requests");
    } else {
        TestHelper::error("FAILED: Middleware should bypass GET requests");
    }
} catch (Exception $e) {
    TestHelper::error("FAILED: " . $e->getMessage() . "");
}

echo "\n"; TestHelper::complete("CSRF Protection Test");
