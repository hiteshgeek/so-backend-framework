<?php

namespace Core\Video;

use Core\Video\Drivers\FFmpegDriver;
use Core\Media\StorageManager;
use App\Models\Media;

/**
 * VideoProcessor
 *
 * High-level video processing wrapper.
 * Provides easy-to-use methods for common video operations.
 *
 * Features:
 * - Thumbnail extraction
 * - Video metadata retrieval
 * - Preview GIF generation
 * - Video sprite generation
 * - Integration with Media model
 *
 * Usage:
 * ```php
 * $processor = new VideoProcessor();
 *
 * // Check availability
 * if (VideoProcessor::isAvailable()) {
 *     // Extract thumbnail
 *     $thumb = $processor->extractThumbnail('/path/video.mp4', '/path/thumb.jpg');
 *
 *     // Get metadata
 *     $meta = $processor->getMetadata('/path/video.mp4');
 *
 *     // Generate preview GIF
 *     $gif = $processor->generatePreviewGif('/path/video.mp4', '/path/preview.gif');
 * }
 * ```
 */
class VideoProcessor
{
    /**
     * FFmpeg driver
     */
    protected FFmpegDriver $driver;

    /**
     * Storage manager
     */
    protected StorageManager $storage;

    /**
     * Thumbnail width
     */
    protected int $thumbnailWidth;

    /**
     * Thumbnail height
     */
    protected int $thumbnailHeight;

    /**
     * Thumbnail extraction time (seconds)
     */
    protected float $thumbnailTime;

    /**
     * Number of thumbnails for preview
     */
    protected int $thumbnailCount;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->driver = new FFmpegDriver();
        $this->storage = new StorageManager();

        $config = config('media.video', []);
        $this->thumbnailWidth = $config['thumbnail_width'] ?? 640;
        $this->thumbnailHeight = $config['thumbnail_height'] ?? 360;
        $this->thumbnailTime = $config['thumbnail_time'] ?? 1.0;
        $this->thumbnailCount = $config['thumbnail_count'] ?? 3;
    }

    /**
     * Check if video processing is available
     *
     * @return bool
     */
    public static function isAvailable(): bool
    {
        $enabled = config('media.video.enabled', true);

        if (!$enabled) {
            return false;
        }

        $driver = new FFmpegDriver();
        return $driver->isAvailable();
    }

    /**
     * Extract thumbnail from video
     *
     * @param string $videoPath Path to video file
     * @param string $outputPath Output path for thumbnail
     * @param float|null $time Time position (uses config default if null)
     * @return bool True if successful
     */
    public function extractThumbnail(string $videoPath, string $outputPath, ?float $time = null): bool
    {
        $time = $time ?? $this->thumbnailTime;

        // Ensure output directory exists
        $dir = dirname($outputPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        return $this->driver->extractFrame($videoPath, $outputPath, $time, $this->thumbnailWidth);
    }

    /**
     * Extract multiple thumbnails from video
     *
     * @param string $videoPath Path to video file
     * @param string $outputDir Output directory
     * @param int|null $count Number of thumbnails (uses config default if null)
     * @return array Array of generated thumbnail paths
     */
    public function extractThumbnails(string $videoPath, string $outputDir, ?int $count = null): array
    {
        $count = $count ?? $this->thumbnailCount;

        return $this->driver->extractFrames(
            $videoPath,
            $outputDir,
            'thumb_%03d.jpg',
            $count
        );
    }

    /**
     * Get video metadata
     *
     * @param string $videoPath Path to video file
     * @return array Video metadata
     */
    public function getMetadata(string $videoPath): array
    {
        return $this->driver->getMetadata($videoPath);
    }

    /**
     * Generate preview GIF from video
     *
     * @param string $videoPath Path to video file
     * @param string $outputPath Output path for GIF
     * @param array $options GIF options (width, fps, duration, start)
     * @return bool True if successful
     */
    public function generatePreviewGif(string $videoPath, string $outputPath, array $options = []): bool
    {
        // Ensure output directory exists
        $dir = dirname($outputPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        return $this->driver->generateGif($videoPath, $outputPath, $options);
    }

    /**
     * Generate video sprite for timeline scrubbing
     *
     * @param string $videoPath Path to video file
     * @param string $outputPath Output path for sprite
     * @param array $options Sprite options (columns, rows, thumb_width)
     * @return array Sprite info or empty array on failure
     */
    public function generateSprite(string $videoPath, string $outputPath, array $options = []): array
    {
        // Ensure output directory exists
        $dir = dirname($outputPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        return $this->driver->generateSprite(
            $videoPath,
            $outputPath,
            $options['columns'] ?? 10,
            $options['rows'] ?? 10,
            $options['thumb_width'] ?? 160
        );
    }

    /**
     * Process video for a Media record
     *
     * Extracts thumbnail and metadata, creates variant record.
     *
     * @param int $mediaId Media record ID
     * @return array Processing result
     */
    public function processMediaVideo(int $mediaId): array
    {
        $media = Media::find($mediaId);

        if (!$media) {
            return ['success' => false, 'error' => 'Media not found'];
        }

        // Check if it's a video
        if (!$media->isVideo()) {
            return ['success' => false, 'error' => 'Not a video file'];
        }

        $videoPath = $media->getFullPath();

        if (!file_exists($videoPath)) {
            return ['success' => false, 'error' => 'Video file not found'];
        }

        $results = [
            'success' => true,
            'metadata' => [],
            'thumbnails' => [],
        ];

        try {
            // Get metadata
            $metadata = $this->getMetadata($videoPath);
            $results['metadata'] = $metadata;

            // Update media record with video metadata
            $media->updateMetadata([
                'video' => $metadata,
                'processed_at' => date('Y-m-d H:i:s'),
            ]);

            // Generate thumbnails
            $pathInfo = pathinfo($media->path);
            $directory = $pathInfo['dirname'] !== '.' ? $pathInfo['dirname'] . '/' : '';
            $filename = $pathInfo['filename'];

            // Main thumbnail
            $thumbFilename = $filename . '_thumb.jpg';
            $thumbRelativePath = $directory . $thumbFilename;
            $thumbFullPath = $this->storage->getPath($thumbRelativePath, $media->disk);

            if ($this->extractThumbnail($videoPath, $thumbFullPath)) {
                $thumbInfo = @getimagesize($thumbFullPath);

                // Create thumbnail media record
                Media::create([
                    'filename' => $thumbFilename,
                    'original_name' => pathinfo($media->original_name, PATHINFO_FILENAME) . '_thumb.jpg',
                    'path' => $thumbRelativePath,
                    'disk' => $media->disk,
                    'mime_type' => 'image/jpeg',
                    'size' => filesize($thumbFullPath),
                    'width' => $thumbInfo ? $thumbInfo[0] : null,
                    'height' => $thumbInfo ? $thumbInfo[1] : null,
                    'parent_id' => $media->id,
                    'metadata' => [
                        'variant_name' => 'video_thumbnail',
                        'source_time' => $this->thumbnailTime,
                    ],
                ]);

                $results['thumbnails'][] = $thumbRelativePath;
            }

            // Update parent metadata with thumbnail info
            $media->updateMetadata([
                'variants' => ['video_thumbnail'],
                'variants_generated_at' => date('Y-m-d H:i:s'),
            ]);

        } catch (\Exception $e) {
            $results['success'] = false;
            $results['error'] = $e->getMessage();

            if (function_exists('logger')) {
                logger()->error('Video processing failed', [
                    'media_id' => $mediaId,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $results;
    }

    /**
     * Check if file is a supported video format
     *
     * @param string $mimeType MIME type
     * @return bool
     */
    public static function isSupportedFormat(string $mimeType): bool
    {
        $allowedTypes = config('media.video.allowed_types', [
            'video/mp4',
            'video/webm',
            'video/quicktime',
            'video/x-msvideo',
            'video/x-ms-wmv',
            'video/x-matroska',
        ]);

        return in_array($mimeType, $allowedTypes);
    }

    /**
     * Validate video duration
     *
     * @param string $videoPath Path to video file
     * @return array Validation result (valid, duration, max_duration)
     */
    public function validateDuration(string $videoPath): array
    {
        $maxDuration = config('media.video.max_duration', 3600);
        $metadata = $this->getMetadata($videoPath);
        $duration = $metadata['duration'] ?? 0;

        return [
            'valid' => $maxDuration === 0 || $duration <= $maxDuration,
            'duration' => $duration,
            'max_duration' => $maxDuration,
        ];
    }

    /**
     * Get FFmpeg version
     *
     * @return string|null
     */
    public function getFFmpegVersion(): ?string
    {
        return $this->driver->getVersion();
    }
}
