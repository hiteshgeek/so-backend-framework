<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * MediaObject - Media object layout component
 *
 * Displays media (image/icon) alongside content with flexible alignment options.
 * Generates proper .so-media structure matching CSS framework.
 */
class MediaObject extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'media-object';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Media source (image URL or icon name)
     *
     * @var string|null
     */
    protected ?string $media = null;

    /**
     * Media type (image or icon)
     *
     * @var string
     */
    protected string $mediaType = 'image';

    /**
     * Image alt text
     *
     * @var string
     */
    protected string $imageAlt = '';

    /**
     * Media size (CSS value)
     *
     * @var string
     */
    protected string $mediaSize = '64px';

    /**
     * Icon variant for colored backgrounds
     *
     * @var string|null
     */
    protected ?string $iconVariant = null;

    /**
     * Title/heading text
     *
     * @var string|null
     */
    protected ?string $title = null;

    /**
     * Body content text
     *
     * @var string|null
     */
    protected ?string $bodyContent = null;

    /**
     * Media position (start or end)
     *
     * @var string
     */
    protected string $mediaPosition = 'start';

    /**
     * Vertical alignment (top, middle, bottom)
     *
     * @var string
     */
    protected string $align = 'top';

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['media'])) {
            $this->media = $config['media'];
        }

        if (isset($config['mediaType'])) {
            $this->mediaType = $config['mediaType'];
        }

        if (isset($config['imageAlt'])) {
            $this->imageAlt = $config['imageAlt'];
        }

        if (isset($config['mediaSize'])) {
            $this->mediaSize = $config['mediaSize'];
        }

        if (isset($config['iconVariant'])) {
            $this->iconVariant = $config['iconVariant'];
        }

        if (isset($config['title'])) {
            $this->title = $config['title'];
        }

        if (isset($config['content'])) {
            $this->bodyContent = $config['content'];
        }

        if (isset($config['mediaPosition'])) {
            $this->mediaPosition = $config['mediaPosition'];
        }

        if (isset($config['align'])) {
            $this->align = $config['align'];
        }
    }

    // ==================
    // Media Methods
    // ==================

    /**
     * Set image media
     *
     * @param string $url Image URL
     * @param string $alt Alt text
     * @return static
     */
    public function image(string $url, string $alt = ''): static
    {
        $this->media = $url;
        $this->mediaType = 'image';
        $this->imageAlt = $alt;
        return $this;
    }

    /**
     * Set icon media
     *
     * @param string $icon Material icon name
     * @param string|null $variant Color variant (primary, success, warning, danger, info, secondary)
     * @return static
     */
    public function icon(string $icon, ?string $variant = null): static
    {
        $this->media = $icon;
        $this->mediaType = 'icon';
        $this->iconVariant = $variant;
        return $this;
    }

    /**
     * Set media size
     *
     * @param string $size CSS size value (e.g., '64px', '4rem')
     * @return static
     */
    public function mediaSize(string $size): static
    {
        $this->mediaSize = $size;
        return $this;
    }

    /**
     * Set icon variant
     *
     * @param string $variant primary, success, warning, danger, info, secondary
     * @return static
     */
    public function iconVariant(string $variant): static
    {
        $this->iconVariant = $variant;
        return $this;
    }

    // ==================
    // Content Methods
    // ==================

    /**
     * Set title/heading
     *
     * @param string $title
     * @return static
     */
    public function title(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set body content
     *
     * @param string $content
     * @return static
     */
    public function content(string $content): static
    {
        $this->bodyContent = $content;
        return $this;
    }

    /**
     * Alias for content()
     *
     * @param string $body
     * @return static
     */
    public function body(string $body): static
    {
        return $this->content($body);
    }

    // ==================
    // Position Methods
    // ==================

    /**
     * Set media position
     *
     * @param string $position start or end
     * @return static
     */
    public function mediaPosition(string $position): static
    {
        $this->mediaPosition = $position;
        return $this;
    }

    /**
     * Media on start (left in LTR)
     *
     * @return static
     */
    public function mediaStart(): static
    {
        return $this->mediaPosition('start');
    }

    /**
     * Media on end (right in LTR)
     *
     * @return static
     */
    public function mediaEnd(): static
    {
        return $this->mediaPosition('end');
    }

    /**
     * Alias for mediaEnd() - media on right
     *
     * @return static
     */
    public function reverse(): static
    {
        return $this->mediaEnd();
    }

    // ==================
    // Alignment Methods
    // ==================

    /**
     * Set vertical alignment
     *
     * @param string $align top, middle, bottom
     * @return static
     */
    public function align(string $align): static
    {
        $this->align = $align;
        return $this;
    }

    /**
     * Align top (default)
     *
     * @return static
     */
    public function alignTop(): static
    {
        return $this->align('top');
    }

    /**
     * Align middle/center
     *
     * @return static
     */
    public function alignMiddle(): static
    {
        return $this->align('middle');
    }

    /**
     * Alias for alignMiddle()
     *
     * @return static
     */
    public function alignCenter(): static
    {
        return $this->alignMiddle();
    }

    /**
     * Align bottom
     *
     * @return static
     */
    public function alignBottom(): static
    {
        return $this->align('bottom');
    }

    // ==================
    // Getters
    // ==================

    /**
     * Get media source
     *
     * @return string|null
     */
    public function getMedia(): ?string
    {
        return $this->media;
    }

    /**
     * Get media type
     *
     * @return string
     */
    public function getMediaType(): string
    {
        return $this->mediaType;
    }

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Get body content
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->bodyContent;
    }

    /**
     * Get media position
     *
     * @return string
     */
    public function getMediaPosition(): string
    {
        return $this->mediaPosition;
    }

    /**
     * Get alignment
     *
     * @return string
     */
    public function getAlign(): string
    {
        return $this->align;
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Build CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('media'));

        // Add alignment class
        if ($this->align === 'middle') {
            $this->addClass(CssPrefix::cls('media-middle'));
        } elseif ($this->align === 'bottom') {
            $this->addClass(CssPrefix::cls('media-bottom'));
        }

        return parent::buildClassString();
    }

    /**
     * Render content
     *
     * @return string
     */
    public function renderContent(): string
    {
        $html = '';

        // Determine media container class
        $mediaContainerClass = $this->mediaPosition === 'end'
            ? CssPrefix::cls('media-right')
            : CssPrefix::cls('media-left');

        // Render media first if position is start
        if ($this->mediaPosition === 'start') {
            $html .= $this->renderMedia($mediaContainerClass);
        }

        // Render body
        $html .= $this->renderBody();

        // Render media last if position is end
        if ($this->mediaPosition === 'end') {
            $html .= $this->renderMedia($mediaContainerClass);
        }

        return $html;
    }

    /**
     * Render media element
     *
     * @param string $containerClass
     * @return string
     */
    protected function renderMedia(string $containerClass): string
    {
        if ($this->media === null) {
            return '';
        }

        $html = '<div class="' . $containerClass . '">';

        if ($this->mediaType === 'image') {
            $html .= '<img src="' . e($this->media) . '"';
            $html .= ' class="' . CssPrefix::cls('media-image') . '"';
            $html .= ' alt="' . e($this->imageAlt) . '"';
            $html .= ' style="width: ' . e($this->mediaSize) . '; height: ' . e($this->mediaSize) . ';">';
        } elseif ($this->mediaType === 'icon') {
            $iconClass = CssPrefix::cls('media-icon');
            if ($this->iconVariant !== null) {
                $iconClass .= ' ' . CssPrefix::cls('media-icon-' . $this->iconVariant);
            }

            $html .= '<div class="' . $iconClass . '"';
            $html .= ' style="width: ' . e($this->mediaSize) . '; height: ' . e($this->mediaSize) . ';">';
            $html .= '<span class="material-icons">' . e($this->media) . '</span>';
            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Render body content
     *
     * @return string
     */
    protected function renderBody(): string
    {
        $html = '<div class="' . CssPrefix::cls('media-body') . '">';

        if ($this->title !== null) {
            $html .= '<h5 class="' . CssPrefix::cls('media-heading') . '">' . e($this->title) . '</h5>';
        }

        if ($this->bodyContent !== null) {
            $html .= '<p>' . e($this->bodyContent) . '</p>';
        }

        // Render any child elements
        $html .= parent::renderContent();

        $html .= '</div>';

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

        if ($this->media !== null) {
            $config['media'] = $this->media;
        }

        if ($this->mediaType !== 'image') {
            $config['mediaType'] = $this->mediaType;
        }

        if ($this->imageAlt !== '') {
            $config['imageAlt'] = $this->imageAlt;
        }

        if ($this->mediaSize !== '64px') {
            $config['mediaSize'] = $this->mediaSize;
        }

        if ($this->iconVariant !== null) {
            $config['iconVariant'] = $this->iconVariant;
        }

        if ($this->title !== null) {
            $config['title'] = $this->title;
        }

        if ($this->bodyContent !== null) {
            $config['content'] = $this->bodyContent;
        }

        if ($this->mediaPosition !== 'start') {
            $config['mediaPosition'] = $this->mediaPosition;
        }

        if ($this->align !== 'top') {
            $config['align'] = $this->align;
        }

        return $config;
    }
}
