<?php

namespace Core\Http;

use Core\Media\FileUploadManager;
use App\Models\Media;

/**
 * Uploaded File
 *
 * Enhanced with media management integration.
 * Provides convenient methods for file uploads with validation and storage.
 */
class UploadedFile
{
    protected array $file;

    public function __construct(array $file)
    {
        $this->file = $file;
    }

    public function isValid(): bool
    {
        return isset($this->file['error']) && $this->file['error'] === UPLOAD_ERR_OK;
    }

    public function getClientOriginalName(): string
    {
        return $this->file['name'] ?? '';
    }

    public function getSize(): int
    {
        return $this->file['size'] ?? 0;
    }

    public function getMimeType(): string
    {
        return $this->file['type'] ?? '';
    }

    public function getExtension(): string
    {
        return pathinfo($this->getClientOriginalName(), PATHINFO_EXTENSION);
    }

    public function move(string $directory, ?string $name = null): bool
    {
        if (!$this->isValid()) {
            return false;
        }

        $name = $name ?? $this->getClientOriginalName();
        $destination = rtrim($directory, '/') . '/' . $name;

        return move_uploaded_file($this->file['tmp_name'], $destination);
    }

    /**
     * Store file using FileUploadManager - returns upload result without DB entry
     *
     * This method validates and stores the file, then returns the result.
     * The developer decides whether to create a database entry.
     *
     * @param string|null $folder Optional folder path (e.g., 'products/featured')
     * @param array $options Upload options:
     *                       - 'filename' (string): Custom filename
     *                       - 'disk' (string): Storage disk
     * @return array Upload result:
     *               - 'success' (bool): Whether upload succeeded
     *               - 'filename' (string): Generated filename
     *               - 'path' (string): Relative path from media root
     *               - 'url' (string): Public URL
     *               - 'size' (int): File size in bytes
     *               - 'mime_type' (string): MIME type
     *               - 'error' (string): Error message if failed
     *
     * @example
     * ```php
     * $result = $request->file('image')->store('products');
     * if ($result['success']) {
     *     echo $result['url'];
     * }
     * ```
     */
    public function store(?string $folder = null, array $options = []): array
    {
        $manager = new FileUploadManager();
        $options['folder'] = $folder;

        return $manager->upload($this->file, $options);
    }

    /**
     * Store file and create Media model (convenience method)
     *
     * This convenience method both uploads the file AND creates a database entry.
     * Use store() if you need manual control over DB entry creation.
     *
     * @param string|null $folder Optional folder path
     * @param array $options Upload options:
     *                       - 'filename' (string): Custom filename
     *                       - 'disk' (string): Storage disk
     *                       - 'variants' (bool): Generate image variants (default: true)
     *                       - 'watermark' (string): Watermark preset name
     * @return Media|null Media model if successful, null if failed
     *
     * @example
     * ```php
     * $media = $request->file('image')->storeAndCreate('products', [
     *     'variants' => true,
     *     'watermark' => 'copyright'
     * ]);
     * if ($media) {
     *     echo $media->url();
     * }
     * ```
     */
    public function storeAndCreate(?string $folder = null, array $options = []): ?Media
    {
        $manager = new FileUploadManager();
        $options['folder'] = $folder;

        return $manager->uploadAndCreate($this->file, $options);
    }

    /**
     * Get raw file data array
     *
     * @return array Raw $_FILES array element
     */
    public function getFileData(): array
    {
        return $this->file;
    }

    /**
     * Get temporary file path
     *
     * @return string Temporary upload path
     */
    public function getTemporaryPath(): string
    {
        return $this->file['tmp_name'] ?? '';
    }

    /**
     * Check if file is an image
     *
     * @return bool True if image
     */
    public function isImage(): bool
    {
        return str_starts_with($this->getMimeType(), 'image/');
    }

    /**
     * Get upload error code
     *
     * @return int PHP upload error code
     */
    public function getError(): int
    {
        return $this->file['error'] ?? UPLOAD_ERR_NO_FILE;
    }

    /**
     * Get upload error message
     *
     * @return string Human-readable error message
     */
    public function getErrorMessage(): string
    {
        $error = $this->getError();

        return match($error) {
            UPLOAD_ERR_OK => 'No error',
            UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE',
            UPLOAD_ERR_PARTIAL => 'File partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file',
            UPLOAD_ERR_EXTENSION => 'Upload blocked by extension',
            default => "Unknown error: {$error}",
        };
    }
}
