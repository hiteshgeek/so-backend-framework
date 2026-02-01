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
    public static function summary(int $passed, int $failed, ?int $total = null): void
    {
        // Calculate total if not provided
        if ($total === null) {
            $total = $passed + $failed;
        }

        echo "\n" . self::colorize("=== Test Summary ===", 'header') . "\n";
        echo "Total Tests: {$total}\n";
        echo self::colorize("Passed: {$passed}", 'success') . "\n";
        if ($failed > 0) {
            echo self::colorize("Failed: {$failed}", 'error') . "\n";
        } else {
            echo "Failed: {$failed}\n";
        }

        if ($total > 0) {
            $successRate = round(($passed / $total) * 100, 1);
            echo "Success Rate: {$successRate}%\n";
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

    // ==========================================
    // HTTP Request Helpers
    // ==========================================

    /**
     * Make HTTP GET request
     *
     * @param string $url URL to request
     * @param array $headers Optional headers
     * @return array ['status' => int, 'body' => string, 'data' => array|null]
     */
    public static function get(string $url, array $headers = []): array
    {
        return self::request('GET', $url, null, $headers);
    }

    /**
     * Make HTTP POST request
     *
     * @param string $url URL to request
     * @param array|null $data Data to send
     * @param array $headers Optional headers
     * @return array ['status' => int, 'body' => string, 'data' => array|null]
     */
    public static function post(string $url, ?array $data = null, array $headers = []): array
    {
        return self::request('POST', $url, $data, $headers);
    }

    /**
     * Make HTTP PUT request
     *
     * @param string $url URL to request
     * @param array|null $data Data to send
     * @param array $headers Optional headers
     * @return array ['status' => int, 'body' => string, 'data' => array|null]
     */
    public static function put(string $url, ?array $data = null, array $headers = []): array
    {
        return self::request('PUT', $url, $data, $headers);
    }

    /**
     * Make HTTP PATCH request
     *
     * @param string $url URL to request
     * @param array|null $data Data to send
     * @param array $headers Optional headers
     * @return array ['status' => int, 'body' => string, 'data' => array|null]
     */
    public static function patch(string $url, ?array $data = null, array $headers = []): array
    {
        return self::request('PATCH', $url, $data, $headers);
    }

    /**
     * Make HTTP DELETE request
     *
     * @param string $url URL to request
     * @param array $headers Optional headers
     * @return array ['status' => int, 'body' => string, 'data' => array|null]
     */
    public static function delete(string $url, array $headers = []): array
    {
        return self::request('DELETE', $url, null, $headers);
    }

    /**
     * Make HTTP request (generic method)
     *
     * @param string $method HTTP method
     * @param string $url URL to request
     * @param array|null $data Optional data to send
     * @param array $headers Optional headers
     * @return array ['status' => int, 'body' => string, 'data' => array|null]
     */
    public static function request(string $method, string $url, ?array $data = null, array $headers = []): array
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        // Add JSON content type if data is provided
        if ($data !== null) {
            $jsonData = json_encode($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            $headers[] = 'Content-Type: application/json';
        }

        // Set headers
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Try to decode JSON response
        $jsonData = json_decode($response, true);

        return [
            'status' => $httpCode,
            'body' => $response,
            'data' => $jsonData,
        ];
    }

    /**
     * Assert HTTP status code
     *
     * @param int $expected Expected status code
     * @param int $actual Actual status code
     * @param string|null $message Optional custom message
     * @return bool True if matches
     */
    public static function assertStatus(int $expected, int $actual, ?string $message = null): bool
    {
        if ($expected === $actual) {
            $msg = $message ?? "Status code {$actual} matches expected";
            self::success($msg);
            return true;
        } else {
            $msg = $message ?? "Expected status {$expected}, got {$actual}";
            self::error($msg);
            return false;
        }
    }

    /**
     * Assert JSON response has key
     *
     * @param array|null $data JSON data
     * @param string $key Key to check
     * @param string|null $message Optional custom message
     * @return bool True if key exists
     */
    public static function assertHasKey(?array $data, string $key, ?string $message = null): bool
    {
        if ($data !== null && isset($data[$key])) {
            $msg = $message ?? "Response has key '{$key}'";
            self::success($msg);
            return true;
        } else {
            $msg = $message ?? "Response missing key '{$key}'";
            self::error($msg);
            return false;
        }
    }

    /**
     * Assert values are equal
     *
     * @param mixed $expected Expected value
     * @param mixed $actual Actual value
     * @param string|null $message Optional custom message
     * @return bool True if equal
     */
    public static function assertEquals($expected, $actual, ?string $message = null): bool
    {
        if ($expected === $actual) {
            $msg = $message ?? "Values match";
            self::success($msg);
            return true;
        } else {
            $expectedStr = is_array($expected) ? json_encode($expected) : $expected;
            $actualStr = is_array($actual) ? json_encode($actual) : $actual;
            $msg = $message ?? "Expected {$expectedStr}, got {$actualStr}";
            self::error($msg);
            return false;
        }
    }
}
