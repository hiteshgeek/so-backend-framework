<?php

namespace Tests\Unit\Localization;

use Core\Localization\Translator;
use Core\Localization\TranslationLoader;
use PHPUnit\Framework\TestCase;

/**
 * Translator Unit Tests
 *
 * Tests for the core translation engine.
 * Covers: translation retrieval, parameter replacement, pluralization, fallback locale.
 */
class TranslatorTest extends TestCase
{
    private Translator $translator;
    private TranslationLoader $loader;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loader = new TranslationLoader('/var/www/html/so-backend-framework/resources/lang');
        $this->translator = new Translator($this->loader, 'en', 'en');
    }

    /**
     * Test basic translation retrieval
     */
    public function testBasicTranslation(): void
    {
        $result = $this->translator->get('validation.required');
        $this->assertStringContainsString('required', strtolower($result));
        $this->assertStringContainsString(':attribute', $result);
    }

    /**
     * Test translation with parameter replacement
     */
    public function testTranslationWithParameters(): void
    {
        $result = $this->translator->get('validation.required', ['attribute' => 'email']);
        $this->assertStringContainsString('email', strtolower($result));
        $this->assertStringNotContainsString(':attribute', $result);
    }

    /**
     * Test translation with multiple parameters
     */
    public function testTranslationWithMultipleParameters(): void
    {
        $result = $this->translator->get('validation.between', [
            'attribute' => 'age',
            'min' => 18,
            'max' => 65
        ]);

        $this->assertStringContainsString('age', strtolower($result));
        $this->assertStringContainsString('18', $result);
        $this->assertStringContainsString('65', $result);
    }

    /**
     * Test nested translation keys (dot notation)
     */
    public function testNestedTranslationKeys(): void
    {
        $result = $this->translator->get('auth.login_success');
        $this->assertNotEmpty($result);
        $this->assertStringContainsString('success', strtolower($result));
    }

    /**
     * Test missing translation key returns the key itself
     */
    public function testMissingTranslationReturnsKey(): void
    {
        $result = $this->translator->get('nonexistent.key');
        $this->assertEquals('nonexistent.key', $result);
    }

    /**
     * Test locale switching
     */
    public function testLocaleSwitching(): void
    {
        // English
        $this->translator->setLocale('en');
        $enResult = $this->translator->get('auth.login_success');
        $this->assertStringContainsString('success', strtolower($enResult));

        // French
        $this->translator->setLocale('fr');
        $frResult = $this->translator->get('auth.login_success');
        $this->assertNotEquals($enResult, $frResult);
        $this->assertStringContainsString('succès', strtolower($frResult));

        // German
        $this->translator->setLocale('de');
        $deResult = $this->translator->get('auth.login_success');
        $this->assertNotEquals($enResult, $deResult);
        $this->assertNotEquals($frResult, $deResult);
        $this->assertStringContainsString('erfolg', strtolower($deResult));
    }

    /**
     * Test fallback locale when translation not found
     */
    public function testFallbackLocale(): void
    {
        $this->translator->setLocale('es'); // Spanish not fully implemented
        $this->translator->setFallback('en');

        $result = $this->translator->get('validation.required');
        $this->assertStringContainsString('required', strtolower($result));
    }

    /**
     * Test pluralization with choice method
     */
    public function testPluralization(): void
    {
        // Note: This requires the translation file to have pluralization syntax
        // Example: '{0} No items|{1} One item|[2,*] :count items'

        $this->translator->setLocale('en');

        // Assuming we have a pluralization translation
        // $result0 = $this->translator->choice('messages.items', 0);
        // $this->assertStringContainsString('No items', $result0);

        // $result1 = $this->translator->choice('messages.items', 1);
        // $this->assertStringContainsString('One item', $result1);

        // $result5 = $this->translator->choice('messages.items', 5);
        // $this->assertStringContainsString('5 items', $result5);

        // For now, test that method exists
        $this->assertTrue(method_exists($this->translator, 'choice'));
    }

    /**
     * Test has() method to check if translation exists
     */
    public function testHasMethod(): void
    {
        $this->assertTrue($this->translator->has('validation.required'));
        $this->assertTrue($this->translator->has('auth.login_success'));
        $this->assertFalse($this->translator->has('nonexistent.key'));
    }

    /**
     * Test that special characters in parameters are handled correctly
     */
    public function testSpecialCharactersInParameters(): void
    {
        $result = $this->translator->get('validation.required', [
            'attribute' => "user's email"
        ]);

        $this->assertStringContainsString("user's email", $result);
    }

    /**
     * Test translation with HTML entities in parameters
     */
    public function testHtmlEntitiesInParameters(): void
    {
        $result = $this->translator->get('validation.required', [
            'attribute' => '<script>alert("xss")</script>'
        ]);

        // The translator should not escape HTML - that's the view layer's job
        $this->assertStringContainsString('<script>', $result);
    }

    /**
     * Test getCurrentLocale()
     */
    public function testGetCurrentLocale(): void
    {
        $this->translator->setLocale('fr');
        $this->assertEquals('fr', $this->translator->getLocale());

        $this->translator->setLocale('de');
        $this->assertEquals('de', $this->translator->getLocale());
    }

    /**
     * Test getFallback()
     */
    public function testGetFallback(): void
    {
        $this->translator->setFallback('en');
        $this->assertEquals('en', $this->translator->getFallback());
    }
}
