<?php

namespace Core\Media;

/**
 * FileValidator
 *
 * Validates uploaded files for security and compliance with configured rules.
 *
 * Security checks:
 * - File upload errors
 * - File size limits
 * - MIME type validation
 * - Extension validation
 * - Image verification (for image files)
 * - File content validation
 */
class FileValidator
{
    /**
     * Allowed MIME types
     */
    protected array $allowedTypes;

    /**
     * Allowed file extensions
     */
    protected array $allowedExtensions;

    /**
     * Maximum file size in bytes
     */
    protected int $maxSize;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->allowedTypes = config('media.allowed_types', []);
        $this->allowedExtensions = config('media.allowed_extensions', []);

        // Convert KB to bytes
        $maxSizeKb = config('media.max_file_size', 10240);
        $this->maxSize = $maxSizeKb * 1024;
    }

    /**
     * Validate uploaded file
     *
     * @param array $file $_FILES array element
     * @return array Array of error messages (empty if valid)
     */
    public function validate(array $file): array
    {
        $errors = [];

        // Check required fields
        if (!isset($file['error'], $file['size'], $file['type'], $file['name'], $file['tmp_name'])) {
            $errors[] = 'Invalid file upload data';
            return $errors;
        }

        // Check upload error
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = $this->getUploadErrorMessage($file['error']);
        }

        // Check if file was actually uploaded
        if (!is_uploaded_file($file['tmp_name']) && !file_exists($file['tmp_name'])) {
            $errors[] = 'File upload failed - not a valid upload';
        }

        // Check file size
        if ($file['size'] > $this->maxSize) {
            $maxMB = round($this->maxSize / 1024 / 1024, 2);
            $fileMB = round($file['size'] / 1024 / 1024, 2);
            $errors[] = "File too large: {$fileMB}MB. Maximum allowed: {$maxMB}MB";
        }

        // Check for empty file
        if ($file['size'] === 0) {
            $errors[] = 'File is empty';
        }

        // Check MIME type
        if (!empty($this->allowedTypes) && !in_array($file['type'], $this->allowedTypes)) {
            $errors[] = "File type not allowed: {$file['type']}";
        }

        // Check extension
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!empty($this->allowedExtensions) && !in_array($extension, $this->allowedExtensions)) {
            $errors[] = "File extension not allowed: {$extension}";
        }

        // Additional validation for image files
        if (str_starts_with($file['type'], 'image/')) {
            $imageErrors = $this->validateImage($file['tmp_name']);
            $errors = array_merge($errors, $imageErrors);
        }

        // Validate file content matches extension
        if (file_exists($file['tmp_name'])) {
            $actualMimeType = mime_content_type($file['tmp_name']);

            // Check if actual MIME type differs significantly from reported type
            if ($actualMimeType && !$this->mimeTypeMatches($actualMimeType, $file['type'])) {
                $errors[] = "File content ({$actualMimeType}) doesn't match reported type ({$file['type']})";
            }
        }

        return $errors;
    }

    /**
     * Validate image file
     *
     * @param string $filePath Path to uploaded file
     * @return array Array of error messages
     */
    protected function validateImage(string $filePath): array
    {
        $errors = [];

        // Verify it's actually an image
        $imageInfo = @getimagesize($filePath);

        if ($imageInfo === false) {
            $errors[] = 'Not a valid image file';
            return $errors;
        }

        // Check image dimensions (optional limits)
        $maxWidth = config('media.max_image_width', null);
        $maxHeight = config('media.max_image_height', null);

        if ($maxWidth && $imageInfo[0] > $maxWidth) {
            $errors[] = "Image width ({$imageInfo[0]}px) exceeds maximum ({$maxWidth}px)";
        }

        if ($maxHeight && $imageInfo[1] > $maxHeight) {
            $errors[] = "Image height ({$imageInfo[1]}px) exceeds maximum ({$maxHeight}px)";
        }

        // Verify image type is allowed
        $allowedImageTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP];
        if (!in_array($imageInfo[2], $allowedImageTypes)) {
            $errors[] = 'Image format not supported';
        }

        return $errors;
    }

    /**
     * Check if two MIME types match (allowing for minor differences)
     *
     * @param string $actual Actual MIME type from file content
     * @param string $reported Reported MIME type from upload
     * @return bool True if types match
     */
    protected function mimeTypeMatches(string $actual, string $reported): bool
    {
        // Exact match
        if ($actual === $reported) {
            return true;
        }

        // Common variations
        $variations = [
            'image/jpg' => 'image/jpeg',
            'image/jpeg' => 'image/jpg',
            'application/x-zip-compressed' => 'application/zip',
            'application/x-rar-compressed' => 'application/x-rar',
        ];

        // Check if variation is acceptable
        if (isset($variations[$actual]) && $variations[$actual] === $reported) {
            return true;
        }

        if (isset($variations[$reported]) && $variations[$reported] === $actual) {
            return true;
        }

        // For generic types, check if they're in the same category
        $actualCategory = explode('/', $actual)[0];
        $reportedCategory = explode('/', $reported)[0];

        // If both are images, allow some flexibility
        if ($actualCategory === 'image' && $reportedCategory === 'image') {
            return true;
        }

        return false;
    }

    /**
     * Get human-readable upload error message
     *
     * @param int $error PHP upload error code
     * @return string Error message
     */
    protected function getUploadErrorMessage(int $error): string
    {
        return match($error) {
            UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize directive in php.ini',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE directive in HTML form',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary upload folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'Upload blocked by PHP extension',
            default => "Unknown upload error: {$error}",
        };
    }

    /**
     * Validate filename for security
     *
     * @param string $filename Filename to validate
     * @return bool True if filename is safe
     */
    public function isValidFilename(string $filename): bool
    {
        // Check for directory traversal attempts
        if (str_contains($filename, '..') || str_contains($filename, '/') || str_contains($filename, '\\')) {
            return false;
        }

        // Check for null bytes
        if (str_contains($filename, "\0")) {
            return false;
        }

        // Check for control characters
        if (preg_match('/[\x00-\x1F\x7F]/', $filename)) {
            return false;
        }

        return true;
    }

    /**
     * Sanitize filename
     *
     * @param string $filename Original filename
     * @return string Sanitized filename
     */
    public function sanitizeFilename(string $filename): string
    {
        // Get extension
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $basename = pathinfo($filename, PATHINFO_FILENAME);

        // Remove special characters
        $basename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $basename);

        // Remove consecutive underscores
        $basename = preg_replace('/_+/', '_', $basename);

        // Trim underscores from ends
        $basename = trim($basename, '_');

        // If basename is empty, generate one
        if (empty($basename)) {
            $basename = 'file_' . uniqid();
        }

        return $basename . '.' . strtolower($extension);
    }

    /**
     * Check if file type is allowed
     *
     * @param string $mimeType MIME type to check
     * @return bool True if allowed
     */
    public function isAllowedType(string $mimeType): bool
    {
        return empty($this->allowedTypes) || in_array($mimeType, $this->allowedTypes);
    }

    /**
     * Check if extension is allowed
     *
     * @param string $extension Extension to check
     * @return bool True if allowed
     */
    public function isAllowedExtension(string $extension): bool
    {
        $extension = strtolower($extension);
        return empty($this->allowedExtensions) || in_array($extension, $this->allowedExtensions);
    }
}
