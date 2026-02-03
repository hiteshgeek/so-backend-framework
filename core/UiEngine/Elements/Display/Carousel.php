<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * Carousel - Image/content slider
 *
 * Provides carousel/slider functionality
 */
class Carousel extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'carousel';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Carousel slides
     *
     * @var array
     */
    protected array $slides = [];

    /**
     * Show indicators
     *
     * @var bool
     */
    protected bool $indicators = true;

    /**
     * Show controls (prev/next)
     *
     * @var bool
     */
    protected bool $controls = true;

    /**
     * Enable autoplay
     *
     * @var bool
     */
    protected bool $autoplay = false;

    /**
     * Slide interval in milliseconds
     *
     * @var int
     */
    protected int $interval = 5000;

    /**
     * Enable crossfade transition
     *
     * @var bool
     */
    protected bool $fade = false;

    /**
     * Enable touch swipe
     *
     * @var bool
     */
    protected bool $touch = true;

    /**
     * Pause on hover
     *
     * @var bool
     */
    protected bool $pauseOnHover = true;

    /**
     * Dark variant
     *
     * @var bool
     */
    protected bool $dark = false;

    /**
     * Enable keyboard navigation
     *
     * @var bool
     */
    protected bool $keyboard = true;

    /**
     * Enable loop (wrap around)
     *
     * @var bool
     */
    protected bool $loop = true;

    /**
     * Number of visible items (for multi-item carousel)
     *
     * @var int
     */
    protected int $items = 1;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['slides'])) {
            $this->slides = $config['slides'];
        }

        if (isset($config['indicators'])) {
            $this->indicators = (bool) $config['indicators'];
        }

        if (isset($config['controls'])) {
            $this->controls = (bool) $config['controls'];
        }

        if (isset($config['autoplay'])) {
            $this->autoplay = (bool) $config['autoplay'];
        }

        if (isset($config['interval'])) {
            $this->interval = (int) $config['interval'];
        }

        if (isset($config['fade'])) {
            $this->fade = (bool) $config['fade'];
        }

        if (isset($config['touch'])) {
            $this->touch = (bool) $config['touch'];
        }

        if (isset($config['pauseOnHover'])) {
            $this->pauseOnHover = (bool) $config['pauseOnHover'];
        }

        if (isset($config['dark'])) {
            $this->dark = (bool) $config['dark'];
        }

        if (isset($config['keyboard'])) {
            $this->keyboard = (bool) $config['keyboard'];
        }

        if (isset($config['loop'])) {
            $this->loop = (bool) $config['loop'];
        }

        if (isset($config['items'])) {
            $this->items = (int) $config['items'];
        }
    }

    /**
     * Set slides
     *
     * @param array $slides
     * @return static
     */
    public function slides(array $slides): static
    {
        $this->slides = $slides;
        return $this;
    }

    /**
     * Add slide
     *
     * @param string $image
     * @param string|null $title
     * @param string|null $description
     * @param string|null $alt
     * @return static
     */
    public function addSlide(string $image, ?string $title = null, ?string $description = null, ?string $alt = null): static
    {
        $slide = ['image' => $image];
        if ($title !== null) {
            $slide['title'] = $title;
        }
        if ($description !== null) {
            $slide['description'] = $description;
        }
        if ($alt !== null) {
            $slide['alt'] = $alt;
        }
        $this->slides[] = $slide;
        return $this;
    }

    /**
     * Show/hide indicators
     *
     * @param bool $show
     * @return static
     */
    public function indicators(bool $show = true): static
    {
        $this->indicators = $show;
        return $this;
    }

    /**
     * Show/hide controls
     *
     * @param bool $show
     * @return static
     */
    public function controls(bool $show = true): static
    {
        $this->controls = $show;
        return $this;
    }

    /**
     * Enable autoplay
     *
     * @param bool $autoplay
     * @return static
     */
    public function autoplay(bool $autoplay = true): static
    {
        $this->autoplay = $autoplay;
        return $this;
    }

    /**
     * Set interval
     *
     * @param int $ms
     * @return static
     */
    public function interval(int $ms): static
    {
        $this->interval = $ms;
        return $this;
    }

    /**
     * Enable fade transition
     *
     * @param bool $fade
     * @return static
     */
    public function fade(bool $fade = true): static
    {
        $this->fade = $fade;
        return $this;
    }

    /**
     * Enable/disable touch
     *
     * @param bool $touch
     * @return static
     */
    public function touch(bool $touch = true): static
    {
        $this->touch = $touch;
        return $this;
    }

    /**
     * Pause on hover
     *
     * @param bool $pause
     * @return static
     */
    public function pauseOnHover(bool $pause = true): static
    {
        $this->pauseOnHover = $pause;
        return $this;
    }

    /**
     * Dark variant
     *
     * @param bool $dark
     * @return static
     */
    public function dark(bool $dark = true): static
    {
        $this->dark = $dark;
        return $this;
    }

    /**
     * Enable keyboard navigation
     *
     * @param bool $keyboard
     * @return static
     */
    public function keyboard(bool $keyboard = true): static
    {
        $this->keyboard = $keyboard;
        return $this;
    }

    /**
     * Enable loop/wrap around
     *
     * @param bool $loop
     * @return static
     */
    public function loop(bool $loop = true): static
    {
        $this->loop = $loop;
        return $this;
    }

    /**
     * Hero carousel (center with peek effect)
     *
     * @return static
     */
    public function hero(): static
    {
        return $this->addClass(CssPrefix::cls('carousel-hero'));
    }

    /**
     * Multi-item carousel
     *
     * @param int|null $items Number of visible items
     * @return static
     */
    public function multi(?int $items = null): static
    {
        $this->addClass(CssPrefix::cls('carousel-multi'));
        if ($items !== null) {
            $this->items = $items;
        }
        return $this;
    }

    /**
     * Small size variant
     *
     * @return static
     */
    public function small(): static
    {
        return $this->addClass(CssPrefix::cls('carousel-sm'));
    }

    /**
     * Large size variant
     *
     * @return static
     */
    public function large(): static
    {
        return $this->addClass(CssPrefix::cls('carousel-lg'));
    }

    /**
     * Show controls only on hover
     *
     * @return static
     */
    public function controlsHover(): static
    {
        return $this->addClass(CssPrefix::cls('carousel-controls-hover'));
    }

    /**
     * Use line-style indicators
     *
     * @return static
     */
    public function lineIndicators(): static
    {
        return $this->addClass(CssPrefix::cls('carousel-indicators-line'));
    }

    /**
     * Build CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('carousel'));

        if ($this->fade) {
            $this->addClass(CssPrefix::cls('carousel-fade'));
        }

        if ($this->dark) {
            $this->addClass(CssPrefix::cls('carousel-dark'));
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

        // Main carousel identifier
        $attrs[CssPrefix::data('carousel')] = '';

        // Autoplay
        if ($this->autoplay) {
            $attrs[CssPrefix::data('autoplay')] = 'true';
        }

        // Interval
        $attrs[CssPrefix::data('interval')] = $this->interval;

        // Loop
        if (!$this->loop) {
            $attrs[CssPrefix::data('loop')] = 'false';
        }

        // Pause on hover
        if (!$this->pauseOnHover) {
            $attrs[CssPrefix::data('pause-on-hover')] = 'false';
        }

        // Keyboard
        if (!$this->keyboard) {
            $attrs[CssPrefix::data('keyboard')] = 'false';
        }

        // Touch
        if (!$this->touch) {
            $attrs[CssPrefix::data('touch')] = 'false';
        }

        // Items (for multi-item carousel)
        if ($this->items > 1) {
            $attrs[CssPrefix::data('items')] = $this->items;
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
        $carouselId = $this->id ?? 'carousel-' . uniqid();
        $html = '';

        // Indicators
        if ($this->indicators && count($this->slides) > 1) {
            $html .= '<div class="' . CssPrefix::cls('carousel-indicators') . '">';
            foreach ($this->slides as $index => $slide) {
                $activeClass = $index === 0 ? ' ' . CssPrefix::cls('active') : '';
                $html .= '<button type="button"';
                $html .= ' class="' . CssPrefix::cls('carousel-indicator') . $activeClass . '"';
                $html .= ' ' . CssPrefix::data('slide') . '="' . $index . '"';
                if ($index === 0) {
                    $html .= ' aria-current="true"';
                }
                $html .= ' aria-label="Go to slide ' . ($index + 1) . '"></button>';
            }
            $html .= '</div>';
        }

        // Slides
        $html .= '<div class="' . CssPrefix::cls('carousel-inner') . '">';
        foreach ($this->slides as $index => $slide) {
            $activeClass = $index === 0 ? ' ' . CssPrefix::cls('active') : '';
            $html .= '<div class="' . CssPrefix::cls('carousel-slide') . $activeClass . '">';

            if (isset($slide['image'])) {
                $html .= '<img src="' . e($slide['image']) . '" class="' . CssPrefix::cls('d-block') . ' ' . CssPrefix::cls('w-100') . '"';
                $html .= ' alt="' . e($slide['alt'] ?? '') . '">';
            }

            // Caption
            if (isset($slide['title']) || isset($slide['description'])) {
                $html .= '<div class="' . CssPrefix::cls('carousel-caption') . ' ' . CssPrefix::cls('d-none') . ' ' . CssPrefix::cls('d-md-block') . '">';
                if (isset($slide['title'])) {
                    $html .= '<h5>' . e($slide['title']) . '</h5>';
                }
                if (isset($slide['description'])) {
                    $html .= '<p>' . e($slide['description']) . '</p>';
                }
                $html .= '</div>';
            }

            $html .= '</div>';
        }
        $html .= '</div>';

        // Controls
        if ($this->controls && count($this->slides) > 1) {
            $html .= '<button class="' . CssPrefix::cls('carousel-control') . ' ' . CssPrefix::cls('carousel-control-prev') . '" type="button" aria-label="Previous slide">';
            $html .= '<span class="material-icons">chevron_left</span>';
            $html .= '</button>';

            $html .= '<button class="' . CssPrefix::cls('carousel-control') . ' ' . CssPrefix::cls('carousel-control-next') . '" type="button" aria-label="Next slide">';
            $html .= '<span class="material-icons">chevron_right</span>';
            $html .= '</button>';
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

        if (!empty($this->slides)) {
            $config['slides'] = $this->slides;
        }

        if (!$this->indicators) {
            $config['indicators'] = false;
        }

        if (!$this->controls) {
            $config['controls'] = false;
        }

        if ($this->autoplay) {
            $config['autoplay'] = true;
        }

        if ($this->interval !== 5000) {
            $config['interval'] = $this->interval;
        }

        if ($this->fade) {
            $config['fade'] = true;
        }

        if (!$this->touch) {
            $config['touch'] = false;
        }

        if (!$this->pauseOnHover) {
            $config['pauseOnHover'] = false;
        }

        if ($this->dark) {
            $config['dark'] = true;
        }

        if (!$this->keyboard) {
            $config['keyboard'] = false;
        }

        if (!$this->loop) {
            $config['loop'] = false;
        }

        if ($this->items !== 1) {
            $config['items'] = $this->items;
        }

        return $config;
    }
}
