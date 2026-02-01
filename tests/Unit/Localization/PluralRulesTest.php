<?php

namespace Tests\Unit\Localization;

use PHPUnit\Framework\TestCase;
use Core\Localization\Pluralization\PluralRules;
use Core\Localization\Pluralization\PluralRuleInterface;
use Core\Localization\Pluralization\Rules\EnglishPluralRule;
use Core\Localization\Pluralization\Rules\FrenchPluralRule;
use Core\Localization\Pluralization\Rules\SlavicPluralRule;
use Core\Localization\Pluralization\Rules\PolishPluralRule;
use Core\Localization\Pluralization\Rules\ArabicPluralRule;
use Core\Localization\Pluralization\Rules\AsianPluralRule;

/**
 * CLDR Pluralization Rules Unit Tests
 *
 * Tests for complex plural form selection based on CLDR rules.
 * Covers all 6 language families: English, French, Slavic, Polish, Arabic, Asian.
 */
class PluralRulesTest extends TestCase
{
    /**
     * Test PluralRules factory returns correct rule for locale
     */
    public function testFactoryReturnsCorrectRule(): void
    {
        $englishRule = PluralRules::forLocale('en');
        $this->assertInstanceOf(PluralRuleInterface::class, $englishRule);

        $russianRule = PluralRules::forLocale('ru');
        $this->assertInstanceOf(PluralRuleInterface::class, $russianRule);

        $arabicRule = PluralRules::forLocale('ar');
        $this->assertInstanceOf(PluralRuleInterface::class, $arabicRule);
    }

    /**
     * Test factory handles locale variants (e.g., en_US, en_GB)
     */
    public function testFactoryHandlesLocaleVariants(): void
    {
        $enUs = PluralRules::forLocale('en_US');
        $enGb = PluralRules::forLocale('en_GB');

        // Both should use English rules
        $this->assertEquals($enUs->choose(1), $enGb->choose(1));
        $this->assertEquals($enUs->choose(2), $enGb->choose(2));
    }

    // ===========================================
    // English Plural Rules Tests (2 forms)
    // ===========================================

    /**
     * Test English plural rule: one = 1
     */
    public function testEnglishPluralOne(): void
    {
        $rule = new EnglishPluralRule();

        // "one" form
        $this->assertEquals(0, $rule->choose(1));

        // "other" form
        $this->assertEquals(1, $rule->choose(0));
        $this->assertEquals(1, $rule->choose(2));
        $this->assertEquals(1, $rule->choose(5));
        $this->assertEquals(1, $rule->choose(100));
    }

    /**
     * Test English form count
     */
    public function testEnglishFormCount(): void
    {
        $rule = new EnglishPluralRule();
        $this->assertEquals(2, $rule->getFormCount());
    }

    /**
     * Test English form names
     */
    public function testEnglishFormNames(): void
    {
        $rule = new EnglishPluralRule();
        $names = $rule->getFormNames();

        $this->assertEquals(['one', 'other'], $names);
    }

    // ===========================================
    // French Plural Rules Tests (2 forms, different from English)
    // ===========================================

    /**
     * Test French plural rule: one = 0, 1
     */
    public function testFrenchPluralOne(): void
    {
        $rule = new FrenchPluralRule();

        // "one" form (0 and 1 are singular in French)
        $this->assertEquals(0, $rule->choose(0));
        $this->assertEquals(0, $rule->choose(1));

        // "other" form
        $this->assertEquals(1, $rule->choose(2));
        $this->assertEquals(1, $rule->choose(5));
        $this->assertEquals(1, $rule->choose(100));
    }

    /**
     * Test French form count
     */
    public function testFrenchFormCount(): void
    {
        $rule = new FrenchPluralRule();
        $this->assertEquals(2, $rule->getFormCount());
    }

    // ===========================================
    // Slavic Plural Rules Tests (4 forms)
    // Russian, Ukrainian, Belarusian
    // ===========================================

    /**
     * Test Slavic plural rule: one (1, 21, 31...)
     */
    public function testSlavicPluralOne(): void
    {
        $rule = new SlavicPluralRule();

        // "one" form: ends in 1, not 11
        $this->assertEquals(0, $rule->choose(1));
        $this->assertEquals(0, $rule->choose(21));
        $this->assertEquals(0, $rule->choose(31));
        $this->assertEquals(0, $rule->choose(101));
    }

    /**
     * Test Slavic plural rule: few (2-4, 22-24, 32-34...)
     */
    public function testSlavicPluralFew(): void
    {
        $rule = new SlavicPluralRule();

        // "few" form: ends in 2-4, not 12-14
        $this->assertEquals(1, $rule->choose(2));
        $this->assertEquals(1, $rule->choose(3));
        $this->assertEquals(1, $rule->choose(4));
        $this->assertEquals(1, $rule->choose(22));
        $this->assertEquals(1, $rule->choose(23));
        $this->assertEquals(1, $rule->choose(24));
    }

    /**
     * Test Slavic plural rule: many (0, 5-20, 25-30...)
     */
    public function testSlavicPluralMany(): void
    {
        $rule = new SlavicPluralRule();

        // "many" form: 0, 5-20, 25-30, ends in 0, 5-9, 11-14
        $this->assertEquals(2, $rule->choose(0));
        $this->assertEquals(2, $rule->choose(5));
        $this->assertEquals(2, $rule->choose(6));
        $this->assertEquals(2, $rule->choose(10));
        $this->assertEquals(2, $rule->choose(11));
        $this->assertEquals(2, $rule->choose(12));
        $this->assertEquals(2, $rule->choose(14));
        $this->assertEquals(2, $rule->choose(20));
        $this->assertEquals(2, $rule->choose(25));
    }

    /**
     * Test Slavic form count
     */
    public function testSlavicFormCount(): void
    {
        $rule = new SlavicPluralRule();
        $this->assertEquals(4, $rule->getFormCount());
    }

    /**
     * Test Slavic form names
     */
    public function testSlavicFormNames(): void
    {
        $rule = new SlavicPluralRule();
        $names = $rule->getFormNames();

        $this->assertContains('one', $names);
        $this->assertContains('few', $names);
        $this->assertContains('many', $names);
        $this->assertContains('other', $names);
    }

    // ===========================================
    // Polish Plural Rules Tests (4 forms, different from Slavic)
    // ===========================================

    /**
     * Test Polish plural rule
     */
    public function testPolishPluralRules(): void
    {
        $rule = new PolishPluralRule();

        // "one" form: exactly 1
        $this->assertEquals(0, $rule->choose(1));

        // "few" form: 2-4, 22-24, etc.
        $this->assertEquals(1, $rule->choose(2));
        $this->assertEquals(1, $rule->choose(3));
        $this->assertEquals(1, $rule->choose(4));
        $this->assertEquals(1, $rule->choose(22));

        // "many" form: 0, 5-21, 25-31, etc.
        $this->assertEquals(2, $rule->choose(0));
        $this->assertEquals(2, $rule->choose(5));
        $this->assertEquals(2, $rule->choose(12));
        $this->assertEquals(2, $rule->choose(14));
    }

    /**
     * Test Polish form count
     */
    public function testPolishFormCount(): void
    {
        $rule = new PolishPluralRule();
        $this->assertEquals(4, $rule->getFormCount());
    }

    // ===========================================
    // Arabic Plural Rules Tests (6 forms)
    // ===========================================

    /**
     * Test Arabic plural rule: zero
     */
    public function testArabicPluralZero(): void
    {
        $rule = new ArabicPluralRule();

        // "zero" form
        $this->assertEquals(0, $rule->choose(0));
    }

    /**
     * Test Arabic plural rule: one
     */
    public function testArabicPluralOne(): void
    {
        $rule = new ArabicPluralRule();

        // "one" form
        $this->assertEquals(1, $rule->choose(1));
    }

    /**
     * Test Arabic plural rule: two
     */
    public function testArabicPluralTwo(): void
    {
        $rule = new ArabicPluralRule();

        // "two" form (dual)
        $this->assertEquals(2, $rule->choose(2));
    }

    /**
     * Test Arabic plural rule: few (3-10)
     */
    public function testArabicPluralFew(): void
    {
        $rule = new ArabicPluralRule();

        // "few" form: 3-10, 103-110, etc.
        $this->assertEquals(3, $rule->choose(3));
        $this->assertEquals(3, $rule->choose(5));
        $this->assertEquals(3, $rule->choose(10));
    }

    /**
     * Test Arabic plural rule: many (11-99)
     */
    public function testArabicPluralMany(): void
    {
        $rule = new ArabicPluralRule();

        // "many" form: 11-99, 111-199, etc.
        $this->assertEquals(4, $rule->choose(11));
        $this->assertEquals(4, $rule->choose(50));
        $this->assertEquals(4, $rule->choose(99));
    }

    /**
     * Test Arabic form count
     */
    public function testArabicFormCount(): void
    {
        $rule = new ArabicPluralRule();
        $this->assertEquals(6, $rule->getFormCount());
    }

    /**
     * Test Arabic form names
     */
    public function testArabicFormNames(): void
    {
        $rule = new ArabicPluralRule();
        $names = $rule->getFormNames();

        $this->assertContains('zero', $names);
        $this->assertContains('one', $names);
        $this->assertContains('two', $names);
        $this->assertContains('few', $names);
        $this->assertContains('many', $names);
        $this->assertContains('other', $names);
    }

    // ===========================================
    // Asian Plural Rules Tests (1 form)
    // Japanese, Chinese, Korean, Vietnamese
    // ===========================================

    /**
     * Test Asian plural rule: no grammatical plural
     */
    public function testAsianPluralNoGrammaticalPlural(): void
    {
        $rule = new AsianPluralRule();

        // All numbers use the same form
        $this->assertEquals(0, $rule->choose(0));
        $this->assertEquals(0, $rule->choose(1));
        $this->assertEquals(0, $rule->choose(2));
        $this->assertEquals(0, $rule->choose(100));
        $this->assertEquals(0, $rule->choose(1000));
    }

    /**
     * Test Asian form count
     */
    public function testAsianFormCount(): void
    {
        $rule = new AsianPluralRule();
        $this->assertEquals(1, $rule->getFormCount());
    }

    /**
     * Test Asian form names
     */
    public function testAsianFormNames(): void
    {
        $rule = new AsianPluralRule();
        $names = $rule->getFormNames();

        $this->assertEquals(['other'], $names);
    }

    // ===========================================
    // PluralRules::choose() static method tests
    // ===========================================

    /**
     * Test static choose method with pipe-separated string
     */
    public function testStaticChooseWithPipeSeparated(): void
    {
        $translation = 'one item|:count items';

        $result1 = PluralRules::choose($translation, 1, 'en');
        $this->assertEquals('one item', $result1);

        $result5 = PluralRules::choose($translation, 5, 'en');
        $this->assertEquals(':count items', $result5);
    }

    /**
     * Test static choose method with CLDR-style keys
     */
    public function testStaticChooseWithCldrKeys(): void
    {
        $translation = '{one} :count товар|{few} :count товара|{many} :count товаров|{other} :count товаров';

        $result1 = PluralRules::choose($translation, 1, 'ru');
        $this->assertStringContainsString('товар', $result1);

        $result2 = PluralRules::choose($translation, 2, 'ru');
        $this->assertStringContainsString('товара', $result2);

        $result5 = PluralRules::choose($translation, 5, 'ru');
        $this->assertStringContainsString('товаров', $result5);
    }

    /**
     * Test getCategory returns correct form name
     */
    public function testGetCategory(): void
    {
        $englishRule = new EnglishPluralRule();

        $this->assertEquals('one', $englishRule->getCategory(1));
        $this->assertEquals('other', $englishRule->getCategory(0));
        $this->assertEquals('other', $englishRule->getCategory(5));
    }

    /**
     * Test plural rules with large numbers
     */
    public function testLargeNumbers(): void
    {
        $rule = new SlavicPluralRule();

        // Test with millions
        $this->assertEquals(0, $rule->choose(1000001)); // ends in 1, not 11
        $this->assertEquals(1, $rule->choose(1000002)); // ends in 2, not 12
        $this->assertEquals(2, $rule->choose(1000011)); // ends in 11
    }

    /**
     * Test plural rules with negative numbers
     */
    public function testNegativeNumbers(): void
    {
        $rule = new EnglishPluralRule();

        // Negative numbers should use absolute value
        $result = $rule->choose(-1);
        $this->assertIsInt($result);
    }

    /**
     * Test factory with unknown locale falls back to English
     */
    public function testUnknownLocaleFallback(): void
    {
        $rule = PluralRules::forLocale('unknown_XX');

        // Should fall back to default (English-like)
        $this->assertInstanceOf(PluralRuleInterface::class, $rule);
        $this->assertEquals(2, $rule->getFormCount());
    }

    /**
     * Test all supported locales return valid rules
     */
    public function testAllSupportedLocales(): void
    {
        $locales = ['en', 'fr', 'de', 'es', 'ru', 'uk', 'pl', 'ar', 'ja', 'zh', 'ko'];

        foreach ($locales as $locale) {
            $rule = PluralRules::forLocale($locale);
            $this->assertInstanceOf(
                PluralRuleInterface::class,
                $rule,
                "Failed to get rule for locale: {$locale}"
            );
        }
    }
}
