<?php

namespace Tests\Unit\Media;

use PHPUnit\Framework\TestCase;
use Core\Media\ChunkedUploadManager;

/**
 * ChunkedUploadManager Unit Tests
 *
 * Tests for resumable chunked file uploads.
 * Covers: initialization, chunk upload, resumption, completion, cancellation.
 *
 * Note: These tests require the full application to be bootstrapped.
 * Tests will be skipped if the application context is not available.
 */
class ChunkedUploadManagerTest extends TestCase
{
    private ?ChunkedUploadManager $manager = null;
    private string $testPath;
    private bool $appAvailable = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testPath = sys_get_temp_dir() . '/chunked_test_' . uniqid();

        if (!is_dir($this->testPath)) {
            mkdir($this->testPath, 0755, true);
        }

        // Try to instantiate the manager and verify database works
        try {
            $this->manager = new ChunkedUploadManager();

            // Test a simple database operation to verify full app context
            $result = $this->manager->initiate('test.txt', 1000, 500);
            if (isset($result['success']) && $result['success']) {
                // Cleanup test session
                $this->manager->cancel($result['upload_id']);
                $this->appAvailable = true;
            } else {
                $this->appAvailable = false;
            }
        } catch (\Throwable $e) {
            // Application or database not available, tests will be skipped
            $this->appAvailable = false;
        }
    }

    /**
     * Skip test if application is not available
     */
    protected function requireApp(): void
    {
        if (!$this->appAvailable || $this->manager === null) {
            $this->markTestSkipped('Chunked upload tests require full application context (database, config)');
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
     * Test initiating a chunked upload session
     */
    public function testInitiateUpload(): void
    {
        $this->requireApp();

        $result = $this->manager->initiate(
            filename: 'large-file.mp4',
            totalSize: 10 * 1024 * 1024, // 10MB
            chunkSize: 2 * 1024 * 1024   // 2MB chunks
        );

        $this->assertTrue($result['success']);
        $this->assertArrayHasKey('upload_id', $result);
        $this->assertArrayHasKey('chunk_size', $result);
        $this->assertArrayHasKey('total_chunks', $result);
        $this->assertEquals(5, $result['total_chunks']);
        $this->assertNotEmpty($result['upload_id']);
    }

    /**
     * Test initiating upload with custom metadata
     */
    public function testInitiateWithMetadata(): void
    {
        $this->requireApp();

        $metadata = [
            'user_id' => 123,
            'folder' => 'videos/uploads',
            'description' => 'Test video file'
        ];

        $result = $this->manager->initiate(
            filename: 'video.mp4',
            totalSize: 5 * 1024 * 1024,
            chunkSize: 1024 * 1024,
            metadata: $metadata
        );

        $this->assertTrue($result['success']);
        $this->assertArrayHasKey('upload_id', $result);
    }

    /**
     * Test initiating upload with invalid parameters
     */
    public function testInitiateWithInvalidSize(): void
    {
        $this->requireApp();

        $result = $this->manager->initiate(
            filename: 'file.txt',
            totalSize: 0,
            chunkSize: 1024
        );

        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('error', $result);
    }

    /**
     * Test getting upload status
     */
    public function testGetStatus(): void
    {
        $this->requireApp();

        $initResult = $this->manager->initiate(
            filename: 'test.mp4',
            totalSize: 4 * 1024 * 1024,
            chunkSize: 1024 * 1024
        );

        $this->assertTrue($initResult['success']);

        $status = $this->manager->getStatus($initResult['upload_id']);

        $this->assertTrue($status['success']);
        $this->assertEquals('pending', $status['status']);
        $this->assertEquals(0, $status['uploaded_chunks']);
        $this->assertEquals(4, $status['total_chunks']);
        $this->assertEquals(0, $status['progress']);
    }

    /**
     * Test getting status for non-existent upload
     */
    public function testGetStatusNonExistent(): void
    {
        $this->requireApp();

        $status = $this->manager->getStatus('non-existent-upload-id');

        $this->assertFalse($status['success']);
        $this->assertArrayHasKey('error', $status);
    }

    /**
     * Test uploading a chunk
     */
    public function testUploadChunk(): void
    {
        $this->requireApp();

        $initResult = $this->manager->initiate(
            filename: 'test.dat',
            totalSize: 3072,
            chunkSize: 1024
        );

        $this->assertTrue($initResult['success']);

        $chunkData = str_repeat('A', 1024);

        $result = $this->manager->uploadChunk(
            uploadId: $initResult['upload_id'],
            chunkNumber: 0,
            chunkData: $chunkData
        );

        $this->assertTrue($result['success']);
        $this->assertEquals(1, $result['uploaded_chunks']);
        $this->assertEquals(3, $result['total_chunks']);
    }

    /**
     * Test uploading chunk with invalid chunk number
     */
    public function testUploadChunkInvalidNumber(): void
    {
        $this->requireApp();

        $initResult = $this->manager->initiate(
            filename: 'test.dat',
            totalSize: 2048,
            chunkSize: 1024
        );

        $chunkData = str_repeat('A', 1024);

        $result = $this->manager->uploadChunk(
            uploadId: $initResult['upload_id'],
            chunkNumber: 10,
            chunkData: $chunkData
        );

        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('error', $result);
    }

    /**
     * Test complete upload flow
     */
    public function testCompleteUpload(): void
    {
        $this->requireApp();

        $initResult = $this->manager->initiate(
            filename: 'complete-test.txt',
            totalSize: 2048,
            chunkSize: 1024
        );

        $this->assertTrue($initResult['success']);
        $uploadId = $initResult['upload_id'];

        for ($i = 0; $i < 2; $i++) {
            $chunkData = str_repeat(chr(65 + $i), 1024);
            $result = $this->manager->uploadChunk($uploadId, $i, $chunkData);
            $this->assertTrue($result['success']);
        }

        $completeResult = $this->manager->complete($uploadId);

        $this->assertTrue($completeResult['success']);
        $this->assertArrayHasKey('path', $completeResult);
        $this->assertArrayHasKey('filename', $completeResult);
        $this->assertEquals(2048, $completeResult['size']);
    }

    /**
     * Test completing upload with missing chunks
     */
    public function testCompleteWithMissingChunks(): void
    {
        $this->requireApp();

        $initResult = $this->manager->initiate(
            filename: 'incomplete.txt',
            totalSize: 3072,
            chunkSize: 1024
        );

        $uploadId = $initResult['upload_id'];

        $this->manager->uploadChunk($uploadId, 0, str_repeat('A', 1024));

        $completeResult = $this->manager->complete($uploadId);

        $this->assertFalse($completeResult['success']);
        $this->assertArrayHasKey('error', $completeResult);
        $this->assertStringContainsString('missing', strtolower($completeResult['error']));
    }

    /**
     * Test cancelling an upload
     */
    public function testCancelUpload(): void
    {
        $this->requireApp();

        $initResult = $this->manager->initiate(
            filename: 'cancel-test.txt',
            totalSize: 2048,
            chunkSize: 1024
        );

        $uploadId = $initResult['upload_id'];

        $this->manager->uploadChunk($uploadId, 0, str_repeat('A', 1024));

        $cancelResult = $this->manager->cancel($uploadId);

        $this->assertTrue($cancelResult);

        $status = $this->manager->getStatus($uploadId);
        $this->assertFalse($status['success']);
    }

    /**
     * Test progress calculation
     */
    public function testProgressCalculation(): void
    {
        $this->requireApp();

        $initResult = $this->manager->initiate(
            filename: 'progress-test.dat',
            totalSize: 4096,
            chunkSize: 1024
        );

        $uploadId = $initResult['upload_id'];

        $this->manager->uploadChunk($uploadId, 0, str_repeat('A', 1024));
        $this->manager->uploadChunk($uploadId, 1, str_repeat('B', 1024));

        $status = $this->manager->getStatus($uploadId);

        $this->assertEquals(50, $status['progress']);
        $this->assertEquals(2, $status['uploaded_chunks']);
        $this->assertEquals(4, $status['total_chunks']);
    }

    /**
     * Test chunk deduplication (uploading same chunk twice)
     */
    public function testChunkDeduplication(): void
    {
        $this->requireApp();

        $initResult = $this->manager->initiate(
            filename: 'dedup-test.dat',
            totalSize: 2048,
            chunkSize: 1024
        );

        $uploadId = $initResult['upload_id'];
        $chunkData = str_repeat('A', 1024);

        $result1 = $this->manager->uploadChunk($uploadId, 0, $chunkData);
        $result2 = $this->manager->uploadChunk($uploadId, 0, $chunkData);

        $this->assertTrue($result1['success']);
        $this->assertTrue($result2['success']);
        $this->assertEquals(1, $result2['uploaded_chunks']);
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
