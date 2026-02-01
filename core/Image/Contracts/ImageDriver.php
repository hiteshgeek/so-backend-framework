<?php

namespace Core\Image\Contracts;

/**
 * ImageDriver Interface
 *
 * Contract for image manipulation drivers (Imagick, GD).
 * Provides a unified API for image operations regardless of underlying library.
 *
 * Implementations:
 * - ImagickDriver: Uses ImageMagick extension (recommended, more features)
 * - GdDriver: Uses GD extension (fallback, basic features)
 */
interface ImageDriver
{
    /**
     * Load image from file path
     *
     * @param string $path Full path to image file
     * @return bool True if loaded successfully
     */
    public function load(string $path): bool;

    /**
     * Create image from dimensions
     *
     * @param int $width Image width
     * @param int $height Image height
     * @param array $background Background color [r, g, b, a]
     * @return bool True if created successfully
     */
    public function create(int $width, int $height, array $background = [255, 255, 255, 0]): bool;

    /**
     * Save image to file
     *
     * @param string $path Destination path
     * @param int $quality Quality (0-100)
     * @param string|null $format Output format (jpeg, png, webp, gif)
     * @return bool True if saved successfully
     */
    public function save(string $path, int $quality = 85, ?string $format = null): bool;

    /**
     * Resize image
     *
     * @param int $width Target width
     * @param int $height Target height
     * @param string $mode Resize mode (fit, crop, stretch)
     * @return bool True if resized successfully
     */
    public function resize(int $width, int $height, string $mode = 'fit'): bool;

    /**
     * Crop image
     *
     * @param int $x X coordinate
     * @param int $y Y coordinate
     * @param int $width Crop width
     * @param int $height Crop height
     * @return bool True if cropped successfully
     */
    public function crop(int $x, int $y, int $width, int $height): bool;

    /**
     * Rotate image
     *
     * @param float $angle Rotation angle in degrees
     * @param array $background Background color for empty areas [r, g, b, a]
     * @return bool True if rotated successfully
     */
    public function rotate(float $angle, array $background = [255, 255, 255, 0]): bool;

    /**
     * Flip image horizontally
     *
     * @return bool True if flipped successfully
     */
    public function flipHorizontal(): bool;

    /**
     * Flip image vertically
     *
     * @return bool True if flipped successfully
     */
    public function flipVertical(): bool;

    /**
     * Add text watermark
     *
     * @param string $text Text to add
     * @param int $x X coordinate
     * @param int $y Y coordinate
     * @param array $options Text options:
     *                        - 'font_size' (int): Font size
     *                        - 'font_path' (string): Path to TTF font file
     *                        - 'color' (array): Text color [r, g, b, a]
     *                        - 'opacity' (int): Text opacity (0-100)
     *                        - 'rotation' (float): Text rotation angle
     * @return bool True if text added successfully
     */
    public function addText(string $text, int $x, int $y, array $options = []): bool;

    /**
     * Add image watermark
     *
     * @param string $watermarkPath Path to watermark image
     * @param int $x X coordinate
     * @param int $y Y coordinate
     * @param array $options Watermark options:
     *                        - 'opacity' (int): Opacity (0-100)
     *                        - 'width' (int): Resize width
     *                        - 'height' (int): Resize height
     * @return bool True if watermark added successfully
     */
    public function addImageWatermark(string $watermarkPath, int $x, int $y, array $options = []): bool;

    /**
     * Apply blur filter
     *
     * @param int $amount Blur amount (0-100)
     * @return bool True if blur applied successfully
     */
    public function blur(int $amount): bool;

    /**
     * Adjust brightness
     *
     * @param int $level Brightness level (-100 to 100)
     * @return bool True if brightness adjusted successfully
     */
    public function brightness(int $level): bool;

    /**
     * Adjust contrast
     *
     * @param int $level Contrast level (-100 to 100)
     * @return bool True if contrast adjusted successfully
     */
    public function contrast(int $level): bool;

    /**
     * Convert to grayscale
     *
     * @return bool True if converted successfully
     */
    public function grayscale(): bool;

    /**
     * Sharpen image
     *
     * @param int $amount Sharpen amount (0-100)
     * @return bool True if sharpened successfully
     */
    public function sharpen(int $amount): bool;

    /**
     * Optimize image (reduce file size without quality loss)
     *
     * @return bool True if optimized successfully
     */
    public function optimize(): bool;

    /**
     * Get image width
     *
     * @return int Image width in pixels
     */
    public function getWidth(): int;

    /**
     * Get image height
     *
     * @return int Image height in pixels
     */
    public function getHeight(): int;

    /**
     * Get image MIME type
     *
     * @return string MIME type
     */
    public function getMimeType(): string;

    /**
     * Get image format
     *
     * @return string Format (jpeg, png, webp, gif)
     */
    public function getFormat(): string;

    /**
     * Get underlying image resource
     *
     * @return mixed Raw image resource (Imagick object or GD resource)
     */
    public function getResource(): mixed;

    /**
     * Destroy image and free memory
     *
     * @return void
     */
    public function destroy(): void;

    /**
     * Clone image
     *
     * @return static New instance with cloned image
     */
    public function clone(): static;

    /**
     * Check if driver is available on system
     *
     * @return bool True if driver can be used
     */
    public static function isAvailable(): bool;
}
