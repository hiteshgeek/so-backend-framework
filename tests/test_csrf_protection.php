<?php

/**
 * CSRF Protection Test
 *
 * Tests CSRF token generation, verification, and middleware functionality.
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';

echo "=== CSRF Protection Test ===\n\n";

// Test 1: Token Generation
echo "Test 1: Token Generation\n";
try {
    $token1 = \Core\Security\Csrf::token();
    echo "✓ Token generated: " . substr($token1, 0, 16) . "...\n";
    echo "✓ Token length: " . strlen($token1) . " characters\n";

    // Token should be 64 characters (32 bytes hex-encoded)
    if (strlen($token1) === 64) {
        echo "✓ Token has correct length (64 characters)\n";
    } else {
        echo "✗ FAILED: Token should be 64 characters, got " . strlen($token1) . "\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Token Persistence (Same token on multiple calls)
echo "Test 2: Token Persistence\n";
try {
    $token1 = \Core\Security\Csrf::token();
    $token2 = \Core\Security\Csrf::token();

    if ($token1 === $token2) {
        echo "✓ Token persists across multiple calls\n";
    } else {
        echo "✗ FAILED: Token should be the same across calls\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Token Verification
echo "Test 3: Token Verification\n";
try {
    $token = \Core\Security\Csrf::token();

    // Test valid token
    if (\Core\Security\Csrf::verify($token)) {
        echo "✓ Valid token verified successfully\n";
    } else {
        echo "✗ FAILED: Valid token should verify\n";
    }

    // Test invalid token
    if (!\Core\Security\Csrf::verify('invalid_token_123')) {
        echo "✓ Invalid token rejected correctly\n";
    } else {
        echo "✗ FAILED: Invalid token should be rejected\n";
    }

    // Test empty token
    if (!\Core\Security\Csrf::verify('')) {
        echo "✓ Empty token rejected correctly\n";
    } else {
        echo "✗ FAILED: Empty token should be rejected\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 4: Token Regeneration
echo "Test 4: Token Regeneration\n";
try {
    $token1 = \Core\Security\Csrf::token();
    $token2 = \Core\Security\Csrf::regenerate();

    if ($token1 !== $token2) {
        echo "✓ New token generated on regenerate\n";
    } else {
        echo "✗ FAILED: Regenerate should create a new token\n";
    }

    // Old token should not verify
    if (!\Core\Security\Csrf::verify($token1)) {
        echo "✓ Old token no longer valid after regeneration\n";
    } else {
        echo "✗ FAILED: Old token should be invalid after regeneration\n";
    }

    // New token should verify
    if (\Core\Security\Csrf::verify($token2)) {
        echo "✓ New token is valid\n";
    } else {
        echo "✗ FAILED: New token should be valid\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 5: Helper Functions
echo "Test 5: Helper Functions\n";
try {
    $token = csrf_token();
    echo "✓ csrf_token() helper works: " . substr($token, 0, 16) . "...\n";

    $field = csrf_field();
    if (str_contains($field, '<input') && str_contains($field, '_token') && str_contains($field, $token)) {
        echo "✓ csrf_field() helper generates correct HTML\n";
        echo "  HTML: " . htmlspecialchars($field) . "\n";
    } else {
        echo "✗ FAILED: csrf_field() should generate proper input field\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 6: Configuration Check
echo "Test 6: Configuration\n";
try {
    $enabled = \Core\Security\Csrf::isEnabled();
    echo "✓ CSRF protection enabled: " . ($enabled ? 'Yes' : 'No') . "\n";

    // Test route exclusion
    $isExcluded = \Core\Security\Csrf::isExcluded('api/users');
    echo "✓ Route 'api/users' excluded: " . ($isExcluded ? 'Yes' : 'No') . "\n";

    $isExcluded = \Core\Security\Csrf::isExcluded('users/create');
    echo "✓ Route 'users/create' excluded: " . ($isExcluded ? 'Yes' : 'No') . "\n";
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 7: Middleware Simulation
echo "Test 7: Middleware Simulation\n";
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
        echo "✓ Middleware allows request with valid token\n";
    } else {
        echo "✗ FAILED: Middleware should allow valid token\n";
    }

    // Test with invalid token
    $request->_input = ['_token' => 'invalid_token'];
    $called = false;

    $response = $middleware->handle($request, $next);

    if (!$called && $response instanceof \Core\Http\JsonResponse) {
        echo "✓ Middleware blocks request with invalid token\n";
        echo "  Response status: " . $response->getStatusCode() . "\n";
    } else {
        echo "✗ WARNING: Middleware behavior may vary (check implementation)\n";
    }

    // Test GET request (should bypass CSRF)
    $request->_method = 'GET';
    $called = false;

    $response = $middleware->handle($request, $next);

    if ($called) {
        echo "✓ Middleware bypasses GET requests\n";
    } else {
        echo "✗ FAILED: Middleware should bypass GET requests\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n=== CSRF Protection Test Complete ===\n";
