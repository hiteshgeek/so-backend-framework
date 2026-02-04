# Chunked Uploads

## Overview

Chunked uploads enable resumable large file uploads with progress tracking and automatic cleanup. This is essential for handling large media files, videos, and datasets in enterprise applications.

## Key Features

- **Resumable uploads** - Continue interrupted uploads
- **Progress tracking** - Real-time upload progress
- **Automatic cleanup** - Remove abandoned chunks
- **Large file support** - Upload files of any size
- **Memory efficient** - Streams chunks without loading full file
- **CORS compatible** - Works with cross-origin requests

## How It Works

1. **Client splits file** into chunks (e.g., 5MB each)
2. **Uploads each chunk** sequentially or in parallel
3. **Server stores chunks** temporarily
4. **Server assembles chunks** when all are received
5. **Final file is processed** (thumbnails, validation, etc.)
6. **Chunks are deleted** after assembly

## Configuration

**config/upload.php**

```php
return [
    'chunked' => [
        'enabled' => true,
        'chunk_size' => 5 * 1024 * 1024, // 5MB per chunk
        'chunk_dir' => storage_path('chunks'),
        'max_file_size' => 5 * 1024 * 1024 * 1024, // 5GB max
        'cleanup_after' => 24 * 60 * 60, // 24 hours
        'allowed_extensions' => ['mp4', 'mov', 'avi', 'zip', 'pdf'],
    ],
];
```

## Server-Side Implementation

### Upload Endpoint

**app/Controllers/UploadController.php**

```php
use Core\Upload\ChunkedUpload;

class UploadController
{
    public function uploadChunk(Request $request)
    {
        $uploader = new ChunkedUpload($request);

        // Process chunk
        $result = $uploader->processChunk([
            'chunk_index' => $request->input('chunkIndex'),
            'total_chunks' => $request->input('totalChunks'),
            'file_id' => $request->input('fileId'),
            'file_name' => $request->input('fileName'),
            'file_size' => $request->input('fileSize'),
        ]);

        if ($result['completed']) {
            // All chunks uploaded, assemble file
            $filePath = $uploader->assembleChunks($result['file_id']);

            // Process final file
            $media = Media::create([
                'path' => $filePath,
                'filename' => $result['file_name'],
                'size' => $result['file_size'],
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'completed' => true,
                'media_id' => $media->id,
                'url' => $media->url,
            ]);
        }

        return response()->json([
            'completed' => false,
            'chunk_index' => $result['chunk_index'],
            'progress' => $result['progress'],
        ]);
    }
}
```

### Routes

```php
Router::post('/upload/chunk', [UploadController::class, 'uploadChunk'])
    ->middleware('auth');
```

## Client-Side Implementation

See [Chunked Upload Implementation Guide](/docs/dev-chunked-uploads) for complete client-side examples with:
- Progress bars
- Retry logic
- Pause/Resume
- Error handling

## Chunk Storage Structure

```
storage/chunks/
├── abc123def456/          # File ID
│   ├── chunk_0.part
│   ├── chunk_1.part
│   ├── chunk_2.part
│   ├── chunk_3.part
│   └── metadata.json      # Upload metadata
└── xyz789ghi012/
    └── ...
```

## Metadata File

**metadata.json**

```json
{
    "file_id": "abc123def456",
    "file_name": "video.mp4",
    "file_size": 52428800,
    "total_chunks": 10,
    "uploaded_chunks": [0, 1, 2, 3],
    "created_at": "2026-02-03T14:30:00Z",
    "updated_at": "2026-02-03T14:32:15Z"
}
```

## Automatic Cleanup

### Cleanup Command

```bash
# Clean up abandoned chunks older than 24 hours
php sixorbit chunks:cleanup

# Custom retention period
php sixorbit chunks:cleanup --hours=6
```

### Schedule Cleanup

**app/Console/Kernel.php**

```php
protected function schedule(Schedule $schedule)
{
    // Clean up chunks daily at 2 AM
    $schedule->command('chunks:cleanup')
        ->daily()
        ->at('02:00');
}
```

## Validation

### Chunk Validation

```php
class UploadController
{
    public function uploadChunk(Request $request)
    {
        $validator = new Validator($request->all(), [
            'chunkIndex' => 'required|integer|min:0',
            'totalChunks' => 'required|integer|min:1',
            'fileId' => 'required|string|size:32',
            'fileName' => 'required|string|max:255',
            'fileSize' => 'required|integer|max:' . config('upload.chunked.max_file_size'),
            'chunk' => 'required|file',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Process chunk...
    }
}
```

### File Type Validation

```php
use Core\Upload\FileValidator;

$uploader = new ChunkedUpload($request);

// Validate final file after assembly
$filePath = $uploader->assembleChunks($fileId);

$validator = new FileValidator();
if (!$validator->isAllowedType($filePath, ['mp4', 'mov', 'avi'])) {
    $uploader->deleteChunks($fileId);
    return response()->json(['error' => 'Invalid file type'], 422);
}
```

## Error Handling

### Server-Side Errors

```php
try {
    $result = $uploader->processChunk($params);
} catch (ChunkUploadException $e) {
    return response()->json([
        'error' => $e->getMessage(),
        'code' => $e->getCode(),
    ], 500);
}
```

### Common Error Codes

| Code | Error | Solution |
|------|-------|----------|
| 1001 | Chunk out of order | Upload chunks sequentially |
| 1002 | Invalid chunk size | Check chunk size configuration |
| 1003 | Disk space full | Free up storage space |
| 1004 | Chunk already uploaded | Skip to next chunk |
| 1005 | Assembly failed | Retry upload from beginning |

## Performance Optimization

### Parallel Chunk Uploads

Upload multiple chunks simultaneously:

```javascript
// JavaScript example
const maxParallelUploads = 3;
const uploadQueue = chunks.map((chunk, index) => ({
    chunk,
    index,
}));

async function uploadWithConcurrency() {
    const promises = [];
    for (let i = 0; i < maxParallelUploads; i++) {
        promises.push(uploadNext());
    }
    await Promise.all(promises);
}
```

### Chunk Size Recommendations

| File Type | Recommended Chunk Size |
|-----------|----------------------|
| Images | 1-2 MB |
| Documents | 2-5 MB |
| Videos | 5-10 MB |
| Large files (>1GB) | 10-20 MB |

## Security

### Authentication

```php
Router::post('/upload/chunk', [UploadController::class, 'uploadChunk'])
    ->middleware('auth', 'throttle:100,1'); // 100 requests per minute
```

### CSRF Protection

```php
// Disable CSRF for chunk uploads (use token in request)
protected $except = [
    '/upload/chunk',
];
```

### Rate Limiting

```php
use Core\RateLimit\RateLimiter;

$limiter = new RateLimiter();
$limiter->allow('chunk-upload:' . auth()->id(), 100, 60); // 100 per minute
```

## Monitoring

### Upload Progress Tracking

```php
use Core\Upload\UploadProgress;

// Track upload progress in database
UploadProgress::create([
    'user_id' => auth()->id(),
    'file_id' => $fileId,
    'total_size' => $fileSize,
    'uploaded_size' => $uploadedSize,
    'progress' => ($uploadedSize / $fileSize) * 100,
]);
```

### Metrics

```php
// Track upload metrics
Metrics::increment('chunked_uploads.total');
Metrics::increment('chunked_uploads.completed');
Metrics::gauge('chunked_uploads.average_speed', $bytesPerSecond);
```

## Testing

### Unit Tests

```php
public function test_chunk_upload()
{
    $chunk = UploadedFile::fake()->create('video.mp4', 5000); // 5MB

    $response = $this->post('/upload/chunk', [
        'chunk' => $chunk,
        'chunkIndex' => 0,
        'totalChunks' => 10,
        'fileId' => 'test123',
        'fileName' => 'video.mp4',
        'fileSize' => 50000000,
    ]);

    $response->assertStatus(200);
}
```

## Related Documentation

- [File Uploads & Image Processing](/docs/features/file-uploads)
- [Chunked Upload Implementation](/docs/dev-chunked-uploads)
- [Video Processing](/docs/video-processing)

## Best Practices

1. **Use appropriate chunk size** - Balance between performance and reliability
2. **Implement retry logic** - Handle network failures gracefully
3. **Clean up abandoned uploads** - Schedule regular cleanup
4. **Validate file type** - Check MIME type after assembly
5. **Monitor disk space** - Ensure sufficient storage for chunks
6. **Rate limit uploads** - Prevent abuse
