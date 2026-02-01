<?php

use Core\Database\Migration;

/**
 * Media Tables Migration
 *
 * Creates tables for file upload and media management system:
 * - media: Track all uploaded files
 * - attachments: Polymorphic relationships to models
 */
return new class extends Migration
{
    /**
     * Run the migrations
     */
    public function up(): void
    {
        // Media table - stores all uploaded files
        $this->execute("
            CREATE TABLE media (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                filename VARCHAR(255) NOT NULL COMMENT 'Generated filename (e.g., file_abc123.jpg)',
                original_name VARCHAR(255) NOT NULL COMMENT 'Original uploaded filename',
                path VARCHAR(500) NOT NULL COMMENT 'Relative path from MEDIA_PATH (e.g., products/featured/file.jpg)',
                disk VARCHAR(50) DEFAULT 'media' COMMENT 'Storage disk name from config',
                mime_type VARCHAR(100) NOT NULL COMMENT 'File MIME type',
                size BIGINT UNSIGNED NOT NULL COMMENT 'File size in bytes',
                width INT UNSIGNED NULL COMMENT 'Image width in pixels (NULL for non-images)',
                height INT UNSIGNED NULL COMMENT 'Image height in pixels (NULL for non-images)',
                parent_id BIGINT UNSIGNED NULL COMMENT 'Parent media ID for variants (thumb, small, etc.)',
                metadata JSON NULL COMMENT 'Additional data: EXIF, variants list, watermark info, etc.',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

                INDEX idx_filename (filename),
                INDEX idx_path (path(255)),
                INDEX idx_parent_id (parent_id),
                INDEX idx_mime_type (mime_type),
                INDEX idx_created_at (created_at),

                FOREIGN KEY (parent_id) REFERENCES media(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='File upload and media tracking'
        ");

        // Attachments table - polymorphic relationships
        $this->execute("
            CREATE TABLE attachments (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                media_id BIGINT UNSIGNED NOT NULL COMMENT 'Reference to media table',
                attachable_type VARCHAR(255) NOT NULL COMMENT 'Model class name (e.g., App\\\\Models\\\\Product)',
                attachable_id BIGINT UNSIGNED NOT NULL COMMENT 'Model record ID',
                collection VARCHAR(100) DEFAULT 'default' COMMENT 'Collection name (e.g., images, documents, featured)',
                position INT UNSIGNED DEFAULT 0 COMMENT 'Sort order within collection',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

                INDEX idx_attachable (attachable_type, attachable_id),
                INDEX idx_media (media_id),
                INDEX idx_collection (collection),
                INDEX idx_position (position),
                UNIQUE KEY unique_attachment (media_id, attachable_type, attachable_id, collection),

                FOREIGN KEY (media_id) REFERENCES media(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Polymorphic file attachments to models'
        ");
    }

    /**
     * Reverse the migrations
     */
    public function down(): void
    {
        $this->execute("DROP TABLE IF EXISTS attachments");
        $this->execute("DROP TABLE IF EXISTS media");
    }
};
