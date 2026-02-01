<?php

namespace App\Jobs\Image;

use Core\Queue\Job;
use App\Models\Media;
use Core\Image\ImageProcessor;
use Core\Media\StorageManager;

/**
 * ApplyWatermark Job
 *
 * Asynchronous job to apply watermarks to images.
 * Queued when watermark option is specified in upload.
 *
 * This job:
 * - Loads the original image
 * - Applies configured watermark (text or image)
 * - Supports presets from config or custom configuration
 * - Can apply to original or variants
 * - Updates file in place or creates new watermarked version
 *
 * Queue: media (default)
 * Priority: normal
 * Retry: 3 attempts
 */
class ApplyWatermark extends Job
{
    /**
     * Media record ID
     */
    protected int $mediaId;

    /**
     * Watermark preset name or configuration
     */
    protected string|array $watermark;

    /**
     * Whether to create new file or overwrite original
     */
    protected bool $inPlace;

    /**
     * Apply to variants as well
     */
    protected bool $applyToVariants;

    /**
     * Constructor
     *
     * @param int $mediaId Media record ID
     * @param string|array $watermark Watermark preset name or config array
     * @param bool $inPlace Overwrite original (true) or create new file (false)
     * @param bool $applyToVariants Apply watermark to variants as well
     */
    public function __construct(
        int $mediaId,
        string|array $watermark,
        bool $inPlace = true,
        bool $applyToVariants = false
    ) {
        $this->mediaId = $mediaId;
        $this->watermark = $watermark;
        $this->inPlace = $inPlace;
        $this->applyToVariants = $applyToVariants;
        $this->queue = config('media.queue.queue', 'media');
        $this->tries = 3;
        $this->timeout = 300; // 5 minutes
    }

    /**
     * Execute the job
     *
     * @return void
     */
    public function handle(): void
    {
        // Load media record
        $media = Media::find($this->mediaId);

        if (!$media) {
            $this->fail(new \Exception("Media record not found: {$this->mediaId}"));
            return;
        }

        // Verify it's an image
        if (!$media->isImage()) {
            $this->log("Skipping watermark for non-image file: {$media->mime_type}");
            return;
        }

        // Verify file exists
        if (!$media->fileExists()) {
            $this->fail(new \Exception("Media file not found: {$media->path}"));
            return;
        }

        $this->log("Applying watermark to media ID: {$this->mediaId}");

        try {
            // Apply watermark to original
            $this->applyWatermarkToFile($media);

            // Apply to variants if requested
            if ($this->applyToVariants) {
                $variants = $media->variants();
                foreach ($variants as $variant) {
                    $this->applyWatermarkToFile($variant);
                }
                $this->log("Applied watermark to " . count($variants) . " variants");
            }

            // Update metadata
            $media->updateMetadata([
                'watermark_applied' => true,
                'watermark_config' => is_string($this->watermark) ? ['preset' => $this->watermark] : $this->watermark,
                'watermark_applied_at' => date('Y-m-d H:i:s'),
            ]);

            $this->log("Watermark applied successfully");

        } catch (\Exception $e) {
            $this->log("Watermark application failed: " . $e->getMessage(), 'error');
            $this->fail($e);
        }
    }

    /**
     * Apply watermark to specific file
     *
     * @param Media $media Media record
     * @return void
     * @throws \Exception
     */
    protected function applyWatermarkToFile(Media $media): void
    {
        $fullPath = $media->getFullPath();

        if (!file_exists($fullPath)) {
            throw new \Exception("File not found: {$fullPath}");
        }

        // Create image processor
        $processor = ImageProcessor::create($fullPath);

        // Apply watermark
        $processor->watermark($this->watermark);

        if ($this->inPlace) {
            // Overwrite original file
            $processor->save($fullPath, 85);
            $this->log("Watermark applied in-place to: {$media->path}");
        } else {
            // Create new watermarked file
            $storage = new StorageManager();
            $pathInfo = pathinfo($media->path);
            $directory = $pathInfo['dirname'] !== '.' ? $pathInfo['dirname'] . '/' : '';
            $filename = $pathInfo['filename'];
            $extension = $pathInfo['extension'] ?? 'jpg';

            $watermarkedFilename = $filename . '_watermarked.' . $extension;
            $watermarkedRelativePath = $directory . $watermarkedFilename;
            $watermarkedFullPath = $storage->getPath($watermarkedRelativePath, $media->disk);

            $processor->save($watermarkedFullPath, 85);

            // Create new media record for watermarked version
            $watermarkedInfo = @getimagesize($watermarkedFullPath);

            Media::create([
                'filename' => $watermarkedFilename,
                'original_name' => $media->original_name,
                'path' => $watermarkedRelativePath,
                'disk' => $media->disk,
                'mime_type' => $media->mime_type,
                'size' => filesize($watermarkedFullPath),
                'width' => $watermarkedInfo ? $watermarkedInfo[0] : null,
                'height' => $watermarkedInfo ? $watermarkedInfo[1] : null,
                'parent_id' => $media->id,
                'metadata' => [
                    'type' => 'watermarked',
                    'watermark_config' => is_string($this->watermark) ? ['preset' => $this->watermark] : $this->watermark,
                ],
            ]);

            $this->log("Created watermarked copy: {$watermarkedRelativePath}");
        }
    }

    /**
     * Handle job failure
     *
     * @param \Throwable $exception
     * @return void
     */
    public function failed(\Throwable $exception): void
    {
        $this->log("Job failed after {$this->attempts()} attempts: " . $exception->getMessage(), 'error');

        // Update media metadata to indicate failure
        $media = Media::find($this->mediaId);
        if ($media) {
            $media->updateMetadata([
                'watermark_failed' => true,
                'watermark_error' => $exception->getMessage(),
                'watermark_failed_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    /**
     * Log message
     *
     * @param string $message Log message
     * @param string $level Log level
     * @return void
     */
    protected function log(string $message, string $level = 'info'): void
    {
        if (function_exists('logger')) {
            logger()->{$level}("[ApplyWatermark] {$message}", [
                'media_id' => $this->mediaId,
                'job_id' => $this->getJobId(),
            ]);
        }
    }

    /**
     * Get serialized job data
     *
     * @return array
     */
    public function __serialize(): array
    {
        return [
            'mediaId' => $this->mediaId,
            'watermark' => $this->watermark,
            'inPlace' => $this->inPlace,
            'applyToVariants' => $this->applyToVariants,
        ];
    }

    /**
     * Restore job from serialized data
     *
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->mediaId = $data['mediaId'];
        $this->watermark = $data['watermark'];
        $this->inPlace = $data['inPlace'] ?? true;
        $this->applyToVariants = $data['applyToVariants'] ?? false;
    }
}
