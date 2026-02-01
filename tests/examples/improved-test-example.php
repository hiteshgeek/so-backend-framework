<?php

/**
 * Improved Test Example
 *
 * Demonstrates using TestHelper HTTP methods for cleaner, more maintainable tests.
 * This shows the BEFORE and AFTER comparison.
 */

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../bootstrap/app.php';
require_once __DIR__ . '/../TestHelper.php';

TestHelper::header('Improved Test Example');
echo "\n";

$baseUrl = 'http://sixorbit.be.local';
$passedTests = 0;
$totalTests = 0;

// ==========================================
// BEFORE: Verbose curl code (OLD WAY) ❌
// ==========================================

echo "━━━ BEFORE (OLD WAY - Verbose) ━━━\n\n";

echo "Test 1: Old verbose curl approach\n";
$totalTests++;
try {
    // ❌ 6 lines of boilerplate code
    $ch = curl_init($baseUrl . '/api/health');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $data = json_decode($response, true);

    if ($httpCode === 200 && isset($data['data']['status'])) {
        echo "✓ Health check passed\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Health check failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==========================================
// AFTER: Clean helper methods (NEW WAY) ✅
// ==========================================

echo "━━━ AFTER (NEW WAY - Clean & Efficient) ━━━\n\n";

echo "Test 2: New clean helper approach\n";
$totalTests++;
try {
    // ✅ 1 line instead of 6!
    $response = TestHelper::get($baseUrl . '/api/health');

    // Clean assertions
    if (TestHelper::assertStatus(200, $response['status']) &&
        TestHelper::assertHasKey($response['data'], 'data')) {
        $passedTests++;
    }
} catch (Exception $e) {
    TestHelper::error("FAILED: " . $e->getMessage());
}

echo "\n";

// ==========================================
// POST Request Example
// ==========================================

echo "Test 3: Clean POST request\n";
$totalTests++;
try {
    // ✅ Clean and readable
    $response = TestHelper::post(
        $baseUrl . '/api/auth/login',
        [
            'email' => 'admin@test.com',
            'password' => '12345678'
        ]
    );

    if (TestHelper::assertStatus(200, $response['status'])) {
        TestHelper::assertHasKey($response['data'], 'data');
        $passedTests++;
    }
} catch (Exception $e) {
    TestHelper::error("FAILED: " . $e->getMessage());
}

echo "\n";

// ==========================================
// Summary
// ==========================================

TestHelper::summary($passedTests, $totalTests - $passedTests, $totalTests);

echo "\n";
echo "Benefits of New Approach:\n";
echo "  ✓ 6 lines reduced to 1 line\n";
echo "  ✓ More readable and maintainable\n";
echo "  ✓ Consistent error handling\n";
echo "  ✓ Built-in JSON parsing\n";
echo "  ✓ Easier to write new tests\n";
echo "  ✓ Less code duplication\n\n";

echo "Available HTTP Methods:\n";
echo "  - TestHelper::get(\$url, \$headers)\n";
echo "  - TestHelper::post(\$url, \$data, \$headers)\n";
echo "  - TestHelper::put(\$url, \$data, \$headers)\n";
echo "  - TestHelper::patch(\$url, \$data, \$headers)\n";
echo "  - TestHelper::delete(\$url, \$headers)\n\n";

echo "Available Assertions:\n";
echo "  - TestHelper::assertStatus(\$expected, \$actual)\n";
echo "  - TestHelper::assertHasKey(\$data, \$key)\n";
echo "  - TestHelper::assertEquals(\$expected, \$actual)\n\n";

echo "Code Reduction:\n";
echo "  Before: 109 curl blocks × 6 lines = ~654 lines\n";
echo "  After:  109 helper calls × 1 line = ~109 lines\n";
echo "  Saved:  545 lines of boilerplate code!\n\n";
