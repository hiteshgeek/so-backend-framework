<?php

namespace Core\Image;

use Core\Image\Contracts\ImageDriver;
use Core\Image\Drivers\ImagickDriver;
use Core\Image\Drivers\GdDriver;
use App\Constants\ImageConstants;

/**
 * ImageProcessor
 *
 * Main facade for image manipulation operations.
 * Provides fluent interface for chaining operations.
 *
 * Automatically selects best available driver:
 * - Imagick (preferred - full features)
 * - GD (fallback - basic features)
 *
 * Usage:
 * ```php
 * $processor = ImageProcessor::create('path/to/image.jpg')
 *     ->resize(800, 600, 'crop')
 *     ->watermark([
 *         'text' => '© 2026 Company',
 *         'position' => 'bottom-right',
 *         'opacity' => 70
 *     ])
 *     ->optimize()
 *     ->save('output.jpg', 85);
 * ```
 */
class ImageProcessor
{
    /**
     * Image driver instance
     */
    protected ImageDriver $driver;

    /**
     * Watermark service
     */
    protected ?WatermarkService $watermarkService = null;

    /**
     * Constructor
     *
     * @param string|null $driverName Driver name (imagick, gd) or null for auto-detect
     */
    public function __construct(?string $driverName = null)
    {
        $this->driver = $this->createDriver($driverName);
    }

    /**
     * Create ImageProcessor instance from file
     *
     * @param string $path Path to image file
     * @param string|null $driver Driver name or null for auto-detect
     * @return static
     * @throws \RuntimeException If image cannot be loaded
     */
    public static function create(string $path, ?string $driver = null): static
    {
        $instance = new static($driver);

        if (!$instance->driver->load($path)) {
            throw new \RuntimeException("Failed to load image: {$path}");
        }

        return $instance;
    }

    /**
     * Create blank image
     *
     * @param int $width Image width
     * @param int $height Image height
     * @param array $background Background color [r, g, b, a]
     * @param string|null $driver Driver name or null for auto-detect
     * @return static
     * @throws \RuntimeException If image cannot be created
     */
    public static function make(int $width, int $height, array $background = [255, 255, 255, 0], ?string $driver = null): static
    {
        $instance = new static($driver);

        if (!$instance->driver->create($width, $height, $background)) {
            throw new \RuntimeException("Failed to create image: {$width}x{$height}");
        }

        return $instance;
    }

    /**
     * Resize image
     *
     * @param int $width Target width
     * @param int $height Target height
     * @param string $mode Resize mode (fit, crop, stretch)
     * @return $this
     * @throws \RuntimeException If resize fails
     */
    public function resize(int $width, int $height, string $mode = ImageConstants::RESIZE_FIT): static
    {
        if (!$this->driver->resize($width, $height, $mode)) {
            throw new \RuntimeException("Failed to resize image to {$width}x{$height}");
        }

        return $this;
    }

    /**
     * Crop image
     *
     * @param int $x X coordinate
     * @param int $y Y coordinate
     * @param int $width Crop width
     * @param int $height Crop height
     * @return $this
     * @throws \RuntimeException If crop fails
     */
    public function crop(int $x, int $y, int $width, int $height): static
    {
        if (!$this->driver->crop($x, $y, $width, $height)) {
            throw new \RuntimeException("Failed to crop image");
        }

        return $this;
    }

    /**
     * Rotate image
     *
     * @param float $angle Rotation angle in degrees
     * @param array $background Background color [r, g, b, a]
     * @return $this
     * @throws \RuntimeException If rotation fails
     */
    public function rotate(float $angle, array $background = [255, 255, 255, 0]): static
    {
        if (!$this->driver->rotate($angle, $background)) {
            throw new \RuntimeException("Failed to rotate image");
        }

        return $this;
    }

    /**
     * Flip image horizontally
     *
     * @return $this
     */
    public function flipHorizontal(): static
    {
        $this->driver->flipHorizontal();
        return $this;
    }

    /**
     * Flip image vertically
     *
     * @return $this
     */
    public function flipVertical(): static
    {
        $this->driver->flipVertical();
        return $this;
    }

    /**
     * Add watermark (text or image)
     *
     * @param array|string $config Watermark config array or preset name
     * @return $this
     * @throws \RuntimeException If watermark fails
     */
    public function watermark(array|string $config): static
    {
        $watermarkService = $this->getWatermarkService();

        if (!$watermarkService->apply($this->driver, $config)) {
            throw new \RuntimeException("Failed to apply watermark");
        }

        return $this;
    }

    /**
     * Apply blur filter
     *
     * @param int $amount Blur amount (0-100)
     * @return $this
     */
    public function blur(int $amount): static
    {
        $this->driver->blur($amount);
        return $this;
    }

    /**
     * Adjust brightness
     *
     * @param int $level Brightness level (-100 to 100)
     * @return $this
     */
    public function brightness(int $level): static
    {
        $this->driver->brightness($level);
        return $this;
    }

    /**
     * Adjust contrast
     *
     * @param int $level Contrast level (-100 to 100)
     * @return $this
     */
    public function contrast(int $level): static
    {
        $this->driver->contrast($level);
        return $this;
    }

    /**
     * Convert to grayscale
     *
     * @return $this
     */
    public function grayscale(): static
    {
        $this->driver->grayscale();
        return $this;
    }

    /**
     * Sharpen image
     *
     * @param int $amount Sharpen amount (0-100)
     * @return $this
     */
    public function sharpen(int $amount): static
    {
        $this->driver->sharpen($amount);
        return $this;
    }

    /**
     * Optimize image
     *
     * @return $this
     */
    public function optimize(): static
    {
        $this->driver->optimize();
        return $this;
    }

    /**
     * Save image to file
     *
     * @param string $path Destination path
     * @param int $quality Quality (0-100)
     * @param string|null $format Output format (jpeg, png, webp, gif)
     * @return string Saved file path
     * @throws \RuntimeException If save fails
     */
    public function save(string $path, int $quality = 85, ?string $format = null): string
    {
        // Create directory if it doesn't exist
        $directory = dirname($path);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (!$this->driver->save($path, $quality, $format)) {
            throw new \RuntimeException("Failed to save image to: {$path}");
        }

        return $path;
    }

    /**
     * Get image width
     *
     * @return int Width in pixels
     */
    public function getWidth(): int
    {
        return $this->driver->getWidth();
    }

    /**
     * Get image height
     *
     * @return int Height in pixels
     */
    public function getHeight(): int
    {
        return $this->driver->getHeight();
    }

    /**
     * Get image dimensions
     *
     * @return array Array with 'width' and 'height'
     */
    public function getDimensions(): array
    {
        return [
            'width' => $this->driver->getWidth(),
            'height' => $this->driver->getHeight(),
        ];
    }

    /**
     * Get image format
     *
     * @return string Format (jpeg, png, webp, gif)
     */
    public function getFormat(): string
    {
        return $this->driver->getFormat();
    }

    /**
     * Get MIME type
     *
     * @return string MIME type
     */
    public function getMimeType(): string
    {
        return $this->driver->getMimeType();
    }

    /**
     * Get underlying driver instance
     *
     * @return ImageDriver
     */
    public function getDriver(): ImageDriver
    {
        return $this->driver;
    }

    /**
     * Clone image
     *
     * @return static New instance with cloned image
     */
    public function clone(): static
    {
        $cloned = new static(get_class($this->driver));
        $cloned->driver = $this->driver->clone();
        return $cloned;
    }

    /**
     * Create driver instance
     *
     * @param string|null $driverName Driver name or null for auto-detect
     * @return ImageDriver
     * @throws \RuntimeException If no driver available
     */
    protected function createDriver(?string $driverName = null): ImageDriver
    {
        // If driver specified, use it
        if ($driverName) {
            return match (strtolower($driverName)) {
                'imagick' => new ImagickDriver(),
                'gd' => new GdDriver(),
                default => throw new \RuntimeException("Unknown driver: {$driverName}"),
            };
        }

        // Auto-detect: prefer Imagick, fallback to GD
        $configuredDriver = config('media.driver', 'imagick');

        if ($configuredDriver === 'imagick' && ImagickDriver::isAvailable()) {
            return new ImagickDriver();
        }

        if (GdDriver::isAvailable()) {
            return new GdDriver();
        }

        throw new \RuntimeException('No image driver available. Install Imagick or GD extension.');
    }

    /**
     * Get watermark service instance
     *
     * @return WatermarkService
     */
    protected function getWatermarkService(): WatermarkService
    {
        if (!$this->watermarkService) {
            $this->watermarkService = new WatermarkService();
        }

        return $this->watermarkService;
    }

    /**
     * Destructor - clean up resources
     */
    public function __destruct()
    {
        $this->driver->destroy();
    }
}
