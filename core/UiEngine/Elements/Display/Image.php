<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\Html;
use Core\UiEngine\Support\CssPrefix;

/**
 * Image - Image element
 *
 * Creates an <img> tag with src, alt, and responsive image features.
 */
class Image extends Html
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'image';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'img';

    /**
     * Self-closing tag
     *
     * @var bool
     */
    protected bool $selfClosing = true;

    /**
     * Image source URL
     *
     * @var string|null
     */
    protected ?string $src = null;

    /**
     * Alt text
     *
     * @var string
     */
    protected string $alt = '';

    /**
     * Image width
     *
     * @var int|string|null
     */
    protected int|string|null $width = null;

    /**
     * Image height
     *
     * @var int|string|null
     */
    protected int|string|null $height = null;

    /**
     * Lazy loading
     *
     * @var bool
     */
    protected bool $lazy = false;

    /**
     * Responsive image (img-fluid class)
     *
     * @var bool
     */
    protected bool $fluid = false;

    /**
     * Rounded corners
     *
     * @var bool
     */
    protected bool $rounded = false;

    /**
     * Circle shape
     *
     * @var bool
     */
    protected bool $circle = false;

    /**
     * Thumbnail style
     *
     * @var bool
     */
    protected bool $thumbnail = false;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['src'])) {
            $this->src = $config['src'];
        }

        if (isset($config['alt'])) {
            $this->alt = $config['alt'];
        }

        if (isset($config['width'])) {
            $this->width = $config['width'];
        }

        if (isset($config['height'])) {
            $this->height = $config['height'];
        }

        if (isset($config['lazy'])) {
            $this->lazy = (bool) $config['lazy'];
        }

        if (isset($config['fluid'])) {
            $this->fluid = (bool) $config['fluid'];
        }

        if (isset($config['rounded'])) {
            $this->rounded = (bool) $config['rounded'];
        }

        if (isset($config['circle'])) {
            $this->circle = (bool) $config['circle'];
        }

        if (isset($config['thumbnail'])) {
            $this->thumbnail = (bool) $config['thumbnail'];
        }
    }

    /**
     * Set image source
     *
     * @param string $src
     * @return static
     */
    public function src(string $src): static
    {
        $this->src = $src;
        return $this;
    }

    /**
     * Set alt text
     *
     * @param string $alt
     * @return static
     */
    public function alt(string $alt): static
    {
        $this->alt = $alt;
        return $this;
    }

    /**
     * Set image width
     *
     * @param int|string $width
     * @return static
     */
    public function width(int|string $width): static
    {
        $this->width = $width;
        return $this;
    }

    /**
     * Set image height
     *
     * @param int|string $height
     * @return static
     */
    public function height(int|string $height): static
    {
        $this->height = $height;
        return $this;
    }

    /**
     * Set dimensions (width and height)
     *
     * @param int|string $width
     * @param int|string|null $height
     * @return static
     */
    public function size(int|string $width, int|string|null $height = null): static
    {
        $this->width = $width;
        $this->height = $height ?? $width;
        return $this;
    }

    /**
     * Enable lazy loading
     *
     * @param bool $lazy
     * @return static
     */
    public function lazy(bool $lazy = true): static
    {
        $this->lazy = $lazy;
        return $this;
    }

    /**
     * Make image responsive (fluid)
     *
     * @param bool $fluid
     * @return static
     */
    public function fluid(bool $fluid = true): static
    {
        $this->fluid = $fluid;
        return $this;
    }

    /**
     * Add rounded corners
     *
     * @param bool $rounded
     * @return static
     */
    public function rounded(bool $rounded = true): static
    {
        $this->rounded = $rounded;
        return $this;
    }

    /**
     * Make image circular
     *
     * @param bool $circle
     * @return static
     */
    public function circle(bool $circle = true): static
    {
        $this->circle = $circle;
        return $this;
    }

    /**
     * Add thumbnail styling
     *
     * @param bool $thumbnail
     * @return static
     */
    public function thumbnail(bool $thumbnail = true): static
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    /**
     * Build the CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        if ($this->fluid) {
            $this->addClass(CssPrefix::cls('img-fluid'));
        }

        if ($this->rounded) {
            $this->addClass(CssPrefix::cls('rounded'));
        }

        if ($this->circle) {
            $this->addClass(CssPrefix::cls('rounded-circle'));
        }

        if ($this->thumbnail) {
            $this->addClass(CssPrefix::cls('img-thumbnail'));
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

        if ($this->src !== null) {
            $attrs['src'] = $this->src;
        }

        $attrs['alt'] = $this->alt;

        if ($this->width !== null) {
            $attrs['width'] = $this->width;
        }

        if ($this->height !== null) {
            $attrs['height'] = $this->height;
        }

        if ($this->lazy) {
            $attrs['loading'] = 'lazy';
        }

        return $attrs;
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        if ($this->src !== null) {
            $config['src'] = $this->src;
        }

        if ($this->alt !== '') {
            $config['alt'] = $this->alt;
        }

        if ($this->width !== null) {
            $config['width'] = $this->width;
        }

        if ($this->height !== null) {
            $config['height'] = $this->height;
        }

        if ($this->lazy) {
            $config['lazy'] = true;
        }

        if ($this->fluid) {
            $config['fluid'] = true;
        }

        if ($this->rounded) {
            $config['rounded'] = true;
        }

        if ($this->circle) {
            $config['circle'] = true;
        }

        if ($this->thumbnail) {
            $config['thumbnail'] = true;
        }

        return $config;
    }
}
