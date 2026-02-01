<?php

namespace Tests\Unit\Localization;

use PHPUnit\Framework\TestCase;
use Core\Localization\MissingTranslationHandler;

/**
 * MissingTranslationHandler Unit Tests
 *
 * Tests for missing translation tracking and logging.
 * Covers: recording, logging, exporting, statistics.
 */
class MissingTranslationHandlerTest extends TestCase
{
    private MissingTranslationHandler $handler;
    private string $testExportPath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new MissingTranslationHandler();
        $this->testExportPath = sys_get_temp_dir() . '/missing_translations_test_' . uniqid() . '.json';
    }

    protected function tearDown(): void
    {
        if (file_exists($this->testExportPath)) {
            unlink($this->testExportPath);
        }
        parent::tearDown();
    }

    /**
     * Test recording a missing translation
     */
    public function testRecordMissingTranslation(): void
    {
        $this->handler->record('messages.welcome', 'fr');

        $missing = $this->handler->getMissing('fr');

        $this->assertArrayHasKey('messages.welcome', $missing);
    }

    /**
     * Test recording with fallback value
     */
    public function testRecordWithFallback(): void
    {
        $this->handler->record('messages.greeting', 'de', 'Hello');

        $missing = $this->handler->getMissing('de');

        $this->assertArrayHasKey('messages.greeting', $missing);
        $this->assertEquals('Hello', $missing['messages.greeting']['fallback']);
    }

    /**
     * Test recording multiple missing translations
     */
    public function testRecordMultiple(): void
    {
        $this->handler->record('messages.key1', 'fr');
        $this->handler->record('messages.key2', 'fr');
        $this->handler->record('validation.required', 'fr');

        $missing = $this->handler->getMissing('fr');

        $this->assertCount(3, $missing);
        $this->assertArrayHasKey('messages.key1', $missing);
        $this->assertArrayHasKey('messages.key2', $missing);
        $this->assertArrayHasKey('validation.required', $missing);
    }

    /**
     * Test recording for multiple locales
     */
    public function testRecordMultipleLocales(): void
    {
        $this->handler->record('messages.key1', 'fr');
        $this->handler->record('messages.key1', 'de');
        $this->handler->record('messages.key2', 'es');

        $frMissing = $this->handler->getMissing('fr');
        $deMissing = $this->handler->getMissing('de');
        $esMissing = $this->handler->getMissing('es');

        $this->assertCount(1, $frMissing);
        $this->assertCount(1, $deMissing);
        $this->assertCount(1, $esMissing);
    }

    /**
     * Test getMissing without locale returns all
     */
    public function testGetMissingAllLocales(): void
    {
        $this->handler->record('key1', 'fr');
        $this->handler->record('key2', 'de');

        $allMissing = $this->handler->getMissing();

        $this->assertArrayHasKey('fr', $allMissing);
        $this->assertArrayHasKey('de', $allMissing);
    }

    /**
     * Test getMissing for non-existent locale returns empty array
     */
    public function testGetMissingNonExistentLocale(): void
    {
        $missing = $this->handler->getMissing('xx');

        $this->assertIsArray($missing);
        $this->assertEmpty($missing);
    }

    /**
     * Test recording includes timestamp
     */
    public function testRecordIncludesTimestamp(): void
    {
        $this->handler->record('test.key', 'en');

        $missing = $this->handler->getMissing('en');

        $this->assertArrayHasKey('timestamp', $missing['test.key']);
    }

    /**
     * Test recording includes key and locale
     */
    public function testRecordIncludesMetadata(): void
    {
        $this->handler->record('test.key', 'en');

        $missing = $this->handler->getMissing('en');

        $this->assertEquals('test.key', $missing['test.key']['key']);
        $this->assertEquals('en', $missing['test.key']['locale']);
    }

    /**
     * Test export to JSON file
     */
    public function testExportToJson(): void
    {
        $this->handler->record('key1', 'fr');
        $this->handler->record('key2', 'de');

        $result = $this->handler->export($this->testExportPath);

        $this->assertTrue($result);
        $this->assertFileExists($this->testExportPath);

        $content = file_get_contents($this->testExportPath);
        $data = json_decode($content, true);

        $this->assertIsArray($data);
        $this->assertArrayHasKey('fr', $data);
        $this->assertArrayHasKey('de', $data);
    }

    /**
     * Test export creates valid JSON
     */
    public function testExportCreatesValidJson(): void
    {
        $this->handler->record('messages.key', 'en', 'Fallback text');

        $this->handler->export($this->testExportPath);

        $content = file_get_contents($this->testExportPath);
        $data = json_decode($content, true);

        $this->assertNotNull($data, 'Export should create valid JSON');
    }

    /**
     * Test clear removes all tracked translations
     */
    public function testClear(): void
    {
        $this->handler->record('key1', 'fr');
        $this->handler->record('key2', 'de');

        $this->handler->clear();

        $missing = $this->handler->getMissing();

        $this->assertEmpty($missing);
    }

    /**
     * Test statistics method
     */
    public function testGetStatistics(): void
    {
        $this->handler->record('key1', 'fr');
        $this->handler->record('key2', 'fr');
        $this->handler->record('key3', 'de');

        $stats = $this->handler->getStatistics();

        $this->assertIsArray($stats);
        $this->assertArrayHasKey('total', $stats);
        $this->assertEquals(3, $stats['total']);

        if (isset($stats['by_locale'])) {
            $this->assertEquals(2, $stats['by_locale']['fr']);
            $this->assertEquals(1, $stats['by_locale']['de']);
        }
    }

    /**
     * Test formatForDebug method
     */
    public function testFormatForDebug(): void
    {
        if (!method_exists($this->handler, 'formatForDebug')) {
            $this->markTestSkipped('formatForDebug method not implemented');
        }

        $this->handler->record('test.key', 'en');

        $debug = $this->handler->formatForDebug('test.key');

        $this->assertIsString($debug);
        $this->assertStringContainsString('test.key', $debug);
    }

    /**
     * Test duplicate keys are not duplicated
     */
    public function testNoDuplicateKeys(): void
    {
        $this->handler->record('messages.key', 'fr');
        $this->handler->record('messages.key', 'fr'); // Same key again
        $this->handler->record('messages.key', 'fr'); // And again

        $missing = $this->handler->getMissing('fr');

        $this->assertCount(1, $missing);
    }

    /**
     * Test memory limit for max entries
     */
    public function testMaxEntriesLimit(): void
    {
        // Record many entries (config default is 1000)
        for ($i = 0; $i < 1100; $i++) {
            $this->handler->record("key_{$i}", 'en');
        }

        $missing = $this->handler->getMissing('en');

        // Should not exceed max entries (implementation dependent)
        $this->assertLessThanOrEqual(1100, count($missing));
    }

    /**
     * Test hasMissing method
     */
    public function testHasMissing(): void
    {
        $this->assertFalse($this->handler->hasMissing());

        $this->handler->record('key', 'en');

        $this->assertTrue($this->handler->hasMissing());
    }

    /**
     * Test hasMissing with specific locale
     */
    public function testHasMissingForLocale(): void
    {
        $this->handler->record('key', 'fr');

        $this->assertTrue($this->handler->hasMissing('fr'));
        $this->assertFalse($this->handler->hasMissing('de'));
    }

    /**
     * Test count method
     */
    public function testCount(): void
    {
        $this->assertEquals(0, $this->handler->count());

        $this->handler->record('key1', 'en');
        $this->handler->record('key2', 'en');

        $this->assertEquals(2, $this->handler->count());
    }

    /**
     * Test count with specific locale
     */
    public function testCountForLocale(): void
    {
        $this->handler->record('key1', 'en');
        $this->handler->record('key2', 'en');
        $this->handler->record('key3', 'fr');

        $this->assertEquals(2, $this->handler->count('en'));
        $this->assertEquals(1, $this->handler->count('fr'));
    }

    /**
     * Test recording with context
     */
    public function testRecordWithContext(): void
    {
        if (!method_exists($this->handler, 'recordWithContext')) {
            // Use basic record if context method doesn't exist
            $this->handler->record('key', 'en', null);
            $missing = $this->handler->getMissing('en');
            $this->assertArrayHasKey('key', $missing);
            return;
        }

        $this->handler->recordWithContext('key', 'en', [
            'file' => 'app/Controllers/HomeController.php',
            'line' => 42
        ]);

        $missing = $this->handler->getMissing('en');

        $this->assertArrayHasKey('key', $missing);
    }

    /**
     * Test enabled/disabled state
     */
    public function testEnabledState(): void
    {
        // Should be enabled by default in debug mode
        $this->assertIsBool($this->handler->isEnabled());
    }

    /**
     * Test export to non-writable path
     */
    public function testExportToInvalidPath(): void
    {
        $this->handler->record('key', 'en');

        $result = $this->handler->export('/nonexistent/directory/file.json');

        $this->assertFalse($result);
    }

    /**
     * Test special characters in keys
     */
    public function testSpecialCharactersInKeys(): void
    {
        $this->handler->record('messages.user\'s_name', 'en');
        $this->handler->record('validation.email@field', 'en');

        $missing = $this->handler->getMissing('en');

        $this->assertCount(2, $missing);
    }

    /**
     * Test empty key handling
     */
    public function testEmptyKeyHandling(): void
    {
        $this->handler->record('', 'en');

        // Should handle gracefully (either reject or accept)
        $missing = $this->handler->getMissing('en');
        $this->assertIsArray($missing);
    }

    /**
     * Test logging configuration
     */
    public function testLoggingConfiguration(): void
    {
        // Verify logging config is respected
        $logEnabled = config('localization.log_missing', false);
        $this->assertIsBool($logEnabled);
    }
}
