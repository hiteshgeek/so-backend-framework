<?php

namespace App\Jobs\Image;

use Core\Queue\Job;
use App\Models\Media;
use Core\Image\VariantGenerator;

/**
 * GenerateImageVariants Job
 *
 * Asynchronous job to generate image variants (thumbnails, responsive sizes).
 * Queued automatically when images are uploaded via uploadAndCreate().
 *
 * This job:
 * - Loads the original image
 * - Generates all configured variants (thumb, small, medium, large)
 * - Saves variants with naming convention: original_thumb.jpg
 * - Creates Media records for each variant
 * - Updates parent metadata with variant list
 *
 * Queue: media (default)
 * Priority: normal
 * Retry: 3 attempts
 */
class GenerateImageVariants extends Job
{
    /**
     * Media record ID
     */
    protected int $mediaId;

    /**
     * Specific variants to generate (null = all)
     */
    protected ?array $variants;

    /**
     * Constructor
     *
     * @param int $mediaId Media record ID
     * @param array|null $variants Specific variant names or null for all
     */
    public function __construct(int $mediaId, ?array $variants = null)
    {
        $this->mediaId = $mediaId;
        $this->variants = $variants;
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
            $this->log("Skipping variant generation for non-image file: {$media->mime_type}");
            return;
        }

        // Verify file exists
        if (!$media->fileExists()) {
            $this->fail(new \Exception("Media file not found: {$media->path}"));
            return;
        }

        $this->log("Generating variants for media ID: {$this->mediaId}");

        // Generate variants
        $generator = new VariantGenerator();

        try {
            if ($this->variants) {
                // Generate specific variants
                $generated = $generator->generate($this->mediaId, $this->variants);
                $this->log("Generated " . count($generated) . " specific variants");
            } else {
                // Generate all configured variants
                $generated = $generator->generateAll($this->mediaId);
                $this->log("Generated " . count($generated) . " variants");
            }

            // Log variant details
            foreach ($generated as $variantName => $variantPath) {
                $this->log("  - {$variantName}: {$variantPath}");
            }

        } catch (\Exception $e) {
            $this->log("Variant generation failed: " . $e->getMessage(), 'error');
            $this->fail($e);
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
                'variant_generation_failed' => true,
                'variant_generation_error' => $exception->getMessage(),
                'variant_generation_failed_at' => date('Y-m-d H:i:s'),
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
            logger()->{$level}("[GenerateImageVariants] {$message}", [
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
            'variants' => $this->variants,
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
        $this->variants = $data['variants'] ?? null;
    }
}
