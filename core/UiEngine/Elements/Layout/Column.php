<?php

namespace Core\UiEngine\Elements\Layout;

use Core\UiEngine\Elements\ContainerElement;
use Core\UiEngine\Support\CssPrefix;

/**
 * Column - Grid column container element
 *
 * Creates a Bootstrap-style column within a row.
 * Uses so-col-* classes from the frontend framework.
 */
class Column extends ContainerElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'column';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Column size (1-12)
     *
     * @var int|string|null
     */
    protected int|string|null $size = null;

    /**
     * Responsive sizes
     *
     * @var array<string, int|string>
     */
    protected array $responsiveSizes = [];

    /**
     * Column offset
     *
     * @var int|null
     */
    protected ?int $offset = null;

    /**
     * Responsive offsets
     *
     * @var array<string, int>
     */
    protected array $responsiveOffsets = [];

    /**
     * Column order
     *
     * @var int|string|null
     */
    protected int|string|null $order = null;

    /**
     * Self alignment
     *
     * @var string|null
     */
    protected ?string $alignSelf = null;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['size'])) {
            $this->size = $config['size'];
        }

        if (isset($config['offset'])) {
            $this->offset = $config['offset'];
        }

        if (isset($config['order'])) {
            $this->order = $config['order'];
        }

        if (isset($config['alignSelf'])) {
            $this->alignSelf = $config['alignSelf'];
        }

        // Responsive sizes: sm, md, lg, xl, xxl
        foreach (['sm', 'md', 'lg', 'xl', 'xxl'] as $breakpoint) {
            if (isset($config[$breakpoint])) {
                $this->responsiveSizes[$breakpoint] = $config[$breakpoint];
            }

            if (isset($config['offset' . ucfirst($breakpoint)])) {
                $this->responsiveOffsets[$breakpoint] = $config['offset' . ucfirst($breakpoint)];
            }
        }
    }

    /**
     * Set column size
     *
     * @param int|string $size 1-12 or 'auto'
     * @return static
     */
    public function size(int|string $size): static
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Set column to auto width
     *
     * @return static
     */
    public function auto(): static
    {
        return $this->size('auto');
    }

    /**
     * Set small breakpoint size
     *
     * @param int|string $size
     * @return static
     */
    public function sm(int|string $size): static
    {
        $this->responsiveSizes['sm'] = $size;
        return $this;
    }

    /**
     * Set medium breakpoint size
     *
     * @param int|string $size
     * @return static
     */
    public function md(int|string $size): static
    {
        $this->responsiveSizes['md'] = $size;
        return $this;
    }

    /**
     * Set large breakpoint size
     *
     * @param int|string $size
     * @return static
     */
    public function lg(int|string $size): static
    {
        $this->responsiveSizes['lg'] = $size;
        return $this;
    }

    /**
     * Set extra large breakpoint size
     *
     * @param int|string $size
     * @return static
     */
    public function xl(int|string $size): static
    {
        $this->responsiveSizes['xl'] = $size;
        return $this;
    }

    /**
     * Set extra extra large breakpoint size
     *
     * @param int|string $size
     * @return static
     */
    public function xxl(int|string $size): static
    {
        $this->responsiveSizes['xxl'] = $size;
        return $this;
    }

    /**
     * Set column offset
     *
     * @param int $offset 0-11
     * @return static
     */
    public function offset(int $offset): static
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Set responsive offset
     *
     * @param string $breakpoint sm|md|lg|xl|xxl
     * @param int $offset
     * @return static
     */
    public function offsetAt(string $breakpoint, int $offset): static
    {
        $this->responsiveOffsets[$breakpoint] = $offset;
        return $this;
    }

    /**
     * Set column order
     *
     * @param int|string $order 1-5 or 'first'|'last'
     * @return static
     */
    public function order(int|string $order): static
    {
        $this->order = $order;
        return $this;
    }

    /**
     * Set column to render first
     *
     * @return static
     */
    public function first(): static
    {
        return $this->order('first');
    }

    /**
     * Set column to render last
     *
     * @return static
     */
    public function last(): static
    {
        return $this->order('last');
    }

    /**
     * Set self alignment
     *
     * @param string $alignment start|center|end|stretch|baseline
     * @return static
     */
    public function alignSelf(string $alignment): static
    {
        $this->alignSelf = $alignment;
        return $this;
    }

    /**
     * Align self to start
     *
     * @return static
     */
    public function alignSelfStart(): static
    {
        return $this->alignSelf('start');
    }

    /**
     * Align self to center
     *
     * @return static
     */
    public function alignSelfCenter(): static
    {
        return $this->alignSelf('center');
    }

    /**
     * Align self to end
     *
     * @return static
     */
    public function alignSelfEnd(): static
    {
        return $this->alignSelf('end');
    }

    /**
     * Build the CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        // Base column class
        if ($this->size !== null) {
            $this->addClass(CssPrefix::cls('col', $this->size));
        } else {
            $this->addClass(CssPrefix::cls('col'));
        }

        // Responsive size classes
        foreach ($this->responsiveSizes as $breakpoint => $size) {
            $this->addClass(CssPrefix::cls('col', $breakpoint, $size));
        }

        // Offset class
        if ($this->offset !== null) {
            $this->addClass(CssPrefix::cls('offset', $this->offset));
        }

        // Responsive offset classes
        foreach ($this->responsiveOffsets as $breakpoint => $offset) {
            $this->addClass(CssPrefix::cls('offset', $breakpoint, $offset));
        }

        // Order class
        if ($this->order !== null) {
            $this->addClass(CssPrefix::cls('order', $this->order));
        }

        // Self alignment
        if ($this->alignSelf !== null) {
            $this->addClass(CssPrefix::cls('align-self', $this->alignSelf));
        }

        return parent::buildClassString();
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        if ($this->size !== null) {
            $config['size'] = $this->size;
        }

        if ($this->offset !== null) {
            $config['offset'] = $this->offset;
        }

        if ($this->order !== null) {
            $config['order'] = $this->order;
        }

        if ($this->alignSelf !== null) {
            $config['alignSelf'] = $this->alignSelf;
        }

        // Responsive sizes
        foreach ($this->responsiveSizes as $breakpoint => $size) {
            $config[$breakpoint] = $size;
        }

        // Responsive offsets
        foreach ($this->responsiveOffsets as $breakpoint => $offset) {
            $config['offset' . ucfirst($breakpoint)] = $offset;
        }

        return $config;
    }
}
