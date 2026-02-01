# File Uploads & Image Processing

Complete guide to file uploads, image processing, watermarks, and variant generation.

## Table of Contents

- [Overview](#overview)
- [Quick Start](#quick-start)
- [Configuration](#configuration)
- [Basic Usage](#basic-usage)
- [Image Processing](#image-processing)
- [Watermarks](#watermarks)
- [Image Variants](#image-variants)
- [File Access](#file-access)
- [Advanced Usage](#advanced-usage)
- [Troubleshooting](#troubleshooting)

---

## Overview

The SO Backend Framework provides a comprehensive file upload and image processing system with:

- **Secure File Uploads** - Validation, sanitization, and storage
- **Image Processing** - Resize, crop, rotate, filters using Imagick/GD
- **Watermarks** - Text and image watermarks with full customization
- **Responsive Variants** - Automatic thumbnail and responsive image generation
- **Hybrid Access** - Secure routes + direct URLs for performance
- **Queue Processing** - Async variant/watermark generation
- **Database Tracking** - Complete audit trail of all uploads

---

## Quick Start

### 1. Basic Upload

```php
public function upload(Request $request)
{
// Upload and create database entry
$media = $request->file('image')->storeAndCreate('products');

if ($media) {
return response()->json([
'success' => true,
'url' => $media->url(),
'id' => $media->id
]);
}

return response()->json(['error' => 'Upload failed'], 500);
}
```

### 2. Upload with Variants & Watermark

```php
$media = $request->file('photo')->storeAndCreate('gallery', [
'variants' => true,         // Generate thumbnails
'watermark' => 'copyright'  // Apply watermark preset
]);

// Access URLs
echo $media->url();          // Original
echo $media->url('thumb');   // Thumbnail (150x150)
echo $media->url('medium');  // Medium (640x480)
```

### 3. Manual Control

```php
// Upload without database entry (developer decides)
$result = $request->file('image')->store('products');

if ($result['success']) {
// Custom logic
$product = Product::create([
'name' => $request->input('name'),
'image_url' => $result['url'],
'image_path' => $result['path']
]);
}
```

---

## Configuration

### Environment Variables

Add to your `.env`:

```env
# Media Storage
MEDIA_PATH=/var/www/html/rpkfiles
MEDIA_URL=/media
MEDIA_DISK=media
MEDIA_MAX_SIZE=10240          # 10MB in KB

# Queue Processing
MEDIA_QUEUE_ENABLED=true
MEDIA_QUEUE_CONNECTION=database

# Image Processing
IMAGE_DRIVER=imagick          # imagick or gd
WATERMARK_ENABLED=false
```

### Configuration File

Edit `config/media.php` for advanced settings:

```php
return [
// Storage paths
'path' => env('MEDIA_PATH', '/var/www/html/rpkfiles'),
'url' => env('MEDIA_URL', '/media'),

// Image variants (responsive sizes)
'variants' => [
'thumb' => [
'width' => 150,
'height' => 150,
'mode' => 'crop',
'quality' => 80,
],
'small' => [
'width' => 320,
'height' => 240,
'mode' => 'fit',
'quality' => 82,
],
// ... more variants
],

// Watermark presets
'watermark' => [
'presets' => [
'copyright' => [
'text' => '© 2026 ' . env('APP_NAME'),
'position' => 'bottom-right',
'opacity' => 60,
],
],
],
];
```

---

## Basic Usage

### Upload Methods

#### storeAndCreate() - Automatic DB Entry

Best for: Simple uploads where you want automatic database tracking.

```php
$media = $request->file('image')->storeAndCreate('folder', [
'filename' => 'custom-name.jpg',  // Optional
'variants' => true,                // Generate variants
'watermark' => 'copyright',        // Apply watermark
]);

if ($media) {
echo $media->url();  // https://yoursite.com/rpkfiles/folder/file.jpg
}
```

#### store() - Manual Control

Best for: Custom logic, updating existing records, or no database tracking.

```php
$result = $request->file('image')->store('folder', [
'filename' => 'custom-name.jpg',
]);

if ($result['success']) {
// You decide what to do with the result
$result['url'];         // Public URL
$result['path'];        // Relative path
$result['filename'];    // Generated filename
$result['size'];        // File size in bytes
$result['mime_type'];   // MIME type
$result['width'];       // Image width (if image)
$result['height'];      // Image height (if image)

// Option 1: Create database entry
$media = Media::create([
'filename' => $result['filename'],
'path' => $result['path'],
// ... other fields
]);

// Option 2: Just use the URL
echo $result['url'];

// Option 3: Update existing record
$product->update(['image_url' => $result['url']]);
}
```

### Folder Organization

```php
// No folder - direct in rpkfiles/
$media->store();  // /rpkfiles/file_abc123.jpg

// With folder structure
$media->store('products');            // /rpkfiles/products/file_abc123.jpg
$media->store('products/featured');   // /rpkfiles/products/featured/file_abc123.jpg
$media->store('users/123/avatars');   // /rpkfiles/users/123/avatars/file_abc123.jpg
```

### Validation

Files are automatically validated for:
- Upload errors
- File size (max from config)
- MIME type (allowed types from config)
- Extension (allowed extensions from config)
- Image verification (for image files)

```php
$result = $request->file('image')->store('folder');

if (!$result['success']) {
// Validation failed
print_r($result['errors']);
// ["File too large: 15.2MB. Maximum allowed: 10MB"]
}
```

---

## Image Processing

### Manual Image Processing

For custom image manipulation:

```php
use Core\Image\ImageProcessor;

$processor = ImageProcessor::create('path/to/image.jpg')
->resize(800, 600, 'crop')      // Resize with mode
->rotate(90)                     // Rotate 90 degrees
->grayscale()                    // Convert to grayscale
->sharpen(20)                    // Sharpen image
->optimize()                     // Optimize file size
->save('output.jpg', 85);        // Save with 85% quality
```

### Resize Modes

```php
// Fit - maintain aspect ratio, fit within bounds
$processor->resize(800, 600, 'fit');

// Crop - exact size, crop to fit
$processor->resize(800, 600, 'crop');

// Stretch - exact size, may distort
$processor->resize(800, 600, 'stretch');
```

### Filters & Effects

```php
$processor = ImageProcessor::create('photo.jpg')
->blur(10)              // Blur (0-100)
->brightness(20)        // Brightness (-100 to 100)
->contrast(-10)         // Contrast (-100 to 100)
->grayscale()           // Convert to grayscale
->sharpen(15)           // Sharpen (0-100)
->save('processed.jpg');
```

### Rotation & Flipping

```php
$processor = ImageProcessor::create('photo.jpg')
->rotate(45, [255, 255, 255, 0])  // Rotate 45° with white background
->flipHorizontal()                 // Mirror horizontally
->flipVertical()                   // Mirror vertically
->save('flipped.jpg');
```

---

## Watermarks

### Using Presets

Presets are defined in `config/media.php`:

```php
$media = $request->file('image')->storeAndCreate('photos', [
'watermark' => 'copyright'  // Use preset
]);
```

### Custom Text Watermark

```php
use Core\Image\ImageProcessor;

$processor = ImageProcessor::create('photo.jpg')
->watermark([
'text' => '© 2026 My Company',
'position' => 'bottom-right',  // 9 presets available
'font_size' => 16,
'color' => '#FFFFFF',
'opacity' => 70,
'rotation' => -45,
'margin' => 20
])
->save('watermarked.jpg');
```

### Image Watermark

```php
$processor = ImageProcessor::create('photo.jpg')
->watermark([
'image' => 'path/to/logo.png',
'position' => 'center',
'opacity' => 50,
'width' => 200,
'height' => 100
])
->save('watermarked.jpg');
```

### Available Positions

- `top-left`, `top-center`, `top-right`
- `center-left`, `center`, `center-right`
- `bottom-left`, `bottom-center`, `bottom-right`
- Custom: `['x' => 100, 'y' => 200]`

### Defining Presets

In `config/media.php`:

```php
'watermark' => [
'presets' => [
'copyright' => [
'text' => '© 2026 ' . env('APP_NAME'),
'position' => 'bottom-right',
'opacity' => 60,
'font_size' => 14,
'color' => '#FFFFFF',
],
'draft' => [
'text' => 'DRAFT',
'position' => 'center',
'opacity' => 30,
'font_size' => 72,
'color' => '#FF0000',
'rotation' => -45,
],
],
],
```

---

## Image Variants

### Automatic Generation

Variants are generated automatically when using `storeAndCreate()`:

```php
$media = $request->file('image')->storeAndCreate('products', [
'variants' => true  // Generate all configured variants
]);

// Access variant URLs
echo $media->url();          // Original
echo $media->url('thumb');   // 150x150 thumbnail
echo $media->url('small');   // 320x240
echo $media->url('medium');  // 640x480
echo $media->url('large');   // 1024x768
```

### Variant Configuration

Edit `config/media.php`:

```php
'variants' => [
'thumb' => [
'width' => 150,
'height' => 150,
'mode' => 'crop',      // Exact size, cropped
'quality' => 80,
],
'small' => [
'width' => 320,
'height' => 240,
'mode' => 'fit',       // Fit within bounds
'quality' => 82,
],
'custom' => [
'width' => 500,
'height' => 500,
'mode' => 'fit',
'quality' => 90,
'optimize' => true,
],
],
```

### Manual Variant Generation

```php
use Core\Image\VariantGenerator;

$generator = new VariantGenerator();

// Generate all configured variants
$variants = $generator->generateAll($mediaId);

// Generate specific variants
$variants = $generator->generate($mediaId, ['thumb', 'medium']);

// Regenerate (delete old, create new)
$variants = $generator->regenerateAll($mediaId);

// On-demand generation
$thumbPath = $generator->generateOnDemand($mediaId, 'thumb');
```

### Naming Convention

Variants are stored alongside the original with suffix naming:

```
/rpkfiles/products/photo.jpg              -> Original
/rpkfiles/products/photo_thumb.jpg        -> Thumbnail
/rpkfiles/products/photo_small.jpg        -> Small
/rpkfiles/products/photo_medium.jpg       -> Medium
/rpkfiles/products/photo_large.jpg        -> Large
```

---

## File Access

### Direct URL Access (Public Files)

For best performance, files stored in `/var/www/html/rpkfiles/` are accessible directly:

```html
<img src="https://yoursite.com/rpkfiles/products/image.jpg">
<img src="https://yoursite.com/rpkfiles/products/image_thumb.jpg">
```

### Secure Route Access (Private Files)

For authenticated access with authorization:

```php
// View file
route('files.show', ['id' => $media->id])
// https://yoursite.com/files/123/view

// Download file
route('files.download', ['id' => $media->id])
// https://yoursite.com/files/123/download
```

### API Endpoints

```
GET    /files              # List files (paginated)
POST   /files/upload       # Upload file
GET    /files/{id}         # Get file details
GET    /files/{id}/view    # View/serve file
GET    /files/{id}/download # Download file
DELETE /files/{id}         # Delete file
```

---

## Advanced Usage

### Multiple File Upload

```php
public function uploadMultiple(Request $request)
{
$files = $request->file('images'); // Array of files
$uploaded = [];

foreach ($files as $file) {
$media = $file->storeAndCreate('gallery');
if ($media) {
$uploaded[] = $media;
}
}

return response()->json([
'count' => count($uploaded),
'files' => array_map(fn($m) => $m->toArray(), $uploaded)
]);
}
```

### Polymorphic Attachments

Attach files to any model:

```php
// In your model
use App\Traits\HasAttachments;

class Product extends Model
{
use HasAttachments;
}

// Attach media
$product->attach($media, 'featured_image');
$product->attach($media, 'gallery');

// Get attachments
$featured = $product->attachment('featured_image');
$gallery = $product->attachments('gallery');
```

### Using Services

Access services via dependency injection:

```php
use Core\Media\FileUploadManager;
use Core\Image\VariantGenerator;

public function __construct(
private FileUploadManager $uploader,
private VariantGenerator $generator
) {}

public function process()
{
// Use services
$result = $this->uploader->upload($file);
$variants = $this->generator->generateAll($mediaId);
}
```

### Queue Processing

Variant generation and watermarks are processed asynchronously:

```bash
# Start queue worker
php artisan queue:work

# Monitor queue
php artisan queue:status
```

---

## Troubleshooting

### Upload Fails

**Issue:** Files not uploading

**Check:**
1. PHP upload limits in `php.ini`:
   ```ini
upload_max_filesize = 10M
post_max_size = 10M
   ```

2. Directory permissions:
   ```bash
chmod 755 /var/www/html/rpkfiles
chown www-data:www-data /var/www/html/rpkfiles
   ```

3. Validation errors:
   ```php
$result = $file->store('folder');
if (!$result['success']) {
    print_r($result['errors']);
}
   ```

### Variants Not Generated

**Issue:** Thumbnails not appearing

**Check:**
1. Queue is running:
   ```bash
php artisan queue:work
   ```

2. Image extensions installed:
   ```bash
php -m | grep -i imagick
php -m | grep -i gd
   ```

3. Manually generate:
   ```php
$generator = new VariantGenerator();
$generator->generateAll($mediaId);
   ```

### Watermarks Not Applied

**Issue:** Watermarks not showing

**Check:**
1. Watermark enabled:
   ```env
WATERMARK_ENABLED=true
   ```

2. Queue is running

3. Font path exists (for text watermarks):
   ```bash
ls -la /usr/share/fonts/truetype/dejavu/DejaVuSans.ttf
   ```

### Out of Memory

**Issue:** Image processing fails on large files

**Solution:**
1. Increase PHP memory:
   ```ini
memory_limit = 256M
   ```

2. Use smaller variants:
   ```php
'variants' => [
    'thumb' => ['width' => 100, 'height' => 100],
]
   ```

---

## Best Practices

1. **Use Folders** - Organize files by type/purpose
   ```php
'products/featured'
'users/avatars'
'documents/invoices'
   ```

2. **Enable Variants** - For responsive images
   ```php
'variants' => true
   ```

3. **Optimize Images** - Reduce file size
   ```php
ImageProcessor::create($path)->optimize()->save($path);
   ```

4. **Use Queue** - Don't block uploads
   ```env
MEDIA_QUEUE_ENABLED=true
   ```

5. **Validate Before Upload** - Check file type/size
   ```php
if (!$file->isValid()) {
    return error($file->getErrorMessage());
}
   ```

6. **Clean Up** - Delete unused files
   ```php
$media->deleteFile();  // Deletes file + variants
   ```

---

## Summary

The media system provides:
- Secure file uploads with validation
- Automatic image processing and variants
- Flexible watermarking system
- Database tracking and audit trail
- Queue-based async processing
- Hybrid access (secure + direct URLs)
- Developer-friendly API

For API reference and advanced topics, see [Media API Documentation](../api/media-api.md).
