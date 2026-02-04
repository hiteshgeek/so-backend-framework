<?php

namespace Core\UiEngine\Elements\Form;

use Core\UiEngine\Elements\FormElement;
use Core\UiEngine\Support\CssPrefix;

/**
 * Dropzone - Drag and drop file upload
 *
 * Provides a drag-and-drop file upload area with preview
 */
class Dropzone extends FormElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'dropzone';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Accepted file types
     *
     * @var string|null
     */
    protected ?string $accept = null;

    /**
     * Allow multiple files
     *
     * @var bool
     */
    protected bool $multiple = true;

    /**
     * Maximum file size in bytes
     *
     * @var int|null
     */
    protected ?int $maxFileSize = null;

    /**
     * Maximum number of files
     *
     * @var int|null
     */
    protected ?int $maxFiles = null;

    /**
     * Upload URL
     *
     * @var string|null
     */
    protected ?string $uploadUrl = null;

    /**
     * Show file preview
     *
     * @var bool
     */
    protected bool $showPreview = true;

    /**
     * Auto upload on drop
     *
     * @var bool
     */
    protected bool $autoUpload = false;

    /**
     * Custom upload message
     *
     * @var string
     */
    protected string $message = 'Drop files here or click to upload';

    /**
     * Custom upload icon
     *
     * @var string
     */
    protected string $icon = 'cloud_upload';

    /**
     * Existing files (for editing)
     *
     * @var array
     */
    protected array $existingFiles = [];

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['accept'])) {
            $this->accept = $config['accept'];
        }

        if (isset($config['multiple'])) {
            $this->multiple = (bool) $config['multiple'];
        }

        if (isset($config['maxFileSize'])) {
            $this->maxFileSize = (int) $config['maxFileSize'];
        }

        if (isset($config['maxFiles'])) {
            $this->maxFiles = (int) $config['maxFiles'];
        }

        if (isset($config['uploadUrl'])) {
            $this->uploadUrl = $config['uploadUrl'];
        }

        if (isset($config['showPreview'])) {
            $this->showPreview = (bool) $config['showPreview'];
        }

        if (isset($config['autoUpload'])) {
            $this->autoUpload = (bool) $config['autoUpload'];
        }

        if (isset($config['message'])) {
            $this->message = $config['message'];
        }

        if (isset($config['icon'])) {
            $this->icon = $config['icon'];
        }

        if (isset($config['existingFiles'])) {
            $this->existingFiles = $config['existingFiles'];
        }
    }

    /**
     * Set accepted file types
     *
     * @param string $accept
     * @return static
     */
    public function accept(string $accept): static
    {
        $this->accept = $accept;
        return $this;
    }

    /**
     * Accept images only
     *
     * @return static
     */
    public function images(): static
    {
        return $this->accept('image/*');
    }

    /**
     * Accept documents
     *
     * @return static
     */
    public function documents(): static
    {
        return $this->accept('.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt');
    }

    /**
     * Accept videos
     *
     * @return static
     */
    public function videos(): static
    {
        return $this->accept('video/*');
    }

    /**
     * Allow multiple files
     *
     * @param bool $multiple
     * @return static
     */
    public function multiple(bool $multiple = true): static
    {
        $this->multiple = $multiple;
        return $this;
    }

    /**
     * Single file only
     *
     * @return static
     */
    public function single(): static
    {
        return $this->multiple(false);
    }

    /**
     * Set maximum file size
     *
     * @param int $bytes
     * @return static
     */
    public function maxFileSize(int $bytes): static
    {
        $this->maxFileSize = $bytes;
        return $this;
    }

    /**
     * Set maximum file size in MB
     *
     * @param int $mb
     * @return static
     */
    public function maxFileSizeMB(int $mb): static
    {
        return $this->maxFileSize($mb * 1024 * 1024);
    }

    /**
     * Set maximum number of files
     *
     * @param int $max
     * @return static
     */
    public function maxFiles(int $max): static
    {
        $this->maxFiles = $max;
        return $this;
    }

    /**
     * Set upload URL
     *
     * @param string $url
     * @return static
     */
    public function uploadUrl(string $url): static
    {
        $this->uploadUrl = $url;
        return $this;
    }

    /**
     * Show/hide preview
     *
     * @param bool $show
     * @return static
     */
    public function showPreview(bool $show = true): static
    {
        $this->showPreview = $show;
        return $this;
    }

    /**
     * Hide preview
     *
     * @return static
     */
    public function hidePreview(): static
    {
        return $this->showPreview(false);
    }

    /**
     * Enable auto upload
     *
     * @param bool $auto
     * @return static
     */
    public function autoUpload(bool $auto = true): static
    {
        $this->autoUpload = $auto;
        return $this;
    }

    /**
     * Set custom upload message
     *
     * @param string $message
     * @return static
     */
    public function uploadMessage(string $message): static
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Set custom icon
     *
     * @param string $icon
     * @return static
     */
    public function icon(string $icon): static
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Set existing files
     *
     * @param array $files
     * @return static
     */
    public function existingFiles(array $files): static
    {
        $this->existingFiles = $files;
        return $this;
    }

    /**
     * Build CSS class string
     *
     * @return string
     */
    /**
     * Override to prevent adding so-form-control class
     * Dropzone is a complex component with its own wrapper structure
     *
     * @return void
     */
    protected function addBaseClasses(): void
    {
        // Do not add form-control class - dropzone has custom structure
    }

    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('form-file-dropzone'));

        if ($this->error) {
            $this->addClass(CssPrefix::cls('is-invalid'));
        }

        return parent::buildClassString();
    }

    /**
     * Gather all attributes for wrapper div
     * Note: name attribute is excluded - it's only on the inner input element
     *
     * @return array<string, mixed>
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = parent::gatherAllAttributes();

        // Remove name attribute - it should only be on the input element
        unset($attrs['name']);

        $attrs[CssPrefix::data('ui-init')] = 'dropzone';

        // Store config for JS initialization
        $config = [
            'multiple' => $this->multiple,
            'showPreview' => $this->showPreview,
            'autoUpload' => $this->autoUpload,
        ];

        if ($this->accept !== null) {
            $config['accept'] = $this->accept;
        }

        if ($this->maxFileSize !== null) {
            $config['maxFileSize'] = $this->maxFileSize;
        }

        if ($this->maxFiles !== null) {
            $config['maxFiles'] = $this->maxFiles;
        }

        if ($this->uploadUrl !== null) {
            $config['uploadUrl'] = $this->uploadUrl;
        }

        if (!empty($this->existingFiles)) {
            $config['existingFiles'] = $this->existingFiles;
        }

        // Don't use htmlspecialchars - attribute values are already escaped in render()
        $attrs[CssPrefix::data('ui-config')] = json_encode($config);

        return $attrs;
    }

    /**
     * Render the complete element
     *
     * @return string
     */
    public function render(): string
    {
        $html = '<div';

        // Build attributes
        $attrs = $this->gatherAllAttributes();
        $attrs['class'] = $this->buildClassString();

        foreach ($attrs as $name => $value) {
            if ($value === true) {
                $html .= ' ' . e($name);
            } elseif ($value !== false && $value !== null) {
                $html .= ' ' . e($name) . '="' . e($value) . '"';
            }
        }

        $html .= '>';

        // Hidden file input (positioned absolutely by CSS)
        $html .= '<input type="file"';
        if ($this->name !== null) {
            $html .= ' name="' . e($this->name) . ($this->multiple ? '[]' : '') . '"';
        }
        if ($this->accept !== null) {
            $html .= ' accept="' . e($this->accept) . '"';
        }
        if ($this->multiple) {
            $html .= ' multiple';
        }
        $html .= '>';

        // Icon
        $html .= '<div class="' . CssPrefix::cls('form-file-dropzone-icon') . '">';
        $html .= '<span class="material-icons">' . e($this->icon) . '</span>';
        $html .= '</div>';

        // Message text with highlighted "click to browse"
        $html .= '<div class="' . CssPrefix::cls('form-file-dropzone-text') . '">';
        $html .= e($this->message);
        $html .= '</div>';

        // Hint text (file type and size info)
        if ($this->accept || $this->maxFileSize) {
            $html .= '<div class="' . CssPrefix::cls('form-file-dropzone-hint') . '">';
            $hints = [];
            if ($this->accept) {
                $hints[] = 'Accepts: ' . e($this->accept);
            }
            if ($this->maxFileSize) {
                $maxMB = round($this->maxFileSize / 1024 / 1024, 0);
                $hints[] = 'Max ' . $maxMB . 'MB';
            }
            $html .= implode(' | ', $hints);
            $html .= '</div>';
        }

        // Preview area for uploaded files
        if ($this->showPreview) {
            $html .= '<div class="' . CssPrefix::cls('form-file-dropzone-files') . '">';

            // Render existing files
            foreach ($this->existingFiles as $file) {
                $html .= $this->renderFilePreview($file);
            }

            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Render file preview item
     *
     * @param array $file
     * @return string
     */
    protected function renderFilePreview(array $file): string
    {
        $html = '<div class="' . CssPrefix::cls('dropzone-file') . '">';

        // Thumbnail or icon
        if (isset($file['thumbnail'])) {
            $html .= '<img src="' . e($file['thumbnail']) . '" class="' . CssPrefix::cls('dropzone-thumb') . '" alt="">';
        } else {
            $html .= '<span class="material-icons ' . CssPrefix::cls('dropzone-file-icon') . '">description</span>';
        }

        // File info
        $html .= '<div class="' . CssPrefix::cls('dropzone-file-info') . '">';
        $html .= '<span class="' . CssPrefix::cls('dropzone-filename') . '">' . e($file['name'] ?? 'File') . '</span>';
        if (isset($file['size'])) {
            $html .= '<span class="' . CssPrefix::cls('dropzone-filesize') . '">' . $this->formatFileSize($file['size']) . '</span>';
        }
        $html .= '</div>';

        // Remove button
        $html .= '<button type="button" class="' . CssPrefix::cls('dropzone-remove') . '" aria-label="Remove">';
        $html .= '<span class="material-icons">close</span>';
        $html .= '</button>';

        $html .= '</div>';

        return $html;
    }

    /**
     * Format file size for display
     *
     * @param int $bytes
     * @return string
     */
    protected function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        if ($this->accept !== null) {
            $config['accept'] = $this->accept;
        }

        if (!$this->multiple) {
            $config['multiple'] = false;
        }

        if ($this->maxFileSize !== null) {
            $config['maxFileSize'] = $this->maxFileSize;
        }

        if ($this->maxFiles !== null) {
            $config['maxFiles'] = $this->maxFiles;
        }

        if ($this->uploadUrl !== null) {
            $config['uploadUrl'] = $this->uploadUrl;
        }

        if (!$this->showPreview) {
            $config['showPreview'] = false;
        }

        if ($this->autoUpload) {
            $config['autoUpload'] = true;
        }

        if ($this->message !== 'Drop files here or click to upload') {
            $config['message'] = $this->message;
        }

        if ($this->icon !== 'cloud_upload') {
            $config['icon'] = $this->icon;
        }

        if (!empty($this->existingFiles)) {
            $config['existingFiles'] = $this->existingFiles;
        }

        return $config;
    }
}
