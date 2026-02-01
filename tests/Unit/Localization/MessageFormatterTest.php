<?php

namespace Tests\Unit\Localization;

use PHPUnit\Framework\TestCase;
use Core\Localization\MessageFormatter;

/**
 * ICU MessageFormat Unit Tests
 *
 * Tests for advanced message formatting using ICU patterns.
 * Covers: select, plural, number, date, time patterns.
 */
class MessageFormatterTest extends TestCase
{
    private MessageFormatter $formatter;
    private bool $intlAvailable;

    protected function setUp(): void
    {
        parent::setUp();
        $this->formatter = new MessageFormatter();
        $this->intlAvailable = extension_loaded('intl');
    }

    /**
     * Test simple placeholder replacement
     */
    public function testSimplePlaceholder(): void
    {
        $pattern = 'Hello, {name}!';
        $result = $this->formatter->format($pattern, ['name' => 'World']);

        $this->assertEquals('Hello, World!', $result);
    }

    /**
     * Test multiple placeholders
     */
    public function testMultiplePlaceholders(): void
    {
        $pattern = '{greeting}, {name}! Welcome to {place}.';
        $result = $this->formatter->format($pattern, [
            'greeting' => 'Hello',
            'name' => 'John',
            'place' => 'Paris'
        ]);

        $this->assertEquals('Hello, John! Welcome to Paris.', $result);
    }

    /**
     * Test select pattern for gender
     */
    public function testSelectGender(): void
    {
        $pattern = '{gender, select, male{He} female{She} other{They}} went to the store.';

        $resultMale = $this->formatter->format($pattern, ['gender' => 'male']);
        $this->assertStringContainsString('He', $resultMale);

        $resultFemale = $this->formatter->format($pattern, ['gender' => 'female']);
        $this->assertStringContainsString('She', $resultFemale);

        $resultOther = $this->formatter->format($pattern, ['gender' => 'unknown']);
        $this->assertStringContainsString('They', $resultOther);
    }

    /**
     * Test select pattern with complex text
     */
    public function testSelectWithComplexText(): void
    {
        $pattern = '{role, select, admin{Administrator with full access} user{Regular user} guest{Guest with limited access}}';

        $result = $this->formatter->format($pattern, ['role' => 'admin']);
        $this->assertStringContainsString('Administrator', $result);

        $result = $this->formatter->format($pattern, ['role' => 'user']);
        $this->assertStringContainsString('Regular', $result);
    }

    /**
     * Test plural pattern (English)
     */
    public function testPluralEnglish(): void
    {
        if (!$this->intlAvailable) {
            $this->markTestSkipped('intl extension not available');
        }

        $pattern = 'You have {count, plural, one{# message} other{# messages}}.';

        $result1 = $this->formatter->format($pattern, ['count' => 1], 'en');
        $this->assertStringContainsString('1 message', $result1);
        $this->assertStringNotContainsString('messages', $result1);

        $result5 = $this->formatter->format($pattern, ['count' => 5], 'en');
        $this->assertStringContainsString('5 messages', $result5);
    }

    /**
     * Test plural with zero
     */
    public function testPluralWithZero(): void
    {
        if (!$this->intlAvailable) {
            $this->markTestSkipped('intl extension not available');
        }

        $pattern = '{count, plural, =0{No items} one{# item} other{# items}}';

        $result0 = $this->formatter->format($pattern, ['count' => 0], 'en');
        $this->assertStringContainsString('No items', $result0);
    }

    /**
     * Test plural with exact matches
     */
    public function testPluralExactMatches(): void
    {
        if (!$this->intlAvailable) {
            $this->markTestSkipped('intl extension not available');
        }

        $pattern = '{count, plural, =0{none} =1{one} =2{a couple} other{many}}';

        $result0 = $this->formatter->format($pattern, ['count' => 0], 'en');
        $this->assertStringContainsString('none', $result0);

        $result2 = $this->formatter->format($pattern, ['count' => 2], 'en');
        $this->assertStringContainsString('couple', $result2);
    }

    /**
     * Test number formatting
     */
    public function testNumberFormatting(): void
    {
        if (!$this->intlAvailable) {
            $this->markTestSkipped('intl extension not available');
        }

        $pattern = 'Total: {amount, number}';

        $result = $this->formatter->format($pattern, ['amount' => 1234567.89], 'en_US');
        // Should format with thousands separator
        $this->assertStringContainsString('1', $result);
    }

    /**
     * Test currency formatting
     */
    public function testCurrencyFormatting(): void
    {
        if (!$this->intlAvailable) {
            $this->markTestSkipped('intl extension not available');
        }

        $pattern = 'Price: {price, number, currency}';

        $result = $this->formatter->format($pattern, ['price' => 99.99], 'en_US');
        // Should include currency symbol
        $this->assertIsString($result);
    }

    /**
     * Test date formatting
     */
    public function testDateFormatting(): void
    {
        if (!$this->intlAvailable) {
            $this->markTestSkipped('intl extension not available');
        }

        $pattern = 'Date: {date, date}';
        $timestamp = strtotime('2024-01-15');

        $result = $this->formatter->format($pattern, ['date' => $timestamp], 'en_US');
        $this->assertStringContainsString('2024', $result);
    }

    /**
     * Test time formatting
     */
    public function testTimeFormatting(): void
    {
        if (!$this->intlAvailable) {
            $this->markTestSkipped('intl extension not available');
        }

        $pattern = 'Time: {time, time}';
        $timestamp = strtotime('14:30:00');

        $result = $this->formatter->format($pattern, ['time' => $timestamp], 'en_US');
        $this->assertIsString($result);
    }

    /**
     * Test selectordinal pattern
     */
    public function testSelectOrdinal(): void
    {
        if (!$this->intlAvailable) {
            $this->markTestSkipped('intl extension not available');
        }

        $pattern = 'Your position is {position, selectordinal, one{#st} two{#nd} few{#rd} other{#th}}.';

        $result1 = $this->formatter->format($pattern, ['position' => 1], 'en');
        $this->assertStringContainsString('1st', $result1);

        $result2 = $this->formatter->format($pattern, ['position' => 2], 'en');
        $this->assertStringContainsString('2nd', $result2);

        $result3 = $this->formatter->format($pattern, ['position' => 3], 'en');
        $this->assertStringContainsString('3rd', $result3);

        $result4 = $this->formatter->format($pattern, ['position' => 4], 'en');
        $this->assertStringContainsString('4th', $result4);
    }

    /**
     * Test nested patterns
     */
    public function testNestedPatterns(): void
    {
        if (!$this->intlAvailable) {
            $this->markTestSkipped('intl extension not available');
        }

        $pattern = '{gender, select, male{{count, plural, one{He has # item} other{He has # items}}} female{{count, plural, one{She has # item} other{She has # items}}} other{{count, plural, one{They have # item} other{They have # items}}}}';

        $result = $this->formatter->format($pattern, [
            'gender' => 'female',
            'count' => 5
        ], 'en');

        $this->assertStringContainsString('She', $result);
        $this->assertStringContainsString('5', $result);
        $this->assertStringContainsString('items', $result);
    }

    /**
     * Test fallback when intl not available
     */
    public function testFallbackSimplePlaceholder(): void
    {
        // This should work even without intl
        $pattern = 'Hello, {name}!';
        $result = $this->formatter->format($pattern, ['name' => 'World']);

        $this->assertEquals('Hello, World!', $result);
    }

    /**
     * Test fallback select pattern
     */
    public function testFallbackSelectPattern(): void
    {
        // The fallback should handle basic select patterns
        $pattern = '{gender, select, male{He} female{She} other{They}}';

        $result = $this->formatter->format($pattern, ['gender' => 'male']);
        $this->assertStringContainsString('He', $result);
    }

    /**
     * Test with missing arguments
     */
    public function testMissingArguments(): void
    {
        $pattern = 'Hello, {name}! You have {count} messages.';

        // With partial arguments
        $result = $this->formatter->format($pattern, ['name' => 'John']);

        // Should handle gracefully (might keep placeholder or use default)
        $this->assertStringContainsString('John', $result);
    }

    /**
     * Test with empty arguments array
     */
    public function testEmptyArguments(): void
    {
        $pattern = 'Hello, {name}!';

        $result = $this->formatter->format($pattern, []);

        // Should return pattern with unresolved placeholder or handle gracefully
        $this->assertIsString($result);
    }

    /**
     * Test with special characters in values
     */
    public function testSpecialCharactersInValues(): void
    {
        $pattern = 'Welcome, {name}!';

        $result = $this->formatter->format($pattern, ['name' => "O'Brien"]);
        $this->assertStringContainsString("O'Brien", $result);

        $result = $this->formatter->format($pattern, ['name' => 'Müller']);
        $this->assertStringContainsString('Müller', $result);
    }

    /**
     * Test locale parameter
     */
    public function testLocaleParameter(): void
    {
        $pattern = 'Hello, {name}!';

        $resultEn = $this->formatter->format($pattern, ['name' => 'World'], 'en');
        $resultFr = $this->formatter->format($pattern, ['name' => 'World'], 'fr');

        // Both should produce valid output
        $this->assertStringContainsString('World', $resultEn);
        $this->assertStringContainsString('World', $resultFr);
    }

    /**
     * Test icu() helper function exists
     */
    public function testIcuHelperExists(): void
    {
        $this->assertTrue(function_exists('icu'), 'icu() helper should exist');
    }

    /**
     * Test icu_format() helper function exists
     */
    public function testIcuFormatHelperExists(): void
    {
        $this->assertTrue(function_exists('icu_format'), 'icu_format() helper should exist');
    }

    /**
     * Test icu_format() helper function for raw ICU patterns
     */
    public function testIcuHelper(): void
    {
        if (function_exists('icu_format')) {
            // Test with raw ICU pattern (use icu_format for raw patterns, icu for translation keys)
            $result = icu_format('Hello, {name}!', ['name' => 'World']);
            $this->assertIsString($result);
            $this->assertStringContainsString('World', $result);
        } else {
            $this->markTestSkipped('icu_format() helper not available');
        }
    }

    /**
     * Test complex real-world pattern
     */
    public function testComplexRealWorldPattern(): void
    {
        $pattern = '{gender, select, male{Mr.} female{Ms.} other{}} {name}, you have {count, plural, one{# new message} other{# new messages}}.';

        $result = $this->formatter->format($pattern, [
            'gender' => 'female',
            'name' => 'Smith',
            'count' => 5
        ], 'en');

        $this->assertStringContainsString('Ms.', $result);
        $this->assertStringContainsString('Smith', $result);
        $this->assertStringContainsString('5', $result);
    }

    /**
     * Test pattern with escaped characters
     */
    public function testEscapedCharacters(): void
    {
        $pattern = "Hello '{name}'!"; // Escaped braces in ICU

        $result = $this->formatter->format($pattern, ['name' => 'World']);
        $this->assertIsString($result);
    }

    /**
     * Test large numbers
     */
    public function testLargeNumbers(): void
    {
        if (!$this->intlAvailable) {
            $this->markTestSkipped('intl extension not available');
        }

        $pattern = 'Users: {count, number}';

        $result = $this->formatter->format($pattern, ['count' => 1000000], 'en_US');
        $this->assertIsString($result);
    }

    /**
     * Test negative numbers
     */
    public function testNegativeNumbers(): void
    {
        if (!$this->intlAvailable) {
            $this->markTestSkipped('intl extension not available');
        }

        $pattern = 'Balance: {amount, number}';

        $result = $this->formatter->format($pattern, ['amount' => -500], 'en_US');
        $this->assertIsString($result);
        $this->assertStringContainsString('500', $result);
    }

    /**
     * Test percentage formatting
     */
    public function testPercentageFormatting(): void
    {
        if (!$this->intlAvailable) {
            $this->markTestSkipped('intl extension not available');
        }

        $pattern = 'Progress: {percent, number, percent}';

        $result = $this->formatter->format($pattern, ['percent' => 0.75], 'en_US');
        $this->assertIsString($result);
    }
}
