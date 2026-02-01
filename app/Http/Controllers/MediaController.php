<?php

namespace App\Http\Controllers;

use Core\Http\Request;
use Core\Http\Response;
use App\Models\Media;
use Core\Media\StorageManager;

/**
 * MediaController
 *
 * Handles secure file access and downloads.
 * Provides controlled access to media files with authentication.
 *
 * Routes:
 * - GET /files/{id} - View file
 * - GET /files/{id}/download - Download file
 * - POST /files/upload - Upload file
 * - DELETE /files/{id} - Delete file
 */
class MediaController
{
    /**
     * Storage manager
     */
    protected StorageManager $storage;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->storage = new StorageManager();
    }

    /**
     * Show file (serve for viewing)
     *
     * @param Request $request
     * @param int $id Media ID
     * @return Response
     */
    public function show(Request $request, int $id): Response
    {
        $media = Media::find($id);

        if (!$media) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $fullPath = $media->getFullPath();

        if (!file_exists($fullPath)) {
            return response()->json(['error' => 'File does not exist'], 404);
        }

        // Send file with appropriate headers
        return $this->sendFile($fullPath, $media->mime_type, $media->original_name, false);
    }

    /**
     * Download file
     *
     * @param Request $request
     * @param int $id Media ID
     * @return Response
     */
    public function download(Request $request, int $id): Response
    {
        $media = Media::find($id);

        if (!$media) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $fullPath = $media->getFullPath();

        if (!file_exists($fullPath)) {
            return response()->json(['error' => 'File does not exist'], 404);
        }

        // Send file as download
        return $this->sendFile($fullPath, $media->mime_type, $media->original_name, true);
    }

    /**
     * Upload file
     *
     * @param Request $request
     * @return Response
     */
    public function upload(Request $request): Response
    {
        $file = $request->file('file');

        if (!$file) {
            return response()->json(['error' => 'No file provided'], 400);
        }

        // Get upload options
        $folder = $request->input('folder', null);
        $generateVariants = $request->input('variants', true);
        $watermark = $request->input('watermark', null);

        // Upload and create media record
        $options = [
            'variants' => filter_var($generateVariants, FILTER_VALIDATE_BOOLEAN),
        ];

        if ($watermark) {
            $options['watermark'] = $watermark;
        }

        $media = $file->storeAndCreate($folder, $options);

        if (!$media) {
            return response()->json(['error' => 'Upload failed'], 500);
        }

        // Return media details
        return response()->json([
            'success' => true,
            'media' => $media->toArray(),
        ], 201);
    }

    /**
     * Delete file
     *
     * @param Request $request
     * @param int $id Media ID
     * @return Response
     */
    public function destroy(Request $request, int $id): Response
    {
        $media = Media::find($id);

        if (!$media) {
            return response()->json(['error' => 'File not found'], 404);
        }

        // Delete file and variants
        if (!$media->deleteFile()) {
            return response()->json(['error' => 'Failed to delete file'], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'File deleted successfully',
        ]);
    }

    /**
     * Get media details
     *
     * @param Request $request
     * @param int $id Media ID
     * @return Response
     */
    public function details(Request $request, int $id): Response
    {
        $media = Media::find($id);

        if (!$media) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return response()->json([
            'success' => true,
            'media' => $media->toArray(),
        ]);
    }

    /**
     * List media files
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        // Get pagination parameters
        $page = max(1, (int)$request->input('page', 1));
        $perPage = min(100, max(1, (int)$request->input('per_page', 20)));

        // Get filters
        $type = $request->input('type', null); // 'image', 'document', etc.

        // Build query
        $query = Media::query();

        // Filter by type
        if ($type === 'image') {
            $query->where('mime_type', 'LIKE', 'image/%');
        } elseif ($type === 'document') {
            $query->whereIn('mime_type', [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ]);
        }

        // Only show parent files (not variants)
        $query->whereNull('parent_id');

        // Order by newest first
        $query->orderBy('created_at', 'DESC');

        // Get total count
        $total = $query->count();

        // Get paginated results
        $offset = ($page - 1) * $perPage;
        $media = $query->limit($perPage)->offset($offset)->get();

        // Convert to array
        $items = array_map(fn($m) => $m->toArray(), $media);

        return response()->json([
            'success' => true,
            'data' => $items,
            'pagination' => [
                'page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'pages' => ceil($total / $perPage),
            ],
        ]);
    }

    /**
     * Send file with appropriate headers
     *
     * @param string $path Full file path
     * @param string $mimeType MIME type
     * @param string $filename Original filename
     * @param bool $download Force download
     * @return Response
     */
    protected function sendFile(string $path, string $mimeType, string $filename, bool $download = false): Response
    {
        $response = new Response();

        // Set headers
        $response->header('Content-Type', $mimeType);
        $response->header('Content-Length', (string)filesize($path));

        if ($download) {
            $response->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        } else {
            $response->header('Content-Disposition', 'inline; filename="' . $filename . '"');
        }

        // Cache headers for public files
        $response->header('Cache-Control', 'public, max-age=31536000');
        $response->header('Expires', gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');

        // Read and output file
        $content = file_get_contents($path);
        $response->setContent($content);

        return $response;
    }
}
