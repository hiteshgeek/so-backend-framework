# Chunked Upload Implementation

## Overview

This guide shows how to implement resumable chunked file uploads with progress bars, retry logic, and error handling on both client and server sides.

## Client-Side Implementation

### HTML Form

```html
<form id="upload-form">
    <input type="file" id="file-input" accept="video/*,.pdf,.zip">
    <button type="submit">Upload</button>

    <div id="upload-progress" style="display:none;">
        <div class="progress-bar">
            <div class="progress-fill" id="progress-fill"></div>
        </div>
        <div class="progress-text">
            <span id="progress-percent">0%</span>
            <span id="progress-size">0 MB / 0 MB</span>
        </div>
        <button id="pause-btn">Pause</button>
        <button id="resume-btn" style="display:none;">Resume</button>
        <button id="cancel-btn">Cancel</button>
    </div>
</form>
```

### JavaScript Implementation

```javascript
class ChunkedUploader {
    constructor(file, options = {}) {
        this.file = file;
        this.chunkSize = options.chunkSize || 5 * 1024 * 1024; // 5MB
        this.uploadUrl = options.uploadUrl || '/upload/chunk';
        this.maxRetries = options.maxRetries || 3;
        this.onProgress = options.onProgress || (() => {});
        this.onComplete = options.onComplete || (() => {});
        this.onError = options.onError || (() => {});

        this.fileId = this.generateFileId();
        this.totalChunks = Math.ceil(file.size / this.chunkSize);
        this.currentChunk = 0;
        this.uploadedBytes = 0;
        this.isPaused = false;
        this.isCancelled = false;
    }

    generateFileId() {
        return Date.now().toString(36) + Math.random().toString(36).substr(2);
    }

    async upload() {
        while (this.currentChunk < this.totalChunks && !this.isCancelled) {
            if (this.isPaused) {
                await this.waitForResume();
            }

            const chunk = this.getChunk(this.currentChunk);
            const success = await this.uploadChunk(chunk, this.currentChunk);

            if (success) {
                this.currentChunk++;
                this.uploadedBytes += chunk.size;
                this.updateProgress();
            } else {
                // Retry logic handled in uploadChunk
                this.onError(new Error('Failed to upload chunk'));
                return;
            }
        }

        if (!this.isCancelled) {
            this.onComplete();
        }
    }

    getChunk(index) {
        const start = index * this.chunkSize;
        const end = Math.min(start + this.chunkSize, this.file.size);
        return this.file.slice(start, end);
    }

    async uploadChunk(chunk, index) {
        const formData = new FormData();
        formData.append('chunk', chunk);
        formData.append('chunkIndex', index);
        formData.append('totalChunks', this.totalChunks);
        formData.append('fileId', this.fileId);
        formData.append('fileName', this.file.name);
        formData.append('fileSize', this.file.size);

        for (let attempt = 0; attempt < this.maxRetries; attempt++) {
            try {
                const response = await fetch(this.uploadUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                return true;
            } catch (error) {
                console.error(`Upload attempt ${attempt + 1} failed:`, error);

                if (attempt === this.maxRetries - 1) {
                    return false;
                }

                // Exponential backoff
                await this.sleep(Math.pow(2, attempt) * 1000);
            }
        }

        return false;
    }

    updateProgress() {
        const percent = Math.round((this.uploadedBytes / this.file.size) * 100);
        const uploadedMB = (this.uploadedBytes / (1024 * 1024)).toFixed(2);
        const totalMB = (this.file.size / (1024 * 1024)).toFixed(2);

        this.onProgress({
            percent,
            uploadedBytes: this.uploadedBytes,
            totalBytes: this.file.size,
            uploadedMB,
            totalMB,
        });
    }

    pause() {
        this.isPaused = true;
    }

    resume() {
        this.isPaused = false;
    }

    cancel() {
        this.isCancelled = true;
    }

    waitForResume() {
        return new Promise(resolve => {
            const checkResume = () => {
                if (!this.isPaused) {
                    resolve();
                } else {
                    setTimeout(checkResume, 100);
                }
            };
            checkResume();
        });
    }

    sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
}

// Usage
document.getElementById('upload-form').addEventListener('submit', async (e) => {
    e.preventDefault();

    const fileInput = document.getElementById('file-input');
    const file = fileInput.files[0];

    if (!file) {
        alert('Please select a file');
        return;
    }

    // Show progress UI
    document.getElementById('upload-progress').style.display = 'block';

    const uploader = new ChunkedUploader(file, {
        chunkSize: 5 * 1024 * 1024, // 5MB chunks
        uploadUrl: '/upload/chunk',

        onProgress: (progress) => {
            document.getElementById('progress-fill').style.width = progress.percent + '%';
            document.getElementById('progress-percent').textContent = progress.percent + '%';
            document.getElementById('progress-size').textContent =
                `${progress.uploadedMB} MB / ${progress.totalMB} MB`;
        },

        onComplete: () => {
            alert('Upload complete!');
            document.getElementById('upload-progress').style.display = 'none';
        },

        onError: (error) => {
            alert('Upload failed: ' + error.message);
        },
    });

    // Pause/Resume/Cancel buttons
    document.getElementById('pause-btn').onclick = () => {
        uploader.pause();
        document.getElementById('pause-btn').style.display = 'none';
        document.getElementById('resume-btn').style.display = 'inline';
    };

    document.getElementById('resume-btn').onclick = () => {
        uploader.resume();
        document.getElementById('resume-btn').style.display = 'none';
        document.getElementById('pause-btn').style.display = 'inline';
    };

    document.getElementById('cancel-btn').onclick = () => {
        if (confirm('Cancel upload?')) {
            uploader.cancel();
            document.getElementById('upload-progress').style.display = 'none';
        }
    };

    // Start upload
    await uploader.upload();
});
```

### CSS Styling

```css
.progress-bar {
    width: 100%;
    height: 30px;
    background-color: #f0f0f0;
    border-radius: 15px;
    overflow: hidden;
    margin: 10px 0;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #4CAF50, #45a049);
    width: 0%;
    transition: width 0.3s ease;
}

.progress-text {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 14px;
    color: #666;
}

#upload-progress button {
    margin-right: 10px;
    padding: 8px 16px;
    cursor: pointer;
}
```

## Server-Side Implementation

### Controller

**app/Controllers/UploadController.php**

```php
use Core\Http\Request;
use Core\Upload\ChunkedUpload;
use Core\Media\Media;

class UploadController
{
    public function uploadChunk(Request $request)
    {
        // Validate request
        $validator = new Validator($request->all(), [
            'chunk' => 'required|file',
            'chunkIndex' => 'required|integer|min:0',
            'totalChunks' => 'required|integer|min:1',
            'fileId' => 'required|string|size:32',
            'fileName' => 'required|string|max:255',
            'fileSize' => 'required|integer|max:' . (5 * 1024 * 1024 * 1024), // 5GB max
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $uploader = new ChunkedUpload($request);

            // Process chunk
            $result = $uploader->processChunk([
                'chunk_index' => $request->input('chunkIndex'),
                'total_chunks' => $request->input('totalChunks'),
                'file_id' => $request->input('fileId'),
                'file_name' => $request->input('fileName'),
                'file_size' => $request->input('fileSize'),
            ]);

            // If all chunks uploaded, assemble file
            if ($result['completed']) {
                $filePath = $uploader->assembleChunks($result['file_id']);

                // Create media record
                $media = Media::create([
                    'user_id' => auth()->id(),
                    'filename' => $result['file_name'],
                    'path' => $filePath,
                    'size' => $result['file_size'],
                    'mime_type' => mime_content_type($filePath),
                ]);

                // Clean up chunks
                $uploader->cleanupChunks($result['file_id']);

                return response()->json([
                    'completed' => true,
                    'media_id' => $media->id,
                    'url' => $media->url,
                ]);
            }

            return response()->json([
                'completed' => false,
                'chunk_index' => $result['chunk_index'],
                'progress' => round(($result['uploaded_chunks'] / $result['total_chunks']) * 100),
            ]);

        } catch (\Exception $e) {
            logger()->error('Chunk upload failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
```

### Routes

```php
Router::post('/upload/chunk', [UploadController::class, 'uploadChunk'])
    ->middleware('auth', 'throttle:200,1'); // 200 requests per minute
```

## Advanced Features

### Auto-Retry with Exponential Backoff

```javascript
async uploadChunkWithRetry(chunk, index) {
    for (let attempt = 0; attempt < this.maxRetries; attempt++) {
        try {
            await this.uploadChunk(chunk, index);
            return true;
        } catch (error) {
            if (attempt === this.maxRetries - 1) {
                throw error;
            }
            // Wait before retry: 1s, 2s, 4s, 8s...
            const delay = Math.pow(2, attempt) * 1000;
            await this.sleep(delay);
        }
    }
}
```

### Resume After Page Reload

```javascript
// Save progress to localStorage
saveProgress() {
    localStorage.setItem(`upload_${this.fileId}`, JSON.stringify({
        currentChunk: this.currentChunk,
        totalChunks: this.totalChunks,
        fileName: this.file.name,
        fileSize: this.file.size,
    }));
}

// Resume from localStorage
resumeFromStorage(fileId) {
    const data = localStorage.getItem(`upload_${fileId}`);
    if (data) {
        const progress = JSON.parse(data);
        this.currentChunk = progress.currentChunk;
        this.uploadedBytes = this.currentChunk * this.chunkSize;
    }
}
```

### Parallel Chunk Uploads

```javascript
async uploadParallel(concurrency = 3) {
    const queue = [...Array(this.totalChunks).keys()];
    const workers = [];

    for (let i = 0; i < concurrency; i++) {
        workers.push(this.uploadWorker(queue));
    }

    await Promise.all(workers);
}

async uploadWorker(queue) {
    while (queue.length > 0 && !this.isCancelled) {
        const index = queue.shift();
        const chunk = this.getChunk(index);
        await this.uploadChunk(chunk, index);
        this.uploadedChunks++;
        this.updateProgress();
    }
}
```

## Testing

```javascript
// Test with mock file
function createMockFile(sizeMB) {
    const size = sizeMB * 1024 * 1024;
    const blob = new Blob([new ArrayBuffer(size)]);
    return new File([blob], 'test.bin', { type: 'application/octet-stream' });
}

// Test upload
const testFile = createMockFile(100); // 100MB test file
const uploader = new ChunkedUploader(testFile);
uploader.upload();
```

## Related Documentation

- [Chunked Uploads](/docs/chunked-uploads)
- [File Uploads](/docs/features/file-uploads)
- [Video Processing](/docs/video-processing)

## Best Practices

1. **Choose appropriate chunk size** - 5-10MB for most cases
2. **Implement retry logic** - Handle network failures
3. **Save progress** - Allow resume after page reload
4. **Validate on server** - Check file type and size
5. **Clean up abandoned chunks** - Schedule cleanup tasks
6. **Show progress feedback** - Keep users informed
7. **Handle errors gracefully** - Provide clear error messages
