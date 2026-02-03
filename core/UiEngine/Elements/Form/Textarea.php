<?php

namespace Core\UiEngine\Elements\Form;

use Core\UiEngine\Elements\FormElement;
use Core\UiEngine\Support\CssPrefix;

/**
 * Textarea - Textarea form element
 *
 * Multi-line text input with rows, cols, and resize options.
 */
class Textarea extends FormElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'textarea';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'textarea';

    /**
     * Number of visible rows
     *
     * @var int
     */
    protected int $rows = 3;

    /**
     * Number of visible columns
     *
     * @var int|null
     */
    protected ?int $cols = null;

    /**
     * Maximum length
     *
     * @var int|null
     */
    protected ?int $maxlength = null;

    /**
     * Minimum length
     *
     * @var int|null
     */
    protected ?int $minlength = null;

    /**
     * Resize behavior (none, vertical, horizontal, both)
     *
     * @var string|null
     */
    protected ?string $resize = null;

    /**
     * Auto-resize based on content
     *
     * @var bool
     */
    protected bool $autoResize = false;

    /**
     * Show character counter
     *
     * @var bool
     */
    protected bool $showCounter = false;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['rows'])) {
            $this->rows = (int) $config['rows'];
        }

        if (isset($config['cols'])) {
            $this->cols = (int) $config['cols'];
        }

        if (isset($config['maxlength'])) {
            $this->maxlength = (int) $config['maxlength'];
        }

        if (isset($config['minlength'])) {
            $this->minlength = (int) $config['minlength'];
        }

        if (isset($config['resize'])) {
            $this->resize = $config['resize'];
        }

        if (isset($config['autoResize'])) {
            $this->autoResize = (bool) $config['autoResize'];
        }

        if (isset($config['showCounter'])) {
            $this->showCounter = (bool) $config['showCounter'];
        }
    }

    /**
     * Set number of visible rows
     *
     * @param int $rows
     * @return static
     */
    public function rows(int $rows): static
    {
        $this->rows = $rows;
        return $this;
    }

    /**
     * Set number of visible columns
     *
     * @param int $cols
     * @return static
     */
    public function cols(int $cols): static
    {
        $this->cols = $cols;
        return $this;
    }

    /**
     * Set maximum length
     *
     * @param int $maxlength
     * @return static
     */
    public function maxlength(int $maxlength): static
    {
        $this->maxlength = $maxlength;
        return $this;
    }

    /**
     * Set minimum length
     *
     * @param int $minlength
     * @return static
     */
    public function minlength(int $minlength): static
    {
        $this->minlength = $minlength;
        return $this;
    }

    /**
     * Set resize behavior
     *
     * @param string $resize none|vertical|horizontal|both
     * @return static
     */
    public function resize(string $resize): static
    {
        $this->resize = $resize;
        return $this;
    }

    /**
     * Disable resizing
     *
     * @return static
     */
    public function noResize(): static
    {
        return $this->resize('none');
    }

    /**
     * Allow only vertical resizing
     *
     * @return static
     */
    public function resizeVertical(): static
    {
        return $this->resize('vertical');
    }

    /**
     * Allow only horizontal resizing
     *
     * @return static
     */
    public function resizeHorizontal(): static
    {
        return $this->resize('horizontal');
    }

    /**
     * Enable auto-resize based on content
     *
     * @param bool $autoResize
     * @return static
     */
    public function autoResize(bool $autoResize = true): static
    {
        $this->autoResize = $autoResize;
        return $this;
    }

    /**
     * Show character counter
     *
     * @param bool $show
     * @return static
     */
    public function showCounter(bool $show = true): static
    {
        $this->showCounter = $show;
        return $this;
    }

    /**
     * Check if value attribute should be rendered
     *
     * @return bool
     */
    protected function shouldRenderValueAttribute(): bool
    {
        return false; // Textarea content goes between tags
    }

    /**
     * Gather all attributes
     *
     * @return array<string, mixed>
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = parent::gatherAllAttributes();

        $attrs['rows'] = $this->rows;

        if ($this->cols !== null) {
            $attrs['cols'] = $this->cols;
        }

        if ($this->maxlength !== null) {
            $attrs['maxlength'] = $this->maxlength;
        }

        if ($this->minlength !== null) {
            $attrs['minlength'] = $this->minlength;
        }

        if ($this->autoResize) {
            $attrs[CssPrefix::data('auto-resize')] = 'true';
        }

        if ($this->showCounter && $this->maxlength !== null) {
            $attrs[CssPrefix::data('counter')] = 'true';
        }

        return $attrs;
    }

    /**
     * Build the CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        // Handle resize style
        if ($this->resize !== null) {
            $this->addClass(CssPrefix::cls('resize', $this->resize));
        }

        return parent::buildClassString();
    }

    /**
     * Render the content (textarea value)
     *
     * @return string
     */
    public function renderContent(): string
    {
        if ($this->value !== null) {
            return e((string) $this->value);
        }

        return '';
    }

    /**
     * Render the complete element with optional counter
     *
     * @return string
     */
    public function render(): string
    {
        $html = parent::render();

        // Add character counter if enabled
        if ($this->showCounter && $this->maxlength !== null) {
            $currentLength = $this->value !== null ? mb_strlen((string) $this->value) : 0;
            $html .= '<div class="' . CssPrefix::cls('form-text') . ' ' . CssPrefix::cls('text-end') . '">';
            $html .= '<span class="' . CssPrefix::cls('char-count') . '">' . $currentLength . '</span>';
            $html .= ' / ' . $this->maxlength;
            $html .= '</div>';
        }

        return $html;
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        if ($this->rows !== 3) {
            $config['rows'] = $this->rows;
        }

        if ($this->cols !== null) {
            $config['cols'] = $this->cols;
        }

        if ($this->maxlength !== null) {
            $config['maxlength'] = $this->maxlength;
        }

        if ($this->minlength !== null) {
            $config['minlength'] = $this->minlength;
        }

        if ($this->resize !== null) {
            $config['resize'] = $this->resize;
        }

        if ($this->autoResize) {
            $config['autoResize'] = true;
        }

        if ($this->showCounter) {
            $config['showCounter'] = true;
        }

        return $config;
    }
}
