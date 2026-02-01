<?php

namespace Core\Image\Drivers;

use Core\Image\Contracts\ImageDriver;
use Imagick;
use ImagickDraw;
use ImagickPixel;
use App\Constants\ImageConstants;

/**
 * ImagickDriver
 *
 * Image manipulation driver using ImageMagick extension.
 * Recommended driver with full feature support.
 *
 * Requirements:
 * - PHP Imagick extension (already installed: 6.9.12-98)
 *
 * Features:
 * - Full image manipulation support
 * - High-quality resizing with multiple algorithms
 * - Advanced watermarking with rotation and opacity
 * - Multiple format support (JPEG, PNG, WebP, GIF)
 * - Image optimization
 */
class ImagickDriver implements ImageDriver
{
    /**
     * Imagick instance
     */
    protected ?Imagick $image = null;

    /**
     * Image format
     */
    protected string $format = 'jpeg';

    /**
     * Load image from file path
     */
    public function load(string $path): bool
    {
        try {
            $this->image = new Imagick($path);
            $this->format = strtolower($this->image->getImageFormat());
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Create image from dimensions
     */
    public function create(int $width, int $height, array $background = [255, 255, 255, 0]): bool
    {
        try {
            $this->image = new Imagick();

            // Create pixel for background color
            $color = sprintf('rgba(%d,%d,%d,%.2f)',
                $background[0],
                $background[1],
                $background[2],
                1 - ($background[3] ?? 0) / 100
            );

            $pixel = new ImagickPixel($color);
            $this->image->newImage($width, $height, $pixel);
            $this->image->setImageFormat('png');
            $this->format = 'png';

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Save image to file
     */
    public function save(string $path, int $quality = 85, ?string $format = null): bool
    {
        try {
            if (!$this->image) {
                return false;
            }

            // Set format if specified
            if ($format) {
                $this->image->setImageFormat($format);
                $this->format = $format;
            }

            // Set quality for lossy formats
            if (in_array($this->format, ['jpeg', 'jpg', 'webp'])) {
                $this->image->setImageCompressionQuality($quality);
            }

            // Write to file
            $this->image->writeImage($path);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Resize image
     */
    public function resize(int $width, int $height, string $mode = 'fit'): bool
    {
        try {
            if (!$this->image) {
                return false;
            }

            $currentWidth = $this->image->getImageWidth();
            $currentHeight = $this->image->getImageHeight();

            switch ($mode) {
                case ImageConstants::RESIZE_FIT:
                    // Fit within bounds, maintain aspect ratio
                    $this->image->thumbnailImage($width, $height, true);
                    break;

                case ImageConstants::RESIZE_CROP:
                    // Crop to exact size
                    $this->image->cropThumbnailImage($width, $height);
                    break;

                case ImageConstants::RESIZE_STRETCH:
                    // Stretch to fill (may distort)
                    $this->image->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1);
                    break;

                default:
                    $this->image->thumbnailImage($width, $height, true);
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Crop image
     */
    public function crop(int $x, int $y, int $width, int $height): bool
    {
        try {
            if (!$this->image) {
                return false;
            }

            $this->image->cropImage($width, $height, $x, $y);
            $this->image->setImagePage(0, 0, 0, 0); // Reset canvas

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Rotate image
     */
    public function rotate(float $angle, array $background = [255, 255, 255, 0]): bool
    {
        try {
            if (!$this->image) {
                return false;
            }

            $color = sprintf('rgba(%d,%d,%d,%.2f)',
                $background[0],
                $background[1],
                $background[2],
                1 - ($background[3] ?? 0) / 100
            );

            $pixel = new ImagickPixel($color);
            $this->image->rotateImage($pixel, $angle);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Flip image horizontally
     */
    public function flipHorizontal(): bool
    {
        try {
            if (!$this->image) {
                return false;
            }

            $this->image->flopImage();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Flip image vertically
     */
    public function flipVertical(): bool
    {
        try {
            if (!$this->image) {
                return false;
            }

            $this->image->flipImage();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Add text watermark
     */
    public function addText(string $text, int $x, int $y, array $options = []): bool
    {
        try {
            if (!$this->image) {
                return false;
            }

            $draw = new ImagickDraw();

            // Set font
            $fontSize = $options['font_size'] ?? 14;
            $fontPath = $options['font_path'] ?? null;

            $draw->setFontSize($fontSize);
            if ($fontPath && file_exists($fontPath)) {
                $draw->setFont($fontPath);
            }

            // Set color with opacity
            $color = $options['color'] ?? [255, 255, 255, 255];
            $opacity = ($options['opacity'] ?? 100) / 100;

            $colorString = sprintf('rgba(%d,%d,%d,%.2f)',
                $color[0], $color[1], $color[2], $opacity
            );
            $draw->setFillColor(new ImagickPixel($colorString));

            // Set rotation if specified
            $rotation = $options['rotation'] ?? 0;
            if ($rotation !== 0) {
                $draw->rotate($rotation);
            }

            // Add text
            $this->image->annotateImage($draw, $x, $y, 0, $text);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Add image watermark
     */
    public function addImageWatermark(string $watermarkPath, int $x, int $y, array $options = []): bool
    {
        try {
            if (!$this->image) {
                return false;
            }

            $watermark = new Imagick($watermarkPath);

            // Resize watermark if dimensions specified
            if (isset($options['width'], $options['height'])) {
                $watermark->thumbnailImage($options['width'], $options['height'], true);
            }

            // Set opacity
            if (isset($options['opacity'])) {
                $opacity = $options['opacity'] / 100;
                $watermark->evaluateImage(Imagick::EVALUATE_MULTIPLY, $opacity, Imagick::CHANNEL_ALPHA);
            }

            // Composite watermark onto image
            $this->image->compositeImage(
                $watermark,
                Imagick::COMPOSITE_OVER,
                $x,
                $y
            );

            $watermark->destroy();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Apply blur filter
     */
    public function blur(int $amount): bool
    {
        try {
            if (!$this->image) {
                return false;
            }

            $radius = $amount / 10;
            $sigma = $amount / 20;
            $this->image->blurImage($radius, $sigma);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Adjust brightness
     */
    public function brightness(int $level): bool
    {
        try {
            if (!$this->image) {
                return false;
            }

            $brightness = 100 + $level;
            $this->image->modulateImage($brightness, 100, 100);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Adjust contrast
     */
    public function contrast(int $level): bool
    {
        try {
            if (!$this->image) {
                return false;
            }

            $sharpen = $level > 0;
            for ($i = 0; $i < abs($level); $i++) {
                $this->image->contrastImage($sharpen);
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Convert to grayscale
     */
    public function grayscale(): bool
    {
        try {
            if (!$this->image) {
                return false;
            }

            $this->image->modulateImage(100, 0, 100);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Sharpen image
     */
    public function sharpen(int $amount): bool
    {
        try {
            if (!$this->image) {
                return false;
            }

            $radius = $amount / 10;
            $sigma = $amount / 20;
            $this->image->sharpenImage($radius, $sigma);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Optimize image
     */
    public function optimize(): bool
    {
        try {
            if (!$this->image) {
                return false;
            }

            // Strip metadata
            $this->image->stripImage();

            // Set interlace for progressive loading
            $this->image->setInterlaceScheme(Imagick::INTERLACE_PLANE);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get image width
     */
    public function getWidth(): int
    {
        return $this->image ? $this->image->getImageWidth() : 0;
    }

    /**
     * Get image height
     */
    public function getHeight(): int
    {
        return $this->image ? $this->image->getImageHeight() : 0;
    }

    /**
     * Get image MIME type
     */
    public function getMimeType(): string
    {
        if (!$this->image) {
            return '';
        }

        return ImageConstants::getMimeType($this->format);
    }

    /**
     * Get image format
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * Get underlying Imagick resource
     */
    public function getResource(): mixed
    {
        return $this->image;
    }

    /**
     * Destroy image and free memory
     */
    public function destroy(): void
    {
        if ($this->image) {
            $this->image->clear();
            $this->image->destroy();
            $this->image = null;
        }
    }

    /**
     * Clone image
     */
    public function clone(): static
    {
        $cloned = new static();
        if ($this->image) {
            $cloned->image = clone $this->image;
            $cloned->format = $this->format;
        }
        return $cloned;
    }

    /**
     * Check if Imagick is available
     */
    public static function isAvailable(): bool
    {
        return extension_loaded('imagick') && class_exists('Imagick');
    }

    /**
     * Destructor - clean up resources
     */
    public function __destruct()
    {
        $this->destroy();
    }
}
