<?php

namespace Core\UiEngine\Elements\Form;

use Core\UiEngine\Elements\FormElement;
use Core\UiEngine\Support\CssPrefix;

/**
 * FileInput - File upload form element
 *
 * Supports single and multiple file uploads with accept filters.
 */
class FileInput extends FormElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'file';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'input';

    /**
     * Whether multiple files are allowed
     *
     * @var bool
     */
    protected bool $multiple = false;

    /**
     * Accepted file types
     *
     * @var string|null
     */
    protected ?string $accept = null;

    /**
     * Maximum file size in bytes
     *
     * @var int|null
     */
    protected ?int $maxSize = null;

    /**
     * Allow camera capture (for mobile)
     *
     * @var string|null capture attribute: user|environment
     */
    protected ?string $capture = null;

    /**
     * Show file preview
     *
     * @var bool
     */
    protected bool $preview = false;

    /**
     * Drag and drop zone
     *
     * @var bool
     */
    protected bool $dropzone = false;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['multiple'])) {
            $this->multiple = (bool) $config['multiple'];
        }

        if (isset($config['accept'])) {
            $this->accept = $config['accept'];
        }

        if (isset($config['maxSize'])) {
            $this->maxSize = (int) $config['maxSize'];
        }

        if (isset($config['capture'])) {
            $this->capture = $config['capture'];
        }

        if (isset($config['preview'])) {
            $this->preview = (bool) $config['preview'];
        }

        if (isset($config['dropzone'])) {
            $this->dropzone = (bool) $config['dropzone'];
        }
    }

    /**
     * Enable multiple file upload
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
     * Set accepted file types
     *
     * @param string $accept MIME types or extensions (e.g., "image/*,.pdf")
     * @return static
     */
    public function accept(string $accept): static
    {
        $this->accept = $accept;
        return $this;
    }

    /**
     * Accept only images
     *
     * @return static
     */
    public function images(): static
    {
        return $this->accept('image/*');
    }

    /**
     * Accept only PDFs
     *
     * @return static
     */
    public function pdf(): static
    {
        return $this->accept('application/pdf,.pdf');
    }

    /**
     * Accept only documents
     *
     * @return static
     */
    public function documents(): static
    {
        return $this->accept('.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt');
    }

    /**
     * Accept only videos
     *
     * @return static
     */
    public function videos(): static
    {
        return $this->accept('video/*');
    }

    /**
     * Accept only audio
     *
     * @return static
     */
    public function audio(): static
    {
        return $this->accept('audio/*');
    }

    /**
     * Set maximum file size
     *
     * @param int $bytes Max size in bytes
     * @return static
     */
    public function maxSize(int $bytes): static
    {
        $this->maxSize = $bytes;
        return $this;
    }

    /**
     * Set max size in megabytes
     *
     * @param int $mb
     * @return static
     */
    public function maxSizeMB(int $mb): static
    {
        return $this->maxSize($mb * 1024 * 1024);
    }

    /**
     * Enable camera capture
     *
     * @param string $type user|environment
     * @return static
     */
    public function capture(string $type = 'user'): static
    {
        $this->capture = $type;
        return $this;
    }

    /**
     * Use front camera
     *
     * @return static
     */
    public function frontCamera(): static
    {
        return $this->capture('user');
    }

    /**
     * Use back camera
     *
     * @return static
     */
    public function backCamera(): static
    {
        return $this->capture('environment');
    }

    /**
     * Enable file preview
     *
     * @param bool $preview
     * @return static
     */
    public function preview(bool $preview = true): static
    {
        $this->preview = $preview;
        return $this;
    }

    /**
     * Enable drag and drop zone
     *
     * @param bool $dropzone
     * @return static
     */
    public function dropzone(bool $dropzone = true): static
    {
        $this->dropzone = $dropzone;
        return $this;
    }

    /**
     * Check if value attribute should be rendered
     *
     * @return bool
     */
    protected function shouldRenderValueAttribute(): bool
    {
        return false; // File inputs don't have value attribute
    }

    /**
     * Gather all attributes
     *
     * @return array<string, mixed>
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = parent::gatherAllAttributes();

        $attrs['type'] = 'file';

        if ($this->multiple) {
            $attrs['multiple'] = true;
        }

        if ($this->accept !== null) {
            $attrs['accept'] = $this->accept;
        }

        if ($this->capture !== null) {
            $attrs['capture'] = $this->capture;
        }

        if ($this->maxSize !== null) {
            $attrs[CssPrefix::data('max-size')] = $this->maxSize;
        }

        if ($this->preview) {
            $attrs[CssPrefix::data('preview')] = 'true';
        }

        if ($this->dropzone) {
            $attrs[CssPrefix::data('dropzone')] = 'true';
        }

        return $attrs;
    }

    /**
     * Render the complete element
     *
     * @return string
     */
    public function render(): string
    {
        if ($this->dropzone) {
            return $this->renderDropzone();
        }

        return parent::render();
    }

    /**
     * Render as dropzone
     *
     * @return string
     */
    protected function renderDropzone(): string
    {
        $html = '<div class="' . CssPrefix::cls('dropzone') . '">';
        $html .= '<div class="' . CssPrefix::cls('dropzone-content') . '">';
        $html .= '<span class="material-icons ' . CssPrefix::cls('dropzone-icon') . '">cloud_upload</span>';
        $html .= '<p class="' . CssPrefix::cls('dropzone-text') . '">Drag and drop files here or click to browse</p>';

        if ($this->accept !== null) {
            $html .= '<p class="' . CssPrefix::cls('dropzone-hint') . '">Accepted: ' . e($this->accept) . '</p>';
        }

        if ($this->maxSize !== null) {
            $html .= '<p class="' . CssPrefix::cls('dropzone-hint') . '">Max size: ' . $this->formatBytes($this->maxSize) . '</p>';
        }

        $html .= '</div>';

        // Hidden file input
        $html .= parent::render();

        // Preview area
        if ($this->preview) {
            $html .= '<div class="' . CssPrefix::cls('dropzone-preview') . '"></div>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Format bytes to human readable
     *
     * @param int $bytes
     * @return string
     */
    protected function formatBytes(int $bytes): string
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

        if ($this->multiple) {
            $config['multiple'] = true;
        }

        if ($this->accept !== null) {
            $config['accept'] = $this->accept;
        }

        if ($this->maxSize !== null) {
            $config['maxSize'] = $this->maxSize;
        }

        if ($this->capture !== null) {
            $config['capture'] = $this->capture;
        }

        if ($this->preview) {
            $config['preview'] = true;
        }

        if ($this->dropzone) {
            $config['dropzone'] = true;
        }

        return $config;
    }
}
