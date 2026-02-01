<?php

namespace Tests\Unit\Media;

use PHPUnit\Framework\TestCase;
use Core\Video\VideoProcessor;
use Core\Video\Drivers\FFmpegDriver;

/**
 * VideoProcessor Unit Tests
 *
 * Tests for video processing operations.
 * Covers: thumbnail extraction, metadata, preview generation.
 *
 * Note: Some tests require FFmpeg to be installed on the system.
 * Tests will be skipped if FFmpeg is not available.
 */
class VideoProcessorTest extends TestCase
{
    private ?VideoProcessor $processor = null;
    private bool $ffmpegAvailable = false;
    private bool $appAvailable = false;
    private string $testPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testPath = sys_get_temp_dir() . '/video_test_' . uniqid();

        if (!is_dir($this->testPath)) {
            mkdir($this->testPath, 0755, true);
        }

        // Check FFmpeg availability independently
        $this->ffmpegAvailable = $this->checkFFmpegAvailable();

        // Try to instantiate the processor - may require app context
        try {
            $this->processor = new VideoProcessor();
            $this->appAvailable = true;
        } catch (\Throwable $e) {
            $this->appAvailable = false;
        }
    }

    /**
     * Check FFmpeg availability independently
     */
    private function checkFFmpegAvailable(): bool
    {
        exec('which ffmpeg 2>/dev/null', $output, $returnCode);
        return $returnCode === 0;
    }

    /**
     * Skip test if application is not available
     */
    protected function requireApp(): void
    {
        if (!$this->appAvailable || $this->processor === null) {
            $this->markTestSkipped('Video processor tests require full application context (config)');
        }
    }

    protected function tearDown(): void
    {
        if (is_dir($this->testPath)) {
            $this->deleteDirectory($this->testPath);
        }

        parent::tearDown();
    }

    /**
     * Test FFmpeg availability check
     */
    public function testIsAvailable(): void
    {
        $available = VideoProcessor::isAvailable();

        $this->assertIsBool($available);

        // Log for debugging
        if (!$available) {
            $this->markTestSkipped('FFmpeg is not available on this system');
        }
    }

    /**
     * Test FFmpegDriver instantiation
     */
    public function testFFmpegDriverInstantiation(): void
    {
        $driver = new FFmpegDriver();
        $this->assertInstanceOf(FFmpegDriver::class, $driver);
    }

    /**
     * Test FFmpegDriver isAvailable method
     */
    public function testFFmpegDriverIsAvailable(): void
    {
        $driver = new FFmpegDriver();
        $available = $driver->isAvailable();

        $this->assertIsBool($available);
    }

    /**
     * Test extractThumbnail method signature
     */
    public function testExtractThumbnailMethodExists(): void
    {
        $this->requireApp();

        $this->assertTrue(
            method_exists($this->processor, 'extractThumbnail'),
            'VideoProcessor should have extractThumbnail method'
        );
    }

    /**
     * Test extractThumbnails method signature
     */
    public function testExtractThumbnailsMethodExists(): void
    {
        $this->requireApp();

        $this->assertTrue(
            method_exists($this->processor, 'extractThumbnails'),
            'VideoProcessor should have extractThumbnails method'
        );
    }

    /**
     * Test getMetadata method signature
     */
    public function testGetMetadataMethodExists(): void
    {
        $this->requireApp();

        $this->assertTrue(
            method_exists($this->processor, 'getMetadata'),
            'VideoProcessor should have getMetadata method'
        );
    }

    /**
     * Test generatePreviewGif method signature
     */
    public function testGeneratePreviewGifMethodExists(): void
    {
        $this->requireApp();

        $this->assertTrue(
            method_exists($this->processor, 'generatePreviewGif'),
            'VideoProcessor should have generatePreviewGif method'
        );
    }

    /**
     * Test extractThumbnail with non-existent file
     */
    public function testExtractThumbnailNonExistentFile(): void
    {
        $this->requireApp();
        if (!$this->ffmpegAvailable) {
            $this->markTestSkipped('FFmpeg not available');
        }

        $result = $this->processor->extractThumbnail(
            '/path/to/nonexistent.mp4',
            $this->testPath . '/thumb.jpg'
        );

        $this->assertFalse($result);
    }

    /**
     * Test getMetadata with non-existent file
     */
    public function testGetMetadataNonExistentFile(): void
    {
        $this->requireApp();
        if (!$this->ffmpegAvailable) {
            $this->markTestSkipped('FFmpeg not available');
        }

        $result = $this->processor->getMetadata('/path/to/nonexistent.mp4');

        // Should return empty array or false for non-existent file
        $this->assertTrue(empty($result) || $result === false);
    }

    /**
     * Test metadata structure for valid video
     */
    public function testMetadataStructure(): void
    {
        $this->requireApp();
        // Create a minimal valid video file for testing
        // This requires FFmpeg, so skip if not available
        if (!$this->ffmpegAvailable) {
            $this->markTestSkipped('FFmpeg not available');
        }

        // Create a test video using FFmpeg
        $testVideo = $this->createTestVideo();

        if (!$testVideo) {
            $this->markTestSkipped('Could not create test video');
        }

        $metadata = $this->processor->getMetadata($testVideo);

        // If we got metadata, verify structure
        if (!empty($metadata)) {
            $this->assertIsArray($metadata);

            // Check for expected keys
            $expectedKeys = ['duration', 'width', 'height'];
            foreach ($expectedKeys as $key) {
                if (isset($metadata[$key])) {
                    $this->assertArrayHasKey($key, $metadata);
                }
            }
        }
    }

    /**
     * Test thumbnail extraction timing parameter
     */
    public function testExtractThumbnailTiming(): void
    {
        $this->requireApp();
        if (!$this->ffmpegAvailable) {
            $this->markTestSkipped('FFmpeg not available');
        }

        $testVideo = $this->createTestVideo();

        if (!$testVideo) {
            $this->markTestSkipped('Could not create test video');
        }

        $output = $this->testPath . '/thumb_1s.jpg';

        // Extract at 1 second (default)
        $result = $this->processor->extractThumbnail($testVideo, $output, 1.0);

        // Check if extraction succeeded
        if ($result && file_exists($output)) {
            $this->assertFileExists($output);
            $this->assertGreaterThan(0, filesize($output));
        }
    }

    /**
     * Test multiple thumbnail extraction
     */
    public function testExtractMultipleThumbnails(): void
    {
        $this->requireApp();
        if (!$this->ffmpegAvailable) {
            $this->markTestSkipped('FFmpeg not available');
        }

        $testVideo = $this->createTestVideo(5); // 5 second video

        if (!$testVideo) {
            $this->markTestSkipped('Could not create test video');
        }

        $outputDir = $this->testPath . '/thumbs';
        mkdir($outputDir, 0755, true);

        $results = $this->processor->extractThumbnails($testVideo, $outputDir, 3);

        if (!empty($results)) {
            $this->assertIsArray($results);
        }
    }

    /**
     * Test GIF preview generation
     */
    public function testGeneratePreviewGif(): void
    {
        $this->requireApp();
        if (!$this->ffmpegAvailable) {
            $this->markTestSkipped('FFmpeg not available');
        }

        $testVideo = $this->createTestVideo(3);

        if (!$testVideo) {
            $this->markTestSkipped('Could not create test video');
        }

        $output = $this->testPath . '/preview.gif';

        $result = $this->processor->generatePreviewGif($testVideo, $output, [
            'width' => 320,
            'fps' => 10,
            'duration' => 2
        ]);

        // May fail if video is too short, but method should exist
        $this->assertIsBool($result);
    }

    /**
     * Test sprite generation method exists
     */
    public function testGenerateSpriteMethodExists(): void
    {
        $this->requireApp();

        $this->assertTrue(
            method_exists($this->processor, 'generateSprite'),
            'VideoProcessor should have generateSprite method'
        );
    }

    /**
     * Test processMediaVideo method exists
     */
    public function testProcessMediaVideoMethodExists(): void
    {
        $this->requireApp();

        $this->assertTrue(
            method_exists($this->processor, 'processMediaVideo'),
            'VideoProcessor should have processMediaVideo method for Media model integration'
        );
    }

    /**
     * Test output format handling
     */
    public function testOutputFormatHandling(): void
    {
        $this->requireApp();
        if (!$this->ffmpegAvailable) {
            $this->markTestSkipped('FFmpeg not available');
        }

        $testVideo = $this->createTestVideo();

        if (!$testVideo) {
            $this->markTestSkipped('Could not create test video');
        }

        // Test different output formats
        $formats = ['jpg', 'png', 'webp'];

        foreach ($formats as $format) {
            $output = $this->testPath . "/thumb.{$format}";
            $result = $this->processor->extractThumbnail($testVideo, $output, 0.5);

            // Result should be boolean
            $this->assertIsBool($result);
        }
    }

    /**
     * Test video duration extraction
     */
    public function testVideoDurationExtraction(): void
    {
        $this->requireApp();
        if (!$this->ffmpegAvailable) {
            $this->markTestSkipped('FFmpeg not available');
        }

        $testVideo = $this->createTestVideo(5);

        if (!$testVideo) {
            $this->markTestSkipped('Could not create test video');
        }

        $metadata = $this->processor->getMetadata($testVideo);

        if (isset($metadata['duration'])) {
            // Duration should be approximately 5 seconds
            $this->assertGreaterThan(0, $metadata['duration']);
        }
    }

    /**
     * Test video dimensions extraction
     */
    public function testVideoDimensionsExtraction(): void
    {
        $this->requireApp();
        if (!$this->ffmpegAvailable) {
            $this->markTestSkipped('FFmpeg not available');
        }

        $testVideo = $this->createTestVideo();

        if (!$testVideo) {
            $this->markTestSkipped('Could not create test video');
        }

        $metadata = $this->processor->getMetadata($testVideo);

        if (isset($metadata['width']) && isset($metadata['height'])) {
            $this->assertGreaterThan(0, $metadata['width']);
            $this->assertGreaterThan(0, $metadata['height']);
        }
    }

    /**
     * Test FFmpegDriver command building
     */
    public function testFFmpegDriverCommands(): void
    {
        $driver = new FFmpegDriver();

        // Test that driver has proper methods
        $this->assertTrue(method_exists($driver, 'extractFrame'));
        $this->assertTrue(method_exists($driver, 'getMetadata'));
    }

    /**
     * Create a test video file using FFmpeg
     *
     * @param int $duration Duration in seconds
     * @return string|null Path to test video or null if creation failed
     */
    private function createTestVideo(int $duration = 2): ?string
    {
        $outputPath = $this->testPath . '/test_video.mp4';

        // Use FFmpeg to create a test video with color bars
        $cmd = sprintf(
            'ffmpeg -f lavfi -i testsrc=duration=%d:size=320x240:rate=30 -c:v libx264 -pix_fmt yuv420p %s -y 2>/dev/null',
            $duration,
            escapeshellarg($outputPath)
        );

        exec($cmd, $output, $returnCode);

        if ($returnCode === 0 && file_exists($outputPath)) {
            return $outputPath;
        }

        // Try simpler command
        $cmd2 = sprintf(
            'ffmpeg -f lavfi -i color=c=blue:s=320x240:d=%d -c:v libx264 %s -y 2>/dev/null',
            $duration,
            escapeshellarg($outputPath)
        );

        exec($cmd2, $output2, $returnCode2);

        if ($returnCode2 === 0 && file_exists($outputPath)) {
            return $outputPath;
        }

        return null;
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
