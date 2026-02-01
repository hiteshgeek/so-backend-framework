<?php

namespace Core\Media;

/**
 * StorageManager
 *
 * Handles file storage operations with flexible folder structure.
 * Supports storing files in shared rpkfiles directory with optional folders.
 *
 * Features:
 * - Store files with optional folder organization
 * - Generate unique filenames or use custom names
 * - Get file URLs and paths
 * - Delete files
 * - Extract file metadata (size, MIME type, dimensions for images)
 */
class StorageManager
{
    /**
     * Default storage disk name
     */
    protected string $defaultDisk;

    /**
     * Configured storage disks
     */
    protected array $disks;

    /**
     * Root path for media files
     */
    protected string $mediaPath;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->defaultDisk = config('media.default_disk', 'media');
        $this->disks = config('media.disks', []);
        $this->mediaPath = config('media.path', '/var/www/html/rpkfiles');
    }

    /**
     * Store file with optional folder structure
     *
     * @param string $sourcePath Source file path (usually temp upload path)
     * @param string|null $folder Optional folder (e.g., 'products/featured')
     * @param string|null $filename Optional custom filename
     * @param string|null $disk Storage disk to use
     * @return array Upload result with success status and file info
     */
    public function store(string $sourcePath, ?string $folder = null, ?string $filename = null, ?string $disk = null): array
    {
        try {
            // Validate source file exists
            if (!file_exists($sourcePath)) {
                return [
                    'success' => false,
                    'error' => 'Source file does not exist',
                ];
            }

            // Generate filename if not provided
            if (!$filename) {
                $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
                $filename = $this->generateUniqueFilename($extension);
            }

            // Build destination path
            $relativePath = $folder ? trim($folder, '/') . '/' . $filename : $filename;
            $fullPath = $this->getPath($relativePath, $disk);

            // Create directory if needed
            $directory = dirname($fullPath);
            if (!is_dir($directory)) {
                if (!mkdir($directory, 0755, true)) {
                    return [
                        'success' => false,
                        'error' => 'Failed to create directory',
                    ];
                }
            }

            // Copy file to destination
            if (!copy($sourcePath, $fullPath)) {
                return [
                    'success' => false,
                    'error' => 'Failed to copy file',
                ];
            }

            // Set proper permissions
            chmod($fullPath, 0644);

            // Get file information
            $fileInfo = $this->getFileInfo($fullPath);

            return [
                'success' => true,
                'filename' => $filename,
                'original_name' => basename($sourcePath),
                'path' => $relativePath,
                'full_path' => $fullPath,
                'url' => $this->getUrl($relativePath, $disk),
                'size' => $fileInfo['size'],
                'mime_type' => $fileInfo['mime_type'],
                'width' => $fileInfo['width'],
                'height' => $fileInfo['height'],
                'disk' => $disk ?? $this->defaultDisk,
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Generate unique filename
     *
     * @param string $extension File extension
     * @return string Unique filename
     */
    protected function generateUniqueFilename(string $extension): string
    {
        $extension = strtolower($extension);
        return uniqid('file_', true) . '.' . $extension;
    }

    /**
     * Get file information
     *
     * @param string $path Full file path
     * @return array File info (size, mime_type, width, height)
     */
    protected function getFileInfo(string $path): array
    {
        $info = [
            'size' => filesize($path),
            'mime_type' => mime_content_type($path) ?: 'application/octet-stream',
            'width' => null,
            'height' => null,
        ];

        // Get dimensions for images
        if (str_starts_with($info['mime_type'], 'image/')) {
            $dimensions = @getimagesize($path);
            if ($dimensions) {
                $info['width'] = $dimensions[0];
                $info['height'] = $dimensions[1];
            }
        }

        return $info;
    }

    /**
     * Get public URL for file
     *
     * @param string $path Relative path from media root
     * @param string|null $disk Storage disk
     * @return string Public URL
     */
    public function getUrl(string $path, ?string $disk = null): string
    {
        $disk = $disk ?? $this->defaultDisk;
        $diskConfig = $this->disks[$disk] ?? [];
        $baseUrl = $diskConfig['url'] ?? '/media';

        // Get app URL
        $appUrl = config('app.url', 'http://localhost');

        return rtrim($appUrl, '/') . '/' . ltrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }

    /**
     * Get full filesystem path
     *
     * @param string $relativePath Relative path from media root
     * @param string|null $disk Storage disk
     * @return string Full filesystem path
     */
    public function getPath(string $relativePath, ?string $disk = null): string
    {
        $disk = $disk ?? $this->defaultDisk;
        $root = $this->disks[$disk]['root'] ?? $this->mediaPath;

        return rtrim($root, '/') . '/' . ltrim($relativePath, '/');
    }

    /**
     * Delete file
     *
     * @param string $relativePath Relative path from media root
     * @param string|null $disk Storage disk
     * @return bool True if deleted successfully
     */
    public function delete(string $relativePath, ?string $disk = null): bool
    {
        $fullPath = $this->getPath($relativePath, $disk);

        if (file_exists($fullPath)) {
            return @unlink($fullPath);
        }

        return false;
    }

    /**
     * Check if file exists
     *
     * @param string $relativePath Relative path from media root
     * @param string|null $disk Storage disk
     * @return bool True if file exists
     */
    public function exists(string $relativePath, ?string $disk = null): bool
    {
        return file_exists($this->getPath($relativePath, $disk));
    }

    /**
     * Move file from one location to another
     *
     * @param string $fromPath Source relative path
     * @param string $toPath Destination relative path
     * @param string|null $disk Storage disk
     * @return bool True if moved successfully
     */
    public function move(string $fromPath, string $toPath, ?string $disk = null): bool
    {
        $fromFullPath = $this->getPath($fromPath, $disk);
        $toFullPath = $this->getPath($toPath, $disk);

        // Create destination directory if needed
        $directory = dirname($toFullPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (file_exists($fromFullPath)) {
            return rename($fromFullPath, $toFullPath);
        }

        return false;
    }

    /**
     * Copy file to another location
     *
     * @param string $fromPath Source relative path
     * @param string $toPath Destination relative path
     * @param string|null $disk Storage disk
     * @return bool True if copied successfully
     */
    public function copy(string $fromPath, string $toPath, ?string $disk = null): bool
    {
        $fromFullPath = $this->getPath($fromPath, $disk);
        $toFullPath = $this->getPath($toPath, $disk);

        // Create destination directory if needed
        $directory = dirname($toFullPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (file_exists($fromFullPath)) {
            return copy($fromFullPath, $toFullPath);
        }

        return false;
    }

    /**
     * Get file size in bytes
     *
     * @param string $relativePath Relative path from media root
     * @param string|null $disk Storage disk
     * @return int|false File size in bytes or false if file doesn't exist
     */
    public function size(string $relativePath, ?string $disk = null): int|false
    {
        $fullPath = $this->getPath($relativePath, $disk);

        if (file_exists($fullPath)) {
            return filesize($fullPath);
        }

        return false;
    }

    /**
     * Get MIME type of file
     *
     * @param string $relativePath Relative path from media root
     * @param string|null $disk Storage disk
     * @return string|false MIME type or false if file doesn't exist
     */
    public function mimeType(string $relativePath, ?string $disk = null): string|false
    {
        $fullPath = $this->getPath($relativePath, $disk);

        if (file_exists($fullPath)) {
            return mime_content_type($fullPath) ?: 'application/octet-stream';
        }

        return false;
    }
}
