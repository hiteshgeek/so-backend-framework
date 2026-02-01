<?php

namespace Tests\Unit\Localization;

use Core\Localization\Formatters\CurrencyFormatter;
use Core\Localization\LocaleManager;
use PHPUnit\Framework\TestCase;

/**
 * CurrencyFormatter Unit Tests
 *
 * Tests for php-intl-based currency formatting.
 * Covers: multiple currencies, locales, zero-decimal currencies, Indian formatting.
 */
class CurrencyFormatterTest extends TestCase
{
    private CurrencyFormatter $formatter;
    private LocaleManager $localeManager;

    protected function setUp(): void
    {
        parent::setUp();

        // Verify php-intl is loaded
        if (!extension_loaded('intl')) {
            $this->markTestSkipped('PHP intl extension is not loaded');
        }

        // Setup translation system with explicit path (no Application container needed)
        $langPath = __DIR__ . '/../../../resources/lang';
        $loader = new \Core\Localization\TranslationLoader($langPath);
        $translator = new \Core\Localization\Translator($loader, 'en', 'en');

        // Setup locale manager with explicit timezone (no config() helper needed)
        $this->localeManager = new LocaleManager(
            $translator,
            ['en', 'fr', 'de', 'es', 'hi', 'it', 'pt', 'ja', 'ko'],
            'en',
            'UTC'
        );

        $this->formatter = new CurrencyFormatter($this->localeManager);
    }

    /**
     * Test basic USD formatting with English locale
     */
    public function testBasicUsdFormatting(): void
    {
        $result = $this->formatter->format(1234.56, 'USD', 'en');

        // Should contain dollar sign and formatted number
        $this->assertStringContainsString('$', $result);
        $this->assertStringContainsString('1,234.56', $result);
    }

    /**
     * Test EUR formatting with French locale
     */
    public function testEurFormattingFrench(): void
    {
        $result = $this->formatter->format(1234.56, 'EUR', 'fr');

        // French uses space (nbsp) as thousand separator and comma for decimal
        $this->assertStringContainsString('€', $result);
        // French format: "1 234,56 €" (space can be regular or nbsp)
        $this->assertStringContainsString('234,56', $result);
        $this->assertStringContainsString('1', $result);
    }

    /**
     * Test EUR formatting with German locale
     */
    public function testEurFormattingGerman(): void
    {
        $result = $this->formatter->format(1234.56, 'EUR', 'de');

        // German uses dot as thousand separator and comma for decimal
        $this->assertStringContainsString('€', $result);
        // German format: "1.234,56 €"
        $this->assertMatchesRegularExpression('/1\.234,56/', $result);
    }

    /**
     * Test INR formatting with Hindi/Indian locale
     */
    public function testInrFormattingIndian(): void
    {
        $result = $this->formatter->format(123456.78, 'INR', 'hi');

        // Indian numbering system (lakhs): ₹1,23,456.78
        $this->assertStringContainsString('₹', $result);
        // Should use Indian numbering (lakhs pattern)
        $this->assertMatchesRegularExpression('/1,23,456/', $result);
    }

    /**
     * Test zero-decimal currency (JPY)
     */
    public function testJpyZeroDecimal(): void
    {
        $result = $this->formatter->format(1234.56, 'JPY', 'ja');

        // JPY should be formatted without decimals
        // Note: Can be ¥ (half-width) or ￥ (full-width) depending on locale
        $this->assertTrue(
            str_contains($result, '¥') || str_contains($result, '￥'),
            "Result should contain yen symbol: {$result}"
        );
        $this->assertStringContainsString('1,235', $result); // Rounded
        $this->assertStringNotContainsString('.', $result);
    }

    /**
     * Test zero-decimal currency (KRW)
     */
    public function testKrwZeroDecimal(): void
    {
        $result = $this->formatter->format(1234.56, 'KRW', 'ko');

        // KRW should be formatted without decimals
        $this->assertStringContainsString('₩', $result);
        $this->assertStringContainsString('1,235', $result); // Rounded
        $this->assertStringNotContainsString('.', $result);
    }

    /**
     * Test GBP formatting with English locale
     */
    public function testGbpFormatting(): void
    {
        $result = $this->formatter->format(1234.56, 'GBP', 'en');

        $this->assertStringContainsString('£', $result);
        $this->assertStringContainsString('1,234.56', $result);
    }

    /**
     * Test CAD formatting
     */
    public function testCadFormatting(): void
    {
        $result = $this->formatter->format(1234.56, 'CAD', 'en');

        $this->assertStringContainsString('CA$', $result);
        $this->assertStringContainsString('1,234.56', $result);
    }

    /**
     * Test AUD formatting
     */
    public function testAudFormatting(): void
    {
        $result = $this->formatter->format(1234.56, 'AUD', 'en');

        $this->assertStringContainsString('A$', $result);
        $this->assertStringContainsString('1,234.56', $result);
    }

    /**
     * Test negative amounts
     */
    public function testNegativeAmount(): void
    {
        $result = $this->formatter->format(-1234.56, 'USD', 'en');

        $this->assertStringContainsString('$', $result);
        $this->assertStringContainsString('1,234.56', $result);
        // Should indicate negative (either with minus sign or parentheses)
        $this->assertTrue(
            str_contains($result, '-') || str_contains($result, '(')
        );
    }

    /**
     * Test zero amount
     */
    public function testZeroAmount(): void
    {
        $result = $this->formatter->format(0, 'USD', 'en');

        $this->assertStringContainsString('$', $result);
        $this->assertStringContainsString('0.00', $result);
    }

    /**
     * Test large amounts
     */
    public function testLargeAmount(): void
    {
        $result = $this->formatter->format(1234567.89, 'USD', 'en');

        $this->assertStringContainsString('$', $result);
        $this->assertStringContainsString('1,234,567.89', $result);
    }

    /**
     * Test very large amounts (millions)
     */
    public function testMillionAmount(): void
    {
        $result = $this->formatter->format(12345678.90, 'USD', 'en');

        $this->assertStringContainsString('$', $result);
        $this->assertStringContainsString('12,345,678.90', $result);
    }

    /**
     * Test Indian numbering with large amounts (crores)
     */
    public function testIndianLargeAmount(): void
    {
        $result = $this->formatter->format(12345678.90, 'INR', 'hi');

        // Indian numbering: ₹1,23,45,678.90
        $this->assertStringContainsString('₹', $result);
        $this->assertMatchesRegularExpression('/1,23,45,678/', $result);
    }

    /**
     * Test locale override
     */
    public function testLocaleOverride(): void
    {
        // Set manager to English
        $this->localeManager->setLocale('en');

        // But override with French
        $result = $this->formatter->format(1234.56, 'EUR', 'fr');

        // Should use French formatting (space can be regular or nbsp)
        $this->assertStringContainsString('€', $result);
        $this->assertStringContainsString('234,56', $result);
    }

    /**
     * Test using current locale from manager
     */
    public function testCurrentLocale(): void
    {
        $this->localeManager->setLocale('de');

        // Don't specify locale - should use manager's current locale
        $result = $this->formatter->format(1234.56, 'EUR');

        // Should use German formatting
        $this->assertMatchesRegularExpression('/1\.234,56/', $result);
    }

    /**
     * Test getCurrencySymbol() method
     */
    public function testGetCurrencySymbol(): void
    {
        $usdSymbol = $this->formatter->getCurrencySymbol('USD', 'en');
        $this->assertNotEmpty($usdSymbol);

        $eurSymbol = $this->formatter->getCurrencySymbol('EUR', 'en');
        $this->assertNotEmpty($eurSymbol);

        $gbpSymbol = $this->formatter->getCurrencySymbol('GBP', 'en');
        $this->assertNotEmpty($gbpSymbol);

        $inrSymbol = $this->formatter->getCurrencySymbol('INR', 'hi');
        $this->assertNotEmpty($inrSymbol);
    }

    /**
     * Test that invalid/uncommon currency codes are handled
     */
    public function testUncommonCurrency(): void
    {
        // NumberFormatter can handle most ISO 4217 currency codes
        // Testing with a valid but uncommon currency: CZK (Czech Koruna)
        $result = $this->formatter->format(1234.56, 'CZK', 'en');

        $this->assertNotEmpty($result);
        $this->assertStringContainsString('1,234.56', $result);
    }

    /**
     * Test small decimal amounts
     */
    public function testSmallDecimalAmounts(): void
    {
        $result = $this->formatter->format(0.99, 'USD', 'en');

        $this->assertStringContainsString('$', $result);
        $this->assertStringContainsString('0.99', $result);
    }

    /**
     * Test formatting consistency across multiple calls
     */
    public function testFormattingConsistency(): void
    {
        $result1 = $this->formatter->format(1234.56, 'USD', 'en');
        $result2 = $this->formatter->format(1234.56, 'USD', 'en');

        $this->assertEquals($result1, $result2);
    }

    /**
     * Test that php-intl NumberFormatter is being used
     */
    public function testUsesPhpIntl(): void
    {
        // This is an indirect test - we verify that the output matches
        // what NumberFormatter produces, not our old manual formatting

        $result = $this->formatter->format(1234.56, 'USD', 'en');

        // NumberFormatter output format
        $this->assertMatchesRegularExpression('/\$1,234\.56/', $result);

        // Should NOT contain patterns from old manual formatting
        $this->assertStringNotContainsString('USD', $result); // Old format used currency code
    }
}
