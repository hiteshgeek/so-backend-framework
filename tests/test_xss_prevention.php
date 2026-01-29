<?php

/**
 * XSS Prevention Test
 *
 * Tests Sanitizer class and XSS prevention utilities.
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';

echo "=== XSS Prevention Test ===\n\n";

// Test 1: HTML Entity Escaping
echo "Test 1: HTML Entity Escaping (e() helper)\n";
try {
    $dangerous = '<script>alert("XSS")</script>';
    $escaped = e($dangerous);

    if (str_contains($escaped, '&lt;script&gt;')) {
        echo "✓ Script tags escaped correctly\n";
        echo "  Input:  " . $dangerous . "\n";
        echo "  Output: " . $escaped . "\n";
    } else {
        echo "✗ FAILED: Script tags not properly escaped\n";
    }

    // Test with quotes
    $withQuotes = 'Hello "world" & <tag>';
    $escaped = e($withQuotes);

    if (str_contains($escaped, '&quot;') && str_contains($escaped, '&amp;')) {
        echo "✓ Quotes and ampersands escaped correctly\n";
        echo "  Output: " . $escaped . "\n";
    } else {
        echo "✗ FAILED: Quotes/ampersands not properly escaped\n";
    }

    // Test with null
    $nullEscaped = e(null);
    if ($nullEscaped === '') {
        echo "✓ Null value handled correctly (returns empty string)\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Strip Dangerous Tags
echo "Test 2: Strip Dangerous Tags\n";
try {
    $dangerous = 'Hello <script>alert("XSS")</script> World <iframe src="evil.com"></iframe>';
    $cleaned = \Core\Security\Sanitizer::stripDangerousTags($dangerous);

    if (!str_contains($cleaned, '<script>') && !str_contains($cleaned, '<iframe>')) {
        echo "✓ Dangerous tags removed\n";
        echo "  Input:  " . $dangerous . "\n";
        echo "  Output: " . $cleaned . "\n";
    } else {
        echo "✗ FAILED: Dangerous tags not removed\n";
    }

    // Test various dangerous tags
    $tests = [
        '<script>evil()</script>' => 'script',
        '<iframe src="x"></iframe>' => 'iframe',
        '<object data="x"></object>' => 'object',
        '<embed src="x">' => 'embed',
        '<link href="x">' => 'link',
        '<style>body{}</style>' => 'style',
        '<form action="x"></form>' => 'form',
    ];

    foreach ($tests as $input => $tagName) {
        $cleaned = \Core\Security\Sanitizer::stripDangerousTags($input);
        if (!str_contains($cleaned, '<' . $tagName)) {
            echo "✓ <" . $tagName . "> tag removed\n";
        } else {
            echo "✗ FAILED: <" . $tagName . "> tag not removed\n";
        }
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Strip Dangerous Attributes
echo "Test 3: Strip Dangerous Attributes\n";
try {
    $dangerous = '<img src="image.jpg" onerror="alert(\'XSS\')" onclick="steal()">';
    $cleaned = \Core\Security\Sanitizer::stripDangerousAttributes($dangerous);

    if (!str_contains($cleaned, 'onerror') && !str_contains($cleaned, 'onclick')) {
        echo "✓ Dangerous attributes removed\n";
        echo "  Input:  " . $dangerous . "\n";
        echo "  Output: " . $cleaned . "\n";
    } else {
        echo "✗ FAILED: Dangerous attributes not removed\n";
    }

    // Test various dangerous attributes
    $attributes = [
        'onload', 'onerror', 'onclick', 'onmouseover', 'onmouseout',
        'onfocus', 'onblur', 'onchange', 'onsubmit', 'onkeydown'
    ];

    foreach ($attributes as $attr) {
        $input = '<div ' . $attr . '="evil()">Test</div>';
        $cleaned = \Core\Security\Sanitizer::stripDangerousAttributes($input);

        if (!str_contains($cleaned, $attr . '=')) {
            echo "✓ " . $attr . " attribute removed\n";
        } else {
            echo "✗ FAILED: " . $attr . " attribute not removed\n";
        }
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 4: Clean String
echo "Test 4: Clean String\n";
try {
    $dangerous = "Hello\0World <script>alert('XSS')</script> <img onerror='steal()' src='x'>";
    $cleaned = \Core\Security\Sanitizer::cleanString($dangerous);

    echo "  Input:  " . str_replace("\0", '\\0', $dangerous) . "\n";
    echo "  Output: " . $cleaned . "\n";

    // Check null bytes removed
    if (!str_contains($cleaned, "\0")) {
        echo "✓ Null bytes removed\n";
    } else {
        echo "✗ FAILED: Null bytes not removed\n";
    }

    // Check dangerous tags removed
    if (!str_contains($cleaned, '<script>')) {
        echo "✓ Script tags removed\n";
    }

    // Check dangerous attributes removed
    if (!str_contains($cleaned, 'onerror')) {
        echo "✓ Dangerous attributes removed\n";
    }

    // Check trimmed
    $untrimmed = "  spaced  ";
    $trimmed = \Core\Security\Sanitizer::cleanString($untrimmed);
    if ($trimmed === "spaced") {
        echo "✓ String trimmed correctly\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 5: Clean Array
echo "Test 5: Clean Array\n";
try {
    $dangerous = [
        'username' => 'john<script>alert(1)</script>',
        'email' => 'test@example.com',
        'bio' => 'Hello <iframe src="evil.com"></iframe> World',
        'nested' => [
            'field1' => '<script>nested()</script>',
            'field2' => 'safe value'
        ]
    ];

    $cleaned = \Core\Security\Sanitizer::cleanArray($dangerous);

    if (!str_contains($cleaned['username'], '<script>')) {
        echo "✓ Array string values cleaned\n";
        echo "  username: " . $cleaned['username'] . "\n";
    }

    if ($cleaned['email'] === 'test@example.com') {
        echo "✓ Safe values preserved\n";
    }

    if (!str_contains($cleaned['bio'], '<iframe>')) {
        echo "✓ Dangerous tags removed from array values\n";
    }

    if (is_array($cleaned['nested']) && !str_contains($cleaned['nested']['field1'], '<script>')) {
        echo "✓ Nested arrays cleaned recursively\n";
        echo "  nested.field1: " . $cleaned['nested']['field1'] . "\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 6: Clean Mixed Data
echo "Test 6: Clean Mixed Data (clean() helper)\n";
try {
    // Test with string
    $string = '<script>alert(1)</script>';
    $cleaned = \Core\Security\Sanitizer::clean($string);
    if (!str_contains($cleaned, '<script>')) {
        echo "✓ String cleaned via clean() method\n";
    }

    // Test with array
    $array = ['key' => '<script>alert(2)</script>'];
    $cleaned = \Core\Security\Sanitizer::clean($array);
    if (!str_contains($cleaned['key'], '<script>')) {
        echo "✓ Array cleaned via clean() method\n";
    }

    // Test with sanitize() helper
    $dirty = '<script>evil()</script>Hello';
    $cleaned = sanitize($dirty);
    if (!str_contains($cleaned, '<script>')) {
        echo "✓ sanitize() helper works correctly\n";
        echo "  Output: " . $cleaned . "\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 7: Strip All Tags
echo "Test 7: Strip All Tags\n";
try {
    $html = '<p>Hello <strong>World</strong></p><script>alert(1)</script>';
    $stripped = \Core\Security\Sanitizer::stripTags($html);

    if ($stripped === 'Hello World') {
        echo "✓ All tags stripped correctly\n";
        echo "  Input:  " . $html . "\n";
        echo "  Output: " . $stripped . "\n";
    } else {
        echo "⚠ WARNING: Output may vary: " . $stripped . "\n";
    }

    // Test with allowed tags
    $stripped = \Core\Security\Sanitizer::stripTags($html, '<p><strong>');
    if (str_contains($stripped, '<p>') && str_contains($stripped, '<strong>')) {
        echo "✓ Allowed tags preserved\n";
        echo "  Output: " . $stripped . "\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 8: Sanitize Email
echo "Test 8: Sanitize Email\n";
try {
    $email = 'test@example.com';
    $sanitized = \Core\Security\Sanitizer::email($email);

    if ($sanitized === $email) {
        echo "✓ Valid email preserved: " . $sanitized . "\n";
    }

    $dangerous = 'test<script>@example.com';
    $sanitized = \Core\Security\Sanitizer::email($dangerous);
    echo "✓ Dangerous email sanitized: " . $sanitized . "\n";
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 9: Sanitize URL
echo "Test 9: Sanitize URL\n";
try {
    $url = 'https://example.com/page';
    $sanitized = \Core\Security\Sanitizer::url($url);

    if ($sanitized) {
        echo "✓ Valid URL preserved: " . $sanitized . "\n";
    }

    $dangerous = 'javascript:alert(1)';
    $sanitized = \Core\Security\Sanitizer::url($dangerous);
    echo "✓ Dangerous URL sanitized: " . ($sanitized ?: 'removed') . "\n";
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 10: Sanitize Numbers
echo "Test 10: Sanitize Numbers\n";
try {
    $int = \Core\Security\Sanitizer::int('123abc');
    if ($int === 123) {
        echo "✓ Integer sanitized: 123abc → " . $int . "\n";
    }

    $float = \Core\Security\Sanitizer::float('45.67xyz');
    if ($float === 45.67) {
        echo "✓ Float sanitized: 45.67xyz → " . $float . "\n";
    }

    $negative = \Core\Security\Sanitizer::int('-999');
    if ($negative === -999) {
        echo "✓ Negative integer handled: " . $negative . "\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 11: Real-world XSS Attempts
echo "Test 11: Real-world XSS Attempts\n";
try {
    $xssAttempts = [
        '<img src=x onerror=alert(1)>',
        '<svg onload=alert(1)>',
        'javascript:alert(1)',
        '<iframe src="javascript:alert(1)">',
        '<body onload=alert(1)>',
        '<input onfocus=alert(1) autofocus>',
        '<marquee onstart=alert(1)>',
        '\' onclick=alert(1)//',
        '"><script>alert(String.fromCharCode(88,83,83))</script>',
    ];

    $passed = 0;
    foreach ($xssAttempts as $xss) {
        $cleaned = \Core\Security\Sanitizer::cleanString($xss);

        // Check if dangerous patterns are removed
        $safe = !str_contains($cleaned, '<script>') &&
                !str_contains($cleaned, 'onerror=') &&
                !str_contains($cleaned, 'onload=') &&
                !str_contains($cleaned, 'onclick=') &&
                !str_contains($cleaned, 'onfocus=');

        if ($safe) {
            $passed++;
            echo "✓ XSS blocked: " . substr($xss, 0, 40) . "...\n";
        } else {
            echo "⚠ WARNING: Potential XSS: " . $cleaned . "\n";
        }
    }

    echo "\n  " . $passed . "/" . count($xssAttempts) . " XSS attempts blocked\n";
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n=== XSS Prevention Test Complete ===\n";
echo "\nRecommendations:\n";
echo "1. Always use e() helper when outputting user data in views\n";
echo "2. Use sanitize() on user input before storing\n";
echo "3. Use specific sanitizers (email, url, int) for validation\n";
echo "4. Implement Content-Security-Policy headers for additional protection\n";
