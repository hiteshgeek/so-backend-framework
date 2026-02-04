# CDN Integration

## Overview

The framework provides seamless integration with Content Delivery Networks (CDN) including CloudFront and Cloudflare, with automatic URL rewriting, cache purging, and asset optimization.

## Supported CDNs

- **Amazon CloudFront** - AWS CDN service
- **Cloudflare** - Global CDN with edge computing
- **Custom CDN** - Any CDN with URL rewriting

## Configuration

**config/cdn.php**

```php
return [
    'enabled' => env('CDN_ENABLED', false),
    'driver' => env('CDN_DRIVER', 'cloudfront'), // cloudfront, cloudflare, custom

    'cloudfront' => [
        'domain' => env('CDN_CLOUDFRONT_DOMAIN'),
        'distribution_id' => env('CDN_CLOUDFRONT_DISTRIBUTION_ID'),
        'key_pair_id' => env('CDN_CLOUDFRONT_KEY_PAIR_ID'),
        'private_key_path' => env('CDN_CLOUDFRONT_PRIVATE_KEY'),
        'signed_urls' => false,
    ],

    'cloudflare' => [
        'domain' => env('CDN_CLOUDFLARE_DOMAIN'),
        'zone_id' => env('CDN_CLOUDFLARE_ZONE_ID'),
        'api_token' => env('CDN_CLOUDFLARE_API_TOKEN'),
    ],

    'custom' => [
        'domain' => env('CDN_CUSTOM_DOMAIN'),
    ],

    'paths' => [
        'assets' => true,    // Serve /assets through CDN
        'uploads' => true,   // Serve /uploads through CDN
        'media' => true,     // Serve /media through CDN
    ],

    'cache' => [
        'max_age' => 31536000, // 1 year in seconds
        'versioning' => true,  // Add version query string
    ],
];
```

**.env**

```env
CDN_ENABLED=true
CDN_DRIVER=cloudfront

# CloudFront
CDN_CLOUDFRONT_DOMAIN=d1234abcd.cloudfront.net
CDN_CLOUDFRONT_DISTRIBUTION_ID=E1234567890ABC
CDN_CLOUDFRONT_KEY_PAIR_ID=K1234567890ABC
CDN_CLOUDFRONT_PRIVATE_KEY=/path/to/private-key.pem

# Cloudflare
CDN_CLOUDFLARE_DOMAIN=cdn.example.com
CDN_CLOUDFLARE_ZONE_ID=abc123def456
CDN_CLOUDFLARE_API_TOKEN=your_api_token_here
```

## CloudFront Setup

### 1. Create CloudFront Distribution

```bash
# AWS CLI
aws cloudfront create-distribution \
    --origin-domain-name yourapp.com \
    --default-root-object index.html
```

### 2. Configure Origin

```json
{
    "Origins": {
        "Items": [{
            "Id": "yourapp-origin",
            "DomainName": "yourapp.com",
            "CustomOriginConfig": {
                "HTTPPort": 80,
                "HTTPSPort": 443,
                "OriginProtocolPolicy": "https-only"
            }
        }]
    }
}
```

### 3. Set Cache Behaviors

```json
{
    "CacheBehaviors": {
        "PathPattern": "/assets/*",
        "MinTTL": 31536000,
        "DefaultTTL": 31536000,
        "MaxTTL": 31536000
    }
}
```

## Cloudflare Setup

### 1. Add Site to Cloudflare

1. Sign up at [Cloudflare](https://www.cloudflare.com)
2. Add your domain
3. Update nameservers

### 2. Configure Page Rules

```
Rule 1: yourapp.com/assets/*
- Cache Level: Cache Everything
- Edge Cache TTL: 1 year

Rule 2: yourapp.com/uploads/*
- Cache Level: Cache Everything
- Edge Cache TTL: 1 month
```

### 3. Generate API Token

1. Go to My Profile → API Tokens
2. Create Token with "Zone.Cache Purge" permission
3. Copy token to `.env`

## URL Rewriting

### Automatic CDN URLs

```php
// Without CDN
asset('css/app.css')
// Output: https://yourapp.com/assets/css/app.css

// With CDN enabled
asset('css/app.css')
// Output: https://d1234abcd.cloudfront.net/assets/css/app.css
```

### Media Files

```php
$media = Media::find(1);

// Without CDN
echo $media->url;
// Output: https://yourapp.com/uploads/image.jpg

// With CDN
echo $media->url;
// Output: https://cdn.yourapp.com/uploads/image.jpg
```

### Custom Paths

```php
use Core\CDN\CDN;

// Rewrite any URL to CDN
$cdnUrl = CDN::url('/custom/path/file.jpg');
// Output: https://d1234abcd.cloudfront.net/custom/path/file.jpg
```

## Cache Purging

### Purge Single File

```php
use Core\CDN\CDN;

// Purge specific file
CDN::purge('/assets/css/app.css');

// Purge multiple files
CDN::purge([
    '/assets/css/app.css',
    '/assets/js/app.js',
]);
```

### Purge by Pattern

```php
// CloudFront: Purge path pattern
CDN::purge('/assets/*');

// Cloudflare: Purge all files with tag
CDN::purgeByTag('assets');

// Purge entire cache
CDN::purgeAll();
```

### Auto-Purge on Upload

```php
use Core\Media\MediaService;

$media = MediaService::upload($file, [
    'purge_cdn' => true, // Auto-purge old version
]);

// Purges:
// - Old file URL
// - Old thumbnail URLs
// - Old variant URLs
```

## Signed URLs (Private Content)

### CloudFront Signed URLs

```php
use Core\CDN\CloudFront;

$cloudfront = new CloudFront();

// Generate signed URL (expires in 1 hour)
$signedUrl = $cloudfront->signedUrl(
    url: 'https://d1234abcd.cloudfront.net/private/video.mp4',
    expires: now()->addHour()
);

// Custom expiration
$signedUrl = $cloudfront->signedUrl(
    url: 'https://d1234abcd.cloudfront.net/private/document.pdf',
    expires: now()->addDays(7)
);
```

### Cloudflare Signed URLs

```php
use Core\CDN\Cloudflare;

$cloudflare = new Cloudflare();

$signedUrl = $cloudflare->signedUrl(
    url: 'https://cdn.yourapp.com/premium/content.mp4',
    expires: now()->addHours(2)
);
```

## Asset Versioning

### Cache Busting

```php
// Automatic versioning
asset('css/app.css')
// Output: https://cdn.yourapp.com/assets/css/app.css?v=1.2.3

// Manual version
asset('css/app.css', version: '2.0.0')
// Output: https://cdn.yourapp.com/assets/css/app.css?v=2.0.0
```

### File Hash Versioning

```php
// Hash-based versioning
asset('css/app.css', hash: true)
// Output: https://cdn.yourapp.com/assets/css/app.css?v=a1b2c3d4
```

## Performance Optimization

### Preload Critical Assets

```html
<link rel="preload" href="<?= cdn_asset('css/critical.css') ?>" as="style">
<link rel="preload" href="<?= cdn_asset('fonts/font.woff2') ?>" as="font" type="font/woff2" crossorigin>
```

### HTTP/2 Server Push

```php
// Automatically push critical assets
CDN::push([
    asset('css/app.css'),
    asset('js/app.js'),
]);
```

## Image Optimization

### CloudFront with Lambda@Edge

```javascript
// Lambda function for image optimization
exports.handler = async (event) => {
    const request = event.Records[0].cf.request;
    const uri = request.uri;

    // Resize images on-the-fly
    if (uri.match(/\.(jpg|png)$/)) {
        const width = request.querystring.match(/w=(\d+)/)?.[1];
        if (width) {
            // Resize and return optimized image
        }
    }

    return request;
};
```

### Usage

```php
// Request resized image from CDN
$imageUrl = cdn_asset('uploads/image.jpg') . '?w=800';
```

## Monitoring

### Cache Hit Rate

```php
use Core\CDN\CDN;

// Get cache statistics
$stats = CDN::getCacheStats();

// Returns:
// [
//     'hit_rate' => 95.5,
//     'total_requests' => 1000000,
//     'cache_hits' => 955000,
//     'cache_misses' => 45000,
// ]
```

### Bandwidth Usage

```php
// CloudFront bandwidth
$bandwidth = CDN::getBandwidthUsage(
    start: now()->subMonth(),
    end: now()
);
```

## CLI Commands

### Purge Cache

```bash
# Purge all CDN cache
php sixorbit cdn:purge

# Purge specific path
php sixorbit cdn:purge --path=/assets/css/app.css

# Purge by pattern
php sixorbit cdn:purge --pattern=/assets/*
```

### Sync Assets

```bash
# Upload assets to CDN
php sixorbit cdn:sync

# Sync specific directory
php sixorbit cdn:sync --dir=assets

# Dry run
php sixorbit cdn:sync --dry-run
```

## Security

### Prevent Hotlinking

**CloudFront Behavior**

```json
{
    "ViewerProtocolPolicy": "redirect-to-https",
    "AllowedMethods": ["GET", "HEAD"],
    "ForwardedValues": {
        "Headers": ["Referer"]
    }
}
```

**Cloudflare Page Rule**

```
Rule: *yourapp.com/uploads/*
- Hotlink Protection: On
- Allowed domains: yourapp.com, *.yourapp.com
```

### Rate Limiting

```php
// Cloudflare rate limiting
Cloudflare::setRateLimit([
    'path' => '/api/*',
    'threshold' => 100,
    'period' => 60, // seconds
    'action' => 'challenge', // block, challenge, js_challenge
]);
```

## Fallback Mechanism

### Automatic Fallback

```php
// CDN with fallback to origin
function cdn_asset($path) {
    if (CDN::isAvailable()) {
        return CDN::url($path);
    }
    return asset($path); // Fallback to origin
}
```

### Health Checks

```bash
# Check CDN availability
php sixorbit cdn:health

# Output:
# ✓ CloudFront: Online (latency: 45ms)
# ✓ Origin: Online (latency: 120ms)
```

## Testing

```php
use Core\CDN\CDN;

public function test_cdn_url_generation()
{
    config(['cdn.enabled' => true]);
    config(['cdn.cloudfront.domain' => 'd1234.cloudfront.net']);

    $url = CDN::url('/assets/app.css');

    $this->assertEquals(
        'https://d1234.cloudfront.net/assets/app.css',
        $url
    );
}
```

## Related Documentation

- [Asset Management](/docs/asset-management)
- [File Uploads](/docs/features/file-uploads)
- [WebP Conversion](/docs/webp-conversion)

## External Resources

- [CloudFront Developer Guide](https://docs.aws.amazon.com/cloudfront/)
- [Cloudflare Documentation](https://developers.cloudflare.com/)
