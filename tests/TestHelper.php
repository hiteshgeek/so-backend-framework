<?php

/**
 * Test Helper
 *
 * Provides colorful output utilities for test files
 */
class TestHelper
{
    /**
     * ANSI color codes
     */
    protected static array $colors = [
        'header' => "\033[1;36m",      // Bright cyan
        'success' => "\033[1;32m",     // Bright green
        'error' => "\033[1;31m",       // Bright red
        'warning' => "\033[1;33m",     // Bright yellow
        'info' => "\033[1;34m",        // Bright blue
        'bold' => "\033[1m",           // Bold
        'reset' => "\033[0m",          // Reset
    ];

    /**
     * Colorize text
     */
    public static function colorize(string $text, string $color): string
    {
        if (!isset(self::$colors[$color])) {
            return $text;
        }
        return self::$colors[$color] . $text . self::$colors['reset'];
    }

    /**
     * Print colored header
     */
    public static function header(string $text): void
    {
        echo self::colorize("=== {$text} ===", 'header') . "\n";
    }

    /**
     * Print test number/name
     */
    public static function test(string $text): void
    {
        echo "\n" . self::colorize($text, 'info') . "\n";
    }

    /**
     * Print success message
     */
    public static function success(string $text): void
    {
        echo self::colorize("✓ {$text}", 'success') . "\n";
    }

    /**
     * Print error message
     */
    public static function error(string $text): void
    {
        echo self::colorize("✗ {$text}", 'error') . "\n";
    }

    /**
     * Print warning message
     */
    public static function warning(string $text): void
    {
        echo self::colorize("⚠ {$text}", 'warning') . "\n";
    }

    /**
     * Print info message
     */
    public static function info(string $text): void
    {
        echo self::colorize($text, 'info') . "\n";
    }

    /**
     * Print summary
     */
    public static function summary(int $passed, int $failed): void
    {
        echo "\n" . self::colorize("=== Test Summary ===", 'header') . "\n";
        echo self::colorize("Passed: {$passed}", 'success') . "\n";
        if ($failed > 0) {
            echo self::colorize("Failed: {$failed}", 'error') . "\n";
        } else {
            echo "Failed: {$failed}\n";
        }
        echo "\n";

        if ($failed === 0) {
            echo self::colorize("✓ ALL TESTS PASSED", 'success') . "\n";
        } else {
            echo self::colorize("✗ SOME TESTS FAILED", 'error') . "\n";
        }
    }

    /**
     * Colorize Yes/No values (Yes=green, No=red)
     */
    public static function yesNo(string $text, bool $value): string
    {
        $valueText = $value ? 'Yes' : 'No';
        $color = $value ? 'success' : 'error';
        return $text . self::colorize($valueText, $color);
    }

    /**
     * Colorize Yes/No informational (Yes=green, No=yellow)
     */
    public static function yesNoInfo(string $text, bool $value): string
    {
        $valueText = $value ? 'Yes' : 'No';
        $color = $value ? 'success' : 'warning';
        return $text . self::colorize($valueText, $color);
    }

    /**
     * Print test complete message
     */
    public static function complete(string $testName): void
    {
        echo "\n" . self::colorize("=== {$testName} Complete ===", 'header') . "\n\n";
    }
}
