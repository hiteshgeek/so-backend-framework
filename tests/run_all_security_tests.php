<?php

/**
 * Security Test Runner
 *
 * Runs all security-related tests and provides a summary report.
 */

echo "\n";
echo "╔═══════════════════════════════════════════════════════════════╗\n";
echo "║                 SECURITY LAYER TEST SUITE                     ║\n";
echo "║                  SO Backend Framework v1.0                    ║\n";
echo "╚═══════════════════════════════════════════════════════════════╝\n";
echo "\n";

$startTime = microtime(true);
$testsPassed = 0;
$testsFailed = 0;

// Test files to run
$tests = [
    'CSRF Protection' => 'test_csrf_protection.php',
    'JWT Authentication' => 'test_jwt_authentication.php',
    'Rate Limiting' => 'test_rate_limiting.php',
    'XSS Prevention' => 'test_xss_prevention.php',
];

echo "Running " . count($tests) . " test suites...\n\n";

foreach ($tests as $name => $file) {
    $testFile = __DIR__ . '/' . $file;

    if (!file_exists($testFile)) {
        echo "✗ SKIPPED: $name (file not found: $file)\n\n";
        $testsFailed++;
        continue;
    }

    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "Running: $name\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

    // Capture output
    ob_start();
    try {
        include $testFile;
        $output = ob_get_clean();

        // Count results
        $passed = substr_count($output, '✓');
        $failed = substr_count($output, '✗');

        echo $output;

        // Update totals
        $testsPassed += $passed;
        $testsFailed += $failed;

        echo "\n";
    } catch (Exception $e) {
        ob_end_clean();
        echo "✗ EXCEPTION: " . $e->getMessage() . "\n";
        echo "  File: " . $e->getFile() . "\n";
        echo "  Line: " . $e->getLine() . "\n\n";
        $testsFailed++;
    }
}

$endTime = microtime(true);
$duration = round($endTime - $startTime, 2);

// Summary Report
echo "\n";
echo "╔═══════════════════════════════════════════════════════════════╗\n";
echo "║                        TEST SUMMARY                           ║\n";
echo "╚═══════════════════════════════════════════════════════════════╝\n";
echo "\n";

$totalTests = $testsPassed + $testsFailed;
$passRate = $totalTests > 0 ? round(($testsPassed / $totalTests) * 100, 1) : 0;

echo "Total Tests:     " . $totalTests . "\n";
echo "Passed:          " . $testsPassed . " ✓\n";
echo "Failed:          " . $testsFailed . ($testsFailed > 0 ? " ✗" : "") . "\n";
echo "Pass Rate:       " . $passRate . "%\n";
echo "Duration:        " . $duration . " seconds\n";
echo "\n";

// Status
if ($testsFailed === 0) {
    echo "╔═══════════════════════════════════════════════════════════════╗\n";
    echo "║                   ✓ ALL TESTS PASSED ✓                       ║\n";
    echo "╚═══════════════════════════════════════════════════════════════╝\n";
    exit(0);
} else {
    echo "╔═══════════════════════════════════════════════════════════════╗\n";
    echo "║                  ⚠ SOME TESTS FAILED ⚠                       ║\n";
    echo "╚═══════════════════════════════════════════════════════════════╝\n";
    echo "\n";
    echo "Please review the output above for details.\n";
    exit(1);
}
