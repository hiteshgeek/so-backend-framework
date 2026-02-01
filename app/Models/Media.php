<?php

namespace App\Models;

use Core\Database\Model;
use Core\Media\StorageManager;

/**
 * Media Model
 *
 * Represents uploaded files in the database.
 * Tracks file metadata, storage location, and variants.
 *
 * Relationships:
 * - parent: Parent media for variants
 * - variants: Child media records (thumbnails, resized versions)
 * - attachments: Polymorphic relationships to other models
 *
 * Usage:
 * ```php
 * $media = Media::find(1);
 * echo $media->url();          // Get original URL
 * echo $media->url('thumb');   // Get thumbnail URL
 * $variants = $media->variants(); // Get all variants
 * $media->deleteFile();        // Delete file and variants
 * ```
 */
class Media extends Model
{
    /**
     * Table name
     */
    protected string $table = 'media';

    /**
     * Fillable attributes
     */
    protected array $fillable = [
        'filename',
        'original_name',
        'path',
        'disk',
        'mime_type',
        'size',
        'width',
        'height',
        'parent_id',
        'metadata',
    ];

    /**
     * Attributes that should be cast
     */
    protected array $casts = [
        'metadata' => 'array',
        'size' => 'int',
        'width' => 'int',
        'height' => 'int',
        'parent_id' => 'int',
    ];

    /**
     * Storage manager instance (lazy loaded)
     */
    protected ?StorageManager $storageManager = null;

    /**
     * Get public URL for file
     *
     * @param string|null $variant Variant name (e.g., 'thumb', 'small', 'medium', 'large')
     * @return string Public URL
     */
    public function url(?string $variant = null): string
    {
        $storage = $this->getStorageManager();

        if ($variant) {
            $variantPath = $this->getVariantPath($variant);
            return $storage->getUrl($variantPath, $this->disk);
        }

        return $storage->getUrl($this->path, $this->disk);
    }

    /**
     * Get variant path based on variant name
     *
     * Naming convention: original.jpg -> original_thumb.jpg
     *
     * @param string $variant Variant name
     * @return string Variant path
     */
    protected function getVariantPath(string $variant): string
    {
        $pathInfo = pathinfo($this->path);
        $directory = $pathInfo['dirname'] !== '.' ? $pathInfo['dirname'] . '/' : '';
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'] ?? '';

        return $directory . $filename . '_' . $variant . '.' . $extension;
    }

    /**
     * Get all variants for this media
     *
     * @return array Array of Media models
     */
    public function variants(): array
    {
        return static::where('parent_id', $this->id)->get();
    }

    /**
     * Get parent media (if this is a variant)
     *
     * @return Media|null Parent media or null
     */
    public function parent(): ?Media
    {
        if (!$this->parent_id) {
            return null;
        }

        return static::find($this->parent_id);
    }

    /**
     * Check if this is a variant
     *
     * @return bool True if variant
     */
    public function isVariant(): bool
    {
        return $this->parent_id !== null;
    }

    /**
     * Check if file is an image
     *
     * @return bool True if image
     */
    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    /**
     * Get file size in human-readable format
     *
     * @return string Formatted file size
     */
    public function getHumanSize(): string
    {
        $bytes = $this->size;

        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        }

        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        }

        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' bytes';
    }

    /**
     * Get file extension
     *
     * @return string File extension
     */
    public function getExtension(): string
    {
        return pathinfo($this->filename, PATHINFO_EXTENSION);
    }

    /**
     * Get full filesystem path
     *
     * @return string Full path
     */
    public function getFullPath(): string
    {
        $storage = $this->getStorageManager();
        return $storage->getPath($this->path, $this->disk);
    }

    /**
     * Check if file exists on disk
     *
     * @return bool True if exists
     */
    public function fileExists(): bool
    {
        $storage = $this->getStorageManager();
        return $storage->exists($this->path, $this->disk);
    }

    /**
     * Delete file from storage and database
     *
     * This deletes:
     * - The original file
     * - All variant files
     * - All variant database records
     * - The original database record
     *
     * @return bool True if deleted successfully
     */
    public function deleteFile(): bool
    {
        $storage = $this->getStorageManager();

        try {
            // Delete all variants first
            $variants = $this->variants();
            foreach ($variants as $variant) {
                $storage->delete($variant->path, $variant->disk);
                $variant->delete();
            }

            // Delete original file
            $storage->delete($this->path, $this->disk);

            // Delete database record
            $this->delete();

            return true;

        } catch (\Exception $e) {
            if (function_exists('logger')) {
                logger()->error('Failed to delete media file', [
                    'media_id' => $this->id,
                    'path' => $this->path,
                    'error' => $e->getMessage(),
                ]);
            }

            return false;
        }
    }

    /**
     * Get image dimensions
     *
     * @return array|null Array with 'width' and 'height' or null if not an image
     */
    public function getDimensions(): ?array
    {
        if (!$this->isImage() || !$this->width || !$this->height) {
            return null;
        }

        return [
            'width' => $this->width,
            'height' => $this->height,
        ];
    }

    /**
     * Get aspect ratio
     *
     * @return float|null Aspect ratio (width/height) or null if not an image
     */
    public function getAspectRatio(): ?float
    {
        $dimensions = $this->getDimensions();

        if (!$dimensions || $dimensions['height'] === 0) {
            return null;
        }

        return round($dimensions['width'] / $dimensions['height'], 2);
    }

    /**
     * Check if variant exists
     *
     * @param string $variant Variant name
     * @return bool True if variant exists
     */
    public function hasVariant(string $variant): bool
    {
        $variantPath = $this->getVariantPath($variant);
        $storage = $this->getStorageManager();

        return $storage->exists($variantPath, $this->disk);
    }

    /**
     * Get all available variant URLs
     *
     * @return array Associative array of variant name => URL
     */
    public function getAllVariantUrls(): array
    {
        $urls = [];
        $variants = config('media.variants', []);

        foreach (array_keys($variants) as $variantName) {
            if ($this->hasVariant($variantName)) {
                $urls[$variantName] = $this->url($variantName);
            }
        }

        return $urls;
    }

    /**
     * Update metadata
     *
     * @param array $data Metadata to merge
     * @return bool True if updated
     */
    public function updateMetadata(array $data): bool
    {
        $metadata = $this->metadata ?? [];
        $metadata = array_merge($metadata, $data);

        return $this->update(['metadata' => $metadata]);
    }

    /**
     * Get metadata value
     *
     * @param string $key Metadata key
     * @param mixed $default Default value
     * @return mixed Metadata value
     */
    public function getMetadata(string $key, mixed $default = null): mixed
    {
        $metadata = $this->metadata ?? [];
        return $metadata[$key] ?? $default;
    }

    /**
     * Get storage manager instance
     *
     * @return StorageManager
     */
    protected function getStorageManager(): StorageManager
    {
        if (!$this->storageManager) {
            $this->storageManager = new StorageManager();
        }

        return $this->storageManager;
    }

    /**
     * Convert to array for JSON responses
     *
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        // Add computed properties
        $data['url'] = $this->url();
        $data['human_size'] = $this->getHumanSize();
        $data['extension'] = $this->getExtension();
        $data['is_image'] = $this->isImage();

        // Add dimensions if image
        if ($this->isImage()) {
            $data['dimensions'] = $this->getDimensions();
            $data['aspect_ratio'] = $this->getAspectRatio();
        }

        // Add variant URLs if available
        $data['variant_urls'] = $this->getAllVariantUrls();

        return $data;
    }
}
