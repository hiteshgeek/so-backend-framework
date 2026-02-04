<?php
/**
 * SixOrbit UI Engine - Dropzone Element Demo
 */

$pageTitle = 'Dropzone - UI Engine';
$pageDescription = 'Drag-and-drop file upload area with previews';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Dropzone</h1>
            <p class="so-page-subtitle">Drag-and-drop file upload area with file previews, progress indicators, and validation.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Dropzone -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Dropzone</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-form-group">
                    <label class="so-form-label">Upload Files</label>
                    <div class="so-form-file-dropzone" id="demo-dropzone-basic">
                        <input type="file" multiple>
                        <div class="so-form-file-dropzone-icon">
                            <span class="material-icons">cloud_upload</span>
                        </div>
                        <div class="so-form-file-dropzone-text">
                            Drag & drop files here, or <span>click to browse</span>
                        </div>
                        <div class="so-form-file-dropzone-hint">
                            Supports all file types
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-dropzone', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$dropzone = UiEngine::dropzone('files')
    ->label('Upload Files')
    ->message('Drag & drop files here or click to upload');

echo \$dropzone->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const dropzone = UiEngine.dropzone('files')
    .label('Upload Files')
    .message('Drag & drop files here or click to upload');

document.getElementById('container').innerHTML = dropzone.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-dropzone">
    <div class="so-dropzone-area">
        <span class="material-icons so-dropzone-icon">cloud_upload</span>
        <p class="so-dropzone-message">Drag & drop files here or click to upload</p>
        <input type="file" class="so-dropzone-input" name="files[]" multiple>
    </div>
    <div class="so-dropzone-preview"></div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With File Type Restrictions -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">File Type Restrictions</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-form-group">
                    <label class="so-form-label">Upload Images</label>
                    <div class="so-form-file-dropzone" id="demo-dropzone-images">
                        <input type="file" multiple accept="image/jpeg,image/png,image/gif">
                        <div class="so-form-file-dropzone-icon">
                            <span class="material-icons">add_photo_alternate</span>
                        </div>
                        <div class="so-form-file-dropzone-text">
                            <span>Click to upload</span> or drag and drop
                        </div>
                        <div class="so-form-file-dropzone-hint">
                            Accepts: JPG, PNG, GIF (max 5MB)
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('dropzone-types', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$dropzone = UiEngine::dropzone('images')
    ->label('Upload Images')
    ->images()  // Shortcut for accept('image/*')
    ->maxFileSizeMB(5)  // 5MB
    ->icon('add_photo_alternate')
    ->message('Click to upload or drag and drop images');

echo \$dropzone->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const dropzone = UiEngine.dropzone('images')
    .label('Upload Images')
    .images()  // Shortcut for accept('image/*')
    .maxFileSizeMB(5)  // 5MB
    .icon('add_photo_alternate')
    .message('Click to upload or drag and drop images');

document.getElementById('container').innerHTML = dropzone.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-dropzone">
    <div class="so-dropzone-area">
        <span class="material-icons so-dropzone-icon">add_photo_alternate</span>
        <p class="so-dropzone-message">Click to upload or drag and drop images</p>
        <input type="file" class="so-dropzone-input" name="images[]" accept="image/*" multiple>
    </div>
    <div class="so-dropzone-preview"></div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Document Upload -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Document Upload</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-form-group">
                    <label class="so-form-label">Upload Documents</label>
                    <div class="so-form-file-dropzone" id="demo-dropzone-docs">
                        <input type="file" multiple accept=".pdf,.doc,.docx,.xls,.xlsx">
                        <div class="so-form-file-dropzone-icon">
                            <span class="material-icons">description</span>
                        </div>
                        <div class="so-form-file-dropzone-text">
                            Drag & drop files here, or <span>click to browse</span>
                        </div>
                        <div class="so-form-file-dropzone-hint">
                            Supports: PDF, DOC, DOCX, XLS, XLSX (max 10MB)
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('dropzone-docs', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$dropzone = UiEngine::dropzone('documents')
    ->label('Upload Documents')
    ->documents()  // Shortcut for common document types
    ->maxFileSizeMB(10)  // 10MB
    ->icon('description')
    ->message('Drag & drop documents here or click to browse');

echo \$dropzone->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const dropzone = UiEngine.dropzone('documents')
    .label('Upload Documents')
    .documents()  // Shortcut for common document types
    .maxFileSizeMB(10)  // 10MB
    .icon('description')
    .message('Drag & drop documents here or click to browse');

document.getElementById('container').innerHTML = dropzone.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-dropzone">
    <div class="so-dropzone-area">
        <span class="material-icons so-dropzone-icon">description</span>
        <p class="so-dropzone-message">Drag & drop documents here or click to browse</p>
        <input type="file" class="so-dropzone-input" name="documents[]"
               accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt" multiple>
    </div>
    <div class="so-dropzone-preview"></div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Compact Profile Photo -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Compact Profile Photo Upload</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-form-group">
                    <label class="so-form-label">Profile Photo</label>
                    <div class="so-form-file-dropzone" id="demo-dropzone-avatar" style="padding: 2rem;">
                        <input type="file" accept="image/*">
                        <div class="so-form-file-dropzone-icon">
                            <span class="material-icons">account_circle</span>
                        </div>
                        <div class="so-form-file-dropzone-text">
                            <span>Click to upload</span> or drag and drop
                        </div>
                        <div class="so-form-file-dropzone-hint">
                            PNG, JPG or GIF (max 2MB)
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('dropzone-avatar', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$dropzone = UiEngine::dropzone('avatar')
    ->label('Profile Photo')
    ->images()  // Accept image/*
    ->single()  // Only one file
    ->maxFileSizeMB(2)  // 2MB
    ->icon('account_circle')
    ->message('Click to upload or drag photo');

echo \$dropzone->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const dropzone = UiEngine.dropzone('avatar')
    .label('Profile Photo')
    .images()  // Accept image/*
    .single()  // Only one file
    .maxFileSizeMB(2)  // 2MB
    .icon('account_circle')
    .message('Click to upload or drag photo');

document.getElementById('container').innerHTML = dropzone.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-dropzone">
    <div class="so-dropzone-area">
        <span class="material-icons so-dropzone-icon">account_circle</span>
        <p class="so-dropzone-message">Click to upload or drag photo</p>
        <input type="file" class="so-dropzone-input" name="avatar" accept="image/*">
    </div>
    <div class="so-dropzone-preview"></div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Event Handlers -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Event Handlers</h3>
            </div>
            <div class="so-card-body">
                <!-- Code Tabs -->
                <?= so_code_tabs('dropzone-events', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$dropzone = UiEngine::dropzone('upload')
    ->label('Upload Files')
    ->multiple()
    ->accept('image/*')
    ->maxSize(5 * 1024 * 1024);

echo \$dropzone->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Initialize dropzone with event handlers
const dropzoneEl = document.querySelector('.so-form-file-dropzone');
const input = dropzoneEl.querySelector('input[type=\"file\"]');

// Prevent default drag behaviors
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropzoneEl.addEventListener(eventName, (e) => {
        e.preventDefault();
        e.stopPropagation();
    }, false);
});

// Highlight dropzone when dragging over
['dragenter', 'dragover'].forEach(eventName => {
    dropzoneEl.addEventListener(eventName, () => {
        dropzoneEl.classList.add('so-dragover');
    }, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropzoneEl.addEventListener(eventName, () => {
        dropzoneEl.classList.remove('so-dragover');
    }, false);
});

// Handle dropped files
dropzoneEl.addEventListener('drop', (e) => {
    const files = e.dataTransfer.files;
    input.files = files;
    handleFiles(files);
}, false);

// Handle file input change
input.addEventListener('change', function() {
    handleFiles(this.files);
});

function handleFiles(files) {
    if (files.length > 0) {
        const fileNames = Array.from(files).map(f => f.name).join(', ');
        const textEl = dropzoneEl.querySelector('.so-form-file-dropzone-text');
        textEl.innerHTML = '<strong>' + files.length + ' file(s) selected:</strong> ' + fileNames;
    }
}"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-form-group">
    <label class="so-form-label">Upload Files</label>
    <div class="so-form-file-dropzone">
        <input type="file" multiple accept="image/*">
        <div class="so-form-file-dropzone-icon">
            <span class="material-icons">cloud_upload</span>
        </div>
        <div class="so-form-file-dropzone-text">
            Drag & drop files here, or <span>click to browse</span>
        </div>
        <div class="so-form-file-dropzone-hint">
            Accepts images (max 5MB)
        </div>
    </div>
</div>

<!-- Drag-over state adds .so-dragover class -->
<div class="so-form-file-dropzone so-dragover">
    <!-- ... -->
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- API Reference -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">API Reference</h3>
            </div>
            <div class="so-card-body">
                <!-- API Tabs -->
                <div class="so-tabs" role="tablist" data-so-tabs>
                    <button class="so-tab so-active" role="tab" data-so-target="#api-php">PHP Class</button>
                    <button class="so-tab" role="tab" data-so-target="#api-js">JS UiEngine</button>
                </div>

                <div class="so-tab-content">
                    <!-- PHP Class Reference -->
                    <div class="so-tab-pane so-fade so-show so-active" id="api-php" role="tabpanel">
                        <h5 class="so-mt-3">Core\\UiEngine\\Elements\\Form\\Dropzone</h5>
                        <p class="so-text-muted">Extends FormElement</p>

                        <h6 class="so-mt-4">Constructor</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <tbody>
                                    <tr>
                                        <td><code>UiEngine::dropzone(string $name)</code></td>
                                        <td>Create dropzone with name</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">File Type Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>accept(string $types)</code></td>
                                        <td>Set accepted MIME types or extensions</td>
                                    </tr>
                                    <tr>
                                        <td><code>images()</code></td>
                                        <td>Shortcut for accept('image/*')</td>
                                    </tr>
                                    <tr>
                                        <td><code>documents()</code></td>
                                        <td>Accept common document types (PDF, DOC, XLS, etc.)</td>
                                    </tr>
                                    <tr>
                                        <td><code>videos()</code></td>
                                        <td>Shortcut for accept('video/*')</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Size & Count Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>maxFileSize(int $bytes)</code></td>
                                        <td>Maximum file size in bytes</td>
                                    </tr>
                                    <tr>
                                        <td><code>maxFileSizeMB(int $mb)</code></td>
                                        <td>Maximum file size in megabytes</td>
                                    </tr>
                                    <tr>
                                        <td><code>maxFiles(int $max)</code></td>
                                        <td>Maximum number of files</td>
                                    </tr>
                                    <tr>
                                        <td><code>multiple(bool $val = true)</code></td>
                                        <td>Allow multiple file selection</td>
                                    </tr>
                                    <tr>
                                        <td><code>single()</code></td>
                                        <td>Allow only single file (multiple=false)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Display & Upload Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>message(string $msg)</code></td>
                                        <td>Set dropzone message text</td>
                                    </tr>
                                    <tr>
                                        <td><code>icon(string $icon)</code></td>
                                        <td>Set Material icon name</td>
                                    </tr>
                                    <tr>
                                        <td><code>showPreview(bool $show = true)</code></td>
                                        <td>Show file preview area</td>
                                    </tr>
                                    <tr>
                                        <td><code>hidePreview()</code></td>
                                        <td>Hide file preview area</td>
                                    </tr>
                                    <tr>
                                        <td><code>uploadUrl(string $url)</code></td>
                                        <td>Set server upload URL</td>
                                    </tr>
                                    <tr>
                                        <td><code>autoUpload(bool $auto = true)</code></td>
                                        <td>Auto-upload files on selection</td>
                                    </tr>
                                    <tr>
                                        <td><code>existingFiles(array $files)</code></td>
                                        <td>Set existing files for edit mode</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- JS UiEngine Reference -->
                    <div class="so-tab-pane so-fade" id="api-js" role="tabpanel">
                        <h5 class="so-mt-3">UiEngine.dropzone()</h5>
                        <p class="so-text-muted">Extends FormElement</p>

                        <h6 class="so-mt-4">Constructor</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <tbody>
                                    <tr>
                                        <td><code>UiEngine.dropzone(name)</code></td>
                                        <td>Create dropzone with name</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">File Type Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>accept(types)</code></td>
                                        <td>Set accepted MIME types or extensions</td>
                                    </tr>
                                    <tr>
                                        <td><code>images()</code></td>
                                        <td>Shortcut for accept('image/*')</td>
                                    </tr>
                                    <tr>
                                        <td><code>documents()</code></td>
                                        <td>Accept common document types</td>
                                    </tr>
                                    <tr>
                                        <td><code>videos()</code></td>
                                        <td>Shortcut for accept('video/*')</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Size & Count Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>maxFileSize(bytes)</code></td>
                                        <td>Maximum file size in bytes</td>
                                    </tr>
                                    <tr>
                                        <td><code>maxFileSizeMB(mb)</code></td>
                                        <td>Maximum file size in megabytes</td>
                                    </tr>
                                    <tr>
                                        <td><code>maxFiles(max)</code></td>
                                        <td>Maximum number of files</td>
                                    </tr>
                                    <tr>
                                        <td><code>multiple(val = true)</code></td>
                                        <td>Allow multiple file selection</td>
                                    </tr>
                                    <tr>
                                        <td><code>single()</code></td>
                                        <td>Allow only single file</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Display & Upload Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>message(msg)</code></td>
                                        <td>Set dropzone message text</td>
                                    </tr>
                                    <tr>
                                        <td><code>icon(icon)</code></td>
                                        <td>Set Material icon name</td>
                                    </tr>
                                    <tr>
                                        <td><code>showPreview(val = true)</code></td>
                                        <td>Show file preview area</td>
                                    </tr>
                                    <tr>
                                        <td><code>hidePreview()</code></td>
                                        <td>Hide file preview area</td>
                                    </tr>
                                    <tr>
                                        <td><code>uploadUrl(url)</code></td>
                                        <td>Set server upload URL</td>
                                    </tr>
                                    <tr>
                                        <td><code>autoUpload(val = true)</code></td>
                                        <td>Auto-upload files on selection</td>
                                    </tr>
                                    <tr>
                                        <td><code>existingFiles(files)</code></td>
                                        <td>Set existing files for edit mode</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Element Methods (Base)</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>id(id)</code></td>
                                        <td>Set element ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>addClass(className)</code></td>
                                        <td>Add CSS class</td>
                                    </tr>
                                    <tr>
                                        <td><code>attr(name, value)</code></td>
                                        <td>Set attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>data(key, value)</code></td>
                                        <td>Set data attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>toHtml()</code></td>
                                        <td>Get HTML string</td>
                                    </tr>
                                    <tr>
                                        <td><code>render()</code></td>
                                        <td>Render to DOM element</td>
                                    </tr>
                                    <tr>
                                        <td><code>toConfig()</code></td>
                                        <td>Export configuration object</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <h4 class="so-mt-4">CSS Classes</h4>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead class="so-table-light">
                            <tr>
                                <th>Class</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>.so-dropzone</code></td>
                                <td>Main dropzone container</td>
                            </tr>
                            <tr>
                                <td><code>.so-dropzone-area</code></td>
                                <td>Drop area wrapper</td>
                            </tr>
                            <tr>
                                <td><code>.so-dropzone-icon</code></td>
                                <td>Icon element</td>
                            </tr>
                            <tr>
                                <td><code>.so-dropzone-message</code></td>
                                <td>Message text</td>
                            </tr>
                            <tr>
                                <td><code>.so-dropzone-input</code></td>
                                <td>Hidden file input</td>
                            </tr>
                            <tr>
                                <td><code>.so-dropzone-preview</code></td>
                                <td>File preview container</td>
                            </tr>
                            <tr>
                                <td><code>.so-dropzone-file</code></td>
                                <td>Individual file preview item</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>

<script>
// Initialize dropzone functionality for all demo dropzones
document.querySelectorAll('.so-form-file-dropzone').forEach(dropzone => {
    const input = dropzone.querySelector('input[type="file"]');

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
        }, false);
    });

    // Highlight dropzone when dragging over
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, () => {
            dropzone.classList.add('so-dragover');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, () => {
            dropzone.classList.remove('so-dragover');
        }, false);
    });

    // Handle dropped files
    dropzone.addEventListener('drop', (e) => {
        const files = e.dataTransfer.files;
        input.files = files;
        handleDropzoneFiles(files, dropzone);
    }, false);

    // Handle file input change
    input.addEventListener('change', function() {
        handleDropzoneFiles(this.files, dropzone);
    });
});

function handleDropzoneFiles(files, dropzone) {
    if (files.length > 0) {
        const fileNames = Array.from(files).map(f => f.name).join(', ');
        const textEl = dropzone.querySelector('.so-form-file-dropzone-text');
        textEl.innerHTML = '<strong>' + files.length + ' file(s) selected:</strong> ' + fileNames;
    }
}
</script>
