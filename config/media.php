<?php

use App\Constants\ImageConstants;

return [
    /*
    |--------------------------------------------------------------------------
    | Media Storage Path (Shared Directory)
    |--------------------------------------------------------------------------
    |
    | Absolute path to the shared media directory where all files are stored.
    | This is typically above the project root for shared access across clients.
    |
    */
    'path' => env('MEDIA_PATH', '/var/www/html/rpkfiles'),

    /*
    |--------------------------------------------------------------------------
    | Media Base URL
    |--------------------------------------------------------------------------
    |
    | Public URL path for accessing media files.
    | Used to generate URLs for uploaded files.
    |
    */
    'url' => env('MEDIA_URL', '/media'),

    /*
    |--------------------------------------------------------------------------
    | Default Storage Disk
    |--------------------------------------------------------------------------
    |
    | The default disk to use for file uploads.
    |
    */
    'default_disk' => env('MEDIA_DISK', 'media'),

    /*
    |--------------------------------------------------------------------------
    | Storage Disks Configuration
    |--------------------------------------------------------------------------
    |
    | Configure multiple storage backends. Each disk can have different
    | settings for root path, visibility, and URL structure.
    |
    */
    'disks' => [
        'media' => [
            'driver' => 'local',
            'root' => env('MEDIA_PATH', '/var/www/html/rpkfiles'),
            'url' => env('MEDIA_URL', '/media'),
            'visibility' => 'public',
        ],
        'local' => [
            'driver' => 'local',
            'root' => storage_path('media'),
            'visibility' => 'private',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Processing Driver
    |--------------------------------------------------------------------------
    |
    | Image processing library to use: 'imagick' or 'gd'
    | Imagick provides better quality and more features but requires extension.
    | GD is built-in to PHP but has fewer features.
    |
    */
    'driver' => env('IMAGE_DRIVER', 'imagick'),

    /*
    |--------------------------------------------------------------------------
    | Image Variants (Responsive Sizes)
    |--------------------------------------------------------------------------
    |
    | Define responsive image variants to generate automatically.
    | Each variant can specify: width, height, mode, quality, format
    |
    | Mode options:
    | - 'fit': Fit within bounds, maintain aspect ratio
    | - 'crop': Crop to exact size
    | - 'stretch': Stretch to fill (may distort)
    |
    */
    'variants' => [
        'thumb' => [
            'width' => 150,
            'height' => 150,
            'mode' => ImageConstants::RESIZE_CROP,
            'quality' => ImageConstants::QUALITY_MEDIUM,
            'optimize' => true,
            'strip_metadata' => true,
        ],
        'small' => [
            'width' => 320,
            'height' => 240,
            'mode' => ImageConstants::RESIZE_FIT,
            'quality' => ImageConstants::QUALITY_HIGH,
            'optimize' => true,
            'strip_metadata' => true,
        ],
        'medium' => [
            'width' => 640,
            'height' => 480,
            'mode' => ImageConstants::RESIZE_FIT,
            'quality' => ImageConstants::QUALITY_HIGH,
            'optimize' => true,
            'strip_metadata' => true,
        ],
        'large' => [
            'width' => 1024,
            'height' => 768,
            'mode' => ImageConstants::RESIZE_FIT,
            'quality' => ImageConstants::QUALITY_HIGH,
            'optimize' => true,
            'strip_metadata' => false, // Keep metadata for large versions
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Watermark Configuration
    |--------------------------------------------------------------------------
    |
    | Default watermark settings and predefined presets for quick application.
    |
    */
    'watermark' => [
        // Global watermark settings
        'enabled' => env('WATERMARK_ENABLED', false),

        'defaults' => [
            'position' => ImageConstants::POSITION_BOTTOM_RIGHT,
            'opacity' => 70,
            'rotation' => 0,
            'padding' => 10,
            'font' => storage_path('fonts/arial.ttf'),
            'font_size' => 18,
            'color' => '#FFFFFF',
        ],

        // Watermark presets for quick application
        'presets' => [
            'copyright' => [
                'text' => '© ' . date('Y') . ' ' . env('APP_NAME', 'Company'),
                'position' => ImageConstants::POSITION_BOTTOM_RIGHT,
                'opacity' => 60,
                'font_size' => 14,
                'color' => '#FFFFFF',
                'padding' => 15,
            ],
            'draft' => [
                'text' => 'DRAFT',
                'position' => ImageConstants::POSITION_CENTER,
                'opacity' => 30,
                'font_size' => 72,
                'color' => '#FF0000',
                'rotation' => -45,
            ],
            'sample' => [
                'text' => 'SAMPLE',
                'position' => ImageConstants::POSITION_CENTER,
                'opacity' => 40,
                'font_size' => 48,
                'color' => '#000000',
                'rotation' => -30,
            ],
            'confidential' => [
                'text' => 'CONFIDENTIAL',
                'position' => ImageConstants::POSITION_TOP_CENTER,
                'opacity' => 80,
                'font_size' => 24,
                'color' => '#FF0000',
                'padding' => 10,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed File Types
    |--------------------------------------------------------------------------
    |
    | MIME types and file extensions allowed for upload.
    | Used by FileValidator for security validation.
    |
    */
    'allowed_types' => [
        // Images
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
        'image/svg+xml',

        // Documents
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // .docx
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx

        // Archives
        'application/zip',
        'application/x-rar-compressed',
        'application/x-7z-compressed',
    ],

    'allowed_extensions' => [
        // Images
        'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg',

        // Documents
        'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'csv',

        // Archives
        'zip', 'rar', '7z',
    ],

    /*
    |--------------------------------------------------------------------------
    | Maximum File Size
    |--------------------------------------------------------------------------
    |
    | Maximum upload file size in kilobytes.
    | Default: 10240 KB = 10 MB
    |
    */
    'max_file_size' => env('MEDIA_MAX_SIZE', 10240),

    /*
    |--------------------------------------------------------------------------
    | Image Processing Options
    |--------------------------------------------------------------------------
    |
    | Global image processing settings.
    |
    */
    'processing' => [
        // Default quality for JPEG images (1-100)
        'jpeg_quality' => ImageConstants::QUALITY_HIGH,

        // Default quality for WebP images (1-100)
        'webp_quality' => 85,

        // PNG compression level (0-9)
        'png_compression' => 6,

        // Strip EXIF data by default?
        'strip_metadata' => true,

        // Convert to progressive JPEG?
        'progressive_jpeg' => true,

        // Auto-orient images based on EXIF data?
        'auto_orient' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Settings
    |--------------------------------------------------------------------------
    |
    | Settings for async image processing via queue system.
    | Variants and watermarks can be processed in background.
    |
    */
    'queue' => [
        // Process variants in background?
        'enabled' => env('MEDIA_QUEUE_ENABLED', true),

        // Queue connection to use
        'connection' => env('MEDIA_QUEUE_CONNECTION', 'database'),

        // Queue name
        'queue' => 'media',
    ],

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Cache processed images to improve performance.
    |
    */
    'cache' => [
        // Enable caching?
        'enabled' => env('MEDIA_CACHE_ENABLED', true),

        // Cache TTL in seconds (0 = forever)
        'ttl' => env('MEDIA_CACHE_TTL', 0),

        // Cache store to use
        'store' => env('MEDIA_CACHE_STORE', 'file'),
    ],

    /*
    |--------------------------------------------------------------------------
    | WebP Auto-Conversion
    |--------------------------------------------------------------------------
    |
    | Automatically generate WebP versions of images for better compression.
    | WebP provides 25-35% smaller file sizes compared to JPEG/PNG.
    |
    */
    'webp' => [
        // Enable automatic WebP generation
        'enabled' => env('MEDIA_AUTO_WEBP', true),

        // Quality for WebP images (1-100)
        'quality' => env('MEDIA_WEBP_QUALITY', 80),

        // Generate WebP for these source types
        'source_types' => ['image/jpeg', 'image/png'],

        // Skip WebP for small images (bytes)
        'min_size' => 1024, // 1KB minimum
    ],

    /*
    |--------------------------------------------------------------------------
    | Chunked/Resumable Uploads
    |--------------------------------------------------------------------------
    |
    | Support for large file uploads using chunked transfer.
    | Files are uploaded in parts and assembled on completion.
    |
    */
    'chunked' => [
        // Enable chunked uploads
        'enabled' => env('MEDIA_CHUNKED_ENABLED', true),

        // Chunk size in bytes (default 2MB)
        'chunk_size' => env('MEDIA_CHUNK_SIZE', 2 * 1024 * 1024),

        // Maximum file size for chunked uploads (default 500MB)
        'max_file_size' => env('MEDIA_CHUNKED_MAX_SIZE', 500 * 1024 * 1024),

        // Temporary directory for chunks
        'temp_directory' => storage_path('chunks'),

        // Hours before incomplete uploads expire
        'expiry_hours' => 24,

        // Cleanup orphaned chunks on boot
        'auto_cleanup' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Video Processing
    |--------------------------------------------------------------------------
    |
    | Settings for video file handling and thumbnail extraction.
    | Requires FFmpeg to be installed on the server.
    |
    */
    'video' => [
        // Enable video processing
        'enabled' => env('MEDIA_VIDEO_ENABLED', true),

        // Path to FFmpeg binary
        'ffmpeg_path' => env('FFMPEG_PATH', '/usr/bin/ffmpeg'),

        // Path to FFprobe binary
        'ffprobe_path' => env('FFPROBE_PATH', '/usr/bin/ffprobe'),

        // Extract thumbnail at this time (seconds)
        'thumbnail_time' => 1.0,

        // Number of thumbnails to extract for preview
        'thumbnail_count' => 3,

        // Thumbnail dimensions
        'thumbnail_width' => 640,
        'thumbnail_height' => 360,

        // Allowed video MIME types
        'allowed_types' => [
            'video/mp4',
            'video/webm',
            'video/quicktime',
            'video/x-msvideo',
            'video/x-ms-wmv',
            'video/x-matroska',
        ],

        // Maximum video duration in seconds (0 = unlimited)
        'max_duration' => 3600, // 1 hour
    ],

    /*
    |--------------------------------------------------------------------------
    | CDN Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for serving media files through a CDN.
    | Supports CloudFront, Cloudflare, and generic CDN providers.
    |
    */
    'cdn' => [
        // Enable CDN URL rewriting
        'enabled' => env('MEDIA_CDN_ENABLED', false),

        // CDN base URL
        'url' => env('MEDIA_CDN_URL', ''),

        // Rules for CDN usage
        'rules' => [
            // Only serve these MIME type patterns via CDN
            'include_types' => ['image/*', 'video/*', 'application/pdf'],

            // Exclude these path patterns from CDN
            'exclude_patterns' => ['/private/', '/temp/', '/secure/'],
        ],

        // CloudFront configuration (optional)
        'cloudfront' => [
            'distribution_id' => env('CLOUDFRONT_DISTRIBUTION_ID'),
            'key_pair_id' => env('CLOUDFRONT_KEY_PAIR_ID'),
            'private_key_path' => env('CLOUDFRONT_PRIVATE_KEY'),
        ],

        // Cloudflare configuration (optional)
        'cloudflare' => [
            'zone_id' => env('CLOUDFLARE_ZONE_ID'),
            'api_token' => env('CLOUDFLARE_API_TOKEN'),
        ],
    ],
];
