<?php

namespace Tests\Unit\Localization;

use Core\Localization\Formatters\DateTimeFormatter;
use Core\Localization\LocaleManager;
use PHPUnit\Framework\TestCase;
use DateTime;

/**
 * DateTimeFormatter Unit Tests
 *
 * Tests for php-intl-based date/time formatting using IntlDateFormatter.
 * Covers: multiple formats, locales, timezones, relative time.
 */
class DateTimeFormatterTest extends TestCase
{
    private DateTimeFormatter $formatter;
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

        $this->formatter = new DateTimeFormatter($this->localeManager);
    }

    /**
     * Test short format with English locale
     */
    public function testShortFormatEnglish(): void
    {
        // Use explicit UTC timezone for consistent results
        $date = new DateTime('2026-01-15 15:30:25', new \DateTimeZone('UTC'));
        $result = $this->formatter->format($date, 'short', 'en');

        // Short format: "1/15/26, 3:30 PM"
        $this->assertMatchesRegularExpression('/1\/15\/26/', $result);
        $this->assertMatchesRegularExpression('/3:30/', $result);
    }

    /**
     * Test medium format with English locale
     */
    public function testMediumFormatEnglish(): void
    {
        // Use explicit UTC timezone for consistent results
        $date = new DateTime('2026-01-15 15:30:25', new \DateTimeZone('UTC'));
        $result = $this->formatter->format($date, 'medium', 'en');

        // Medium format: "Jan 15, 2026, 3:30:25 PM"
        $this->assertStringContainsString('Jan', $result);
        $this->assertStringContainsString('15', $result);
        $this->assertStringContainsString('2026', $result);
        $this->assertMatchesRegularExpression('/3:30:25/', $result);
    }

    /**
     * Test long format with English locale
     */
    public function testLongFormatEnglish(): void
    {
        // Use explicit UTC timezone for consistent results
        $date = new DateTime('2026-01-15 15:30:25', new \DateTimeZone('UTC'));
        $result = $this->formatter->format($date, 'long', 'en');

        // Long format: "January 15, 2026 at 3:30:25 PM UTC"
        $this->assertStringContainsString('January', $result);
        $this->assertStringContainsString('15', $result);
        $this->assertStringContainsString('2026', $result);
        $this->assertMatchesRegularExpression('/3:30:25/', $result);
    }

    /**
     * Test full format with English locale
     */
    public function testFullFormatEnglish(): void
    {
        $date = new DateTime('2026-01-15 15:30:25');
        $result = $this->formatter->format($date, 'full', 'en');

        // Full format: "Thursday, January 15, 2026 at 3:30:25 PM Coordinated Universal Time"
        $this->assertStringContainsString('January', $result);
        $this->assertStringContainsString('15', $result);
        $this->assertStringContainsString('2026', $result);
    }

    /**
     * Test French locale formatting
     */
    public function testFrenchFormatting(): void
    {
        $date = new DateTime('2026-01-15 15:30:25');
        $result = $this->formatter->format($date, 'medium', 'fr');

        // French format uses different month names
        $this->assertMatchesRegularExpression('/janv\.?/', $result); // "janv." for January
        $this->assertStringContainsString('15', $result);
        $this->assertStringContainsString('2026', $result);
    }

    /**
     * Test German locale formatting
     */
    public function testGermanFormatting(): void
    {
        $date = new DateTime('2026-01-15 15:30:25');
        $result = $this->formatter->format($date, 'medium', 'de');

        // German format: "15.01.2026, 15:30:25"
        $this->assertMatchesRegularExpression('/15\.01\.2026/', $result);
    }

    /**
     * Test Hindi/Indian locale formatting
     */
    public function testHindiFormatting(): void
    {
        $date = new DateTime('2026-01-15 15:30:25');
        $result = $this->formatter->format($date, 'medium', 'hi');

        // Hindi format will use Devanagari numerals or Latin depending on locale
        $this->assertStringContainsString('15', $result);
        $this->assertStringContainsString('2026', $result);
    }

    /**
     * Test formatDate (date only, no time)
     */
    public function testFormatDateOnly(): void
    {
        $date = new DateTime('2026-01-15 15:30:25');
        $result = $this->formatter->formatDate($date, 'medium', 'en');

        // Should contain date but no time
        $this->assertStringContainsString('Jan', $result);
        $this->assertStringContainsString('15', $result);
        $this->assertStringContainsString('2026', $result);
        $this->assertStringNotContainsString('3:30', $result);
    }

    /**
     * Test formatDate with short format
     */
    public function testFormatDateShort(): void
    {
        $date = new DateTime('2026-01-15');
        $result = $this->formatter->formatDate($date, 'short', 'en');

        // Short date: "1/15/26"
        $this->assertMatchesRegularExpression('/1\/15\/26/', $result);
    }

    /**
     * Test formatDate with long format
     */
    public function testFormatDateLong(): void
    {
        $date = new DateTime('2026-01-15');
        $result = $this->formatter->formatDate($date, 'long', 'en');

        // Long date: "January 15, 2026"
        $this->assertStringContainsString('January', $result);
        $this->assertStringContainsString('15', $result);
        $this->assertStringContainsString('2026', $result);
    }

    /**
     * Test formatDate with full format
     */
    public function testFormatDateFull(): void
    {
        $date = new DateTime('2026-01-15');
        $result = $this->formatter->formatDate($date, 'full', 'en');

        // Full date: "Thursday, January 15, 2026"
        $this->assertStringContainsString('Thursday', $result);
        $this->assertStringContainsString('January', $result);
        $this->assertStringContainsString('15', $result);
        $this->assertStringContainsString('2026', $result);
    }

    /**
     * Test formatTime (time only, no date)
     */
    public function testFormatTimeOnly(): void
    {
        // Use explicit UTC timezone for consistent results
        $date = new DateTime('2026-01-15 15:30:25', new \DateTimeZone('UTC'));
        $result = $this->formatter->formatTime($date, 'medium', 'en');

        // Should contain time but no date
        $this->assertMatchesRegularExpression('/3:30:25/', $result);
        $this->assertStringNotContainsString('Jan', $result);
        $this->assertStringNotContainsString('2026', $result);
    }

    /**
     * Test formatTime with short format
     */
    public function testFormatTimeShort(): void
    {
        // Use explicit UTC timezone for consistent results
        $date = new DateTime('2026-01-15 15:30:25', new \DateTimeZone('UTC'));
        $result = $this->formatter->formatTime($date, 'short', 'en');

        // Short time: "3:30 PM" or similar
        $this->assertStringContainsString('3:30', $result);
        $this->assertTrue(
            str_contains($result, 'PM') || str_contains($result, 'p.m.'),
            "Time should contain PM indicator: {$result}"
        );
    }

    /**
     * Test formatTime with long format
     */
    public function testFormatTimeLong(): void
    {
        // Use explicit UTC timezone for consistent results
        $date = new DateTime('2026-01-15 15:30:25', new \DateTimeZone('UTC'));
        $result = $this->formatter->formatTime($date, 'long', 'en', 'UTC');

        // Long time includes timezone
        $this->assertMatchesRegularExpression('/3:30:25/', $result);
        $this->assertMatchesRegularExpression('/UTC|GMT/', $result);
    }

    /**
     * Test timezone handling
     */
    public function testTimezoneHandling(): void
    {
        $date = new DateTime('2026-01-15 15:30:25', new \DateTimeZone('UTC'));

        // Format in IST (UTC+5:30)
        $result = $this->formatter->format($date, 'medium', 'en', 'Asia/Kolkata');

        // Time should be 9:00 PM (15:30 + 5:30)
        $this->assertMatchesRegularExpression('/9:00/', $result);
    }

    /**
     * Test string date input
     */
    public function testStringDateInput(): void
    {
        $result = $this->formatter->format('2026-01-15 15:30:25', 'medium', 'en');

        $this->assertStringContainsString('Jan', $result);
        $this->assertStringContainsString('15', $result);
        $this->assertStringContainsString('2026', $result);
    }

    /**
     * Test relative time - just now
     */
    public function testRelativeTimeJustNow(): void
    {
        $now = new DateTime();
        $result = $this->formatter->formatRelative($now, 'en');

        $this->assertEquals('just now', $result);
    }

    /**
     * Test relative time - minutes ago
     */
    public function testRelativeTimeMinutesAgo(): void
    {
        $past = new DateTime('-5 minutes');
        $result = $this->formatter->formatRelative($past, 'en');

        $this->assertEquals('5 minutes ago', $result);
    }

    /**
     * Test relative time - hours ago
     */
    public function testRelativeTimeHoursAgo(): void
    {
        $past = new DateTime('-3 hours');
        $result = $this->formatter->formatRelative($past, 'en');

        $this->assertEquals('3 hours ago', $result);
    }

    /**
     * Test relative time - days ago
     */
    public function testRelativeTimeDaysAgo(): void
    {
        $past = new DateTime('-2 days');
        $result = $this->formatter->formatRelative($past, 'en');

        $this->assertEquals('2 days ago', $result);
    }

    /**
     * Test relative time - weeks ago
     */
    public function testRelativeTimeWeeksAgo(): void
    {
        $past = new DateTime('-2 weeks');
        $result = $this->formatter->formatRelative($past, 'en');

        $this->assertEquals('2 weeks ago', $result);
    }

    /**
     * Test relative time - months ago
     */
    public function testRelativeTimeMonthsAgo(): void
    {
        $past = new DateTime('-2 months');
        $result = $this->formatter->formatRelative($past, 'en');

        $this->assertEquals('2 months ago', $result);
    }

    /**
     * Test relative time - future (in X time)
     */
    public function testRelativeTimeFuture(): void
    {
        $future = new DateTime('+3 days');
        $result = $this->formatter->formatRelative($future, 'en');

        $this->assertEquals('in 3 days', $result);
    }

    /**
     * Test relative time with French locale
     */
    public function testRelativeTimeFrench(): void
    {
        $past = new DateTime('-2 days');
        $result = $this->formatter->formatRelative($past, 'fr');

        // French: "il y a 2 jours"
        $this->assertStringContainsString('il y a', $result);
        $this->assertStringContainsString('2', $result);
        $this->assertStringContainsString('jours', $result);
    }

    /**
     * Test relative time with German locale
     */
    public function testRelativeTimeGerman(): void
    {
        $past = new DateTime('-2 days');
        $result = $this->formatter->formatRelative($past, 'de');

        // German: "vor 2 Tage"
        $this->assertStringContainsString('vor', $result);
        $this->assertStringContainsString('2', $result);
        $this->assertStringContainsString('Tag', $result);
    }

    /**
     * Test parse method (reverse of format)
     */
    public function testParseFormattedDate(): void
    {
        // Format a date
        $original = new DateTime('2026-01-15');
        $formatted = $this->formatter->formatDate($original, 'medium', 'en');

        // Parse it back
        $parsed = $this->formatter->parse($formatted, 'medium', 'en');

        $this->assertNotNull($parsed);
        $this->assertEquals('2026', $parsed->format('Y'));
        $this->assertEquals('01', $parsed->format('m'));
        $this->assertEquals('15', $parsed->format('d'));
    }

    /**
     * Test parse with invalid input
     */
    public function testParseInvalidDate(): void
    {
        $result = $this->formatter->parse('invalid date', 'medium', 'en');

        $this->assertNull($result);
    }

    /**
     * Test locale override
     */
    public function testLocaleOverride(): void
    {
        // Set manager to English
        $this->localeManager->setLocale('en');

        $date = new DateTime('2026-01-15 15:30:25');

        // But override with German
        $result = $this->formatter->format($date, 'medium', 'de');

        // Should use German formatting
        $this->assertMatchesRegularExpression('/15\.01\.2026/', $result);
    }

    /**
     * Test using current locale from manager
     */
    public function testCurrentLocale(): void
    {
        $this->localeManager->setLocale('de');

        $date = new DateTime('2026-01-15 15:30:25');

        // Don't specify locale - should use manager's current locale
        $result = $this->formatter->format($date, 'medium');

        // Should use German formatting
        $this->assertMatchesRegularExpression('/15\.01\.2026/', $result);
    }

    /**
     * Test formatting consistency
     */
    public function testFormattingConsistency(): void
    {
        $date = new DateTime('2026-01-15 15:30:25');

        $result1 = $this->formatter->format($date, 'medium', 'en');
        $result2 = $this->formatter->format($date, 'medium', 'en');

        $this->assertEquals($result1, $result2);
    }

    /**
     * Test that php-intl IntlDateFormatter is being used
     */
    public function testUsesPhpIntl(): void
    {
        $date = new DateTime('2026-01-15');
        $result = $this->formatter->formatDate($date, 'full', 'en');

        // IntlDateFormatter produces day name for full format
        // e.g., "Thursday, January 15, 2026"
        $this->assertMatchesRegularExpression('/Thursday|Friday|Saturday|Sunday|Monday|Tuesday|Wednesday/', $result);

        // Old manual formatter would not include day name
    }

    /**
     * Test Spanish locale formatting
     */
    public function testSpanishFormatting(): void
    {
        $date = new DateTime('2026-01-15 15:30:25');
        $result = $this->formatter->format($date, 'medium', 'es');

        // Spanish format
        $this->assertStringContainsString('15', $result);
        $this->assertStringContainsString('2026', $result);
    }

    /**
     * Test Italian locale formatting
     */
    public function testItalianFormatting(): void
    {
        $date = new DateTime('2026-01-15 15:30:25');
        $result = $this->formatter->format($date, 'medium', 'it');

        // Italian format
        $this->assertStringContainsString('15', $result);
        $this->assertStringContainsString('2026', $result);
    }

    /**
     * Test midnight time
     */
    public function testMidnightTime(): void
    {
        // Use explicit UTC timezone for consistent results
        $date = new DateTime('2026-01-15 00:00:00', new \DateTimeZone('UTC'));
        $result = $this->formatter->formatTime($date, 'short', 'en');

        // Should show midnight (12:00 AM or similar)
        $this->assertStringContainsString('12:00', $result);
        $this->assertTrue(
            str_contains($result, 'AM') || str_contains($result, 'a.m.'),
            "Time should contain AM indicator: {$result}"
        );
    }

    /**
     * Test noon time
     */
    public function testNoonTime(): void
    {
        // Use explicit UTC timezone for consistent results
        $date = new DateTime('2026-01-15 12:00:00', new \DateTimeZone('UTC'));
        $result = $this->formatter->formatTime($date, 'short', 'en');

        // Should show noon (12:00 PM or similar)
        $this->assertStringContainsString('12:00', $result);
        $this->assertTrue(
            str_contains($result, 'PM') || str_contains($result, 'p.m.'),
            "Time should contain PM indicator: {$result}"
        );
    }
}
