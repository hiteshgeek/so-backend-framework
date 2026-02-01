# File Uploads - Developer Guide

**SO Framework** | **Handling File Uploads** | **Version 1.0**

A comprehensive guide to handling file uploads, validation, storage, and security in the SO Framework.

---

## Table of Contents

1. [Overview](#overview)
2. [Basic File Upload](#basic-file-upload)
3. [File Validation](#file-validation)
4. [Storing Uploaded Files](#storing-uploaded-files)
5. [Security Best Practices](#security-best-practices)
6. [Complete Examples](#complete-examples)

---

## Overview

The SO Framework provides a simple, secure API for handling file uploads through the `Request` class and `UploadedFile` class.

### Key Classes

- **Request::file()** -- Retrieve uploaded files
- **UploadedFile** -- Represents an uploaded file with helper methods

### Common Use Cases

- User profile pictures
- Document uploads
- Image galleries
- CSV import files
- PDF attachments

---

## Basic File Upload

### HTML Form

Create a form with `enctype="multipart/form-data"`:

```php
<form action="/upload" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <label>Upload File:</label>
    <input type="file" name="document">

    <button type="submit">Upload</button>
</form>
```

**Important:** The `enctype="multipart/form-data"` attribute is **required** for file uploads.

### Controller - Retrieving Files

```php
use Core\Http\Request;
use Core\Http\Response;

public function upload(Request $request): Response
{
    $file = $request->file('document');

    if (!$file) {
        return redirect()->back()->withErrors(['document' => 'No file uploaded']);
    }

    if (!$file->isValid()) {
        return redirect()->back()->withErrors(['document' => 'File upload failed']);
    }

    // File is valid - process it
    $file->move(storage_path('uploads'), 'mydocument.pdf');

    return redirect('/dashboard')->with('success', 'File uploaded successfully');
}
```

### UploadedFile Methods

| Method | Returns | Description |
|--------|---------|-------------|
| `isValid()` | `bool` | Check if upload succeeded |
| `getClientOriginalName()` | `string` | Original filename from user |
| `getSize()` | `int` | File size in bytes |
| `getMimeType()` | `string` | MIME type (e.g., `image/jpeg`) |
| `getExtension()` | `string` | File extension (e.g., `jpg`) |
| `move($dir, $name)` | `bool` | Move file to destination |

---

## File Validation

### Validating File Size

```php
public function upload(Request $request): Response
{
    $file = $request->file('photo');

    if (!$file || !$file->isValid()) {
        return redirect()->back()->withErrors(['photo' => 'Invalid file']);
    }

    // Check file size (5MB max)
    $maxSize = 5 * 1024 * 1024; // 5MB in bytes
    if ($file->getSize() > $maxSize) {
        return redirect()->back()->withErrors(['photo' => 'File too large (max 5MB)']);
    }

    // Process file...
}
```

### Validating File Type

```php
public function upload(Request $request): Response
{
    $file = $request->file('photo');

    if (!$file || !$file->isValid()) {
        return redirect()->back()->withErrors(['photo' => 'Invalid file']);
    }

    // Check MIME type
    $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file->getMimeType(), $allowedMimes)) {
        return redirect()->back()->withErrors(['photo' => 'Only JPG, PNG, and GIF images allowed']);
    }

    // Check extension
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array(strtolower($file->getExtension()), $allowedExtensions)) {
        return redirect()->back()->withErrors(['photo' => 'Invalid file extension']);
    }

    // Process file...
}
```

### Using Validator

Combine validation rules with the framework's validator:

```php
use Core\Validation\Validator;

public function upload(Request $request): Response
{
    // Basic input validation
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'description' => 'string|max:1000',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator->errors());
    }

    // File validation
    $file = $request->file('photo');

    if (!$file || !$file->isValid()) {
        return redirect()->back()->withErrors(['photo' => 'Photo is required']);
    }

    // Check file constraints
    if ($file->getSize() > 5 * 1024 * 1024) {
        return redirect()->back()->withErrors(['photo' => 'Photo must be less than 5MB']);
    }

    $allowedMimes = ['image/jpeg', 'image/png'];
    if (!in_array($file->getMimeType(), $allowedMimes)) {
        return redirect()->back()->withErrors(['photo' => 'Photo must be JPG or PNG']);
    }

    // Process file...
}
```

---

## Storing Uploaded Files

### Basic Storage

```php
$file = $request->file('document');

// Store with original name
$file->move(storage_path('uploads'));

// Store with custom name
$file->move(storage_path('uploads'), 'report-2024.pdf');
```

### Generate Unique Filenames

Avoid filename collisions by generating unique names:

```php
$file = $request->file('photo');

// Generate unique filename
$filename = time() . '-' . uniqid() . '.' . $file->getExtension();

$file->move(storage_path('uploads/photos'), $filename);

// Save to database
$photo = Photo::create([
    'filename' => $filename,
    'original_name' => $file->getClientOriginalName(),
    'size' => $file->getSize(),
    'mime_type' => $file->getMimeType(),
]);
```

### Organize by Date

```php
$file = $request->file('document');

// Create directory structure: uploads/2024/01/
$directory = storage_path('uploads/' . date('Y/m'));

if (!is_dir($directory)) {
    mkdir($directory, 0755, true);
}

$filename = time() . '-' . $file->getClientOriginalName();
$file->move($directory, $filename);

// Save relative path to database
$relativePath = 'uploads/' . date('Y/m') . '/' . $filename;
```

### Store by User

```php
$file = $request->file('avatar');
$user = auth()->user();

// Create user-specific directory
$directory = storage_path("uploads/users/{$user['id']}/avatars");

if (!is_dir($directory)) {
    mkdir($directory, 0755, true);
}

$filename = 'avatar-' . time() . '.' . $file->getExtension();
$file->move($directory, $filename);

// Update user record
User::where('id', $user['id'])->update([
    'avatar' => "uploads/users/{$user['id']}/avatars/{$filename}"
]);
```

---

## Security Best Practices

### 1. Never Trust the MIME Type Alone

MIME types can be spoofed. Always validate file extensions AND content:

```php
// Bad - only checking MIME
if ($file->getMimeType() === 'image/jpeg') {
    // Attacker can fake this
}

// Good - check both MIME and extension
$allowedMimes = ['image/jpeg', 'image/png'];
$allowedExtensions = ['jpg', 'jpeg', 'png'];

if (!in_array($file->getMimeType(), $allowedMimes) ||
    !in_array($file->getExtension(), $allowedExtensions)) {
    return redirect()->back()->withErrors(['file' => 'Invalid file type']);
}
```

### 2. Validate File Content

For images, verify the file is actually an image:

```php
$file = $request->file('photo');

// Move to temporary location
$tempPath = storage_path('temp/' . uniqid() . '.' . $file->getExtension());
$file->move(dirname($tempPath), basename($tempPath));

// Verify it's a valid image
$imageInfo = getimagesize($tempPath);
if ($imageInfo === false) {
    unlink($tempPath); // Delete invalid file
    return redirect()->back()->withErrors(['photo' => 'File is not a valid image']);
}

// Image is valid - move to final location
rename($tempPath, storage_path('uploads/photos/' . basename($tempPath)));
```

### 3. Sanitize Filenames

Never use user-provided filenames directly:

```php
// Bad - user filename could be "../../../etc/passwd"
$filename = $file->getClientOriginalName();
$file->move(storage_path('uploads'), $filename);

// Good - generate safe filename
$safeFilename = time() . '-' . preg_replace('/[^a-z0-9\.\-_]/i', '', $file->getClientOriginalName());
$file->move(storage_path('uploads'), $safeFilename);
```

### 4. Store Files Outside Web Root

Never store uploads in the `public/` directory:

```php
// Bad - accessible via direct URL
$file->move(public_path('uploads'), $filename);
// File accessible at: https://example.com/uploads/file.pdf

// Good - stored outside public directory
$file->move(storage_path('uploads'), $filename);
// File NOT directly accessible - must go through controller
```

Serve files through a controller with access control:

```php
// Route
Router::get('/files/{id}', [FileController::class, 'download']);

// Controller
public function download(Request $request, int $id): Response
{
    $file = File::find($id);

    if (!$file || !auth()->check()) {
        return Response::view('errors/404', [], 404);
    }

    $path = storage_path($file->path);

    if (!file_exists($path)) {
        return Response::view('errors/404', [], 404);
    }

    return Response::download($path, $file->original_name);
}
```

### 5. Limit File Sizes

Configure PHP upload limits in `php.ini`:

```ini
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
```

Validate in application code:

```php
$maxSize = 10 * 1024 * 1024; // 10MB

if ($file->getSize() > $maxSize) {
    return redirect()->back()->withErrors(['file' => 'File exceeds 10MB limit']);
}
```

### 6. Prevent Code Execution

Disable script execution in upload directories with `.htaccess`:

```apache
# storage/uploads/.htaccess
<Files *>
    SetHandler none
    SetHandler default-handler
    Options -ExecCGI
    RemoveHandler .cgi .php .php3 .php4 .php5 .phtml .pl .py .pyc .pyo
</Files>
```

---

## Complete Examples

### Example 1: Profile Picture Upload

**Form:**

```php
<form action="/profile/upload-avatar" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div>
        <label>Profile Picture:</label>
        <input type="file" name="avatar" accept="image/*">
        <small>Max 2MB. JPG, PNG, or GIF only.</small>
    </div>

    <button type="submit">Upload</button>
</form>
```

**Controller:**

```php
use Core\Http\Request;
use Core\Http\Response;
use App\Models\User;

public function uploadAvatar(Request $request): Response
{
    $user = auth()->user();
    $file = $request->file('avatar');

    // Validate file exists
    if (!$file || !$file->isValid()) {
        return redirect()->back()->withErrors(['avatar' => 'Please select a valid image']);
    }

    // Validate file size (2MB)
    if ($file->getSize() > 2 * 1024 * 1024) {
        return redirect()->back()->withErrors(['avatar' => 'Image must be less than 2MB']);
    }

    // Validate file type
    $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($file->getMimeType(), $allowedMimes) ||
        !in_array(strtolower($file->getExtension()), $allowedExtensions)) {
        return redirect()->back()->withErrors(['avatar' => 'Only JPG, PNG, and GIF images allowed']);
    }

    // Create user directory
    $directory = storage_path("uploads/avatars/{$user['id']}");
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    // Delete old avatar if exists
    if ($user['avatar']) {
        $oldPath = storage_path($user['avatar']);
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }
    }

    // Generate unique filename
    $filename = 'avatar-' . time() . '.' . $file->getExtension();

    // Move file
    $file->move($directory, $filename);

    // Update user record
    $avatarPath = "uploads/avatars/{$user['id']}/{$filename}";
    User::where('id', $user['id'])->update(['avatar' => $avatarPath]);

    return redirect('/profile')->with('success', 'Profile picture updated successfully');
}
```

### Example 2: Document Upload with Database Record

**Migration:**

```php
Schema::create('documents', function($table) {
    $table->id();
    $table->integer('user_id');
    $table->string('title');
    $table->string('filename');
    $table->string('original_name');
    $table->string('mime_type');
    $table->integer('size');
    $table->string('path');
    $table->timestamps();
});
```

**Controller:**

```php
use App\Models\Document;

public function uploadDocument(Request $request): Response
{
    // Validate input
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator->errors());
    }

    // Get file
    $file = $request->file('document');

    if (!$file || !$file->isValid()) {
        return redirect()->back()->withErrors(['document' => 'Document is required']);
    }

    // Validate file type (PDF or Word)
    $allowedMimes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    $allowedExtensions = ['pdf', 'doc', 'docx'];

    if (!in_array($file->getMimeType(), $allowedMimes) ||
        !in_array(strtolower($file->getExtension()), $allowedExtensions)) {
        return redirect()->back()->withErrors(['document' => 'Only PDF and Word documents allowed']);
    }

    // Validate size (10MB)
    if ($file->getSize() > 10 * 1024 * 1024) {
        return redirect()->back()->withErrors(['document' => 'Document must be less than 10MB']);
    }

    // Create directory structure
    $directory = storage_path('uploads/documents/' . date('Y/m'));
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    // Generate unique filename
    $filename = time() . '-' . uniqid() . '.' . $file->getExtension();

    // Move file
    $file->move($directory, $filename);

    // Create database record
    $document = Document::create([
        'user_id' => auth()->user()['id'],
        'title' => $request->input('title'),
        'filename' => $filename,
        'original_name' => $file->getClientOriginalName(),
        'mime_type' => $file->getMimeType(),
        'size' => $file->getSize(),
        'path' => 'uploads/documents/' . date('Y/m') . '/' . $filename,
    ]);

    return redirect('/documents')->with('success', 'Document uploaded successfully');
}
```

### Example 3: Multiple File Upload

**Form:**

```php
<form action="/photos/upload" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <input type="file" name="photos[]" multiple accept="image/*">

    <button type="submit">Upload Photos</button>
</form>
```

**Controller:**

```php
public function uploadPhotos(Request $request): Response
{
    if (!isset($_FILES['photos'])) {
        return redirect()->back()->withErrors(['photos' => 'No photos selected']);
    }

    $uploaded = 0;
    $errors = [];

    // Process each file
    foreach ($_FILES['photos']['tmp_name'] as $index => $tmpName) {
        // Build file array
        $fileData = [
            'name' => $_FILES['photos']['name'][$index],
            'type' => $_FILES['photos']['type'][$index],
            'tmp_name' => $tmpName,
            'error' => $_FILES['photos']['error'][$index],
            'size' => $_FILES['photos']['size'][$index],
        ];

        $file = new \Core\Http\UploadedFile($fileData);

        // Validate
        if (!$file->isValid()) {
            $errors[] = "Failed to upload {$file->getClientOriginalName()}";
            continue;
        }

        if ($file->getSize() > 5 * 1024 * 1024) {
            $errors[] = "{$file->getClientOriginalName()} exceeds 5MB";
            continue;
        }

        $allowedMimes = ['image/jpeg', 'image/png'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            $errors[] = "{$file->getClientOriginalName()} is not a valid image";
            continue;
        }

        // Store file
        $directory = storage_path('uploads/photos/' . date('Y/m'));
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = time() . '-' . uniqid() . '.' . $file->getExtension();
        $file->move($directory, $filename);

        // Create database record
        Photo::create([
            'user_id' => auth()->user()['id'],
            'filename' => $filename,
            'path' => 'uploads/photos/' . date('Y/m') . '/' . $filename,
        ]);

        $uploaded++;
    }

    if ($uploaded > 0) {
        $message = "Successfully uploaded {$uploaded} photo(s)";
        if (count($errors) > 0) {
            $message .= '. Some uploads failed.';
        }
        return redirect('/photos')->with('success', $message);
    }

    return redirect()->back()->withErrors(['photos' => implode(', ', $errors)]);
}
```

---

**Related Documentation:**
- [Forms & Validation](/docs/dev/forms-validation) - Form handling and validation
- [Models](/docs/dev/models) - Database models
- [Security](/docs/dev/security) - Security best practices

---

**Last Updated**: 2026-01-31
**Framework Version**: 1.0
