<?php

namespace Tests\Unit\Localization;

use Core\Localization\Formatters\NumberFormatter;
use Core\Localization\LocaleManager;
use PHPUnit\Framework\TestCase;

/**
 * NumberFormatter Unit Tests
 *
 * Tests for php-intl-based number formatting.
 * Covers: decimal formatting, percentages, Indian numbering, multiple locales.
 */
class NumberFormatterTest extends TestCase
{
    private NumberFormatter $formatter;
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

        $this->formatter = new NumberFormatter($this->localeManager);
    }

    /**
     * Test basic number formatting with English locale
     */
    public function testBasicNumberFormatting(): void
    {
        $result = $this->formatter->format(1234.56, 2, 'en');

        $this->assertEquals('1,234.56', $result);
    }

    /**
     * Test number formatting with German locale
     */
    public function testGermanNumberFormatting(): void
    {
        $result = $this->formatter->format(1234.56, 2, 'de');

        // German uses dot for thousands, comma for decimal
        $this->assertEquals('1.234,56', $result);
    }

    /**
     * Test number formatting with French locale
     */
    public function testFrenchNumberFormatting(): void
    {
        $result = $this->formatter->format(1234.56, 2, 'fr');

        // French uses space (nbsp) for thousands, comma for decimal
        $this->assertStringContainsString('234,56', $result);
        $this->assertStringContainsString('1', $result);
    }

    /**
     * Test Indian numbering system (lakhs)
     */
    public function testIndianNumbering(): void
    {
        $result = $this->formatter->format(123456.78, 2, 'hi');

        // Indian numbering: 1,23,456.78
        $this->assertMatchesRegularExpression('/1,23,456\.78/', $result);
    }

    /**
     * Test Indian numbering with large numbers (crores)
     */
    public function testIndianNumberingCrores(): void
    {
        $result = $this->formatter->format(12345678.90, 2, 'hi');

        // Indian numbering: 1,23,45,678.90
        $this->assertMatchesRegularExpression('/1,23,45,678\.90/', $result);
    }

    /**
     * Test zero decimals
     */
    public function testZeroDecimals(): void
    {
        $result = $this->formatter->format(1234.56, 0, 'en');

        $this->assertEquals('1,235', $result); // Rounded
        $this->assertStringNotContainsString('.', $result);
    }

    /**
     * Test one decimal
     */
    public function testOneDecimal(): void
    {
        $result = $this->formatter->format(1234.56, 1, 'en');

        $this->assertEquals('1,234.6', $result); // Rounded
    }

    /**
     * Test three decimals
     */
    public function testThreeDecimals(): void
    {
        $result = $this->formatter->format(1234.5678, 3, 'en');

        $this->assertEquals('1,234.568', $result); // Rounded
    }

    /**
     * Test four decimals
     */
    public function testFourDecimals(): void
    {
        $result = $this->formatter->format(1234.56789, 4, 'en');

        $this->assertEquals('1,234.5679', $result); // Rounded
    }

    /**
     * Test negative numbers
     */
    public function testNegativeNumbers(): void
    {
        $result = $this->formatter->format(-1234.56, 2, 'en');

        $this->assertEquals('-1,234.56', $result);
    }

    /**
     * Test zero
     */
    public function testZero(): void
    {
        $result = $this->formatter->format(0, 2, 'en');

        $this->assertEquals('0.00', $result);
    }

    /**
     * Test large numbers (millions)
     */
    public function testMillions(): void
    {
        $result = $this->formatter->format(1234567.89, 2, 'en');

        $this->assertEquals('1,234,567.89', $result);
    }

    /**
     * Test very large numbers (billions)
     */
    public function testBillions(): void
    {
        $result = $this->formatter->format(1234567890.12, 2, 'en');

        $this->assertEquals('1,234,567,890.12', $result);
    }

    /**
     * Test small decimal numbers
     */
    public function testSmallDecimals(): void
    {
        $result = $this->formatter->format(0.99, 2, 'en');

        $this->assertEquals('0.99', $result);
    }

    /**
     * Test very small numbers
     */
    public function testVerySmallNumbers(): void
    {
        $result = $this->formatter->format(0.0001, 4, 'en');

        $this->assertEquals('0.0001', $result);
    }

    /**
     * Test percentage formatting
     */
    public function testBasicPercentage(): void
    {
        $result = $this->formatter->formatPercent(0.1234, 2, 'en');

        $this->assertEquals('12.34%', $result);
    }

    /**
     * Test percentage with zero decimals
     */
    public function testPercentageZeroDecimals(): void
    {
        $result = $this->formatter->formatPercent(0.1234, 0, 'en');

        $this->assertEquals('12%', $result);
    }

    /**
     * Test percentage with German locale
     */
    public function testPercentageGerman(): void
    {
        $result = $this->formatter->formatPercent(0.1234, 2, 'de');

        // German uses comma for decimal, may have space before %
        $this->assertStringContainsString('12,34', $result);
        $this->assertStringContainsString('%', $result);
    }

    /**
     * Test percentage with French locale
     */
    public function testPercentageFrench(): void
    {
        $result = $this->formatter->formatPercent(0.1234, 2, 'fr');

        // French uses comma for decimal, may have space before %
        $this->assertStringContainsString('12,34', $result);
        $this->assertStringContainsString('%', $result);
    }

    /**
     * Test percentage over 100%
     */
    public function testPercentageOver100(): void
    {
        $result = $this->formatter->formatPercent(1.5, 2, 'en');

        $this->assertEquals('150.00%', $result);
    }

    /**
     * Test negative percentage
     */
    public function testNegativePercentage(): void
    {
        $result = $this->formatter->formatPercent(-0.1234, 2, 'en');

        $this->assertEquals('-12.34%', $result);
    }

    /**
     * Test zero percentage
     */
    public function testZeroPercentage(): void
    {
        $result = $this->formatter->formatPercent(0, 2, 'en');

        $this->assertEquals('0.00%', $result);
    }

    /**
     * Test whole number (100%)
     */
    public function testWholeNumberPercentage(): void
    {
        $result = $this->formatter->formatPercent(1, 2, 'en');

        $this->assertEquals('100.00%', $result);
    }

    /**
     * Test locale override
     */
    public function testLocaleOverride(): void
    {
        // Set manager to English
        $this->localeManager->setLocale('en');

        // But override with German
        $result = $this->formatter->format(1234.56, 2, 'de');

        // Should use German formatting
        $this->assertEquals('1.234,56', $result);
    }

    /**
     * Test using current locale from manager
     */
    public function testCurrentLocale(): void
    {
        $this->localeManager->setLocale('de');

        // Don't specify locale - should use manager's current locale
        $result = $this->formatter->format(1234.56, 2);

        // Should use German formatting
        $this->assertEquals('1.234,56', $result);
    }

    /**
     * Test formatting consistency
     */
    public function testFormattingConsistency(): void
    {
        $result1 = $this->formatter->format(1234.56, 2, 'en');
        $result2 = $this->formatter->format(1234.56, 2, 'en');

        $this->assertEquals($result1, $result2);
    }

    /**
     * Test rounding behavior
     */
    public function testRoundingBehavior(): void
    {
        // .5 rounds up
        $result1 = $this->formatter->format(1.5, 0, 'en');
        $this->assertEquals('2', $result1);

        // .4 rounds down
        $result2 = $this->formatter->format(1.4, 0, 'en');
        $this->assertEquals('1', $result2);

        // .6 rounds up
        $result3 = $this->formatter->format(1.6, 0, 'en');
        $this->assertEquals('2', $result3);
    }

    /**
     * Test that php-intl NumberFormatter is being used
     */
    public function testUsesPhpIntl(): void
    {
        // This is an indirect test - we verify Indian numbering works
        // which only works correctly with php-intl's NumberFormatter

        $result = $this->formatter->format(123456.78, 2, 'hi');

        // Indian numbering pattern (lakhs): 1,23,456.78
        // This pattern is ONLY correct with php-intl
        $this->assertMatchesRegularExpression('/1,23,456\.78/', $result);

        // Old manual formatter would produce: 123,456.78 (wrong)
        $this->assertStringNotContainsString('123,456.78', $result);
    }

    /**
     * Test Spanish locale
     */
    public function testSpanishNumberFormatting(): void
    {
        $result = $this->formatter->format(1234.56, 2, 'es');

        // Spanish uses dot for thousands, comma for decimal
        $this->assertMatchesRegularExpression('/1\.234,56/', $result);
    }

    /**
     * Test Italian locale
     */
    public function testItalianNumberFormatting(): void
    {
        $result = $this->formatter->format(1234.56, 2, 'it');

        // Italian uses dot for thousands, comma for decimal
        $this->assertMatchesRegularExpression('/1\.234,56/', $result);
    }

    /**
     * Test Portuguese locale
     */
    public function testPortugueseNumberFormatting(): void
    {
        $result = $this->formatter->format(1234.56, 2, 'pt');

        // Portuguese (Brazil) uses dot for thousands, comma for decimal
        $this->assertMatchesRegularExpression('/1\.234,56/', $result);
    }

    /**
     * Test percentage with one decimal
     */
    public function testPercentageOneDecimal(): void
    {
        $result = $this->formatter->formatPercent(0.1234, 1, 'en');

        $this->assertEquals('12.3%', $result);
    }

    /**
     * Test percentage with three decimals
     */
    public function testPercentageThreeDecimals(): void
    {
        $result = $this->formatter->formatPercent(0.123456, 3, 'en');

        $this->assertEquals('12.346%', $result); // Rounded
    }

    /**
     * Test very small percentage
     */
    public function testVerySmallPercentage(): void
    {
        $result = $this->formatter->formatPercent(0.0001, 4, 'en');

        $this->assertEquals('0.0100%', $result);
    }
}
