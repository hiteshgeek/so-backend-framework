# Video Processing

## Overview

The framework provides comprehensive video processing capabilities using FFmpeg, including thumbnail extraction, metadata parsing, format conversion, and preview generation.

## Requirements

### FFmpeg Installation

```bash
# Ubuntu/Debian
sudo apt-get update
sudo apt-get install ffmpeg

# macOS
brew install ffmpeg

# Verify installation
ffmpeg -version
```

## Configuration

**config/media.php**

```php
return [
    'video' => [
        'enabled' => true,
        'ffmpeg_path' => '/usr/bin/ffmpeg',
        'ffprobe_path' => '/usr/bin/ffprobe',
        'max_file_size' => 2 * 1024 * 1024 * 1024, // 2GB
        'allowed_formats' => ['mp4', 'mov', 'avi', 'webm', 'mkv'],

        'thumbnails' => [
            'enabled' => true,
            'count' => 3, // Generate 3 thumbnails
            'width' => 640,
            'height' => 360,
            'format' => 'jpg',
            'quality' => 85,
        ],

        'preview' => [
            'enabled' => true,
            'duration' => 10, // 10 second preview
            'format' => 'mp4',
            'width' => 640,
            'height' => 360,
        ],

        'transcoding' => [
            'enabled' => false,
            'formats' => ['mp4', 'webm'],
            'queue' => true, // Process in background
        ],
    ],
];
```

## Upload and Process Video

### Basic Upload

```php
use Core\Media\MediaService;
use Core\Media\VideoProcessor;

// Upload video
$media = MediaService::upload($request->file('video'), [
    'disk' => 'public',
    'path' => 'videos',
    'type' => 'video',
]);

// Process video
$processor = new VideoProcessor();
$result = $processor->process($media);

// Result contains:
// - thumbnails: Array of thumbnail paths
// - duration: Video duration in seconds
// - width: Video width
// - height: Video height
// - codec: Video codec
// - bitrate: Bitrate in kbps
// - fps: Frames per second
```

### Upload with Auto-Processing

```php
$media = MediaService::upload($request->file('video'), [
    'disk' => 'public',
    'path' => 'videos',
    'type' => 'video',
    'process_video' => true, // Auto-process after upload
    'generate_thumbnails' => true,
    'generate_preview' => true,
]);

// Thumbnails automatically available
echo $media->thumbnail_url; // First thumbnail
echo $media->preview_url;   // Preview video URL
```

## Thumbnail Generation

### Single Thumbnail

```php
use Core\Media\VideoProcessor;

$processor = new VideoProcessor();

// Extract thumbnail at 5 seconds
$thumbnail = $processor->extractThumbnail(
    videoPath: storage_path('videos/video.mp4'),
    outputPath: storage_path('thumbnails/thumb.jpg'),
    timeSeconds: 5.0
);
```

### Multiple Thumbnails

```php
// Generate thumbnails at 25%, 50%, and 75% of video duration
$thumbnails = $processor->extractMultipleThumbnails(
    videoPath: storage_path('videos/video.mp4'),
    outputDir: storage_path('thumbnails'),
    count: 3,
    width: 640,
    height: 360
);

// Returns:
// [
//     'storage/thumbnails/video_thumb_1.jpg',
//     'storage/thumbnails/video_thumb_2.jpg',
//     'storage/thumbnails/video_thumb_3.jpg',
// ]
```

### Custom Thumbnail Times

```php
// Extract at specific timestamps
$thumbnails = $processor->extractThumbnailsAtTimes(
    videoPath: storage_path('videos/video.mp4'),
    outputDir: storage_path('thumbnails'),
    times: [10, 30, 60, 120], // seconds
);
```

## Video Metadata Extraction

```php
use Core\Media\VideoMetadata;

$metadata = VideoMetadata::extract(storage_path('videos/video.mp4'));

// Returns:
[
    'duration' => 125.5,        // seconds
    'width' => 1920,
    'height' => 1080,
    'codec' => 'h264',
    'audio_codec' => 'aac',
    'bitrate' => 5000,          // kbps
    'fps' => 30,                // frames per second
    'aspect_ratio' => '16:9',
    'file_size' => 157286400,   // bytes
    'format' => 'mp4',
    'has_audio' => true,
    'has_video' => true,
]
```

## Preview Generation

### Short Preview Clip

```php
use Core\Media\VideoProcessor;

$processor = new VideoProcessor();

// Generate 10-second preview starting at 5 seconds
$preview = $processor->generatePreview(
    videoPath: storage_path('videos/long-video.mp4'),
    outputPath: storage_path('previews/preview.mp4'),
    startTime: 5,
    duration: 10,
    width: 640,
    height: 360
);
```

### Highlight Reel

```php
// Generate preview from multiple segments
$preview = $processor->generateHighlightReel(
    videoPath: storage_path('videos/video.mp4'),
    outputPath: storage_path('previews/highlights.mp4'),
    segments: [
        ['start' => 10, 'duration' => 3],  // 3 seconds from 0:10
        ['start' => 45, 'duration' => 3],  // 3 seconds from 0:45
        ['start' => 90, 'duration' => 4],  // 4 seconds from 1:30
    ]
);
```

## Video Conversion

### Convert to Different Format

```php
use Core\Media\VideoConverter;

$converter = new VideoConverter();

// Convert to MP4
$converter->convert(
    inputPath: storage_path('videos/video.avi'),
    outputPath: storage_path('videos/video.mp4'),
    format: 'mp4',
    codec: 'h264',
    quality: 'high' // low, medium, high, lossless
);
```

### Resize Video

```php
// Resize to 720p
$converter->resize(
    inputPath: storage_path('videos/video.mp4'),
    outputPath: storage_path('videos/video_720p.mp4'),
    width: 1280,
    height: 720,
    maintainAspectRatio: true
);
```

### Compress Video

```php
// Compress video for web
$converter->compress(
    inputPath: storage_path('videos/large-video.mp4'),
    outputPath: storage_path('videos/compressed.mp4'),
    targetSizeMB: 50, // Target file size
    quality: 'medium'
);
```

## Background Processing

### Queue Video Processing

```php
use Core\Jobs\ProcessVideoJob;

// Upload video and queue processing
$media = MediaService::upload($request->file('video'));

// Dispatch to queue
ProcessVideoJob::dispatch($media->id);
```

### Video Processing Job

**app/Jobs/ProcessVideoJob.php**

```php
use Core\Media\VideoProcessor;
use Core\Media\Media;

class ProcessVideoJob
{
    protected $mediaId;

    public function __construct($mediaId)
    {
        $this->mediaId = $mediaId;
    }

    public function handle()
    {
        $media = Media::find($this->mediaId);

        $processor = new VideoProcessor();

        // Extract metadata
        $metadata = $processor->extractMetadata($media->full_path);
        $media->update([
            'duration' => $metadata['duration'],
            'width' => $metadata['width'],
            'height' => $metadata['height'],
            'metadata' => json_encode($metadata),
        ]);

        // Generate thumbnails
        $thumbnails = $processor->extractMultipleThumbnails(
            $media->full_path,
            storage_path('thumbnails'),
            count: 3
        );

        $media->update([
            'thumbnail_path' => $thumbnails[0] ?? null,
        ]);

        // Generate preview
        if ($metadata['duration'] > 30) {
            $preview = $processor->generatePreview(
                $media->full_path,
                storage_path('previews/' . $media->id . '_preview.mp4'),
                startTime: $metadata['duration'] * 0.25,
                duration: 10
            );

            $media->update(['preview_path' => $preview]);
        }
    }
}
```

## Video Player Integration

### HTML5 Video Player

```html
<video controls width="100%" poster="<?= $media->thumbnail_url ?>">
    <source src="<?= $media->url ?>" type="video/mp4">
    <source src="<?= $media->webm_url ?? $media->url ?>" type="video/webm">
    Your browser does not support the video tag.
</video>
```

### With Preview

```html
<!-- Show preview on hover -->
<div class="video-preview"
     data-preview="<?= $media->preview_url ?>"
     data-full="<?= $media->url ?>">
    <img src="<?= $media->thumbnail_url ?>" alt="Video thumbnail">
    <span class="duration"><?= format_duration($media->duration) ?></span>
</div>

<script>
// Swap to preview on hover
document.querySelectorAll('.video-preview').forEach(el => {
    el.addEventListener('mouseenter', function() {
        const video = document.createElement('video');
        video.src = this.dataset.preview;
        video.autoplay = true;
        video.loop = true;
        video.muted = true;
        this.innerHTML = '';
        this.appendChild(video);
    });
});
</script>
```

## Advanced Features

### Extract Audio

```php
$processor->extractAudio(
    videoPath: storage_path('videos/video.mp4'),
    outputPath: storage_path('audio/audio.mp3'),
    format: 'mp3',
    bitrate: 192 // kbps
);
```

### Add Watermark

```php
$processor->addWatermark(
    videoPath: storage_path('videos/video.mp4'),
    watermarkPath: storage_path('images/logo.png'),
    outputPath: storage_path('videos/watermarked.mp4'),
    position: 'bottom-right', // top-left, top-right, bottom-left, bottom-right, center
    opacity: 0.7
);
```

### Concatenate Videos

```php
$processor->concatenate(
    videoPaths: [
        storage_path('videos/intro.mp4'),
        storage_path('videos/main.mp4'),
        storage_path('videos/outro.mp4'),
    ],
    outputPath: storage_path('videos/final.mp4')
);
```

## Error Handling

```php
use Core\Media\VideoProcessingException;

try {
    $processor->process($media);
} catch (VideoProcessingException $e) {
    logger()->error('Video processing failed: ' . $e->getMessage());

    // Mark media as failed
    $media->update([
        'status' => 'failed',
        'error_message' => $e->getMessage(),
    ]);
}
```

## Performance Optimization

### Use Queue for Large Videos

```php
// Queue videos larger than 100MB
if ($media->size > 100 * 1024 * 1024) {
    ProcessVideoJob::dispatch($media->id);
} else {
    // Process immediately for small videos
    $processor->process($media);
}
```

### Progress Tracking

```php
$processor->process($media, function($progress) {
    // Update progress in database
    $media->update(['processing_progress' => $progress]);

    // Or broadcast via websocket
    broadcast(new VideoProcessingProgress($media->id, $progress));
});
```

## Testing

```php
use Core\Media\VideoProcessor;

public function test_video_thumbnail_extraction()
{
    $processor = new VideoProcessor();

    $thumbnail = $processor->extractThumbnail(
        base_path('tests/fixtures/sample.mp4'),
        storage_path('test_thumb.jpg'),
        5.0
    );

    $this->assertFileExists($thumbnail);
}
```

## Related Documentation

- [File Uploads & Image Processing](/docs/features/file-uploads)
- [Chunked Uploads](/docs/chunked-uploads)
- [Video Processing Guide](/docs/dev-video-processing)
- [Queue System](/docs/queue-system)

## External Resources

- [FFmpeg Documentation](https://ffmpeg.org/documentation.html)
- [FFmpeg Filters](https://ffmpeg.org/ffmpeg-filters.html)
