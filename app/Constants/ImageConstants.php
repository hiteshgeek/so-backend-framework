<?php

namespace App\Constants;

/**
 * Image Processing Constants
 *
 * Centralized constants for image processing, watermarks, and variants.
 */
class ImageConstants
{
    /*
    |--------------------------------------------------------------------------
    | Watermark Positions
    |--------------------------------------------------------------------------
    |
    | Standard position constants for watermark placement.
    |
    */
    const POSITION_TOP_LEFT = 'top-left';
    const POSITION_TOP_CENTER = 'top-center';
    const POSITION_TOP_RIGHT = 'top-right';
    const POSITION_CENTER_LEFT = 'center-left';
    const POSITION_CENTER = 'center';
    const POSITION_CENTER_RIGHT = 'center-right';
    const POSITION_BOTTOM_LEFT = 'bottom-left';
    const POSITION_BOTTOM_CENTER = 'bottom-center';
    const POSITION_BOTTOM_RIGHT = 'bottom-right';

    /**
     * Get all valid watermark positions
     *
     * @return array
     */
    public static function getAllPositions(): array
    {
        return [
            self::POSITION_TOP_LEFT,
            self::POSITION_TOP_CENTER,
            self::POSITION_TOP_RIGHT,
            self::POSITION_CENTER_LEFT,
            self::POSITION_CENTER,
            self::POSITION_CENTER_RIGHT,
            self::POSITION_BOTTOM_LEFT,
            self::POSITION_BOTTOM_CENTER,
            self::POSITION_BOTTOM_RIGHT,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Resize Modes
    |--------------------------------------------------------------------------
    |
    | Constants for image resize behavior.
    |
    */
    const RESIZE_FIT = 'fit';        // Fit within bounds, maintain aspect ratio
    const RESIZE_CROP = 'crop';      // Crop to exact size
    const RESIZE_STRETCH = 'stretch'; // Stretch to fill (may distort)

    /**
     * Get all resize modes
     *
     * @return array
     */
    public static function getResizeModes(): array
    {
        return [
            self::RESIZE_FIT,
            self::RESIZE_CROP,
            self::RESIZE_STRETCH,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Image Formats
    |--------------------------------------------------------------------------
    |
    | Supported image format constants.
    |
    */
    const FORMAT_JPEG = 'jpeg';
    const FORMAT_PNG = 'png';
    const FORMAT_WEBP = 'webp';
    const FORMAT_GIF = 'gif';

    /**
     * Get supported image formats
     *
     * @return array
     */
    public static function getSupportedFormats(): array
    {
        return [
            self::FORMAT_JPEG,
            self::FORMAT_PNG,
            self::FORMAT_WEBP,
            self::FORMAT_GIF,
        ];
    }

    /**
     * Get MIME type for format
     *
     * @param string $format
     * @return string
     */
    public static function getMimeType(string $format): string
    {
        return match($format) {
            self::FORMAT_JPEG => 'image/jpeg',
            self::FORMAT_PNG => 'image/png',
            self::FORMAT_WEBP => 'image/webp',
            self::FORMAT_GIF => 'image/gif',
            default => 'application/octet-stream',
        };
    }

    /**
     * Get file extension for MIME type
     *
     * @param string $mimeType
     * @return string
     */
    public static function getExtension(string $mimeType): string
    {
        return match($mimeType) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
            default => 'bin',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Quality Presets
    |--------------------------------------------------------------------------
    |
    | Predefined quality levels for image compression.
    |
    */
    const QUALITY_LOW = 60;
    const QUALITY_MEDIUM = 75;
    const QUALITY_HIGH = 85;
    const QUALITY_MAXIMUM = 95;
    const QUALITY_ORIGINAL = 100;

    /**
     * Get quality presets
     *
     * @return array
     */
    public static function getQualityPresets(): array
    {
        return [
            'low' => self::QUALITY_LOW,
            'medium' => self::QUALITY_MEDIUM,
            'high' => self::QUALITY_HIGH,
            'maximum' => self::QUALITY_MAXIMUM,
            'original' => self::QUALITY_ORIGINAL,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Variant Names
    |--------------------------------------------------------------------------
    |
    | Standard variant size names.
    |
    */
    const VARIANT_THUMBNAIL = 'thumb';
    const VARIANT_SMALL = 'small';
    const VARIANT_MEDIUM = 'medium';
    const VARIANT_LARGE = 'large';
    const VARIANT_ORIGINAL = 'original';

    /**
     * Get all variant names
     *
     * @return array
     */
    public static function getVariantNames(): array
    {
        return [
            self::VARIANT_THUMBNAIL,
            self::VARIANT_SMALL,
            self::VARIANT_MEDIUM,
            self::VARIANT_LARGE,
            self::VARIANT_ORIGINAL,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Optimization Strategies
    |--------------------------------------------------------------------------
    |
    | Image optimization levels.
    |
    */
    const OPTIMIZE_NONE = 'none';
    const OPTIMIZE_BASIC = 'basic';           // Basic compression
    const OPTIMIZE_AGGRESSIVE = 'aggressive'; // Maximum compression

    /**
     * Get optimization strategies
     *
     * @return array
     */
    public static function getOptimizationStrategies(): array
    {
        return [
            self::OPTIMIZE_NONE,
            self::OPTIMIZE_BASIC,
            self::OPTIMIZE_AGGRESSIVE,
        ];
    }
}
