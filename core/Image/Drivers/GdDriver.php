<?php

namespace Core\Image\Drivers;

use Core\Image\Contracts\ImageDriver;
use App\Constants\ImageConstants;
use GdImage;

/**
 * GdDriver
 *
 * Image manipulation driver using PHP GD extension.
 * Fallback driver with basic feature support.
 *
 * Requirements:
 * - PHP GD extension (already installed: 2.3.3)
 *
 * Features:
 * - Basic image manipulation
 * - Resizing and cropping
 * - Text and image watermarks
 * - Format conversion (JPEG, PNG, WebP, GIF)
 *
 * Limitations compared to Imagick:
 * - Less sophisticated resizing algorithms
 * - Limited filter support
 * - No built-in optimization
 */
class GdDriver implements ImageDriver
{
    /**
     * GD image resource
     */
    protected ?GdImage $image = null;

    /**
     * Image format
     */
    protected string $format = 'jpeg';

    /**
     * Original image path
     */
    protected ?string $originalPath = null;

    /**
     * Load image from file path
     */
    public function load(string $path): bool
    {
        try {
            $this->originalPath = $path;
            $imageInfo = getimagesize($path);

            if ($imageInfo === false) {
                return false;
            }

            $this->image = match ($imageInfo[2]) {
                IMAGETYPE_JPEG => imagecreatefromjpeg($path),
                IMAGETYPE_PNG => imagecreatefrompng($path),
                IMAGETYPE_GIF => imagecreatefromgif($path),
                IMAGETYPE_WEBP => imagecreatefromwebp($path),
                default => false,
            };

            if ($this->image === false) {
                return false;
            }

            // Set format
            $this->format = ImageConstants::getExtension($imageInfo['mime']);

            // Preserve transparency for PNG and GIF
            if (in_array($imageInfo[2], [IMAGETYPE_PNG, IMAGETYPE_GIF])) {
                $this->preserveTransparency();
            }

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
            $this->image = imagecreatetruecolor($width, $height);

            if ($this->image === false) {
                return false;
            }

            // Set background color
            $color = imagecolorallocatealpha(
                $this->image,
                $background[0],
                $background[1],
                $background[2],
                127 - (int)(($background[3] ?? 0) * 1.27)
            );

            imagefill($this->image, 0, 0, $color);
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

            $format = $format ?? $this->format;

            $result = match ($format) {
                'jpeg', 'jpg' => imagejpeg($this->image, $path, $quality),
                'png' => imagepng($this->image, $path, (int)(9 - ($quality / 11))),
                'webp' => imagewebp($this->image, $path, $quality),
                'gif' => imagegif($this->image, $path),
                default => false,
            };

            if ($result) {
                $this->format = $format;
            }

            return $result;
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

            $currentWidth = imagesx($this->image);
            $currentHeight = imagesy($this->image);

            switch ($mode) {
                case ImageConstants::RESIZE_FIT:
                    // Fit within bounds, maintain aspect ratio
                    [$newWidth, $newHeight] = $this->calculateFitDimensions(
                        $currentWidth, $currentHeight, $width, $height
                    );
                    break;

                case ImageConstants::RESIZE_CROP:
                    // Crop to exact size
                    return $this->cropToSize($width, $height);

                case ImageConstants::RESIZE_STRETCH:
                    // Stretch to fill
                    $newWidth = $width;
                    $newHeight = $height;
                    break;

                default:
                    [$newWidth, $newHeight] = $this->calculateFitDimensions(
                        $currentWidth, $currentHeight, $width, $height
                    );
            }

            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            $this->preserveTransparency($newImage);

            imagecopyresampled(
                $newImage, $this->image,
                0, 0, 0, 0,
                $newWidth, $newHeight,
                $currentWidth, $currentHeight
            );

            imagedestroy($this->image);
            $this->image = $newImage;

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

            $newImage = imagecreatetruecolor($width, $height);
            $this->preserveTransparency($newImage);

            imagecopy($newImage, $this->image, 0, 0, $x, $y, $width, $height);

            imagedestroy($this->image);
            $this->image = $newImage;

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

            $bgColor = imagecolorallocatealpha(
                $this->image,
                $background[0],
                $background[1],
                $background[2],
                127 - (int)(($background[3] ?? 0) * 1.27)
            );

            $rotated = imagerotate($this->image, -$angle, $bgColor);

            if ($rotated === false) {
                return false;
            }

            imagedestroy($this->image);
            $this->image = $rotated;

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

            imageflip($this->image, IMG_FLIP_HORIZONTAL);
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

            imageflip($this->image, IMG_FLIP_VERTICAL);
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

            $fontSize = $options['font_size'] ?? 14;
            $fontPath = $options['font_path'] ?? null;
            $color = $options['color'] ?? [255, 255, 255, 255];
            $opacity = ($options['opacity'] ?? 100);

            // Convert opacity (0-100) to alpha (0-127)
            $alpha = 127 - (int)(($opacity / 100) * 127);

            $textColor = imagecolorallocatealpha(
                $this->image,
                $color[0],
                $color[1],
                $color[2],
                $alpha
            );

            // Add text (with or without TTF font)
            if ($fontPath && file_exists($fontPath)) {
                $rotation = $options['rotation'] ?? 0;
                imagettftext($this->image, $fontSize, -$rotation, $x, $y, $textColor, $fontPath, $text);
            } else {
                imagestring($this->image, 5, $x, $y, $text, $textColor);
            }

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

            $watermark = $this->loadWatermark($watermarkPath);
            if (!$watermark) {
                return false;
            }

            // Resize watermark if needed
            if (isset($options['width'], $options['height'])) {
                $watermark = $this->resizeWatermark($watermark, $options['width'], $options['height']);
            }

            // Apply opacity
            if (isset($options['opacity']) && $options['opacity'] < 100) {
                $this->applyWatermarkOpacity($watermark, $options['opacity']);
            }

            // Copy watermark onto image
            imagecopy(
                $this->image,
                $watermark,
                $x,
                $y,
                0,
                0,
                imagesx($watermark),
                imagesy($watermark)
            );

            imagedestroy($watermark);

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

            for ($i = 0; $i < $amount; $i++) {
                imagefilter($this->image, IMG_FILTER_GAUSSIAN_BLUR);
            }

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

            imagefilter($this->image, IMG_FILTER_BRIGHTNESS, $level);
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

            imagefilter($this->image, IMG_FILTER_CONTRAST, -$level);
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

            imagefilter($this->image, IMG_FILTER_GRAYSCALE);
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

            // Create sharpen matrix
            $matrix = [
                [-1, -1, -1],
                [-1, 16, -1],
                [-1, -1, -1],
            ];

            imageconvolution($this->image, $matrix, 8, 0);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Optimize image (limited in GD)
     */
    public function optimize(): bool
    {
        // GD doesn't have built-in optimization
        // This is a no-op that returns true for interface compatibility
        return true;
    }

    /**
     * Get image width
     */
    public function getWidth(): int
    {
        return $this->image ? imagesx($this->image) : 0;
    }

    /**
     * Get image height
     */
    public function getHeight(): int
    {
        return $this->image ? imagesy($this->image) : 0;
    }

    /**
     * Get image MIME type
     */
    public function getMimeType(): string
    {
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
     * Get underlying GD resource
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
            imagedestroy($this->image);
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
            $width = imagesx($this->image);
            $height = imagesy($this->image);

            $cloned->image = imagecreatetruecolor($width, $height);
            $this->preserveTransparency($cloned->image);
            imagecopy($cloned->image, $this->image, 0, 0, 0, 0, $width, $height);
            $cloned->format = $this->format;
        }
        return $cloned;
    }

    /**
     * Check if GD is available
     */
    public static function isAvailable(): bool
    {
        return extension_loaded('gd') && function_exists('imagecreatetruecolor');
    }

    /**
     * Preserve transparency for PNG/GIF
     */
    protected function preserveTransparency(?GdImage $image = null): void
    {
        $target = $image ?? $this->image;
        if (!$target) {
            return;
        }

        imagealphablending($target, false);
        imagesavealpha($target, true);
    }

    /**
     * Calculate fit dimensions maintaining aspect ratio
     */
    protected function calculateFitDimensions(int $currentWidth, int $currentHeight, int $maxWidth, int $maxHeight): array
    {
        $ratio = min($maxWidth / $currentWidth, $maxHeight / $currentHeight);
        return [
            (int)($currentWidth * $ratio),
            (int)($currentHeight * $ratio),
        ];
    }

    /**
     * Crop to exact size from center
     */
    protected function cropToSize(int $width, int $height): bool
    {
        $currentWidth = imagesx($this->image);
        $currentHeight = imagesy($this->image);

        // Calculate crop position (center)
        $ratio = max($width / $currentWidth, $height / $currentHeight);
        $newWidth = (int)($currentWidth * $ratio);
        $newHeight = (int)($currentHeight * $ratio);

        // Create resized image
        $resized = imagecreatetruecolor($newWidth, $newHeight);
        $this->preserveTransparency($resized);
        imagecopyresampled($resized, $this->image, 0, 0, 0, 0, $newWidth, $newHeight, $currentWidth, $currentHeight);

        // Crop from center
        $cropX = ($newWidth - $width) / 2;
        $cropY = ($newHeight - $height) / 2;

        $cropped = imagecreatetruecolor($width, $height);
        $this->preserveTransparency($cropped);
        imagecopy($cropped, $resized, 0, 0, (int)$cropX, (int)$cropY, $width, $height);

        imagedestroy($resized);
        imagedestroy($this->image);
        $this->image = $cropped;

        return true;
    }

    /**
     * Load watermark image
     */
    protected function loadWatermark(string $path): GdImage|false
    {
        $imageInfo = @getimagesize($path);
        if ($imageInfo === false) {
            return false;
        }

        return match ($imageInfo[2]) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($path),
            IMAGETYPE_PNG => imagecreatefrompng($path),
            IMAGETYPE_GIF => imagecreatefromgif($path),
            IMAGETYPE_WEBP => imagecreatefromwebp($path),
            default => false,
        };
    }

    /**
     * Resize watermark
     */
    protected function resizeWatermark(GdImage $watermark, int $width, int $height): GdImage
    {
        $currentWidth = imagesx($watermark);
        $currentHeight = imagesy($watermark);

        [$newWidth, $newHeight] = $this->calculateFitDimensions($currentWidth, $currentHeight, $width, $height);

        $resized = imagecreatetruecolor($newWidth, $newHeight);
        $this->preserveTransparency($resized);
        imagecopyresampled($resized, $watermark, 0, 0, 0, 0, $newWidth, $newHeight, $currentWidth, $currentHeight);

        imagedestroy($watermark);
        return $resized;
    }

    /**
     * Apply opacity to watermark
     */
    protected function applyWatermarkOpacity(GdImage $watermark, int $opacity): void
    {
        $opacity = max(0, min(100, $opacity));
        imagefilter($watermark, IMG_FILTER_COLORIZE, 0, 0, 0, 127 - (int)(($opacity / 100) * 127));
    }

    /**
     * Destructor - clean up resources
     */
    public function __destruct()
    {
        $this->destroy();
    }
}
