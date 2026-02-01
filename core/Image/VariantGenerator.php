<?php

namespace Core\Image;

use Core\Media\StorageManager;
use App\Models\Media;

/**
 * VariantGenerator
 *
 * Generates image variants (thumbnails, responsive sizes) from original images.
 *
 * Features:
 * - Generate multiple variants from config
 * - Support for different resize modes (fit, crop, stretch)
 * - Configurable quality per variant
 * - Automatic storage and database tracking
 * - Naming convention: original.jpg -> original_thumb.jpg
 *
 * Variants configured in config/media.php:
 * - thumb: 150x150 (crop)
 * - small: 320x240 (fit)
 * - medium: 640x480 (fit)
 * - large: 1024x768 (fit)
 *
 * Usage:
 * ```php
 * $generator = new VariantGenerator();
 *
 * // Generate all configured variants
 * $variants = $generator->generateAll($mediaId);
 *
 * // Generate specific variants
 * $variants = $generator->generate($mediaId, ['thumb', 'medium']);
 * ```
 */
class VariantGenerator
{
    /**
     * Storage manager
     */
    protected StorageManager $storage;

    /**
     * Image processor
     */
    protected ?ImageProcessor $processor = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->storage = new StorageManager();
    }

    /**
     * Generate all configured variants for a media file
     *
     * @param int $mediaId Media record ID
     * @return array Array of generated variant paths
     */
    public function generateAll(int $mediaId): array
    {
        $media = Media::find($mediaId);

        if (!$media || !$media->isImage()) {
            return [];
        }

        $variants = config('media.variants', []);
        $variantNames = array_keys($variants);

        return $this->generate($mediaId, $variantNames);
    }

    /**
     * Generate specific variants
     *
     * @param int $mediaId Media record ID
     * @param array $variantNames Variant names to generate
     * @return array Array of generated variant paths
     */
    public function generate(int $mediaId, array $variantNames): array
    {
        $media = Media::find($mediaId);

        if (!$media || !$media->isImage()) {
            return [];
        }

        $originalPath = $media->getFullPath();

        if (!file_exists($originalPath)) {
            return [];
        }

        $generatedVariants = [];
        $variants = config('media.variants', []);

        foreach ($variantNames as $variantName) {
            if (!isset($variants[$variantName])) {
                continue;
            }

            $variantConfig = $variants[$variantName];
            $variantPath = $this->generateVariant($originalPath, $variantName, $variantConfig, $media);

            if ($variantPath) {
                $generatedVariants[$variantName] = $variantPath;
            }
        }

        // Update parent metadata with variant list
        if (!empty($generatedVariants)) {
            $media->updateMetadata([
                'variants' => array_keys($generatedVariants),
                'variants_generated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        return $generatedVariants;
    }

    /**
     * Generate single variant
     *
     * @param string $originalPath Path to original image
     * @param string $variantName Variant name (thumb, small, medium, large)
     * @param array $config Variant configuration
     * @param Media $parentMedia Parent media record
     * @return string|null Path to generated variant or null if failed
     */
    protected function generateVariant(string $originalPath, string $variantName, array $config, Media $parentMedia): ?string
    {
        try {
            // Build variant path
            $pathInfo = pathinfo($parentMedia->path);
            $directory = $pathInfo['dirname'] !== '.' ? $pathInfo['dirname'] . '/' : '';
            $filename = $pathInfo['filename'];
            $extension = $pathInfo['extension'] ?? 'jpg';

            $variantFilename = $filename . '_' . $variantName . '.' . $extension;
            $variantRelativePath = $directory . $variantFilename;
            $variantFullPath = $this->storage->getPath($variantRelativePath, $parentMedia->disk);

            // Skip if variant already exists
            if (file_exists($variantFullPath)) {
                return $variantRelativePath;
            }

            // Create image processor
            $processor = ImageProcessor::create($originalPath);

            // Get variant dimensions
            $width = $config['width'] ?? 800;
            $height = $config['height'] ?? 600;
            $mode = $config['mode'] ?? 'fit';
            $quality = $config['quality'] ?? 85;

            // Resize image
            $processor->resize($width, $height, $mode);

            // Optimize if configured
            if ($config['optimize'] ?? true) {
                $processor->optimize();
            }

            // Save variant
            $processor->save($variantFullPath, $quality);

            // Get variant file info
            $variantInfo = @getimagesize($variantFullPath);

            // Create database record for variant
            Media::create([
                'filename' => $variantFilename,
                'original_name' => $parentMedia->original_name,
                'path' => $variantRelativePath,
                'disk' => $parentMedia->disk,
                'mime_type' => $parentMedia->mime_type,
                'size' => filesize($variantFullPath),
                'width' => $variantInfo ? $variantInfo[0] : null,
                'height' => $variantInfo ? $variantInfo[1] : null,
                'parent_id' => $parentMedia->id,
                'metadata' => [
                    'variant_name' => $variantName,
                    'variant_config' => $config,
                ],
            ]);

            return $variantRelativePath;

        } catch (\Exception $e) {
            if (function_exists('logger')) {
                logger()->error('Failed to generate variant', [
                    'variant' => $variantName,
                    'parent_id' => $parentMedia->id,
                    'error' => $e->getMessage(),
                ]);
            }

            return null;
        }
    }

    /**
     * Regenerate all variants for a media file
     *
     * This deletes existing variants and generates new ones.
     *
     * @param int $mediaId Media record ID
     * @return array Array of generated variant paths
     */
    public function regenerateAll(int $mediaId): array
    {
        $media = Media::find($mediaId);

        if (!$media) {
            return [];
        }

        // Delete existing variants
        $this->deleteVariants($mediaId);

        // Generate new variants
        return $this->generateAll($mediaId);
    }

    /**
     * Delete all variants for a media file
     *
     * @param int $mediaId Media record ID
     * @return bool True if deleted successfully
     */
    public function deleteVariants(int $mediaId): bool
    {
        $media = Media::find($mediaId);

        if (!$media) {
            return false;
        }

        // Get all variant records
        $variants = Media::where('parent_id', $mediaId)->get();

        foreach ($variants as $variant) {
            // Delete file from storage
            $this->storage->delete($variant->path, $variant->disk);

            // Delete database record
            $variant->delete();
        }

        return true;
    }

    /**
     * Check if variant exists
     *
     * @param int $mediaId Media record ID
     * @param string $variantName Variant name
     * @return bool True if variant exists
     */
    public function variantExists(int $mediaId, string $variantName): bool
    {
        $variant = Media::where('parent_id', $mediaId)
            ->where('metadata->variant_name', $variantName)
            ->first();

        if (!$variant) {
            return false;
        }

        return $this->storage->exists($variant->path, $variant->disk);
    }

    /**
     * Get all variants for a media file
     *
     * @param int $mediaId Media record ID
     * @return array Array of variant Media models indexed by variant name
     */
    public function getVariants(int $mediaId): array
    {
        $variants = Media::where('parent_id', $mediaId)->get();

        $result = [];
        foreach ($variants as $variant) {
            $variantName = $variant->getMetadata('variant_name');
            if ($variantName) {
                $result[$variantName] = $variant;
            }
        }

        return $result;
    }

    /**
     * Get variant by name
     *
     * @param int $mediaId Media record ID
     * @param string $variantName Variant name
     * @return Media|null Variant media model or null
     */
    public function getVariant(int $mediaId, string $variantName): ?Media
    {
        return Media::where('parent_id', $mediaId)
            ->where('metadata->variant_name', $variantName)
            ->first();
    }

    /**
     * Generate variant on demand (if not exists)
     *
     * @param int $mediaId Media record ID
     * @param string $variantName Variant name
     * @return string|null Path to variant or null if failed
     */
    public function generateOnDemand(int $mediaId, string $variantName): ?string
    {
        // Check if variant already exists
        if ($this->variantExists($mediaId, $variantName)) {
            $variant = $this->getVariant($mediaId, $variantName);
            return $variant ? $variant->path : null;
        }

        // Generate new variant
        $variants = $this->generate($mediaId, [$variantName]);
        return $variants[$variantName] ?? null;
    }

    /**
     * Get configured variant names
     *
     * @return array Array of variant names
     */
    public function getConfiguredVariants(): array
    {
        $variants = config('media.variants', []);
        return array_keys($variants);
    }

    /**
     * Get variant configuration
     *
     * @param string $variantName Variant name
     * @return array|null Variant config or null
     */
    public function getVariantConfig(string $variantName): ?array
    {
        $variants = config('media.variants', []);
        return $variants[$variantName] ?? null;
    }
}
