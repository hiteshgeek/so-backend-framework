<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Test Command
 *
 * Run framework tests organized by category
 *
 * Usage:
 *   php sixorbit test                    # Show help/list tests
 *   php sixorbit test --all              # Run all tests
 *   php sixorbit test --list             # List all tests
 *   php sixorbit test security           # Run security category
 *   php sixorbit test csrf               # Run specific test
 */
class TestCommand extends Command
{
    protected string $signature = 'test {target?} {--list} {--l} {--all} {--summary} {--s}';
    protected string $description = 'Run framework tests';

    /**
     * ANSI color codes for terminal output
     */
    protected array $colors = [
        'header' => "\033[1;36m",      // Bright cyan
        'success' => "\033[1;32m",     // Bright green
        'error' => "\033[1;31m",       // Bright red
        'warning' => "\033[1;33m",     // Bright yellow
        'info' => "\033[1;34m",        // Bright blue
        'reset' => "\033[0m",          // Reset
    ];

    /**
     * Test suites organized by category
     */
    protected array $testSuites = [
        'security' => [
            'csrf' => ['name' => 'CSRF Protection', 'file' => 'Integration/security/csrf-protection.test.php'],
            'jwt' => ['name' => 'JWT Authentication', 'file' => 'Integration/security/jwt-auth.test.php'],
            'rate-limit' => ['name' => 'Rate Limiting', 'file' => 'Integration/security/rate-limit.test.php'],
            'xss' => ['name' => 'XSS Prevention', 'file' => 'Integration/security/xss-prevention.test.php'],
            'sanitizer' => ['name' => 'Sanitizer Bypass Prevention', 'file' => 'Integration/security/sanitizer-bypass.test.php'],
            'auth-lockout' => ['name' => 'Auth Account Lockout', 'file' => 'Integration/security/auth-lockout.test.php'],
        ],
        'infrastructure' => [
            'cache' => ['name' => 'Cache and Sessions', 'file' => 'Integration/infrastructure/cache-sessions.test.php'],
            'file-cache' => ['name' => 'File Cache Driver', 'file' => 'Integration/infrastructure/file-cache.test.php'],
            'queue' => ['name' => 'Queue System', 'file' => 'Integration/infrastructure/queue.test.php'],
            'notifications' => ['name' => 'Notification System', 'file' => 'Integration/infrastructure/notifications.test.php'],
            'activity' => ['name' => 'Activity Logging', 'file' => 'Integration/infrastructure/activity-logging.test.php'],
            'session-encryption' => ['name' => 'Session Encryption', 'file' => 'Integration/infrastructure/session-encryption.test.php'],
        ],
        'application' => [
            'validation' => ['name' => 'Validation System', 'file' => 'Integration/application/validation.test.php'],
            'middleware' => ['name' => 'Middleware System', 'file' => 'Integration/application/middleware.test.php'],
            'api' => ['name' => 'Internal API Layer', 'file' => 'Integration/application/api-layer.test.php'],
            'api-versioning' => ['name' => 'API Versioning', 'file' => 'Integration/application/api-versioning.test.php'],
            'models' => ['name' => 'Model Enhancements', 'file' => 'Integration/application/model-relations.test.php'],
        ],
    ];

    /**
     * Execute the command
     */
    public function handle(): int
    {
        // Show list if --list flag is provided
        if ($this->option('list') || $this->option('l')) {
            return $this->showList();
        }

        // Get test target
        $target = $this->argument(0);

        // If no target and no --all flag, show help
        if ($target === null && !$this->option('all')) {
            return $this->showList();
        }

        // Run all tests if --all flag is provided
        if ($this->option('all')) {
            return $this->runAllTests();
        }

        // Run tests based on target
        if (isset($this->testSuites[$target])) {
            return $this->runCategory($target);
        } else {
            // Check if it's a specific test
            foreach ($this->testSuites as $category => $tests) {
                if (isset($tests[$target])) {
                    return $this->runSingleTest($tests[$target]['file'], $tests[$target]['name']);
                }
            }

            $this->error("Unknown test target: {$target}");
            $this->info("Use 'php sixorbit test --list' to see available tests");
            return 1;
        }
    }

    /**
     * Apply color to text
     */
    protected function colorize(string $text, string $color): string
    {
        if (!isset($this->colors[$color])) {
            return $text;
        }
        return $this->colors[$color] . $text . $this->colors['reset'];
    }

    /**
     * Show list of available tests
     */
    protected function showList(): int
    {
        $this->line('');
        $this->line($this->colorize('╔═══════════════════════════════════════════════════════════════╗', 'header'));
        $this->line($this->colorize('║              AVAILABLE TESTS                                  ║', 'header'));
        $this->line($this->colorize('╚═══════════════════════════════════════════════════════════════╝', 'header'));
        $this->line('');

        foreach ($this->testSuites as $category => $tests) {
            $categoryName = ucwords(str_replace('-', ' ', $category));
            $this->line($this->colorize("📁 {$categoryName}", 'header'));
            $this->line(str_repeat('─', 63));

            foreach ($tests as $key => $test) {
                $this->line(sprintf("  %-20s %s", $key, $test['name']));
            }

            $this->line('');
        }

        $this->line('Usage Examples:');
        $this->line('  php sixorbit test                    # Show this help');
        $this->line('  php sixorbit test --all              # Run all tests (detailed)');
        $this->line('  php sixorbit test --all --summary    # Run all tests (summary only)');
        $this->line('  php sixorbit test security           # Run security category');
        $this->line('  php sixorbit test security --summary # Run category (summary only)');
        $this->line('  php sixorbit test csrf               # Run specific test');
        $this->line('  php sixorbit test --list             # Show this help');
        $this->line('');

        return 0;
    }

    /**
     * Run all tests
     */
    protected function runAllTests(): int
    {
        $startTime = microtime(true);
        $summaryOnly = $this->option('summary') || $this->option('s');

        $this->line('');
        $this->line($this->colorize('╔═══════════════════════════════════════════════════════════════╗', 'header'));
        $this->line($this->colorize('║              SO BACKEND FRAMEWORK - TEST SUITE                ║', 'header'));
        $this->line($this->colorize('║                        Version 2.0                            ║', 'header'));
        $this->line($this->colorize('╚═══════════════════════════════════════════════════════════════╝', 'header'));
        $this->line('');

        if ($summaryOnly) {
            $this->line($this->colorize('Running in SUMMARY mode - detailed output suppressed', 'info'));
            $this->line('');
        }

        $categoryStats = [];
        $totalPassed = 0;
        $totalFailed = 0;

        foreach ($this->testSuites as $category => $tests) {
            if (!$summaryOnly) {
                $this->line($this->colorize('╔═══════════════════════════════════════════════════════════════╗', 'header'));
                $categoryName = ucwords(str_replace('-', ' ', $category));
                $this->line($this->colorize('║  ' . str_pad($categoryName, 61) . '║', 'header'));
                $this->line($this->colorize('╚═══════════════════════════════════════════════════════════════╝', 'header'));
                $this->line('');
            }

            $catPassed = 0;
            $catFailed = 0;

            foreach ($tests as $key => $test) {
                if ($summaryOnly) {
                    // Summary mode: show running indicator
                    $this->line($this->colorize("Running: {$test['name']}...", 'info'));
                } else {
                    // Detailed mode: show full header
                    $this->line($this->colorize("Running: {$test['name']}", 'info'));
                    $this->line(str_repeat('─', 63));
                }

                $result = $this->runTest($test['file'], !$summaryOnly);

                $catPassed += $result['passed'];
                $catFailed += $result['failed'];
                $totalPassed += $result['passed'];
                $totalFailed += $result['failed'];

                $total = $result['passed'] + $result['failed'];
                if ($total > 0) {
                    if ($summaryOnly) {
                        // Summary mode: compact output
                        $status = $result['failed'] === 0 ? '✓' : '✗';
                        $color = $result['failed'] === 0 ? 'success' : 'error';
                        $this->line($this->colorize("  {$status} {$result['passed']}/{$total} passed", $color));
                    } else {
                        // Detailed mode: table output
                        $passRate = round(($result['passed'] / $total) * 100, 1);
                        $this->line($this->colorize("Total Tests: {$total}", 'info'));
                        $this->line(str_repeat('─', 45));
                        $this->line($this->colorize(sprintf("  %-12s │ %10s │ %10s", "Status", "Count", "Percentage"), 'header'));
                        $this->line(str_repeat('─', 45));
                        $this->line($this->colorize(sprintf("  %-12s │ %10d │ %9.1f%%", "Passed", $result['passed'], $passRate), 'success'));

                        if ($result['failed'] > 0) {
                            $failRate = round(($result['failed'] / $total) * 100, 1);
                            $this->line($this->colorize(sprintf("  %-12s │ %10d │ %9.1f%%", "Failed", $result['failed'], $failRate), 'error'));
                        }

                        if ($result['warnings'] > 0) {
                            $warnRate = round(($result['warnings'] / $total) * 100, 1);
                            $this->line($this->colorize(sprintf("  %-12s │ %10d │ %9.1f%%", "Warnings", $result['warnings'], $warnRate), 'warning'));
                        }
                        $this->line(str_repeat('─', 45));
                    }
                }

                if (!$summaryOnly) {
                    $this->line('');
                }
            }

            $categoryStats[$category] = [
                'passed' => $catPassed,
                'failed' => $catFailed,
            ];

            $catTotal = $catPassed + $catFailed;
            if ($catTotal > 0) {
                $catPassRate = round(($catPassed / $catTotal) * 100, 1);
                $categoryName = ucwords(str_replace('-', ' ', $category));
                $summaryText = "{$categoryName}: {$catPassed}/{$catTotal} passed ({$catPassRate}%)";
                if ($catFailed === 0) {
                    $this->line($this->colorize($summaryText . ' ✓', 'success'));
                } else {
                    $this->line($this->colorize($summaryText . ' ✗', 'warning'));
                }
                $this->line('');
            }
        }

        // Overall summary
        $this->showSummary($categoryStats, $totalPassed, $totalFailed, $startTime);

        return $totalFailed > 0 ? 1 : 0;
    }

    /**
     * Run a category of tests
     */
    protected function runCategory(string $category): int
    {
        if (!isset($this->testSuites[$category])) {
            $this->error("Unknown category: {$category}");
            return 1;
        }

        $startTime = microtime(true);
        $summaryOnly = $this->option('summary') || $this->option('s');
        $categoryName = ucwords(str_replace('-', ' ', $category));

        $this->line('');
        $this->line($this->colorize('╔═══════════════════════════════════════════════════════════════╗', 'header'));
        $this->line($this->colorize('║  ' . str_pad($categoryName . ' Tests', 61) . '║', 'header'));
        $this->line($this->colorize('╚═══════════════════════════════════════════════════════════════╝', 'header'));
        $this->line('');

        if ($summaryOnly) {
            $this->line($this->colorize('Running in SUMMARY mode - detailed output suppressed', 'info'));
            $this->line('');
        }

        $totalPassed = 0;
        $totalFailed = 0;

        foreach ($this->testSuites[$category] as $key => $test) {
            if ($summaryOnly) {
                $this->line($this->colorize("Running: {$test['name']}...", 'info'));
            } else {
                $this->line($this->colorize("Running: {$test['name']}", 'info'));
                $this->line(str_repeat('─', 63));
            }

            $result = $this->runTest($test['file'], !$summaryOnly);

            $totalPassed += $result['passed'];
            $totalFailed += $result['failed'];

            $total = $result['passed'] + $result['failed'];
            if ($total > 0) {
                if ($summaryOnly) {
                    $status = $result['failed'] === 0 ? '✓' : '✗';
                    $color = $result['failed'] === 0 ? 'success' : 'error';
                    $this->line($this->colorize("  {$status} {$result['passed']}/{$total} passed", $color));
                } else {
                    $passRate = round(($result['passed'] / $total) * 100, 1);
                    $this->line($this->colorize("Total Tests: {$total}", 'info'));
                    $this->line(str_repeat('─', 45));
                    $this->line($this->colorize(sprintf("  %-12s │ %10s │ %10s", "Status", "Count", "Percentage"), 'header'));
                    $this->line(str_repeat('─', 45));
                    $this->line($this->colorize(sprintf("  %-12s │ %10d │ %9.1f%%", "Passed", $result['passed'], $passRate), 'success'));

                    if ($result['failed'] > 0) {
                        $failRate = round(($result['failed'] / $total) * 100, 1);
                        $this->line($this->colorize(sprintf("  %-12s │ %10d │ %9.1f%%", "Failed", $result['failed'], $failRate), 'error'));
                    }

                    if ($result['warnings'] > 0) {
                        $warnRate = round(($result['warnings'] / $total) * 100, 1);
                        $this->line($this->colorize(sprintf("  %-12s │ %10d │ %9.1f%%", "Warnings", $result['warnings'], $warnRate), 'warning'));
                    }
                    $this->line(str_repeat('─', 45));
                }
            }

            if (!$summaryOnly) {
                $this->line('');
            }
        }

        $total = $totalPassed + $totalFailed;
        $duration = round(microtime(true) - $startTime, 2);

        $this->line('');
        $this->line($this->colorize('╔═══════════════════════════════════════════════════════════════╗', 'header'));
        $this->line($this->colorize('║                        SUMMARY                                ║', 'header'));
        $this->line($this->colorize('╚═══════════════════════════════════════════════════════════════╝', 'header'));
        $this->line('');
        $this->line("Total Tests: {$total}");
        $this->line($this->colorize("Passed:      {$totalPassed} ✓", 'success'));
        if ($totalFailed > 0) {
            $this->line($this->colorize("Failed:      {$totalFailed} ✗", 'error'));
        } else {
            $this->line("Failed:      {$totalFailed}");
        }
        $this->line("Duration:    {$duration} seconds");
        $this->line('');

        if ($totalFailed === 0 && $total > 0) {
            $this->line($this->colorize('✓ ALL TESTS PASSED ✓', 'success'));
        } else {
            $this->line($this->colorize('⚠ SOME TESTS FAILED ⚠', 'error'));
        }

        return $totalFailed > 0 ? 1 : 0;
    }

    /**
     * Run a single test file
     */
    protected function runSingleTest(string $file, string $name): int
    {
        $this->line('');
        $this->line($this->colorize("Running: {$name}", 'info'));
        $this->line(str_repeat('─', 63));
        $this->line('');

        $result = $this->runTest($file, true);

        $total = $result['passed'] + $result['failed'];
        if ($total > 0) {
            $passRate = round(($result['passed'] / $total) * 100, 1);

            $this->line('');
            $this->line($this->colorize("Total Tests: {$total}", 'info'));
            $this->line(str_repeat('─', 45));
            $this->line($this->colorize(sprintf("  %-12s │ %10s │ %10s", "Status", "Count", "Percentage"), 'header'));
            $this->line(str_repeat('─', 45));
            $this->line($this->colorize(sprintf("  %-12s │ %10d │ %9.1f%%", "Passed", $result['passed'], $passRate), 'success'));

            if ($result['failed'] > 0) {
                $failRate = round(($result['failed'] / $total) * 100, 1);
                $this->line($this->colorize(sprintf("  %-12s │ %10d │ %9.1f%%", "Failed", $result['failed'], $failRate), 'error'));
            }

            if ($result['warnings'] > 0) {
                $warnRate = round(($result['warnings'] / $total) * 100, 1);
                $this->line($this->colorize(sprintf("  %-12s │ %10d │ %9.1f%%", "Warnings", $result['warnings'], $warnRate), 'warning'));
            }
            $this->line(str_repeat('─', 45));

            $this->line('');
            if ($result['failed'] === 0) {
                $this->line($this->colorize('✓ ALL TESTS PASSED', 'success'));
            } else {
                $this->line($this->colorize('✗ SOME TESTS FAILED', 'error'));
            }
        }

        return $result['failed'] > 0 ? 1 : 0;
    }

    /**
     * Run a test file and return results
     */
    protected function runTest(string $file, bool $showOutput = false): array
    {
        $testFile = __DIR__ . '/../../../tests/' . $file;

        if (!file_exists($testFile)) {
            $this->error("Test file not found: {$file}");
            return ['passed' => 0, 'failed' => 1, 'warnings' => 0];
        }

        ob_start();
        try {
            include $testFile;
            $output = ob_get_clean();

            if ($showOutput) {
                echo $this->colorizeTestOutput($output);
            }

            $passed = substr_count($output, '✓');
            $failed = substr_count($output, '✗');
            $warnings = substr_count($output, '⚠');

            return ['passed' => $passed, 'failed' => $failed, 'warnings' => $warnings];
        } catch (\Exception $e) {
            ob_end_clean();
            $this->error("Exception: " . $e->getMessage());
            return ['passed' => 0, 'failed' => 1, 'warnings' => 0];
        }
    }

    /**
     * Colorize test output automatically
     */
    protected function colorizeTestOutput(string $output): string
    {
        $lines = explode("\n", $output);
        $colorized = [];

        foreach ($lines as $line) {
            // Skip ANSI escape codes (already colored)
            if (strpos($line, "\033[") !== false) {
                $colorized[] = $line;
                continue;
            }

            // Headers with === or ╔═══
            if (preg_match('/^(===.*===|╔═+╗|║.*║|╚═+╝)$/', $line)) {
                $colorized[] = $this->colorize($line, 'header');
            }
            // Success indicators
            elseif (preg_match('/^(\s*✓|.*\bPASSED\b|.*\bSuccess\b)/i', $line) && !preg_match('/\bFAILED\b/i', $line)) {
                $colorized[] = $this->colorize($line, 'success');
            }
            // Failure indicators
            elseif (preg_match('/^(\s*✗|.*\bFAILED\b|.*\bERROR\b)/i', $line)) {
                $colorized[] = $this->colorize($line, 'error');
            }
            // Warning indicators
            elseif (preg_match('/^(\s*⚠|.*\bSkipped\b|.*\bWarning\b)/i', $line)) {
                $colorized[] = $this->colorize($line, 'warning');
            }
            // Test numbers and names
            elseif (preg_match('/^(Test \d+:|Running:|Setup:|Cleanup:)/', $line)) {
                $colorized[] = $this->colorize($line, 'info');
            }
            // Summary sections
            elseif (preg_match('/^(Total Tests?:|Passed:|Failed:|Success Rate:|Duration:)/i', $line)) {
                if (preg_match('/Passed:/i', $line)) {
                    $colorized[] = $this->colorize($line, 'success');
                } elseif (preg_match('/Failed:/i', $line) && !preg_match('/Failed:\s*0/', $line)) {
                    $colorized[] = $this->colorize($line, 'error');
                } else {
                    $colorized[] = $line;
                }
            }
            // Section dividers
            elseif (preg_match('/^[-─=]+$/', $line)) {
                $colorized[] = $this->colorize($line, 'header');
            }
            // Default: no coloring
            else {
                $colorized[] = $line;
            }
        }

        return implode("\n", $colorized);
    }

    /**
     * Show overall summary
     */
    protected function showSummary(array $categoryStats, int $totalPassed, int $totalFailed, float $startTime): void
    {
        $duration = round(microtime(true) - $startTime, 2);

        $this->line($this->colorize('╔═══════════════════════════════════════════════════════════════╗', 'header'));
        $this->line($this->colorize('║                      OVERALL SUMMARY                          ║', 'header'));
        $this->line($this->colorize('╚═══════════════════════════════════════════════════════════════╝', 'header'));
        $this->line('');

        $this->line('Results by Category:');
        $this->line(str_repeat('─', 63));

        foreach ($categoryStats as $category => $stats) {
            $catTotal = $stats['passed'] + $stats['failed'];
            if ($catTotal > 0) {
                $passRate = round(($stats['passed'] / $catTotal) * 100, 1);
                $status = $stats['failed'] === 0 ? '✓' : '✗';
                $categoryName = ucwords(str_replace('-', ' ', $category));
                $lineText = sprintf("  %-25s %3d/%3d passed (%5.1f%%) %s",
                    $categoryName . ':',
                    $stats['passed'],
                    $catTotal,
                    $passRate,
                    $status
                );
                if ($stats['failed'] === 0) {
                    $this->line($this->colorize($lineText, 'success'));
                } else {
                    $this->line($this->colorize($lineText, 'error'));
                }
            }
        }

        $this->line(str_repeat('─', 63));

        $totalTests = $totalPassed + $totalFailed;
        $overallPassRate = $totalTests > 0 ? round(($totalPassed / $totalTests) * 100, 1) : 0;

        $this->line('');
        $this->line("Total Tests:     {$totalTests}");
        $this->line($this->colorize("Passed:          {$totalPassed} ✓", 'success'));
        if ($totalFailed > 0) {
            $this->line($this->colorize("Failed:          {$totalFailed} ✗", 'error'));
        } else {
            $this->line("Failed:          {$totalFailed}");
        }
        $this->line("Pass Rate:       {$overallPassRate}%");
        $this->line("Duration:        {$duration} seconds");
        $this->line('');

        if ($totalFailed === 0 && $totalTests > 0) {
            $this->line($this->colorize('╔═══════════════════════════════════════════════════════════════╗', 'success'));
            $this->line($this->colorize('║                   ✓ ALL TESTS PASSED ✓                       ║', 'success'));
            $this->line($this->colorize('╚═══════════════════════════════════════════════════════════════╝', 'success'));
        } else {
            $this->line($this->colorize('╔═══════════════════════════════════════════════════════════════╗', 'error'));
            $this->line($this->colorize('║                  ⚠ SOME TESTS FAILED ⚠                       ║', 'error'));
            $this->line($this->colorize('╚═══════════════════════════════════════════════════════════════╝', 'error'));
        }
    }

    /**
     * Write a line to console
     */
    protected function line(string $message): void
    {
        echo $message . "\n";
    }
}
