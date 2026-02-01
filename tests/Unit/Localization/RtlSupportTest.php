<?php

namespace Tests\Unit\Localization;

use PHPUnit\Framework\TestCase;
use Core\Localization\LocaleManager;
use Core\Localization\Translator;
use Core\Localization\TranslationLoader;

/**
 * RTL (Right-to-Left) Language Support Unit Tests
 *
 * Tests for RTL language detection and helpers.
 * Covers: isRtl(), getDirection(), helper functions.
 */
class RtlSupportTest extends TestCase
{
    private LocaleManager $localeManager;
    private Translator $translator;

    protected function setUp(): void
    {
        parent::setUp();

        // Create dependencies
        $loader = new TranslationLoader('/var/www/html/so-backend-framework/resources/lang');
        $this->translator = new Translator($loader, 'en', 'en');

        // Available locales from config
        $availableLocales = [
            'en' => 'English',
            'fr' => 'Français',
            'de' => 'Deutsch',
            'ar' => 'العربية',
            'he' => 'עברית',
            'fa' => 'فارسی',
            'ur' => 'اردو',
        ];

        $this->localeManager = new LocaleManager(
            $this->translator,
            $availableLocales,
            'en',
            'UTC'
        );
    }

    /**
     * Test isRtl returns true for Arabic
     */
    public function testIsRtlArabic(): void
    {
        $this->assertTrue($this->localeManager->isRtl('ar'));
        $this->assertTrue($this->localeManager->isRtl('ar_SA'));
        $this->assertTrue($this->localeManager->isRtl('ar_EG'));
    }

    /**
     * Test isRtl returns true for Hebrew
     */
    public function testIsRtlHebrew(): void
    {
        $this->assertTrue($this->localeManager->isRtl('he'));
        $this->assertTrue($this->localeManager->isRtl('he_IL'));
    }

    /**
     * Test isRtl returns true for Persian/Farsi
     */
    public function testIsRtlPersian(): void
    {
        $this->assertTrue($this->localeManager->isRtl('fa'));
        $this->assertTrue($this->localeManager->isRtl('fa_IR'));
    }

    /**
     * Test isRtl returns true for Urdu
     */
    public function testIsRtlUrdu(): void
    {
        $this->assertTrue($this->localeManager->isRtl('ur'));
        $this->assertTrue($this->localeManager->isRtl('ur_PK'));
    }

    /**
     * Test isRtl returns false for English
     */
    public function testIsNotRtlEnglish(): void
    {
        $this->assertFalse($this->localeManager->isRtl('en'));
        $this->assertFalse($this->localeManager->isRtl('en_US'));
        $this->assertFalse($this->localeManager->isRtl('en_GB'));
    }

    /**
     * Test isRtl returns false for other LTR languages
     */
    public function testIsNotRtlOtherLanguages(): void
    {
        $ltrLocales = ['fr', 'de', 'es', 'it', 'pt', 'ru', 'zh', 'ja', 'ko', 'hi'];

        foreach ($ltrLocales as $locale) {
            $this->assertFalse(
                $this->localeManager->isRtl($locale),
                "Expected {$locale} to be LTR"
            );
        }
    }

    /**
     * Test getDirection returns 'rtl' for RTL locales
     */
    public function testGetDirectionRtl(): void
    {
        $this->assertEquals('rtl', $this->localeManager->getDirection('ar'));
        $this->assertEquals('rtl', $this->localeManager->getDirection('he'));
        $this->assertEquals('rtl', $this->localeManager->getDirection('fa'));
    }

    /**
     * Test getDirection returns 'ltr' for LTR locales
     */
    public function testGetDirectionLtr(): void
    {
        $this->assertEquals('ltr', $this->localeManager->getDirection('en'));
        $this->assertEquals('ltr', $this->localeManager->getDirection('fr'));
        $this->assertEquals('ltr', $this->localeManager->getDirection('de'));
    }

    /**
     * Test getHtmlDir returns dir attribute value
     */
    public function testGetHtmlDir(): void
    {
        $this->assertEquals('rtl', $this->localeManager->getHtmlDir('ar'));
        $this->assertEquals('ltr', $this->localeManager->getHtmlDir('en'));
    }

    /**
     * Test getDirectionClass returns CSS class
     */
    public function testGetDirectionClass(): void
    {
        if (method_exists($this->localeManager, 'getDirectionClass')) {
            $this->assertStringContainsString('rtl', $this->localeManager->getDirectionClass('ar'));
            $this->assertStringContainsString('ltr', $this->localeManager->getDirectionClass('en'));
        } else {
            $this->markTestSkipped('getDirectionClass method not implemented');
        }
    }

    /**
     * Test all configured RTL locales
     */
    public function testAllConfiguredRtlLocales(): void
    {
        // From config: ['ar', 'he', 'fa', 'ur', 'ps', 'ku', 'yi', 'dv', 'sd', 'ug']
        $rtlLocales = ['ar', 'he', 'fa', 'ur'];

        foreach ($rtlLocales as $locale) {
            $this->assertTrue(
                $this->localeManager->isRtl($locale),
                "Expected {$locale} to be RTL"
            );
        }
    }

    /**
     * Test RTL detection with current locale
     */
    public function testRtlWithCurrentLocale(): void
    {
        // Set locale to Arabic
        $this->localeManager->setLocale('ar');
        $this->assertTrue($this->localeManager->isRtl());

        // Set locale to English
        $this->localeManager->setLocale('en');
        $this->assertFalse($this->localeManager->isRtl());
    }

    /**
     * Test helper functions exist
     */
    public function testHelperFunctionsExist(): void
    {
        $this->assertTrue(function_exists('is_rtl'), 'is_rtl() helper should exist');
        $this->assertTrue(function_exists('text_direction'), 'text_direction() helper should exist');
    }

    /**
     * Test is_rtl() helper function
     */
    public function testIsRtlHelper(): void
    {
        if (function_exists('is_rtl')) {
            $this->assertTrue(is_rtl('ar'));
            $this->assertFalse(is_rtl('en'));
        } else {
            $this->markTestSkipped('is_rtl() helper not available');
        }
    }

    /**
     * Test text_direction() helper function
     */
    public function testTextDirectionHelper(): void
    {
        if (function_exists('text_direction')) {
            $this->assertEquals('rtl', text_direction('ar'));
            $this->assertEquals('ltr', text_direction('en'));
        } else {
            $this->markTestSkipped('text_direction() helper not available');
        }
    }

    /**
     * Test html_dir() helper function
     */
    public function testHtmlDirHelper(): void
    {
        if (function_exists('html_dir')) {
            $this->assertEquals('rtl', html_dir('ar'));
            $this->assertEquals('ltr', html_dir('en'));
        } else {
            $this->markTestSkipped('html_dir() helper not available');
        }
    }

    /**
     * Test dir_class() helper function
     */
    public function testDirClassHelper(): void
    {
        if (function_exists('dir_class')) {
            $arClass = dir_class('ar');
            $enClass = dir_class('en');

            $this->assertIsString($arClass);
            $this->assertIsString($enClass);
        } else {
            $this->markTestSkipped('dir_class() helper not available');
        }
    }

    /**
     * Test RTL CSS file exists
     */
    public function testRtlCssFileExists(): void
    {
        $rtlCssPath = '/var/www/html/so-backend-framework/public/assets/css/rtl.css';

        $this->assertFileExists($rtlCssPath, 'RTL CSS file should exist');
    }

    /**
     * Test RTL CSS contains essential rules
     */
    public function testRtlCssContent(): void
    {
        $rtlCssPath = '/var/www/html/so-backend-framework/public/assets/css/rtl.css';

        if (!file_exists($rtlCssPath)) {
            $this->markTestSkipped('RTL CSS file not found');
        }

        $content = file_get_contents($rtlCssPath);

        // Check for RTL-specific CSS rules
        $this->assertStringContainsString('[dir="rtl"]', $content, 'Should have RTL selector');
        $this->assertStringContainsString('text-align', $content, 'Should have text-align rules');
    }

    /**
     * Test locale case insensitivity
     */
    public function testLocaleCaseInsensitivity(): void
    {
        $this->assertTrue($this->localeManager->isRtl('AR'));
        $this->assertTrue($this->localeManager->isRtl('Ar'));
        $this->assertFalse($this->localeManager->isRtl('EN'));
    }

    /**
     * Test empty locale handling
     */
    public function testEmptyLocaleHandling(): void
    {
        // Should use current locale or default
        $result = $this->localeManager->isRtl('');
        $this->assertIsBool($result);
    }

    /**
     * Test unknown locale handling
     */
    public function testUnknownLocaleHandling(): void
    {
        // Unknown locale should default to LTR
        $this->assertFalse($this->localeManager->isRtl('xx'));
        $this->assertEquals('ltr', $this->localeManager->getDirection('unknown'));
    }

    /**
     * Test mixed-direction content scenario
     */
    public function testMixedDirectionScenario(): void
    {
        // Simulating switching between locales
        $this->localeManager->setLocale('ar');
        $arDirection = $this->localeManager->getDirection();

        $this->localeManager->setLocale('en');
        $enDirection = $this->localeManager->getDirection();

        $this->assertEquals('rtl', $arDirection);
        $this->assertEquals('ltr', $enDirection);
    }

    /**
     * Test RTL locale configuration
     */
    public function testRtlLocaleConfiguration(): void
    {
        $config = config('localization.rtl_locales', []);

        $this->assertIsArray($config);
        $this->assertContains('ar', $config);
        $this->assertContains('he', $config);
    }

    /**
     * Test getLanguageCode extracts base language
     */
    public function testGetLanguageCode(): void
    {
        $this->assertEquals('ar', $this->localeManager->getLanguageCode('ar_SA'));
        $this->assertEquals('en', $this->localeManager->getLanguageCode('en_US'));
        $this->assertEquals('zh', $this->localeManager->getLanguageCode('zh_Hans_CN'));
    }

    /**
     * Test getRegionCode extracts region
     */
    public function testGetRegionCode(): void
    {
        if (method_exists($this->localeManager, 'getRegionCode')) {
            $this->assertEquals('SA', $this->localeManager->getRegionCode('ar_SA'));
            $this->assertEquals('US', $this->localeManager->getRegionCode('en_US'));
        } else {
            $this->markTestSkipped('getRegionCode method not implemented');
        }
    }
}
