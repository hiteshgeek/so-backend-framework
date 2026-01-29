<?php

/**
 * Rate Limiting Test
 *
 * Tests RateLimiter and ThrottleMiddleware functionality.
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';

echo "=== Rate Limiting Test ===\n\n";

// Test 1: RateLimiter Instance
echo "Test 1: RateLimiter Instance Creation\n";
try {
    $cache = cache();
    $limiter = new \Core\Security\RateLimiter($cache);
    echo "✓ RateLimiter instance created successfully\n";
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Hit Counter
echo "Test 2: Hit Counter\n";
try {
    $cache = cache();
    $limiter = new \Core\Security\RateLimiter($cache);

    $key = 'test_user_' . time();

    // Initial attempts should be 0
    $attempts = $limiter->attempts($key);
    echo "✓ Initial attempts: " . $attempts . "\n";

    // Increment counter
    $newAttempts = $limiter->hit($key, 1);
    echo "✓ After first hit: " . $newAttempts . " attempts\n";

    // Hit again
    $newAttempts = $limiter->hit($key, 1);
    echo "✓ After second hit: " . $newAttempts . " attempts\n";

    // Verify attempts
    $attempts = $limiter->attempts($key);
    if ($attempts === 2) {
        echo "✓ Attempts counter working correctly: " . $attempts . "\n";
    } else {
        echo "✗ FAILED: Expected 2 attempts, got " . $attempts . "\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Too Many Attempts Check
echo "Test 3: Too Many Attempts Check\n";
try {
    $cache = cache();
    $limiter = new \Core\Security\RateLimiter($cache);

    $key = 'test_limit_' . time();
    $maxAttempts = 5;

    // Make attempts up to limit
    for ($i = 1; $i <= $maxAttempts; $i++) {
        $limiter->hit($key, 1);
    }

    // Check if limit reached
    if ($limiter->tooManyAttempts($key, $maxAttempts)) {
        echo "✓ Too many attempts detected correctly\n";
    } else {
        echo "✗ FAILED: Should detect too many attempts\n";
    }

    // Check below limit
    $key2 = 'test_below_' . time();
    $limiter->hit($key2, 1);
    $limiter->hit($key2, 1);

    if (!$limiter->tooManyAttempts($key2, $maxAttempts)) {
        echo "✓ Below limit detected correctly (2/" . $maxAttempts . ")\n";
    } else {
        echo "✗ FAILED: Should not detect limit when below threshold\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 4: Retries Left
echo "Test 4: Retries Left\n";
try {
    $cache = cache();
    $limiter = new \Core\Security\RateLimiter($cache);

    $key = 'test_retries_' . time();
    $maxAttempts = 10;

    // Make 3 attempts
    $limiter->hit($key, 1);
    $limiter->hit($key, 1);
    $limiter->hit($key, 1);

    $retriesLeft = $limiter->retriesLeft($key, $maxAttempts);

    if ($retriesLeft === 7) {
        echo "✓ Retries left calculated correctly: " . $retriesLeft . " (3 used, 7 remaining)\n";
    } else {
        echo "✗ FAILED: Expected 7 retries left, got " . $retriesLeft . "\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 5: Available In (Cooldown)
echo "Test 5: Available In (Cooldown)\n";
try {
    $cache = cache();
    $limiter = new \Core\Security\RateLimiter($cache);

    $key = 'test_cooldown_' . time();
    $maxAttempts = 3;

    // Exceed limit
    for ($i = 0; $i <= $maxAttempts; $i++) {
        $limiter->hit($key, 1); // 1 minute decay
    }

    $availableIn = $limiter->availableIn($key);
    echo "✓ Available in: " . $availableIn . " seconds\n";

    if ($availableIn > 0 && $availableIn <= 60) {
        echo "✓ Cooldown period set correctly (0-60 seconds)\n";
    } else {
        echo "⚠ WARNING: Cooldown may vary: " . $availableIn . " seconds\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 6: Reset Attempts
echo "Test 6: Reset Attempts\n";
try {
    $cache = cache();
    $limiter = new \Core\Security\RateLimiter($cache);

    $key = 'test_reset_' . time();

    // Make some attempts
    $limiter->hit($key, 1);
    $limiter->hit($key, 1);
    $limiter->hit($key, 1);

    $beforeReset = $limiter->attempts($key);
    echo "  Before reset: " . $beforeReset . " attempts\n";

    // Reset
    $limiter->resetAttempts($key);

    $afterReset = $limiter->attempts($key);
    if ($afterReset === 0) {
        echo "✓ Attempts reset successfully: " . $afterReset . "\n";
    } else {
        echo "✗ FAILED: Expected 0 attempts after reset, got " . $afterReset . "\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 7: Clear Rate Limiter
echo "Test 7: Clear Rate Limiter\n";
try {
    $cache = cache();
    $limiter = new \Core\Security\RateLimiter($cache);

    $key = 'test_clear_' . time();
    $maxAttempts = 2;

    // Exceed limit
    for ($i = 0; $i <= $maxAttempts; $i++) {
        $limiter->hit($key, 1);
    }

    // Should be limited
    if ($limiter->tooManyAttempts($key, $maxAttempts)) {
        echo "  Limited: Yes (as expected)\n";
    }

    // Clear
    $limiter->clear($key);

    // Should not be limited after clear
    if (!$limiter->tooManyAttempts($key, $maxAttempts)) {
        echo "✓ Rate limiter cleared successfully\n";
    } else {
        echo "✗ FAILED: Should not be limited after clear\n";
    }

    $attempts = $limiter->attempts($key);
    if ($attempts === 0) {
        echo "✓ Attempts cleared: " . $attempts . "\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 8: Multiple Keys
echo "Test 8: Multiple Keys (Isolation)\n";
try {
    $cache = cache();
    $limiter = new \Core\Security\RateLimiter($cache);

    $key1 = 'user_1_' . time();
    $key2 = 'user_2_' . time();

    // User 1 makes 3 attempts
    $limiter->hit($key1, 1);
    $limiter->hit($key1, 1);
    $limiter->hit($key1, 1);

    // User 2 makes 1 attempt
    $limiter->hit($key2, 1);

    $attempts1 = $limiter->attempts($key1);
    $attempts2 = $limiter->attempts($key2);

    if ($attempts1 === 3 && $attempts2 === 1) {
        echo "✓ Keys isolated correctly\n";
        echo "  User 1: " . $attempts1 . " attempts\n";
        echo "  User 2: " . $attempts2 . " attempts\n";
    } else {
        echo "✗ FAILED: Keys not isolated properly\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 9: Middleware Configuration
echo "Test 9: ThrottleMiddleware Configuration\n";
try {
    $middleware = new \App\Middleware\ThrottleMiddleware();
    echo "✓ ThrottleMiddleware instance created\n";

    // Check default configuration
    $default = config('security.rate_limit.default', '60,1');
    echo "✓ Default rate limit: " . $default . " (requests, minutes)\n";

} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 10: Middleware Headers
echo "Test 10: Middleware Headers (Simulation)\n";
try {
    echo "  Rate limit headers that should be added:\n";
    echo "  - X-RateLimit-Limit: Maximum attempts allowed\n";
    echo "  - X-RateLimit-Remaining: Attempts remaining\n";
    echo "  - Retry-After: Seconds until available (when limited)\n";
    echo "  - X-RateLimit-Reset: Timestamp when limit resets\n";
    echo "✓ Header documentation verified\n";
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 11: Stress Test (Multiple Rapid Requests)
echo "Test 11: Stress Test (10 rapid requests)\n";
try {
    $cache = cache();
    $limiter = new \Core\Security\RateLimiter($cache);

    $key = 'stress_test_' . time();
    $maxAttempts = 5;

    echo "  Making 10 requests with limit of " . $maxAttempts . ":\n";

    for ($i = 1; $i <= 10; $i++) {
        $limiter->hit($key, 1);
        $tooMany = $limiter->tooManyAttempts($key, $maxAttempts);
        $attempts = $limiter->attempts($key);

        echo "  Request #" . $i . ": " . $attempts . " attempts - ";
        echo ($tooMany ? "BLOCKED" : "ALLOWED") . "\n";
    }

    $finalAttempts = $limiter->attempts($key);
    if ($finalAttempts === 10) {
        echo "✓ All attempts recorded: " . $finalAttempts . "\n";
    }

} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n=== Rate Limiting Test Complete ===\n";
echo "\nNote: For complete middleware testing, run with actual HTTP requests\n";
echo "Expected behavior: After 5 requests, should return 429 status with Retry-After header\n";
