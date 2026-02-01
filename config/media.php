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
];
