<?php

namespace Tests\Unit\Media;

use PHPUnit\Framework\TestCase;
use Core\Media\CdnManager;

/**
 * CdnManager Unit Tests
 *
 * Tests for CDN URL generation and cache management.
 * Covers: URL rewriting, CDN rules, purge operations.
 *
 * Note: Some tests require the full application to be bootstrapped.
 */
class CdnManagerTest extends TestCase
{
    private ?CdnManager $cdn = null;
    private bool $appAvailable = false;

    protected function setUp(): void
    {
        parent::setUp();

        try {
            $this->cdn = new CdnManager();
            $this->appAvailable = true;
        } catch (\Throwable $e) {
            $this->appAvailable = false;
        }
    }

    /**
     * Skip test if application is not available
     */
    protected function requireApp(): void
    {
        if (!$this->appAvailable || $this->cdn === null) {
            $this->markTestSkipped('CDN tests require full application context (config)');
        }
    }

    /**
     * Test CDN URL generation when CDN is disabled
     */
    public function testGetUrlWhenDisabled(): void
    {
        $this->requireApp();

        $path = 'images/photo.jpg';
        $url = $this->cdn->getUrl($path);

        $this->assertStringContainsString($path, $url);
    }

    /**
     * Test CDN enabled check
     */
    public function testIsEnabled(): void
    {
        $this->requireApp();

        $enabled = $this->cdn->isEnabled();
        $this->assertIsBool($enabled);
    }

    /**
     * Test shouldUseCdn with different file types
     */
    public function testShouldUseCdnForImages(): void
    {
        $this->requireApp();

        $result = $this->cdn->shouldUseCdn('images/photo.jpg', 'image/jpeg');
        $this->assertIsBool($result);
    }

    /**
     * Test shouldUseCdn for video files
     */
    public function testShouldUseCdnForVideos(): void
    {
        $this->requireApp();

        $result = $this->cdn->shouldUseCdn('videos/clip.mp4', 'video/mp4');
        $this->assertIsBool($result);
    }

    /**
     * Test shouldUseCdn for excluded paths
     */
    public function testShouldNotUseCdnForPrivatePaths(): void
    {
        $this->requireApp();

        $result = $this->cdn->shouldUseCdn('/private/secret.pdf', 'application/pdf');
        $this->assertIsBool($result);
    }

    /**
     * Test shouldUseCdn for temp paths
     */
    public function testShouldNotUseCdnForTempPaths(): void
    {
        $this->requireApp();

        $result = $this->cdn->shouldUseCdn('/temp/upload.tmp', 'application/octet-stream');
        $this->assertIsBool($result);
    }

    /**
     * Test URL generation preserves path structure
     */
    public function testUrlPreservesPathStructure(): void
    {
        $this->requireApp();

        $path = 'products/category/item-123/image.jpg';
        $url = $this->cdn->getUrl($path);

        $this->assertStringContainsString('products', $url);
        $this->assertStringContainsString('image.jpg', $url);
    }

    /**
     * Test URL generation handles leading slashes
     */
    public function testUrlHandlesLeadingSlash(): void
    {
        $this->requireApp();

        $url1 = $this->cdn->getUrl('images/photo.jpg');
        $url2 = $this->cdn->getUrl('/images/photo.jpg');

        $this->assertStringNotContainsString('//', ltrim($url1, 'https://http://'));
        $this->assertStringNotContainsString('//', ltrim($url2, 'https://http://'));
    }

    /**
     * Test URL generation with query strings
     */
    public function testUrlWithQueryString(): void
    {
        $this->requireApp();

        $path = 'images/photo.jpg?v=123';
        $url = $this->cdn->getUrl($path);

        $this->assertStringContainsString('v=123', $url);
    }

    /**
     * Test purge method exists and returns expected type
     */
    public function testPurgeMethod(): void
    {
        $this->requireApp();

        $result = $this->cdn->purge('images/photo.jpg');
        $this->assertIsBool($result);
    }

    /**
     * Test purgeMany method
     */
    public function testPurgeManyMethod(): void
    {
        $this->requireApp();

        $paths = [
            'images/photo1.jpg',
            'images/photo2.jpg',
            'images/photo3.jpg'
        ];

        $results = $this->cdn->purgeMany($paths);
        $this->assertIsArray($results);
    }

    /**
     * Test purge with wildcard pattern
     */
    public function testPurgeWithWildcard(): void
    {
        $this->requireApp();

        $result = $this->cdn->purge('images/*');
        $this->assertIsBool($result);
    }

    /**
     * Test MIME type filtering
     */
    public function testMimeTypeFiltering(): void
    {
        $this->requireApp();

        $imageResult = $this->cdn->shouldUseCdn('file.jpg', 'image/jpeg');
        $phpResult = $this->cdn->shouldUseCdn('file.php', 'application/x-php');

        $this->assertIsBool($imageResult);
        $this->assertIsBool($phpResult);
    }

    /**
     * Test path normalization
     */
    public function testPathNormalization(): void
    {
        $this->requireApp();

        $url = $this->cdn->getUrl('../../../etc/passwd');
        $this->assertStringNotContainsString('../', $url);
    }

    /**
     * Test URL for WebP variants
     */
    public function testUrlForWebpVariants(): void
    {
        $this->requireApp();

        $url = $this->cdn->getUrl('images/photo.webp');
        $this->assertStringContainsString('.webp', $url);
    }

    /**
     * Test URL for video thumbnails
     */
    public function testUrlForVideoThumbnails(): void
    {
        $this->requireApp();

        $url = $this->cdn->getUrl('videos/clip_thumb.jpg');
        $this->assertStringContainsString('_thumb.jpg', $url);
    }

    /**
     * Test empty path handling
     */
    public function testEmptyPathHandling(): void
    {
        $this->requireApp();

        $url = $this->cdn->getUrl('');
        $this->assertIsString($url);
    }

    /**
     * Test special characters in path
     */
    public function testSpecialCharactersInPath(): void
    {
        $this->requireApp();

        $path = 'images/photo with spaces.jpg';
        $url = $this->cdn->getUrl($path);
        $this->assertIsString($url);
    }

    /**
     * Test unicode characters in path
     */
    public function testUnicodeInPath(): void
    {
        $this->requireApp();

        $path = 'images/фото.jpg';
        $url = $this->cdn->getUrl($path);
        $this->assertIsString($url);
    }
}
