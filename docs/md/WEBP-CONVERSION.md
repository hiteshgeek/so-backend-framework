# WebP Auto-Conversion

## Overview

WebP is a modern image format that provides superior compression compared to JPEG and PNG. The framework automatically generates WebP variants for uploaded images, delivering optimized images while maintaining fallbacks for legacy browsers.

## Benefits

- **60-80% smaller** file sizes compared to JPEG
- **30-50% smaller** than PNG for transparent images
- **Faster page loads** - Reduced bandwidth usage
- **Automatic fallback** - Serves original format if WebP not supported
- **Quality preservation** - Maintains visual quality

## Configuration

**config/media.php**

```php
return [
    'webp' => [
        'enabled' => true,
        'quality' => 85, // 1-100 (higher = better quality, larger file)
        'convert_on_upload' => true,
        'generate_variants' => true,
        'preserve_original' => true,
        'supported_sources' => ['jpg', 'jpeg', 'png'],
    ],
];
```

## How It Works

When an image is uploaded:

1. **Original saved** - JPEG/PNG stored normally
2. **WebP generated** - Converted to WebP format
3. **Metadata updated** - WebP path added to database
4. **Responsive delivery** - Server sends WebP if browser supports it

### Storage Structure

```
storage/media/
├── products/
│   ├── product-123.jpg        # Original
│   ├── product-123.webp       # WebP version
│   ├── thumb_product-123.jpg  # Thumbnail
│   └── thumb_product-123.webp # WebP thumbnail
```

## Usage

### Automatic Conversion

```php
use Core\Media\MediaService;

$media = MediaService::upload($file, [
    'disk' => 'public',
    'path' => 'products',
    'generate_webp' => true, // Enabled by default
]);

// Returns:
// $media->path       => 'products/product-123.jpg'
// $media->webp_path  => 'products/product-123.webp'
```

### Manual Conversion

```php
use Core\Media\ImageProcessor;

$processor = new ImageProcessor();

// Convert existing image
$webpPath = $processor->convertToWebP(
    storage_path('media/product.jpg'),
    quality: 85
);

// Output: storage/media/product.webp
```

## Serving WebP Images

### Option 1: Picture Element (Recommended)

```html
<picture>
    <source srcset="<?= $media->webp_url ?>" type="image/webp">
    <source srcset="<?= $media->url ?>" type="image/jpeg">
    <img src="<?= $media->url ?>" alt="Product">
</picture>
```

Browser automatically selects WebP if supported, falls back to JPEG/PNG otherwise.

### Option 2: Content Negotiation

**.htaccess (Apache)**

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTP_ACCEPT} image/webp
    RewriteCond %{REQUEST_FILENAME}.webp -f
    RewriteRule ^(.+)\.(jpe?g|png)$ $1.$2.webp [T=image/webp,E=accept:1,L]
</IfModule>

<IfModule mod_headers.c>
    Header append Vary Accept env=REDIRECT_accept
</IfModule>
```

**nginx**

```nginx
location ~* ^/storage/media/(.+)\.(jpe?g|png)$ {
    set $webp_path /storage/media/$1.$2.webp;

    if ($http_accept ~* "webp") {
        set $webp_accept "true";
    }

    if (-f $webp_path) {
        set $webp_exists "true";
    }

    if ($webp_accept$webp_exists = "truetrue") {
        rewrite ^(.*)$ $webp_path break;
        add_header Content-Type image/webp;
    }
}
```

### Option 3: PHP Helper

```php
// Helper function
function img_webp($media, $alt = '', $class = '')
{
    $webp = $media->webp_url ?? null;
    $fallback = $media->url;

    if ($webp) {
        return "<picture>
            <source srcset=\"$webp\" type=\"image/webp\">
            <img src=\"$fallback\" alt=\"$alt\" class=\"$class\">
        </picture>";
    }

    return "<img src=\"$fallback\" alt=\"$alt\" class=\"$class\">";
}

// Usage
echo img_webp($media, 'Product Image', 'img-fluid');
```

## Batch Conversion

### Convert Existing Images

```bash
# Convert all existing images to WebP
php sixorbit media:webp-convert

# Convert specific directory
php sixorbit media:webp-convert --path=products

# Dry run (preview only)
php sixorbit media:webp-convert --dry-run
```

### Conversion Command

**app/Console/Commands/WebPConvertCommand.php**

```php
class WebPConvertCommand extends Command
{
    protected $signature = 'media:webp-convert {--path=} {--dry-run}';

    public function handle()
    {
        $path = $this->option('path');
        $dryRun = $this->option('dry-run');

        $images = Media::where('mime_type', 'LIKE', 'image/%')
            ->whereNull('webp_path')
            ->when($path, fn($q) => $q->where('path', 'LIKE', "$path%"))
            ->get();

        $this->info("Found {$images->count()} images to convert");

        $processor = new ImageProcessor();
        $bar = $this->output->createProgressBar($images->count());

        foreach ($images as $media) {
            if (!$dryRun) {
                $webpPath = $processor->convertToWebP($media->full_path);
                $media->update(['webp_path' => $webpPath]);
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('✓ Conversion complete!');
    }
}
```

## Quality Settings

### Quality vs File Size

| Quality | Use Case | File Size | Visual Quality |
|---------|----------|-----------|----------------|
| 60-70 | Thumbnails, small icons | Very small | Acceptable |
| 75-85 | Product images, general use | Small | Good |
| 85-90 | Hero images, featured content | Medium | Excellent |
| 90-100 | Photography, detailed images | Large | Lossless |

### Recommended Settings

```php
$processor = new ImageProcessor();

// Thumbnails
$processor->convertToWebP($path, quality: 70);

// Product images
$processor->convertToWebP($path, quality: 85);

// Hero/featured images
$processor->convertToWebP($path, quality: 90);
```

## Responsive WebP Images

### Generate Multiple Sizes

```php
use Core\Media\MediaService;

$media = MediaService::upload($file, [
    'variants' => [
        'thumb' => ['width' => 150, 'height' => 150],
        'medium' => ['width' => 600, 'height' => 400],
        'large' => ['width' => 1200, 'height' => 800],
    ],
    'generate_webp' => true, // WebP for all variants
]);

// Result:
// - product.jpg + product.webp (original)
// - thumb_product.jpg + thumb_product.webp
// - medium_product.jpg + medium_product.webp
// - large_product.jpg + large_product.webp
```

### Responsive Picture Element

```html
<picture>
    <!-- WebP sources -->
    <source media="(min-width: 1200px)"
            srcset="<?= $media->variant('large')->webp_url ?>"
            type="image/webp">
    <source media="(min-width: 600px)"
            srcset="<?= $media->variant('medium')->webp_url ?>"
            type="image/webp">
    <source srcset="<?= $media->variant('thumb')->webp_url ?>"
            type="image/webp">

    <!-- Fallback sources -->
    <source media="(min-width: 1200px)"
            srcset="<?= $media->variant('large')->url ?>">
    <source media="(min-width: 600px)"
            srcset="<?= $media->variant('medium')->url ?>">

    <img src="<?= $media->variant('thumb')->url ?>" alt="Product">
</picture>
```

## Browser Support

WebP is supported by:
- ✅ Chrome 23+
- ✅ Firefox 65+
- ✅ Edge 18+
- ✅ Safari 14+
- ✅ Opera 12.1+
- ❌ IE 11 (requires fallback)

### Detect WebP Support (JavaScript)

```javascript
function supportsWebP() {
    const canvas = document.createElement('canvas');
    if (canvas.getContext && canvas.getContext('2d')) {
        return canvas.toDataURL('image/webp').indexOf('data:image/webp') === 0;
    }
    return false;
}

if (supportsWebP()) {
    document.documentElement.classList.add('webp');
} else {
    document.documentElement.classList.add('no-webp');
}
```

## Performance Metrics

### Typical File Size Reductions

```
Original JPEG (100KB)  → WebP (35KB)   = 65% reduction
Original PNG (200KB)   → WebP (80KB)   = 60% reduction
Original JPEG (500KB)  → WebP (175KB)  = 65% reduction
```

### Page Load Impact

```
Before WebP: 3.2 MB total images, 4.5s load time
After WebP:  1.1 MB total images, 1.8s load time
Improvement: 66% smaller, 60% faster
```

## Troubleshooting

### WebP Not Generated

Check GD/Imagick extension:

```bash
php -m | grep -E '(gd|imagick)'
```

Install missing extension:

```bash
# GD
sudo apt-get install php-gd

# Imagick (better quality)
sudo apt-get install php-imagick
```

### Poor Quality Output

Increase quality setting:

```php
config(['media.webp.quality' => 90]);
```

## Related Documentation

- [File Uploads & Image Processing](/docs/features/file-uploads)
- [CDN Integration](/docs/cdn-integration)
- [Media API Reference](/docs/api/media-api)

## External Resources

- [WebP Official Site](https://developers.google.com/speed/webp)
- [Can I Use WebP](https://caniuse.com/webp)
