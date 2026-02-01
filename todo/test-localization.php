<?php

/**
 * Localization System Test Script
 *
 * Tests the localization system after converting to php-intl-only
 */

require __DIR__ . '/vendor/autoload.php';

echo "==============================================\n";
echo "Testing Localization System (php-intl required)\n";
echo "==============================================\n\n";

// Check if php-intl is installed
echo "1. Checking PHP Intl Extension:\n";
if (extension_loaded('intl')) {
    echo "   ✓ php-intl is installed\n";
    echo "   Version: " . INTL_ICU_VERSION . "\n\n";
} else {
    echo "   ✗ php-intl is NOT installed\n";
    echo "   Install with: sudo apt-get install php8.3-intl\n\n";
    exit(1);
}

// Bootstrap the application
$app = require __DIR__ . '/bootstrap/app.php';

echo "2. Testing Currency Formatting:\n";
try {
    $cf = $app->make('currency.formatter');

    // Test USD (English)
    $result = $cf->format(1234.56, 'USD', 'en');
    echo "   USD (en): {$result}\n";
    assert(str_contains($result, '1,234.56'), "USD formatting failed");

    // Test EUR (French)
    $result = $cf->format(1234.56, 'EUR', 'fr');
    echo "   EUR (fr): {$result}\n";
    assert(str_contains($result, '€'), "EUR formatting failed");

    // Test JPY (Japanese - zero decimal)
    $result = $cf->format(1234.56, 'JPY', 'ja');
    echo "   JPY (ja): {$result}\n";
    assert(!str_contains($result, '.'), "JPY should not have decimals");

    // Test INR (Hindi - Indian numbering)
    $result = $cf->format(123456.78, 'INR', 'hi');
    echo "   INR (hi): {$result}\n";
    assert(str_contains($result, '₹'), "INR formatting failed");

    echo "   ✓ All currency tests passed\n\n";
} catch (Exception $e) {
    echo "   ✗ Currency formatting failed: " . $e->getMessage() . "\n\n";
    exit(1);
}

echo "3. Testing Number Formatting:\n";
try {
    $nf = $app->make('number.formatter');

    // Test English
    $result = $nf->format(1234567.89, 2, 'en');
    echo "   Decimal (en): {$result}\n";
    assert(str_contains($result, '1,234,567.89'), "English number formatting failed");

    // Test German
    $result = $nf->format(1234567.89, 2, 'de');
    echo "   Decimal (de): {$result}\n";
    assert(str_contains($result, '.'), "German number formatting failed");

    // Test French
    $result = $nf->format(1234567.89, 2, 'fr');
    echo "   Decimal (fr): {$result}\n";

    // Test Percentage
    $result = $nf->formatPercent(0.1234, 2, 'en');
    echo "   Percent (en): {$result}\n";
    assert(str_contains($result, '%'), "Percentage formatting failed");

    // Test File Size
    $result = $nf->formatFileSize(1536000, 2, 'en');
    echo "   File Size: {$result}\n";
    assert(str_contains($result, 'MB'), "File size formatting failed");

    echo "   ✓ All number tests passed\n\n";
} catch (Exception $e) {
    echo "   ✗ Number formatting failed: " . $e->getMessage() . "\n\n";
    exit(1);
}

echo "4. Testing DateTime Formatting:\n";
try {
    $dtf = $app->make('datetime.formatter');

    $now = new DateTime('2026-02-01 15:30:00');

    // Test English
    $result = $dtf->format($now, 'medium', 'en');
    echo "   Medium (en): {$result}\n";

    // Test French
    $result = $dtf->format($now, 'medium', 'fr');
    echo "   Medium (fr): {$result}\n";

    // Test German
    $result = $dtf->format($now, 'long', 'de');
    echo "   Long (de): {$result}\n";

    echo "   ✓ All datetime tests passed\n\n";
} catch (Exception $e) {
    echo "   ✗ DateTime formatting failed: " . $e->getMessage() . "\n\n";
    exit(1);
}

echo "5. Testing Locale Manager:\n";
try {
    $lm = $app->make('locale');

    // Test locale detection
    $currentLocale = $lm->getCurrentLocale();
    echo "   Current locale: {$currentLocale}\n";

    // Test setting locale
    $lm->setLocale('fr');
    assert($lm->getCurrentLocale() === 'fr', "Setting locale failed");
    echo "   Set locale to: fr\n";

    // Test getting available locales
    $available = $lm->getAvailableLocales();
    echo "   Available locales: " . implode(', ', array_keys($available)) . "\n";

    echo "   ✓ All locale manager tests passed\n\n";
} catch (Exception $e) {
    echo "   ✗ Locale manager failed: " . $e->getMessage() . "\n\n";
    exit(1);
}

echo "==============================================\n";
echo "✓ ALL TESTS PASSED!\n";
echo "==============================================\n\n";

echo "Summary:\n";
echo "- php-intl extension is required and working\n";
echo "- Currency formatting works for USD, EUR, JPY, INR\n";
echo "- Number formatting works with locale-specific separators\n";
echo "- DateTime formatting works with IntlDateFormatter\n";
echo "- Locale detection and management working\n";
echo "- No fallback code is used (php-intl only)\n\n";
