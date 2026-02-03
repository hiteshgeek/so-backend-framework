# Video Processing Guide

## Overview

This guide demonstrates how to implement video processing features including thumbnail extraction, metadata parsing, preview generation, and format conversion.

## Prerequisites

Install FFmpeg:

```bash
# Ubuntu/Debian
sudo apt-get update
sudo apt-get install ffmpeg

# macOS
brew install ffmpeg

# Verify
ffmpeg -version
ffprobe -version
```

## Basic Video Upload and Processing

### Upload Form

```html
<form action="/videos/upload" method="POST" enctype="multipart/form-data">
    <input type="file" name="video" accept="video/*" required>
    <button type="submit">Upload Video</button>
</form>
```

### Controller

```php
use Core\Media\MediaService;
use Core\Media\VideoProcessor;

class VideoController
{
    public function upload(Request $request)
    {
        // Validate
        $validator = new Validator($request->all(), [
            'video' => 'required|file|mimes:mp4,mov,avi,webm|max:2097152', // 2GB max
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        // Upload video
        $media = MediaService::upload($request->file('video'), [
            'disk' => 'public',
            'path' => 'videos',
            'type' => 'video',
        ]);

        // Process video
        $processor = new VideoProcessor();
        $result = $processor->process($media->full_path);

        // Update media record with metadata
        $media->update([
            'duration' => $result['duration'],
            'width' => $result['width'],
            'height' => $result['height'],
            'metadata' => json_encode($result),
            'thumbnail_path' => $result['thumbnails'][0] ?? null,
        ]);

        return redirect("/videos/{$media->id}")->with('success', 'Video uploaded successfully');
    }

    public function show($id)
    {
        $video = Media::findOrFail($id);

        return view('videos/show', compact('video'));
    }
}
```

### View Template

```php
<div class="video-player">
    <video controls width="100%" poster="<?= $video->thumbnail_url ?>">
        <source src="<?= $video->url ?>" type="<?= $video->mime_type ?>">
        Your browser does not support the video tag.
    </video>

    <div class="video-info">
        <h2><?= e($video->filename) ?></h2>
        <p>Duration: <?= format_duration($video->duration) ?></p>
        <p>Resolution: <?= $video->width ?>x<?= $video->height ?></p>
        <p>Size: <?= format_bytes($video->size) ?></p>
    </div>
</div>
```

## Extract Thumbnails

### Single Thumbnail at Specific Time

```php
use Core\Media\VideoProcessor;

$processor = new VideoProcessor();

// Extract thumbnail at 5 seconds
$thumbnail = $processor->extractThumbnail(
    videoPath: storage_path('videos/video.mp4'),
    outputPath: storage_path('thumbnails/thumb.jpg'),
    timeSeconds: 5.0,
    width: 640,
    height: 360
);
```

### Multiple Thumbnails

```php
// Extract 3 thumbnails at 25%, 50%, 75% of duration
$thumbnails = $processor->extractMultipleThumbnails(
    videoPath: storage_path('videos/video.mp4'),
    outputDir: storage_path('thumbnails'),
    count: 3,
    width: 640,
    height: 360,
    prefix: 'video_123'
);

// Returns:
// [
//     'storage/thumbnails/video_123_1.jpg',
//     'storage/thumbnails/video_123_2.jpg',
//     'storage/thumbnails/video_123_3.jpg',
// ]
```

### Thumbnail Grid (Sprite Sheet)

```php
// Create single image with multiple thumbnails
$spriteSheet = $processor->createThumbnailSprite(
    videoPath: storage_path('videos/video.mp4'),
    outputPath: storage_path('thumbnails/sprite.jpg'),
    columns: 5,
    rows: 5,
    thumbnailWidth: 160,
    thumbnailHeight: 90
);

// Creates a 5x5 grid = 25 thumbnails in one image
// Useful for video preview on hover (like YouTube)
```

## Video Metadata

### Extract All Metadata

```php
use Core\Media\VideoMetadata;

$metadata = VideoMetadata::extract(storage_path('videos/video.mp4'));

print_r($metadata);
/*
Array (
    [duration] => 125.5
    [width] => 1920
    [height] => 1080
    [codec] => h264
    [audio_codec] => aac
    [bitrate] => 5000
    [fps] => 30
    [aspect_ratio] => 16:9
    [file_size] => 157286400
    [format] => mp4
    [has_audio] => true
    [has_video] => true
)
*/
```

### Check Video Compatibility

```php
$metadata = VideoMetadata::extract($videoPath);

if ($metadata['codec'] !== 'h264') {
    // Need to transcode
    $processor->transcode($videoPath, $outputPath, 'h264');
}

if ($metadata['width'] > 1920) {
    // Need to resize
    $processor->resize($videoPath, $outputPath, 1920, 1080);
}
```

## Generate Preview Clips

### Short Preview

```php
// 10-second preview starting at 10% of video duration
$preview = $processor->generatePreview(
    videoPath: storage_path('videos/long-video.mp4'),
    outputPath: storage_path('previews/preview.mp4'),
    startTime: $metadata['duration'] * 0.1,
    duration: 10,
    width: 640,
    height: 360
);
```

### Highlight Reel

```php
// Combine multiple segments into one preview
$preview = $processor->generateHighlightReel(
    videoPath: storage_path('videos/video.mp4'),
    outputPath: storage_path('previews/highlights.mp4'),
    segments: [
        ['start' => 10, 'duration' => 5],  // 5 seconds from 0:10
        ['start' => 45, 'duration' => 3],  // 3 seconds from 0:45
        ['start' => 90, 'duration' => 2],  // 2 seconds from 1:30
    ],
    width: 640,
    height: 360
);
```

## Format Conversion

### Convert to MP4

```php
use Core\Media\VideoConverter;

$converter = new VideoConverter();

// Convert AVI to MP4
$converter->convert(
    inputPath: storage_path('videos/video.avi'),
    outputPath: storage_path('videos/video.mp4'),
    format: 'mp4',
    codec: 'h264',
    quality: 'high'
);
```

### Resize Video

```php
// Resize to 720p, maintain aspect ratio
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
// Compress to target file size
$converter->compress(
    inputPath: storage_path('videos/large-video.mp4'),
    outputPath: storage_path('videos/compressed.mp4'),
    targetSizeMB: 50,
    quality: 'medium'
);
```

## Background Processing

### Queue Processing Job

```php
use App\Jobs\ProcessVideoJob;

class VideoController
{
    public function upload(Request $request)
    {
        // Upload video
        $media = MediaService::upload($request->file('video'));

        // Queue processing
        ProcessVideoJob::dispatch($media->id);

        return redirect()->back()->with('success', 'Video uploaded. Processing in background...');
    }
}
```

### Processing Job

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
        $media = Media::findOrFail($this->mediaId);

        try {
            $media->update(['status' => 'processing']);

            $processor = new VideoProcessor();

            // Extract metadata
            $metadata = $processor->extractMetadata($media->full_path);

            // Generate thumbnails
            $thumbnails = $processor->extractMultipleThumbnails(
                $media->full_path,
                storage_path('thumbnails'),
                count: 3
            );

            // Generate preview if video is long
            $previewPath = null;
            if ($metadata['duration'] > 30) {
                $previewPath = $processor->generatePreview(
                    $media->full_path,
                    storage_path("previews/{$media->id}_preview.mp4"),
                    startTime: $metadata['duration'] * 0.25,
                    duration: 10
                );
            }

            // Update media record
            $media->update([
                'status' => 'completed',
                'duration' => $metadata['duration'],
                'width' => $metadata['width'],
                'height' => $metadata['height'],
                'metadata' => json_encode($metadata),
                'thumbnail_path' => $thumbnails[0] ?? null,
                'preview_path' => $previewPath,
            ]);

        } catch (\Exception $e) {
            logger()->error("Video processing failed: {$e->getMessage()}");

            $media->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }
    }
}
```

## Progress Tracking

### Track Processing Progress

```php
use Core\Media\VideoProcessor;

$processor = new VideoProcessor();

$processor->process($media->full_path, function($progress) use ($media) {
    // Update progress in database
    $media->update(['processing_progress' => $progress]);

    // Broadcast via websocket
    broadcast(new VideoProcessingProgress($media->id, $progress));
});
```

### Display Progress

```javascript
// Listen for progress updates
Echo.channel(`video.${videoId}`)
    .listen('VideoProcessingProgress', (e) => {
        document.getElementById('progress').textContent = e.progress + '%';
    });
```

## Advanced Features

### Extract Audio Track

```php
$processor->extractAudio(
    videoPath: storage_path('videos/video.mp4'),
    outputPath: storage_path('audio/audio.mp3'),
    format: 'mp3',
    bitrate: 192
);
```

### Add Watermark

```php
$processor->addWatermark(
    videoPath: storage_path('videos/video.mp4'),
    watermarkPath: storage_path('images/logo.png'),
    outputPath: storage_path('videos/watermarked.mp4'),
    position: 'bottom-right',
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

## Helper Functions

```php
// Format duration in seconds to HH:MM:SS
function format_duration($seconds)
{
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $secs = $seconds % 60;

    if ($hours > 0) {
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
    }
    return sprintf('%02d:%02d', $minutes, $secs);
}

// Format bytes to human-readable
function format_bytes($bytes)
{
    $units = ['B', 'KB', 'MB', 'GB'];
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.2f %s", $bytes / pow(1024, $factor), $units[$factor]);
}
```

## Related Documentation

- [Video Processing](/docs/video-processing)
- [Chunked Uploads](/docs/chunked-uploads)
- [File Uploads](/docs/features/file-uploads)
- [Queue System](/docs/queue-system)

## Best Practices

1. **Process in background** - Use queues for large videos
2. **Generate multiple thumbnails** - Give users preview options
3. **Store metadata** - Save duration, resolution, codec info
4. **Validate before processing** - Check file size and format
5. **Handle errors gracefully** - Log errors and update status
6. **Clean up temp files** - Remove intermediate files after processing
7. **Monitor disk space** - Video processing requires storage
