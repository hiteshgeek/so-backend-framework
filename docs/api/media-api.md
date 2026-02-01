# Media API Reference

Complete API documentation for file uploads, image processing, and media management.

## Table of Contents

- [Core Classes](#core-classes)
- [UploadedFile](#uploadedfile)
- [FileUploadManager](#fileuploadmanager)
- [StorageManager](#storagemanager)
- [ImageProcessor](#imageprocessor)
- [WatermarkService](#watermarkservice)
- [VariantGenerator](#variantgenerator)
- [Media Model](#media-model)
- [Queue Jobs](#queue-jobs)
- [Constants](#constants)

---

## Core Classes

### Architecture Overview

```
Request
+--> UploadedFile
+--> FileUploadManager
|    +--> FileValidator
|    +--> StorageManager
+--> Media Model
+--> VariantGenerator
|    +--> ImageProcessor
+--> WatermarkService
+--> ImageProcessor
```

---

## UploadedFile

**Namespace:** `Core\Http\UploadedFile`

Wrapper for uploaded files with media integration.

### Methods

#### store()

Upload file and return result without DB entry.

```php
public function store(?string $folder = null, array $options = []): array
```

**Parameters:**
- `$folder` - Optional folder path (e.g., 'products/featured')
- `$options` - Upload options

**Options:**
- `filename` (string) - Custom filename
- `disk` (string) - Storage disk name

**Returns:** Array with keys:
- `success` (bool) - Upload status
- `filename` (string) - Generated filename
- `original_name` (string) - Original filename
- `path` (string) - Relative path from media root
- `full_path` (string) - Full filesystem path
- `url` (string) - Public URL
- `size` (int) - File size in bytes
- `mime_type` (string) - MIME type
- `width` (int|null) - Image width
- `height` (int|null) - Image height
- `disk` (string) - Storage disk
- `error` (string) - Error message if failed
- `errors` (array) - Validation errors if failed

**Example:**
```php
$result = $request->file('image')->store('products', [
'filename' => 'product-123.jpg'
]);

if ($result['success']) {
$url = $result['url'];
$path = $result['path'];
}
```

#### storeAndCreate()

Upload file and create Media model automatically.

```php
public function storeAndCreate(?string $folder = null, array $options = []): ?Media
```

**Parameters:**
- `$folder` - Optional folder path
- `$options` - Upload options

**Options:**
- `filename` (string) - Custom filename
- `disk` (string) - Storage disk
- `variants` (bool) - Generate variants (default: true)
- `watermark` (string|array) - Watermark preset or config

**Returns:** Media model or null if failed

**Example:**
```php
$media = $request->file('image')->storeAndCreate('products', [
'variants' => true,
'watermark' => 'copyright'
]);

if ($media) {
echo $media->url();
}
```

#### Other Methods

```php
public function isValid(): bool
public function getClientOriginalName(): string
public function getSize(): int
public function getMimeType(): string
public function getExtension(): string
public function getFileData(): array
public function getTemporaryPath(): string
public function isImage(): bool
public function getError(): int
public function getErrorMessage(): string
```

---

## FileUploadManager

**Namespace:** `Core\Media\FileUploadManager`

Central orchestrator for file uploads.

### Methods

#### upload()

Upload file with validation - returns result without DB entry.

```php
public function upload(array $file, array $options = []): array
```

**Parameters:**
- `$file` - $_FILES array element
- `$options` - Upload options (see UploadedFile::store)

**Returns:** Upload result array

**Example:**
```php
$manager = new FileUploadManager();
$result = $manager->upload($_FILES['image'], ['folder' => 'products']);
```

#### uploadAndCreate()

Upload file and create Media model.

```php
public function uploadAndCreate(array $file, array $options = []): ?Media
```

**Example:**
```php
$media = $manager->uploadAndCreate($_FILES['image'], [
'folder' => 'products',
'variants' => true,
'watermark' => 'copyright'
]);
```

#### uploadMultiple()

Upload multiple files.

```php
public function uploadMultiple(array $files, array $options = []): array
```

**Returns:** Array of upload results

#### uploadMultipleAndCreate()

Upload multiple files and create Media models.

```php
public function uploadMultipleAndCreate(array $files, array $options = []): array
```

**Returns:** Array of Media models (nulls for failed uploads)

#### deleteMedia()

Delete file and database record.

```php
public function deleteMedia(int $mediaId): bool
```

---

## StorageManager

**Namespace:** `Core\Media\StorageManager`

Handles file storage operations.

### Methods

#### store()

Store file with optional folder structure.

```php
public function store(
string $sourcePath,
?string $folder = null,
?string $filename = null,
?string $disk = null
): array
```

**Parameters:**
- `$sourcePath` - Source file path (temp upload path)
- `$folder` - Optional folder (e.g., 'products/featured')
- `$filename` - Optional custom filename
- `$disk` - Storage disk name

**Returns:** Array with success status and file info

#### getUrl()

Get public URL for file.

```php
public function getUrl(string $path, ?string $disk = null): string
```

**Example:**
```php
$url = $storage->getUrl('products/image.jpg');
// https://yoursite.com/rpkfiles/products/image.jpg
```

#### getPath()

Get full filesystem path.

```php
public function getPath(string $relativePath, ?string $disk = null): string
```

#### delete()

Delete file from storage.

```php
public function delete(string $relativePath, ?string $disk = null): bool
```

#### exists()

Check if file exists.

```php
public function exists(string $relativePath, ?string $disk = null): bool
```

#### move() / copy()

Move or copy file.

```php
public function move(string $fromPath, string $toPath, ?string $disk = null): bool
public function copy(string $fromPath, string $toPath, ?string $disk = null): bool
```

#### size() / mimeType()

Get file metadata.

```php
public function size(string $relativePath, ?string $disk = null): int|false
public function mimeType(string $relativePath, ?string $disk = null): string|false
```

---

## ImageProcessor

**Namespace:** `Core\Image\ImageProcessor`

Main facade for image manipulation with fluent interface.

### Static Constructors

#### create()

Load image from file.

```php
public static function create(string $path, ?string $driver = null): static
```

**Throws:** `RuntimeException` if image cannot be loaded

**Example:**
```php
$processor = ImageProcessor::create('photo.jpg');
```

#### make()

Create blank image.

```php
public static function make(
int $width,
int $height,
array $background = [255, 255, 255, 0],
?string $driver = null
): static
```

**Example:**
```php
$processor = ImageProcessor::make(800, 600, [255, 255, 255, 0]);
```

### Manipulation Methods

All methods return `$this` for method chaining.

#### resize()

Resize image.

```php
public function resize(int $width, int $height, string $mode = 'fit'): static
```

**Modes:**
- `fit` - Fit within bounds, maintain aspect ratio
- `crop` - Crop to exact size
- `stretch` - Stretch to fill (may distort)

**Example:**
```php
$processor->resize(800, 600, 'crop');
```

#### crop()

Crop image region.

```php
public function crop(int $x, int $y, int $width, int $height): static
```

#### rotate()

Rotate image.

```php
public function rotate(float $angle, array $background = [255, 255, 255, 0]): static
```

#### flipHorizontal() / flipVertical()

Flip image.

```php
public function flipHorizontal(): static
public function flipVertical(): static
```

#### watermark()

Apply watermark (text or image).

```php
public function watermark(array|string $config): static
```

**Config (Text):**
```php
[
'text' => '© 2026',
'position' => 'bottom-right',
'font_size' => 16,
'color' => '#FFFFFF',
'opacity' => 70,
'rotation' => -45,
'margin' => 10
]
```

**Config (Image):**
```php
[
'image' => 'logo.png',
'position' => 'center',
'opacity' => 50,
'width' => 200,
'height' => 100
]
```

#### Filters

Apply image filters.

```php
public function blur(int $amount): static           // 0-100
public function brightness(int $level): static      // -100 to 100
public function contrast(int $level): static        // -100 to 100
public function grayscale(): static
public function sharpen(int $amount): static        // 0-100
public function optimize(): static
```

### Output Methods

#### save()

Save image to file.

```php
public function save(string $path, int $quality = 85, ?string $format = null): string
```

**Parameters:**
- `$path` - Destination path
- `$quality` - Quality (0-100)
- `$format` - Output format (jpeg, png, webp, gif)

**Returns:** Saved file path

**Example:**
```php
$processor->save('output.jpg', 90, 'jpeg');
```

### Info Methods

```php
public function getWidth(): int
public function getHeight(): int
public function getDimensions(): array      // ['width' => int, 'height' => int]
public function getFormat(): string
public function getMimeType(): string
public function getDriver(): ImageDriver
```

### Utility Methods

```php
public function clone(): static
```

### Full Example

```php
$processor = ImageProcessor::create('input.jpg')
->resize(1200, 800, 'crop')
->watermark([
'text' => '© 2026 Company',
'position' => 'bottom-right',
'opacity' => 70
])
->sharpen(15)
->optimize()
->save('output.jpg', 85);
```

---

## WatermarkService

**Namespace:** `Core\Image\WatermarkService`

Applies watermarks to images.

### Methods

#### apply()

Apply watermark to image.

```php
public function apply(ImageDriver $driver, array|string $config): bool
```

**Parameters:**
- `$driver` - ImageDriver instance
- `$config` - Watermark config array or preset name

**Example:**
```php
$watermark = new WatermarkService();
$watermark->apply($processor->getDriver(), 'copyright');
```

#### setDefaultFont() / getDefaultFont()

Manage default font for text watermarks.

```php
public function setDefaultFont(string $path): void
public function getDefaultFont(): ?string
```

### Position Constants

Available via `ImageConstants`:
- `POSITION_TOP_LEFT`
- `POSITION_TOP_CENTER`
- `POSITION_TOP_RIGHT`
- `POSITION_CENTER_LEFT`
- `POSITION_CENTER`
- `POSITION_CENTER_RIGHT`
- `POSITION_BOTTOM_LEFT`
- `POSITION_BOTTOM_CENTER`
- `POSITION_BOTTOM_RIGHT`

---

## VariantGenerator

**Namespace:** `Core\Image\VariantGenerator`

Generates image variants (thumbnails, responsive sizes).

### Methods

#### generateAll()

Generate all configured variants.

```php
public function generateAll(int $mediaId): array
```

**Returns:** Array of generated variant paths indexed by variant name

**Example:**
```php
$generator = new VariantGenerator();
$variants = $generator->generateAll($mediaId);
// ['thumb' => 'products/image_thumb.jpg', 'small' => '...']
```

#### generate()

Generate specific variants.

```php
public function generate(int $mediaId, array $variantNames): array
```

**Example:**
```php
$variants = $generator->generate($mediaId, ['thumb', 'medium']);
```

#### regenerateAll()

Delete and regenerate all variants.

```php
public function regenerateAll(int $mediaId): array
```

#### deleteVariants()

Delete all variants for a media file.

```php
public function deleteVariants(int $mediaId): bool
```

#### variantExists()

Check if variant exists.

```php
public function variantExists(int $mediaId, string $variantName): bool
```

#### getVariants()

Get all variants for a media file.

```php
public function getVariants(int $mediaId): array
```

**Returns:** Array of Media models indexed by variant name

#### getVariant()

Get specific variant.

```php
public function getVariant(int $mediaId, string $variantName): ?Media
```

#### generateOnDemand()

Generate variant if not exists.

```php
public function generateOnDemand(int $mediaId, string $variantName): ?string
```

#### getConfiguredVariants()

Get all variant names from config.

```php
public function getConfiguredVariants(): array
```

#### getVariantConfig()

Get variant configuration.

```php
public function getVariantConfig(string $variantName): ?array
```

---

## Media Model

**Namespace:** `App\Models\Media`

Eloquent model for uploaded files.

### Properties

```php
protected array $fillable = [
'filename', 'original_name', 'path', 'disk', 'mime_type',
'size', 'width', 'height', 'parent_id', 'metadata'
];

protected array $casts = [
'metadata' => 'array',
'size' => 'int',
'width' => 'int',
'height' => 'int',
'parent_id' => 'int',
];
```

### Methods

#### url()

Get public URL.

```php
public function url(?string $variant = null): string
```

**Example:**
```php
$media->url();          // Original
$media->url('thumb');   // Thumbnail variant
```

#### variants()

Get all variants.

```php
public function variants(): array
```

**Returns:** Array of Media models

#### parent()

Get parent media (if variant).

```php
public function parent(): ?Media
```

#### isVariant()

Check if this is a variant.

```php
public function isVariant(): bool
```

#### isImage()

Check if file is an image.

```php
public function isImage(): bool
```

#### getHumanSize()

Get file size in human-readable format.

```php
public function getHumanSize(): string
```

**Example:**
```php
$media->getHumanSize(); // "2.5 MB"
```

#### getExtension()

Get file extension.

```php
public function getExtension(): string
```

#### getFullPath()

Get full filesystem path.

```php
public function getFullPath(): string
```

#### fileExists()

Check if file exists on disk.

```php
public function fileExists(): bool
```

#### deleteFile()

Delete file, variants, and records.

```php
public function deleteFile(): bool
```

#### getDimensions()

Get image dimensions.

```php
public function getDimensions(): ?array
```

**Returns:** `['width' => int, 'height' => int]` or null

#### getAspectRatio()

Get image aspect ratio.

```php
public function getAspectRatio(): ?float
```

#### hasVariant()

Check if variant exists.

```php
public function hasVariant(string $variant): bool
```

#### getAllVariantUrls()

Get all variant URLs.

```php
public function getAllVariantUrls(): array
```

**Returns:** Associative array of variant name => URL

#### updateMetadata() / getMetadata()

Manage metadata.

```php
public function updateMetadata(array $data): bool
public function getMetadata(string $key, mixed $default = null): mixed
```

#### toArray()

Convert to array for JSON.

```php
public function toArray(): array
```

**Includes:**
- All database fields
- `url` - Public URL
- `human_size` - Formatted file size
- `extension` - File extension
- `is_image` - Whether file is image
- `dimensions` - Image dimensions (if image)
- `aspect_ratio` - Aspect ratio (if image)
- `variant_urls` - Available variant URLs

---

## Queue Jobs

### GenerateImageVariants

**Namespace:** `App\Jobs\Image\GenerateImageVariants`

Generates image variants asynchronously.

```php
new GenerateImageVariants(int $mediaId, ?array $variants = null)
```

**Properties:**
- Queue: `media`
- Timeout: 300 seconds
- Retries: 3

**Example:**
```php
use App\Jobs\Image\GenerateImageVariants;

$queue->push(new GenerateImageVariants($mediaId));
$queue->push(new GenerateImageVariants($mediaId, ['thumb', 'medium']));
```

### ApplyWatermark

**Namespace:** `App\Jobs\Image\ApplyWatermark`

Applies watermark asynchronously.

```php
new ApplyWatermark(
int $mediaId,
string|array $watermark,
bool $inPlace = true,
bool $applyToVariants = false
)
```

**Properties:**
- Queue: `media`
- Timeout: 300 seconds
- Retries: 3

**Example:**
```php
use App\Jobs\Image\ApplyWatermark;

$queue->push(new ApplyWatermark($mediaId, 'copyright'));
$queue->push(new ApplyWatermark($mediaId, [
'text' => '© 2026',
'position' => 'bottom-right'
], true, true));
```

---

## Constants

### ImageConstants

**Namespace:** `App\Constants\ImageConstants`

#### Position Constants

```php
const POSITION_TOP_LEFT = 'top-left';
const POSITION_TOP_CENTER = 'top-center';
const POSITION_TOP_RIGHT = 'top-right';
const POSITION_CENTER_LEFT = 'center-left';
const POSITION_CENTER = 'center';
const POSITION_CENTER_RIGHT = 'center-right';
const POSITION_BOTTOM_LEFT = 'bottom-left';
const POSITION_BOTTOM_CENTER = 'bottom-center';
const POSITION_BOTTOM_RIGHT = 'bottom-right';
```

#### Resize Mode Constants

```php
const RESIZE_FIT = 'fit';
const RESIZE_CROP = 'crop';
const RESIZE_STRETCH = 'stretch';
```

#### Format Constants

```php
const FORMAT_JPEG = 'jpeg';
const FORMAT_PNG = 'png';
const FORMAT_WEBP = 'webp';
const FORMAT_GIF = 'gif';
```

#### Quality Constants

```php
const QUALITY_LOW = 60;
const QUALITY_MEDIUM = 75;
const QUALITY_HIGH = 85;
const QUALITY_MAXIMUM = 95;
const QUALITY_ORIGINAL = 100;
```

#### Variant Constants

```php
const VARIANT_THUMBNAIL = 'thumb';
const VARIANT_SMALL = 'small';
const VARIANT_MEDIUM = 'medium';
const VARIANT_LARGE = 'large';
const VARIANT_ORIGINAL = 'original';
```

#### Optimization Constants

```php
const OPTIMIZE_NONE = 'none';
const OPTIMIZE_BASIC = 'basic';
const OPTIMIZE_AGGRESSIVE = 'aggressive';
```

#### Helper Methods

```php
public static function getAllPositions(): array
public static function getResizeModes(): array
public static function getSupportedFormats(): array
public static function getMimeType(string $format): string
public static function getExtension(string $mimeType): string
public static function getQualityPresets(): array
public static function getVariantNames(): array
public static function getOptimizationStrategies(): array
```

---

## Service Container

Access services via dependency injection or `app()` helper:

```php
// Singletons
$storage = app('storage');              // StorageManager
$uploader = app('uploader');            // FileUploadManager
$validator = app('file.validator');    // FileValidator
$watermark = app('watermark');          // WatermarkService
$generator = app('variant.generator'); // VariantGenerator

// Or via class name
$storage = app(StorageManager::class);
$uploader = app(FileUploadManager::class);

// Factory (new instance each time)
$processor = app(ImageProcessor::class);
```

---

## Error Handling

### Upload Errors

```php
$result = $file->store('folder');

if (!$result['success']) {
// Check for validation errors
if (isset($result['errors'])) {
foreach ($result['errors'] as $error) {
echo $error . "\n";
}
}

// Or single error message
if (isset($result['error'])) {
echo $result['error'];
}
}
```

### Image Processing Errors

```php
try {
$processor = ImageProcessor::create('photo.jpg')
->resize(800, 600)
->save('output.jpg');
} catch (\RuntimeException $e) {
// Handle error
echo "Processing failed: " . $e->getMessage();
}
```

### Queue Job Failures

Jobs automatically retry 3 times and log failures:

```php
// Check metadata for failure info
$media = Media::find($id);
if ($media->getMetadata('variant_generation_failed')) {
$error = $media->getMetadata('variant_generation_error');
echo "Variant generation failed: $error";
}
```

---

## Performance Tips

1. **Use Queue for Variants**
   ```php
MEDIA_QUEUE_ENABLED=true
   ```

2. **Optimize Images**
   ```php
$processor->optimize();
   ```

3. **Use Appropriate Quality**
   ```php
$processor->save('output.jpg', ImageConstants::QUALITY_MEDIUM);
   ```

4. **Generate Variants on Upload**
   ```php
$media = $file->storeAndCreate('folder', ['variants' => true]);
   ```

5. **Use Direct URLs**
   ```html
<img src="{{ $media->url('thumb') }}">
   ```

---

## Testing

See [Test Examples](../tests/media-tests.md) for comprehensive testing guide.

---

## Summary

The Media API provides:
- Complete file upload system
- Fluent image processing interface
- Flexible watermarking
- Automatic variant generation
- Queue-based async processing
- Comprehensive error handling
- Type-safe constants
- Service container integration

For usage examples, see [File Uploads Guide](../features/file-uploads.md).
