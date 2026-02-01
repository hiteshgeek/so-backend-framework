<?php

namespace Core\Media;

use App\Constants\DatabaseTables;

/**
 * ChunkedUploadManager
 *
 * Handles chunked/resumable file uploads for large files.
 *
 * Features:
 * - Initialize chunked upload sessions
 * - Upload individual chunks
 * - Resume interrupted uploads
 * - Merge chunks on completion
 * - Cleanup expired/orphaned chunks
 *
 * Usage:
 * ```php
 * $manager = new ChunkedUploadManager();
 *
 * // Initialize upload session
 * $session = $manager->initiate('large-video.mp4', 500000000, 2097152);
 *
 * // Upload chunks
 * $manager->uploadChunk($session['upload_id'], 0, $chunkData);
 * $manager->uploadChunk($session['upload_id'], 1, $chunkData);
 * // ... more chunks
 *
 * // Complete upload
 * $result = $manager->complete($session['upload_id']);
 * ```
 */
class ChunkedUploadManager
{
    /**
     * Temporary directory for chunks
     */
    protected string $tempDirectory;

    /**
     * Maximum file size for chunked uploads
     */
    protected int $maxFileSize;

    /**
     * Chunk size in bytes
     */
    protected int $chunkSize;

    /**
     * Hours before incomplete uploads expire
     */
    protected int $expiryHours;

    /**
     * Storage manager instance
     */
    protected StorageManager $storage;

    /**
     * Database connection
     */
    protected $db;

    /**
     * Constructor
     *
     * @throws \RuntimeException If database connection is not available
     */
    public function __construct()
    {
        $config = config('media.chunked', []);

        $this->tempDirectory = $config['temp_directory'] ?? storage_path('chunks');
        $this->maxFileSize = $config['max_file_size'] ?? 500 * 1024 * 1024;
        $this->chunkSize = $config['chunk_size'] ?? 2 * 1024 * 1024;
        $this->expiryHours = $config['expiry_hours'] ?? 24;
        $this->storage = new StorageManager();
        $this->db = app('db-essentials');

        // Require database connection for chunked uploads
        if ($this->db === null) {
            throw new \RuntimeException('ChunkedUploadManager requires database connection');
        }

        // Ensure temp directory exists
        if (!is_dir($this->tempDirectory)) {
            mkdir($this->tempDirectory, 0755, true);
        }
    }

    /**
     * Initialize a new chunked upload session
     *
     * @param string $filename Original filename
     * @param int $totalSize Total file size in bytes
     * @param int|null $chunkSize Chunk size (uses config default if null)
     * @param array $metadata Optional metadata
     * @return array Session info with upload_id
     * @throws \InvalidArgumentException If file size exceeds limit
     */
    public function initiate(string $filename, int $totalSize, ?int $chunkSize = null, array $metadata = []): array
    {
        // Validate file size
        if ($totalSize > $this->maxFileSize) {
            throw new \InvalidArgumentException(
                "File size ({$totalSize} bytes) exceeds maximum allowed ({$this->maxFileSize} bytes)"
            );
        }

        $chunkSize = $chunkSize ?? $this->chunkSize;
        $totalChunks = (int) ceil($totalSize / $chunkSize);
        $uploadId = $this->generateUploadId();
        $expiresAt = date('Y-m-d H:i:s', strtotime("+{$this->expiryHours} hours"));

        // Detect MIME type from extension
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $mimeType = $this->getMimeTypeFromExtension($extension);

        // Create upload session record
        $this->db->table(DatabaseTables::UPLOAD_CHUNKS)->insert([
            'upload_id' => $uploadId,
            'filename' => $filename,
            'total_chunks' => $totalChunks,
            'uploaded_chunks' => 0,
            'total_size' => $totalSize,
            'chunk_size' => $chunkSize,
            'mime_type' => $mimeType,
            'metadata' => json_encode($metadata),
            'expires_at' => $expiresAt,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Create upload directory
        $uploadDir = $this->getUploadDirectory($uploadId);
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        return [
            'success' => true,
            'upload_id' => $uploadId,
            'filename' => $filename,
            'total_chunks' => $totalChunks,
            'chunk_size' => $chunkSize,
            'total_size' => $totalSize,
            'expires_at' => $expiresAt,
        ];
    }

    /**
     * Upload a single chunk
     *
     * @param string $uploadId Upload session ID
     * @param int $chunkNumber Chunk number (0-indexed)
     * @param mixed $chunkData Chunk data (string, stream, or file path)
     * @return array Chunk upload result
     * @throws \InvalidArgumentException If session not found or chunk invalid
     */
    public function uploadChunk(string $uploadId, int $chunkNumber, $chunkData): array
    {
        // Get upload session
        $session = $this->getSession($uploadId);

        if (!$session) {
            throw new \InvalidArgumentException("Upload session not found: {$uploadId}");
        }

        // Check expiry
        if (strtotime($session->expires_at) < time()) {
            $this->cancel($uploadId);
            throw new \InvalidArgumentException("Upload session has expired");
        }

        // Validate chunk number
        if ($chunkNumber < 0 || $chunkNumber >= $session->total_chunks) {
            throw new \InvalidArgumentException(
                "Invalid chunk number: {$chunkNumber} (expected 0-" . ($session->total_chunks - 1) . ")"
            );
        }

        // Write chunk to disk
        $chunkPath = $this->getChunkPath($uploadId, $chunkNumber);

        if (is_resource($chunkData)) {
            // Stream resource
            $content = stream_get_contents($chunkData);
            file_put_contents($chunkPath, $content);
        } elseif (is_file($chunkData)) {
            // File path
            copy($chunkData, $chunkPath);
        } else {
            // String data
            file_put_contents($chunkPath, $chunkData);
        }

        // Update uploaded chunks count
        $uploadedChunks = $this->countUploadedChunks($uploadId);
        $this->db->table(DatabaseTables::UPLOAD_CHUNKS)
            ->where('upload_id', $uploadId)
            ->update([
                'uploaded_chunks' => $uploadedChunks,
            ]);

        $isComplete = $uploadedChunks >= $session->total_chunks;

        return [
            'success' => true,
            'chunk_number' => $chunkNumber,
            'uploaded_chunks' => $uploadedChunks,
            'total_chunks' => $session->total_chunks,
            'is_complete' => $isComplete,
            'progress' => round(($uploadedChunks / $session->total_chunks) * 100, 2),
        ];
    }

    /**
     * Complete upload and merge chunks
     *
     * @param string $uploadId Upload session ID
     * @param string|null $folder Destination folder
     * @param string|null $disk Storage disk
     * @return array Final file info
     * @throws \InvalidArgumentException If session not found or incomplete
     */
    public function complete(string $uploadId, ?string $folder = null, ?string $disk = null): array
    {
        $session = $this->getSession($uploadId);

        if (!$session) {
            throw new \InvalidArgumentException("Upload session not found: {$uploadId}");
        }

        // Verify all chunks are uploaded
        $uploadedChunks = $this->countUploadedChunks($uploadId);
        if ($uploadedChunks < $session->total_chunks) {
            throw new \InvalidArgumentException(
                "Upload incomplete: {$uploadedChunks}/{$session->total_chunks} chunks uploaded"
            );
        }

        // Merge chunks into final file
        $tempFile = $this->mergeChunks($uploadId, $session->total_chunks);

        // Store final file
        $result = $this->storage->store($tempFile, $folder, $session->filename, $disk);

        // Cleanup
        $this->cleanupSession($uploadId);

        if ($result['success']) {
            $result['original_name'] = $session->filename;
            $result['metadata'] = json_decode($session->metadata, true) ?: [];
        }

        return $result;
    }

    /**
     * Get upload session status
     *
     * @param string $uploadId Upload session ID
     * @return array|null Session status or null if not found
     */
    public function getStatus(string $uploadId): ?array
    {
        $session = $this->getSession($uploadId);

        if (!$session) {
            return null;
        }

        $uploadedChunks = $this->countUploadedChunks($uploadId);
        $missingChunks = $this->getMissingChunks($uploadId, $session->total_chunks);

        return [
            'success' => true,
            'upload_id' => $uploadId,
            'filename' => $session->filename,
            'total_size' => (int) $session->total_size,
            'chunk_size' => (int) $session->chunk_size,
            'total_chunks' => (int) $session->total_chunks,
            'uploaded_chunks' => $uploadedChunks,
            'missing_chunks' => $missingChunks,
            'progress' => round(($uploadedChunks / $session->total_chunks) * 100, 2),
            'is_complete' => $uploadedChunks >= $session->total_chunks,
            'is_expired' => strtotime($session->expires_at) < time(),
            'expires_at' => $session->expires_at,
            'created_at' => $session->created_at,
            'metadata' => json_decode($session->metadata, true) ?: [],
        ];
    }

    /**
     * Cancel and cleanup an upload session
     *
     * @param string $uploadId Upload session ID
     * @return bool True if cancelled successfully
     */
    public function cancel(string $uploadId): bool
    {
        $session = $this->getSession($uploadId);

        if (!$session) {
            return false;
        }

        return $this->cleanupSession($uploadId);
    }

    /**
     * Cleanup expired upload sessions
     *
     * @return int Number of sessions cleaned up
     */
    public function cleanupExpired(): int
    {
        $expired = $this->db->table(DatabaseTables::UPLOAD_CHUNKS)
            ->where('expires_at', '<', date('Y-m-d H:i:s'))
            ->get();

        $count = 0;
        foreach ($expired as $session) {
            if ($this->cleanupSession($session->upload_id)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Get session record from database
     *
     * @param string $uploadId Upload session ID
     * @return object|null Session record
     */
    protected function getSession(string $uploadId): ?object
    {
        return $this->db->table(DatabaseTables::UPLOAD_CHUNKS)
            ->where('upload_id', $uploadId)
            ->first();
    }

    /**
     * Generate unique upload ID
     *
     * @return string Unique upload ID
     */
    protected function generateUploadId(): string
    {
        return bin2hex(random_bytes(32));
    }

    /**
     * Get upload directory for a session
     *
     * @param string $uploadId Upload session ID
     * @return string Directory path
     */
    protected function getUploadDirectory(string $uploadId): string
    {
        return $this->tempDirectory . '/' . $uploadId;
    }

    /**
     * Get chunk file path
     *
     * @param string $uploadId Upload session ID
     * @param int $chunkNumber Chunk number
     * @return string Chunk file path
     */
    protected function getChunkPath(string $uploadId, int $chunkNumber): string
    {
        return $this->getUploadDirectory($uploadId) . '/chunk_' . str_pad($chunkNumber, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Count uploaded chunks for a session
     *
     * @param string $uploadId Upload session ID
     * @return int Number of uploaded chunks
     */
    protected function countUploadedChunks(string $uploadId): int
    {
        $uploadDir = $this->getUploadDirectory($uploadId);

        if (!is_dir($uploadDir)) {
            return 0;
        }

        $files = glob($uploadDir . '/chunk_*');
        return count($files);
    }

    /**
     * Get list of missing chunk numbers
     *
     * @param string $uploadId Upload session ID
     * @param int $totalChunks Total expected chunks
     * @return array Missing chunk numbers
     */
    protected function getMissingChunks(string $uploadId, int $totalChunks): array
    {
        $missing = [];

        for ($i = 0; $i < $totalChunks; $i++) {
            $chunkPath = $this->getChunkPath($uploadId, $i);
            if (!file_exists($chunkPath)) {
                $missing[] = $i;
            }
        }

        return $missing;
    }

    /**
     * Merge chunks into final file
     *
     * @param string $uploadId Upload session ID
     * @param int $totalChunks Total chunks to merge
     * @return string Path to merged file
     */
    protected function mergeChunks(string $uploadId, int $totalChunks): string
    {
        $uploadDir = $this->getUploadDirectory($uploadId);
        $tempFile = $uploadDir . '/merged_' . time();

        $output = fopen($tempFile, 'wb');

        for ($i = 0; $i < $totalChunks; $i++) {
            $chunkPath = $this->getChunkPath($uploadId, $i);

            if (file_exists($chunkPath)) {
                $chunk = fopen($chunkPath, 'rb');
                stream_copy_to_stream($chunk, $output);
                fclose($chunk);
            }
        }

        fclose($output);

        return $tempFile;
    }

    /**
     * Cleanup session files and database record
     *
     * @param string $uploadId Upload session ID
     * @return bool True if cleaned up successfully
     */
    protected function cleanupSession(string $uploadId): bool
    {
        try {
            // Delete chunk files
            $uploadDir = $this->getUploadDirectory($uploadId);
            if (is_dir($uploadDir)) {
                $files = glob($uploadDir . '/*');
                foreach ($files as $file) {
                    @unlink($file);
                }
                @rmdir($uploadDir);
            }

            // Delete database record
            $this->db->table(DatabaseTables::UPLOAD_CHUNKS)
                ->where('upload_id', $uploadId)
                ->delete();

            return true;

        } catch (\Exception $e) {
            if (function_exists('logger')) {
                logger()->error('Failed to cleanup chunked upload', [
                    'upload_id' => $uploadId,
                    'error' => $e->getMessage(),
                ]);
            }
            return false;
        }
    }

    /**
     * Get MIME type from file extension
     *
     * @param string $extension File extension
     * @return string MIME type
     */
    protected function getMimeTypeFromExtension(string $extension): string
    {
        $mimeTypes = [
            // Images
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',

            // Videos
            'mp4' => 'video/mp4',
            'webm' => 'video/webm',
            'mov' => 'video/quicktime',
            'avi' => 'video/x-msvideo',
            'wmv' => 'video/x-ms-wmv',
            'mkv' => 'video/x-matroska',

            // Audio
            'mp3' => 'audio/mpeg',
            'wav' => 'audio/wav',
            'ogg' => 'audio/ogg',

            // Documents
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',

            // Archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            '7z' => 'application/x-7z-compressed',
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }

    /**
     * Check if chunked uploads are enabled
     *
     * @return bool
     */
    public static function isEnabled(): bool
    {
        return config('media.chunked.enabled', true);
    }

    /**
     * Get maximum file size for chunked uploads
     *
     * @return int Maximum size in bytes
     */
    public function getMaxFileSize(): int
    {
        return $this->maxFileSize;
    }

    /**
     * Get default chunk size
     *
     * @return int Chunk size in bytes
     */
    public function getChunkSize(): int
    {
        return $this->chunkSize;
    }
}
