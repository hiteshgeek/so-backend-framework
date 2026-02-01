<?php

namespace Core\Media;

/**
 * FileUploadManager
 *
 * Central orchestrator for file uploads.
 * Coordinates validation, storage, and optional database tracking.
 *
 * Key Design:
 * - upload() returns result without creating DB entry (developer decides)
 * - uploadAndCreate() convenience method for automatic DB entry
 * - Queue-based async processing for variants and watermarks
 *
 * Usage:
 * ```php
 * $manager = new FileUploadManager();
 *
 * // Manual control (no DB entry)
 * $result = $manager->upload($_FILES['image'], ['folder' => 'products']);
 * if ($result['success']) {
 *     // Developer decides what to do with result
 *     Media::create([...]);
 * }
 *
 * // Convenience method (auto DB entry)
 * $media = $manager->uploadAndCreate($_FILES['image'], ['folder' => 'products']);
 * ```
 */
class FileUploadManager
{
    /**
     * Storage manager instance
     */
    protected StorageManager $storage;

    /**
     * File validator instance
     */
    protected FileValidator $validator;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->storage = new StorageManager();
        $this->validator = new FileValidator();
    }

    /**
     * Upload file with validation - Returns upload result WITHOUT DB entry
     *
     * This method validates and stores the file, then returns the result.
     * The developer decides whether to create a database entry or not.
     *
     * @param array $file $_FILES array element
     * @param array $options Upload options:
     *                       - 'folder' (string): Optional folder path (e.g., 'products/featured')
     *                       - 'filename' (string): Optional custom filename
     *                       - 'disk' (string): Storage disk to use
     *                       - 'variants' (bool): Generate image variants (requires DB entry)
     *                       - 'watermark' (string): Watermark preset name (requires DB entry)
     * @return array Upload result:
     *               - 'success' (bool): Whether upload succeeded
     *               - 'filename' (string): Generated filename
     *               - 'original_name' (string): Original uploaded filename
     *               - 'path' (string): Relative path from media root
     *               - 'full_path' (string): Full filesystem path
     *               - 'url' (string): Public URL
     *               - 'size' (int): File size in bytes
     *               - 'mime_type' (string): MIME type
     *               - 'width' (int|null): Image width in pixels
     *               - 'height' (int|null): Image height in pixels
     *               - 'disk' (string): Storage disk used
     *               - 'error' (string): Error message if failed
     *               - 'errors' (array): Validation errors if failed
     */
    public function upload(array $file, array $options = []): array
    {
        // Validate file
        $errors = $this->validator->validate($file);
        if (!empty($errors)) {
            return [
                'success' => false,
                'errors' => $errors,
            ];
        }

        // Extract options
        $folder = $options['folder'] ?? null;
        $filename = $options['filename'] ?? null;
        $disk = $options['disk'] ?? null;

        // Sanitize custom filename if provided
        if ($filename) {
            $filename = $this->validator->sanitizeFilename($filename);
        }

        // Store file
        $result = $this->storage->store($file['tmp_name'], $folder, $filename, $disk);

        if (!$result['success']) {
            return $result;
        }

        // Add original filename from upload
        $result['original_name'] = $file['name'];

        // Return result - developer decides whether to create DB entry
        return $result;
    }

    /**
     * Upload and create Media model (convenience method)
     *
     * This is a convenience method that both uploads the file AND creates
     * a database entry automatically. Use upload() if you need manual control.
     *
     * @param array $file $_FILES array element
     * @param array $options Upload options (same as upload() method)
     * @return \App\Models\Media|null Media model if successful, null if failed
     */
    public function uploadAndCreate(array $file, array $options = []): ?\App\Models\Media
    {
        // Upload file (validation + storage)
        $result = $this->upload($file, $options);

        if (!$result['success']) {
            // Upload failed - log errors if needed
            if (function_exists('logger') && isset($result['errors'])) {
                logger()->warning('File upload failed', [
                    'errors' => $result['errors'],
                    'file' => $file['name'] ?? 'unknown',
                ]);
            }
            return null;
        }

        // Create media database record
        try {
            $media = \App\Models\Media::create([
                'filename' => $result['filename'],
                'original_name' => $result['original_name'],
                'path' => $result['path'],
                'disk' => $result['disk'],
                'mime_type' => $result['mime_type'],
                'size' => $result['size'],
                'width' => $result['width'],
                'height' => $result['height'],
            ]);

            // Queue variant generation for images (if enabled)
            if ($this->isImage($result['mime_type']) && ($options['variants'] ?? true)) {
                $this->queueVariantGeneration($media->id);
            }

            // Queue watermark if requested
            if (isset($options['watermark'])) {
                $this->queueWatermark($media->id, $options['watermark']);
            }

            return $media;

        } catch (\Exception $e) {
            // DB creation failed - clean up uploaded file
            $this->storage->delete($result['path'], $result['disk']);

            if (function_exists('logger')) {
                logger()->error('Failed to create media record', [
                    'error' => $e->getMessage(),
                    'file' => $result['path'],
                ]);
            }

            return null;
        }
    }

    /**
     * Upload multiple files
     *
     * @param array $files Array of $_FILES elements
     * @param array $options Upload options
     * @return array Array of upload results
     */
    public function uploadMultiple(array $files, array $options = []): array
    {
        $results = [];

        foreach ($files as $file) {
            $results[] = $this->upload($file, $options);
        }

        return $results;
    }

    /**
     * Upload multiple files and create Media models
     *
     * @param array $files Array of $_FILES elements
     * @param array $options Upload options
     * @return array Array of Media models (nulls for failed uploads)
     */
    public function uploadMultipleAndCreate(array $files, array $options = []): array
    {
        $mediaModels = [];

        foreach ($files as $file) {
            $mediaModels[] = $this->uploadAndCreate($file, $options);
        }

        return $mediaModels;
    }

    /**
     * Check if MIME type is an image
     *
     * @param string $mimeType MIME type to check
     * @return bool True if image
     */
    protected function isImage(string $mimeType): bool
    {
        return str_starts_with($mimeType, 'image/');
    }

    /**
     * Queue variant generation job
     *
     * @param int $mediaId Media record ID
     * @return void
     */
    protected function queueVariantGeneration(int $mediaId): void
    {
        // Only queue if queue is enabled
        if (!config('media.queue.enabled', true)) {
            return;
        }

        try {
            // Check if queue manager is available
            if (function_exists('app') && app()->has('queue')) {
                $queue = app('queue');
                $queue->push(new \App\Jobs\Image\GenerateImageVariants($mediaId));
            }
        } catch (\Exception $e) {
            // Queue failed - log but don't fail upload
            if (function_exists('logger')) {
                logger()->warning('Failed to queue variant generation', [
                    'media_id' => $mediaId,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Queue watermark job
     *
     * @param int $mediaId Media record ID
     * @param string $preset Watermark preset name
     * @return void
     */
    protected function queueWatermark(int $mediaId, string $preset): void
    {
        // Only queue if queue is enabled
        if (!config('media.queue.enabled', true)) {
            return;
        }

        try {
            // Check if queue manager is available
            if (function_exists('app') && app()->has('queue')) {
                $queue = app('queue');
                $queue->push(new \App\Jobs\Image\ApplyWatermark($mediaId, $preset));
            }
        } catch (\Exception $e) {
            // Queue failed - log but don't fail upload
            if (function_exists('logger')) {
                logger()->warning('Failed to queue watermark', [
                    'media_id' => $mediaId,
                    'preset' => $preset,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Delete uploaded file and its database record
     *
     * @param int $mediaId Media record ID
     * @return bool True if deleted successfully
     */
    public function deleteMedia(int $mediaId): bool
    {
        try {
            $media = \App\Models\Media::find($mediaId);

            if (!$media) {
                return false;
            }

            // Delete file from storage
            $this->storage->delete($media->path, $media->disk);

            // Delete variants if any
            $variants = \App\Models\Media::where('parent_id', $mediaId)->get();
            foreach ($variants as $variant) {
                $this->storage->delete($variant->path, $variant->disk);
                $variant->delete();
            }

            // Delete database record
            $media->delete();

            return true;

        } catch (\Exception $e) {
            if (function_exists('logger')) {
                logger()->error('Failed to delete media', [
                    'media_id' => $mediaId,
                    'error' => $e->getMessage(),
                ]);
            }

            return false;
        }
    }

    /**
     * Get storage manager instance
     *
     * @return StorageManager
     */
    public function getStorageManager(): StorageManager
    {
        return $this->storage;
    }

    /**
     * Get file validator instance
     *
     * @return FileValidator
     */
    public function getValidator(): FileValidator
    {
        return $this->validator;
    }
}
