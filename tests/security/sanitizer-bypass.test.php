#!/usr/bin/env php
<?php

/**
 * Sanitizer Bypass Prevention Tests
 *
 * Tests the enhanced sanitizer to ensure it prevents common XSS bypass techniques
 * using nested tags, malformed HTML, and dangerous attributes.
 */

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../TestHelper.php';

use Core\Security\Sanitizer;

TestHelper::header('Sanitizer Bypass Prevention Tests');
echo "\n";
TestHelper::info('Testing DOMDocument-based sanitizer against common bypass techniques...');
echo "\n";

$tests = [
    [
        'name' => 'Nested script tags',
        'input' => '<script><script>alert("XSS")</script></script>',
        'expected' => '', // All script content should be removed
        'category' => 'Tag Nesting',
    ],
    [
        'name' => 'Malformed script tags',
        'input' => '<scr<script>ipt>alert("XSS")</script>',
        'expected_not_contains' => '<script>', // Script tag should be removed
        'category' => 'Malformed HTML',
    ],
    [
        'name' => 'Multiple nested scripts',
        'input' => '<script><script><script>alert("XSS")</script></script></script>',
        'expected' => '', // All script content should be removed
        'category' => 'Tag Nesting',
    ],
    [
        'name' => 'Mixed case script tag',
        'input' => '<ScRiPt>alert("XSS")</sCrIpT>',
        'expected' => '',
        'category' => 'Case Manipulation',
    ],
    [
        'name' => 'Iframe with nested script',
        'input' => '<iframe><script>alert("XSS")</script></iframe>',
        'expected' => '',
        'category' => 'Tag Nesting',
    ],
    [
        'name' => 'Event handler attribute (onerror)',
        'input' => '<img src="x" onerror="alert(\'XSS\')">',
        'expected_contains' => '<img src="x">',
        'category' => 'Event Handlers',
    ],
    [
        'name' => 'Multiple event handlers',
        'input' => '<div onclick="alert(1)" onmouseover="alert(2)" onload="alert(3)">Test</div>',
        'expected_contains' => '<div>Test</div>',
        'category' => 'Event Handlers',
    ],
    [
        'name' => 'JavaScript protocol in href',
        'input' => '<a href="javascript:alert(\'XSS\')">Click</a>',
        'expected_contains' => '<a>Click</a>',
        'category' => 'Protocol Handlers',
    ],
    [
        'name' => 'Data URI XSS in img src',
        'input' => '<img src="data:text/html,<script>alert(\'XSS\')</script>">',
        'expected_contains' => '<img>',
        'category' => 'Protocol Handlers',
    ],
    [
        'name' => 'JavaScript protocol with whitespace',
        'input' => '<a href="  javascript:alert(\'XSS\')">Click</a>',
        'expected_contains' => '<a>Click</a>',
        'category' => 'Protocol Handlers',
    ],
    [
        'name' => 'Safe HTML should pass through',
        'input' => '<p>Hello <strong>World</strong></p>',
        'expected' => '<p>Hello <strong>World</strong></p>',
        'category' => 'Safe Content',
    ],
    [
        'name' => 'Plain text should pass through',
        'input' => 'Just plain text with no HTML',
        'expected' => 'Just plain text with no HTML',
        'category' => 'Safe Content',
    ],
    [
        'name' => 'Style tag removal',
        'input' => '<style>body { background: url("javascript:alert(1)"); }</style>',
        'expected' => '',
        'category' => 'Dangerous Tags',
    ],
    [
        'name' => 'Object tag removal',
        'input' => '<object data="evil.swf"></object>',
        'expected' => '',
        'category' => 'Dangerous Tags',
    ],
    [
        'name' => 'Embed tag removal',
        'input' => '<embed src="evil.swf">',
        'expected' => '',
        'category' => 'Dangerous Tags',
    ],
];

$passed = 0;
$failed = 0;
$categories = [];

foreach ($tests as $test) {
    $result = Sanitizer::clean($test['input']);

    if (isset($test['expected'])) {
        $success = ($result === $test['expected']);
    } elseif (isset($test['expected_contains'])) {
        $success = str_contains($result, $test['expected_contains']);
    } elseif (isset($test['expected_not_contains'])) {
        $success = !str_contains($result, $test['expected_not_contains']);
    } else {
        $success = false;
    }

    $category = $test['category'] ?? 'General';
    if (!isset($categories[$category])) {
        $categories[$category] = ['passed' => 0, 'failed' => 0];
    }

    if ($success) {
        TestHelper::success("PASS: {$test['name']}");
        $passed++;
        $categories[$category]['passed']++;
    } else {
        TestHelper::error("FAIL: {$test['name']}");
        echo "  Input:    {$test['input']}\n";

        if (isset($test['expected'])) {
            echo "  Expected: {$test['expected']}\n";
        } elseif (isset($test['expected_contains'])) {
            echo "  Expected: contains '{$test['expected_contains']}'\n";
        } elseif (isset($test['expected_not_contains'])) {
            echo "  Expected: does NOT contain '{$test['expected_not_contains']}'\n";
        }

        echo "  Got:      {$result}\n\n";
        $failed++;
        $categories[$category]['failed']++;
    }
}

echo "\n";
TestHelper::header('Summary by Category');
foreach ($categories as $category => $stats) {
    $total = $stats['passed'] + $stats['failed'];
    $line = sprintf("%-20s %d/%d passed", $category . ':', $stats['passed'], $total);
    if ($stats['failed'] === 0) {
        echo TestHelper::colorize($line, 'success') . "\n";
    } else {
        echo TestHelper::colorize($line, 'warning') . "\n";
    }
}

echo "\n";
TestHelper::header('Overall Summary');
echo "Total Tests: " . ($passed + $failed) . "\n";
echo TestHelper::colorize("Passed:      {$passed}", 'success') . "\n";
if ($failed > 0) {
    echo TestHelper::colorize("Failed:      {$failed}", 'error') . "\n";
} else {
    echo "Failed:      {$failed}\n";
}

echo "\n";
if ($failed === 0) {
    echo TestHelper::colorize("✓ ALL TESTS PASSED", 'success') . "\n";
    echo "\n";
    TestHelper::success("Sanitizer successfully prevents all tested bypass techniques!");
    echo "   - DOMDocument-based implementation handles nested/malformed tags\n";
    echo "   - Event handler attributes are properly removed\n";
    echo "   - Dangerous protocols (javascript:, data:) are filtered\n";
    echo "   - Safe HTML content is preserved\n";
} else {
    echo TestHelper::colorize("✗ SOME TESTS FAILED", 'error') . "\n";
}

exit($failed > 0 ? 1 : 0);
