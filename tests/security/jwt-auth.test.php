<?php

/**
 * JWT Authentication Test
 *
 * Tests JWT token encoding, decoding, expiration, and middleware functionality.
 */

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../bootstrap/app.php';

echo "=== JWT Authentication Test ===\n\n";

// Set JWT secret for testing
putenv('JWT_SECRET=test_secret_key_for_jwt_testing_12345678');

// Test 1: JWT Instance Creation
echo "Test 1: JWT Instance Creation\n";
try {
    $jwt = new \Core\Security\JWT('test_secret_key', 'HS256');
    echo "✓ JWT instance created successfully\n";

    // Test factory method
    $jwt2 = \Core\Security\JWT::fromConfig();
    echo "✓ JWT instance created from config\n";
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Token Encoding
echo "Test 2: Token Encoding\n";
try {
    $jwt = new \Core\Security\JWT('test_secret_key', 'HS256');

    $payload = [
        'user_id' => 123,
        'username' => 'testuser',
        'role' => 'admin'
    ];

    $token = $jwt->encode($payload, 3600);
    echo "✓ Token encoded successfully\n";
    echo "  Token: " . substr($token, 0, 50) . "...\n";

    // Token should have 3 parts separated by dots
    $parts = explode('.', $token);
    if (count($parts) === 3) {
        echo "✓ Token has correct format (3 parts)\n";
    } else {
        echo "✗ FAILED: Token should have 3 parts, got " . count($parts) . "\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Token Decoding
echo "Test 3: Token Decoding\n";
try {
    $jwt = new \Core\Security\JWT('test_secret_key', 'HS256');

    $payload = [
        'user_id' => 456,
        'username' => 'johndoe',
        'email' => 'john@example.com'
    ];

    $token = $jwt->encode($payload, 3600);
    $decoded = $jwt->decode($token);

    if ($decoded['user_id'] === 456) {
        echo "✓ Token decoded successfully\n";
        echo "✓ user_id matches: " . $decoded['user_id'] . "\n";
    } else {
        echo "✗ FAILED: Decoded user_id doesn't match\n";
    }

    if ($decoded['username'] === 'johndoe') {
        echo "✓ username matches: " . $decoded['username'] . "\n";
    } else {
        echo "✗ FAILED: Decoded username doesn't match\n";
    }

    // Check for standard claims
    if (isset($decoded['iat'])) {
        echo "✓ Issued at (iat) claim present: " . date('Y-m-d H:i:s', $decoded['iat']) . "\n";
    }

    if (isset($decoded['exp'])) {
        echo "✓ Expiration (exp) claim present: " . date('Y-m-d H:i:s', $decoded['exp']) . "\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 4: Token Expiration
echo "Test 4: Token Expiration\n";
try {
    $jwt = new \Core\Security\JWT('test_secret_key', 'HS256');

    // Create token that expires in -1 second (already expired)
    $payload = ['user_id' => 789];
    $token = $jwt->encode($payload, -1);

    // Try to decode expired token
    try {
        $decoded = $jwt->decode($token);
        echo "✗ FAILED: Should throw exception for expired token\n";
    } catch (Exception $e) {
        if (str_contains($e->getMessage(), 'expired')) {
            echo "✓ Expired token rejected correctly\n";
            echo "  Error: " . $e->getMessage() . "\n";
        } else {
            echo "✗ FAILED: Wrong exception message: " . $e->getMessage() . "\n";
        }
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 5: Invalid Signature
echo "Test 5: Invalid Signature\n";
try {
    $jwt = new \Core\Security\JWT('test_secret_key', 'HS256');

    $payload = ['user_id' => 999];
    $token = $jwt->encode($payload, 3600);

    // Tamper with the token
    $parts = explode('.', $token);
    $parts[1] = base64_encode('{"user_id":1000}'); // Change payload
    $tamperedToken = implode('.', $parts);

    try {
        $decoded = $jwt->decode($tamperedToken);
        echo "✗ FAILED: Should reject tampered token\n";
    } catch (Exception $e) {
        if (str_contains($e->getMessage(), 'signature')) {
            echo "✓ Tampered token rejected (invalid signature)\n";
            echo "  Error: " . $e->getMessage() . "\n";
        } else {
            echo "✗ FAILED: Wrong exception message: " . $e->getMessage() . "\n";
        }
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 6: Invalid Token Format
echo "Test 6: Invalid Token Format\n";
try {
    $jwt = new \Core\Security\JWT('test_secret_key', 'HS256');

    $invalidTokens = [
        'not.a.valid.token.too.many.parts',
        'only.two.parts',
        'invalid_token_no_dots',
        ''
    ];

    foreach ($invalidTokens as $invalidToken) {
        try {
            $jwt->decode($invalidToken);
            echo "✗ FAILED: Should reject invalid format: $invalidToken\n";
        } catch (Exception $e) {
            echo "✓ Invalid format rejected: " . substr($invalidToken, 0, 20) . "...\n";
        }
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 7: Helper Function
echo "Test 7: Helper Function\n";
try {
    $jwt = jwt();
    echo "✓ jwt() helper returns JWT instance\n";

    $payload = ['user_id' => 111];
    $token = $jwt->encode($payload, 3600);
    echo "✓ Helper-created JWT can encode tokens\n";

    $decoded = $jwt->decode($token);
    if ($decoded['user_id'] === 111) {
        echo "✓ Helper-created JWT can decode tokens\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 8: Token Without Expiration
echo "Test 8: Token Without Expiration\n";
try {
    $jwt = new \Core\Security\JWT('test_secret_key', 'HS256');

    $payload = ['user_id' => 222];
    $token = $jwt->encode($payload, null); // No TTL

    $decoded = $jwt->decode($token);

    if (!isset($decoded['exp'])) {
        echo "✓ Token without expiration created successfully\n";
    } else {
        echo "✗ FAILED: Token should not have expiration\n";
    }

    if ($decoded['user_id'] === 222) {
        echo "✓ Token without expiration decodes correctly\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 9: Middleware Simulation
echo "Test 9: Middleware Simulation\n";
try {
    $jwt = new \Core\Security\JWT('test_secret_key', 'HS256');
    $token = $jwt->encode(['user_id' => 333], 3600);

    // Mock request with valid token
    $request = new \Core\Http\Request();
    $request->_headers = ['Authorization' => 'Bearer ' . $token];

    $middleware = new \App\Middleware\JwtMiddleware();
    $middleware->jwt = $jwt; // Inject JWT instance for testing

    $called = false;
    $next = function($req) use (&$called) {
        $called = true;
        return new \Core\Http\Response('OK');
    };

    // Note: This is a simplified test. Actual middleware may require more setup
    echo "✓ JwtMiddleware instance created\n";
    echo "  (Full middleware test requires request context setup)\n";

} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 10: Configuration
echo "Test 10: Configuration\n";
try {
    $ttl = \Core\Security\JWT::getDefaultTtl();
    echo "✓ Default TTL from config: " . $ttl . " seconds (" . ($ttl / 60) . " minutes)\n";
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n=== JWT Authentication Test Complete ===\n";
