<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * Skeleton - Loading skeleton placeholder
 *
 * Displays placeholder content while loading
 */
class Skeleton extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'skeleton';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Skeleton shape
     *
     * @var string
     */
    protected string $shape = 'text';

    /**
     * Width
     *
     * @var string|null
     */
    protected ?string $width = null;

    /**
     * Height
     *
     * @var string|null
     */
    protected ?string $height = null;

    /**
     * Number of lines (for text shape)
     *
     * @var int
     */
    protected int $lines = 1;

    /**
     * Enable animation
     *
     * @var bool
     */
    protected bool $animated = true;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['shape'])) {
            $this->shape = $config['shape'];
        }

        if (isset($config['width'])) {
            $this->width = $config['width'];
        }

        if (isset($config['height'])) {
            $this->height = $config['height'];
        }

        if (isset($config['lines'])) {
            $this->lines = (int) $config['lines'];
        }

        if (isset($config['animated'])) {
            $this->animated = (bool) $config['animated'];
        }
    }

    /**
     * Set shape
     *
     * @param string $shape
     * @return static
     */
    public function shape(string $shape): static
    {
        $this->shape = $shape;
        return $this;
    }

    /**
     * Text skeleton
     *
     * @return static
     */
    public function text(): static
    {
        return $this->shape('text');
    }

    /**
     * Circle skeleton
     *
     * @param string $size
     * @return static
     */
    public function circle(string $size = '50px'): static
    {
        $this->shape = 'circle';
        $this->width = $size;
        $this->height = $size;
        return $this;
    }

    /**
     * Rectangle skeleton
     *
     * @return static
     */
    public function rectangle(): static
    {
        return $this->shape('rectangle');
    }

    /**
     * Card skeleton
     *
     * @return static
     */
    public function card(): static
    {
        return $this->shape('card');
    }

    /**
     * Avatar skeleton
     *
     * @param string $size
     * @return static
     */
    public function avatar(string $size = '40px'): static
    {
        return $this->circle($size);
    }

    /**
     * Set width
     *
     * @param string $width
     * @return static
     */
    public function width(string $width): static
    {
        $this->width = $width;
        return $this;
    }

    /**
     * Set height
     *
     * @param string $height
     * @return static
     */
    public function height(string $height): static
    {
        $this->height = $height;
        return $this;
    }

    /**
     * Set dimensions
     *
     * @param string $width
     * @param string $height
     * @return static
     */
    public function dimensions(string $width, string $height): static
    {
        $this->width = $width;
        $this->height = $height;
        return $this;
    }

    /**
     * Set number of text lines
     *
     * @param int $lines
     * @return static
     */
    public function lines(int $lines): static
    {
        $this->lines = $lines;
        return $this;
    }

    /**
     * Enable/disable animation
     *
     * @param bool $animated
     * @return static
     */
    public function animated(bool $animated = true): static
    {
        $this->animated = $animated;
        return $this;
    }

    /**
     * Disable animation
     *
     * @return static
     */
    public function noAnimation(): static
    {
        return $this->animated(false);
    }

    /**
     * Build CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('skeleton'));
        $this->addClass(CssPrefix::cls('skeleton', $this->shape));

        if ($this->animated) {
            $this->addClass(CssPrefix::cls('skeleton-animated'));
        }

        return parent::buildClassString();
    }

    /**
     * Gather all attributes
     *
     * @return array<string, mixed>
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = parent::gatherAllAttributes();
        $attrs['aria-hidden'] = 'true';

        $styles = [];

        if ($this->width !== null) {
            $styles[] = 'width: ' . $this->width;
        }

        if ($this->height !== null) {
            $styles[] = 'height: ' . $this->height;
        }

        if (!empty($styles)) {
            $attrs['style'] = implode('; ', $styles);
        }

        return $attrs;
    }

    /**
     * Render content
     *
     * @return string
     */
    public function renderContent(): string
    {
        // For text skeleton with multiple lines
        if ($this->shape === 'text' && $this->lines > 1) {
            $html = '';
            for ($i = 0; $i < $this->lines; $i++) {
                // Make last line shorter for natural look
                $width = $i === $this->lines - 1 ? '75%' : '100%';
                $html .= '<div class="' . CssPrefix::cls('skeleton-line') . '" style="width: ' . $width . '"></div>';
            }
            return $html;
        }

        // For card skeleton
        if ($this->shape === 'card') {
            $html = '<div class="' . CssPrefix::cls('skeleton-card-image') . '"></div>';
            $html .= '<div class="' . CssPrefix::cls('skeleton-card-body') . '">';
            $html .= '<div class="' . CssPrefix::cls('skeleton-line') . '" style="width: 60%"></div>';
            $html .= '<div class="' . CssPrefix::cls('skeleton-line') . '"></div>';
            $html .= '<div class="' . CssPrefix::cls('skeleton-line') . '" style="width: 80%"></div>';
            $html .= '</div>';
            return $html;
        }

        return '';
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        if ($this->shape !== 'text') {
            $config['shape'] = $this->shape;
        }

        if ($this->width !== null) {
            $config['width'] = $this->width;
        }

        if ($this->height !== null) {
            $config['height'] = $this->height;
        }

        if ($this->lines !== 1) {
            $config['lines'] = $this->lines;
        }

        if (!$this->animated) {
            $config['animated'] = false;
        }

        return $config;
    }
}
