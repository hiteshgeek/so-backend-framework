<?php

namespace Core\Image;

use Core\Image\Contracts\ImageDriver;
use App\Constants\ImageConstants;

/**
 * WatermarkService
 *
 * Applies watermarks to images with full customization support.
 *
 * Features:
 * - Text watermarks with custom fonts, colors, opacity
 * - Image watermarks with opacity control
 * - 9 position presets + custom coordinates
 * - Rotation support (0-360 degrees)
 * - Watermark presets from config
 * - Automatic positioning based on image size
 *
 * Usage:
 * ```php
 * $service = new WatermarkService();
 *
 * // Using preset
 * $service->apply($driver, 'copyright');
 *
 * // Custom text watermark
 * $service->apply($driver, [
 *     'text' => '© 2026 Company',
 *     'position' => 'bottom-right',
 *     'opacity' => 70,
 *     'font_size' => 16,
 *     'color' => '#FFFFFF'
 * ]);
 *
 * // Image watermark
 * $service->apply($driver, [
 *     'image' => 'path/to/watermark.png',
 *     'position' => 'center',
 *     'opacity' => 50
 * ]);
 * ```
 */
class WatermarkService
{
    /**
     * Default font path
     */
    protected ?string $defaultFontPath = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Set default font path if available
        $this->defaultFontPath = $this->findDefaultFont();
    }

    /**
     * Apply watermark to image
     *
     * @param ImageDriver $driver Image driver instance
     * @param array|string $config Watermark config or preset name
     * @return bool True if watermark applied successfully
     */
    public function apply(ImageDriver $driver, array|string $config): bool
    {
        // Load preset if string provided
        if (is_string($config)) {
            $config = $this->loadPreset($config);
        }

        if (empty($config)) {
            return false;
        }

        // Determine watermark type
        if (isset($config['image'])) {
            return $this->applyImageWatermark($driver, $config);
        }

        if (isset($config['text'])) {
            return $this->applyTextWatermark($driver, $config);
        }

        return false;
    }

    /**
     * Apply text watermark
     *
     * @param ImageDriver $driver Image driver instance
     * @param array $config Watermark configuration
     * @return bool True if applied successfully
     */
    protected function applyTextWatermark(ImageDriver $driver, array $config): bool
    {
        $text = $config['text'] ?? '';
        if (empty($text)) {
            return false;
        }

        // Get position coordinates
        [$x, $y] = $this->calculatePosition(
            $driver,
            $config['position'] ?? 'bottom-right',
            $config['x'] ?? null,
            $config['y'] ?? null,
            $config['margin'] ?? 10
        );

        // Prepare text options
        $options = [
            'font_size' => $config['font_size'] ?? 14,
            'font_path' => $config['font_path'] ?? $this->defaultFontPath,
            'color' => $this->parseColor($config['color'] ?? '#FFFFFF'),
            'opacity' => $config['opacity'] ?? 100,
            'rotation' => $config['rotation'] ?? 0,
        ];

        return $driver->addText($text, $x, $y, $options);
    }

    /**
     * Apply image watermark
     *
     * @param ImageDriver $driver Image driver instance
     * @param array $config Watermark configuration
     * @return bool True if applied successfully
     */
    protected function applyImageWatermark(ImageDriver $driver, array $config): bool
    {
        $imagePath = $config['image'] ?? '';
        if (empty($imagePath) || !file_exists($imagePath)) {
            return false;
        }

        // Get watermark dimensions
        $watermarkInfo = getimagesize($imagePath);
        if ($watermarkInfo === false) {
            return false;
        }

        $watermarkWidth = $config['width'] ?? $watermarkInfo[0];
        $watermarkHeight = $config['height'] ?? $watermarkInfo[1];

        // Get position coordinates
        [$x, $y] = $this->calculatePosition(
            $driver,
            $config['position'] ?? 'bottom-right',
            $config['x'] ?? null,
            $config['y'] ?? null,
            $config['margin'] ?? 10,
            $watermarkWidth,
            $watermarkHeight
        );

        // Prepare watermark options
        $options = [
            'opacity' => $config['opacity'] ?? 100,
            'width' => $watermarkWidth,
            'height' => $watermarkHeight,
        ];

        return $driver->addImageWatermark($imagePath, $x, $y, $options);
    }

    /**
     * Calculate watermark position
     *
     * @param ImageDriver $driver Image driver
     * @param string $position Position name or 'custom'
     * @param int|null $customX Custom X coordinate
     * @param int|null $customY Custom Y coordinate
     * @param int $margin Margin from edges
     * @param int $watermarkWidth Watermark width (for image watermarks)
     * @param int $watermarkHeight Watermark height (for image watermarks)
     * @return array [x, y] coordinates
     */
    protected function calculatePosition(
        ImageDriver $driver,
        string $position,
        ?int $customX = null,
        ?int $customY = null,
        int $margin = 10,
        int $watermarkWidth = 0,
        int $watermarkHeight = 0
    ): array {
        // Use custom coordinates if provided
        if ($customX !== null && $customY !== null) {
            return [$customX, $customY];
        }

        $imageWidth = $driver->getWidth();
        $imageHeight = $driver->getHeight();

        // Calculate position based on preset
        return match ($position) {
            ImageConstants::POSITION_TOP_LEFT => [
                $margin,
                $margin + $watermarkHeight
            ],
            ImageConstants::POSITION_TOP_CENTER => [
                (int)(($imageWidth - $watermarkWidth) / 2),
                $margin + $watermarkHeight
            ],
            ImageConstants::POSITION_TOP_RIGHT => [
                $imageWidth - $watermarkWidth - $margin,
                $margin + $watermarkHeight
            ],
            ImageConstants::POSITION_CENTER_LEFT => [
                $margin,
                (int)(($imageHeight + $watermarkHeight) / 2)
            ],
            ImageConstants::POSITION_CENTER => [
                (int)(($imageWidth - $watermarkWidth) / 2),
                (int)(($imageHeight + $watermarkHeight) / 2)
            ],
            ImageConstants::POSITION_CENTER_RIGHT => [
                $imageWidth - $watermarkWidth - $margin,
                (int)(($imageHeight + $watermarkHeight) / 2)
            ],
            ImageConstants::POSITION_BOTTOM_LEFT => [
                $margin,
                $imageHeight - $margin
            ],
            ImageConstants::POSITION_BOTTOM_CENTER => [
                (int)(($imageWidth - $watermarkWidth) / 2),
                $imageHeight - $margin
            ],
            ImageConstants::POSITION_BOTTOM_RIGHT => [
                $imageWidth - $watermarkWidth - $margin,
                $imageHeight - $margin
            ],
            default => [
                $imageWidth - $watermarkWidth - $margin,
                $imageHeight - $margin
            ],
        };
    }

    /**
     * Parse color string to RGB array
     *
     * @param string|array $color Color in hex (#FFFFFF) or RGB array
     * @return array [r, g, b, a]
     */
    protected function parseColor(string|array $color): array
    {
        // Already an array
        if (is_array($color)) {
            return array_pad($color, 4, 255);
        }

        // Parse hex color
        $hex = ltrim($color, '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        if (strlen($hex) !== 6) {
            return [255, 255, 255, 255];
        }

        return [
            (int)hexdec(substr($hex, 0, 2)),
            (int)hexdec(substr($hex, 2, 2)),
            (int)hexdec(substr($hex, 4, 2)),
            255,
        ];
    }

    /**
     * Load watermark preset from config
     *
     * @param string $presetName Preset name
     * @return array Watermark configuration
     */
    protected function loadPreset(string $presetName): array
    {
        $presets = config('media.watermark.presets', []);

        if (!isset($presets[$presetName])) {
            return [];
        }

        return $presets[$presetName];
    }

    /**
     * Find default TTF font
     *
     * @return string|null Path to default font or null
     */
    protected function findDefaultFont(): ?string
    {
        // Common font locations
        $fontPaths = [
            '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
            '/usr/share/fonts/truetype/liberation/LiberationSans-Regular.ttf',
            '/System/Library/Fonts/Helvetica.ttc',
            'C:/Windows/Fonts/arial.ttf',
        ];

        foreach ($fontPaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * Set default font path
     *
     * @param string $path Path to TTF font file
     * @return void
     */
    public function setDefaultFont(string $path): void
    {
        if (file_exists($path)) {
            $this->defaultFontPath = $path;
        }
    }

    /**
     * Get default font path
     *
     * @return string|null
     */
    public function getDefaultFont(): ?string
    {
        return $this->defaultFontPath;
    }
}
