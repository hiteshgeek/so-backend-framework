<?php

namespace Tests\Unit\Media;

use PHPUnit\Framework\TestCase;
use Core\Media\StorageManager;

/**
 * StorageManager Unit Tests
 *
 * Tests for file storage operations, URL generation, and path management.
 */
class StorageManagerTest extends TestCase
{
    private StorageManager $storage;
    private string $testPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->storage = new StorageManager();
        $this->testPath = sys_get_temp_dir() . '/media_test_' . uniqid();

        // Create test directory
        if (!is_dir($this->testPath)) {
            mkdir($this->testPath, 0755, true);
        }
    }

    protected function tearDown(): void
    {
        // Clean up test files
        if (is_dir($this->testPath)) {
            $this->deleteDirectory($this->testPath);
        }

        parent::tearDown();
    }

    /**
     * Test basic file storage
     */
    public function testStoreFile(): void
    {
        // Create test file
        $sourceFile = $this->testPath . '/source.txt';
        file_put_contents($sourceFile, 'Test content');

        // Store file
        $result = $this->storage->store($sourceFile);

        $this->assertTrue($result['success']);
        $this->assertArrayHasKey('filename', $result);
        $this->assertArrayHasKey('path', $result);
        $this->assertArrayHasKey('url', $result);
        $this->assertArrayHasKey('size', $result);
        $this->assertArrayHasKey('mime_type', $result);
    }

    /**
     * Test store with folder structure
     */
    public function testStoreWithFolder(): void
    {
        $sourceFile = $this->testPath . '/source.txt';
        file_put_contents($sourceFile, 'Test content');

        $result = $this->storage->store($sourceFile, 'products/featured');

        $this->assertTrue($result['success']);
        $this->assertStringContainsString('products/featured', $result['path']);
    }

    /**
     * Test store with custom filename
     */
    public function testStoreWithCustomFilename(): void
    {
        $sourceFile = $this->testPath . '/source.txt';
        file_put_contents($sourceFile, 'Test content');

        $result = $this->storage->store($sourceFile, null, 'custom.txt');

        $this->assertTrue($result['success']);
        $this->assertEquals('custom.txt', $result['filename']);
    }

    /**
     * Test store non-existent file
     */
    public function testStoreNonExistentFile(): void
    {
        $result = $this->storage->store('/path/to/nonexistent.txt');

        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('error', $result);
    }

    /**
     * Test URL generation
     */
    public function testGetUrl(): void
    {
        $url = $this->storage->getUrl('products/image.jpg');

        $this->assertStringContainsString('/media/products/image.jpg', $url);
    }

    /**
     * Test path generation
     */
    public function testGetPath(): void
    {
        $path = $this->storage->getPath('products/image.jpg');

        $this->assertStringContainsString('rpkfiles/products/image.jpg', $path);
    }

    /**
     * Test file existence check
     */
    public function testExists(): void
    {
        // Create test file in actual media path
        $testFile = $this->testPath . '/test.txt';
        file_put_contents($testFile, 'test');

        // File doesn't exist yet in storage
        $this->assertFalse($this->storage->exists('test.txt'));
    }

    /**
     * Test file size retrieval
     */
    public function testSize(): void
    {
        $sourceFile = $this->testPath . '/source.txt';
        $content = 'Test content with known length';
        file_put_contents($sourceFile, $content);

        $result = $this->storage->store($sourceFile);

        $this->assertEquals(strlen($content), $result['size']);
    }

    /**
     * Test MIME type detection for text file
     */
    public function testMimeTypeText(): void
    {
        $sourceFile = $this->testPath . '/source.txt';
        file_put_contents($sourceFile, 'Test content');

        $result = $this->storage->store($sourceFile);

        $this->assertStringContainsString('text', $result['mime_type']);
    }

    /**
     * Test image dimensions extraction
     */
    public function testImageDimensions(): void
    {
        // Create simple 10x10 GIF
        $sourceFile = $this->testPath . '/test.gif';
        $img = imagecreate(10, 10);
        imagegif($img, $sourceFile);
        imagedestroy($img);

        $result = $this->storage->store($sourceFile);

        $this->assertEquals(10, $result['width']);
        $this->assertEquals(10, $result['height']);
    }

    /**
     * Test unique filename generation
     */
    public function testUniqueFilenames(): void
    {
        $sourceFile = $this->testPath . '/source.txt';
        file_put_contents($sourceFile, 'Test content');

        $result1 = $this->storage->store($sourceFile);
        $result2 = $this->storage->store($sourceFile);

        $this->assertNotEquals($result1['filename'], $result2['filename']);
    }

    /**
     * Test directory creation
     */
    public function testDirectoryCreation(): void
    {
        $sourceFile = $this->testPath . '/source.txt';
        file_put_contents($sourceFile, 'Test content');

        // Store in nested folder that doesn't exist
        $result = $this->storage->store($sourceFile, 'level1/level2/level3');

        $this->assertTrue($result['success']);
        $this->assertStringContainsString('level1/level2/level3', $result['path']);
    }

    /**
     * Helper to delete directory recursively
     */
    private function deleteDirectory(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }
        rmdir($dir);
    }
}
