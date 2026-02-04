<?php

namespace Core\UiEngine\Elements\Layout;

use Core\UiEngine\Elements\ContainerElement;
use Core\UiEngine\Contracts\ElementInterface;
use Core\UiEngine\Support\CssPrefix;
use Core\UiEngine\Support\ElementFactory;

/**
 * Row - Grid row container element
 *
 * Creates a Bootstrap-style row that contains columns.
 * Uses so-row class from the frontend framework.
 */
class Row extends ContainerElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'row';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Gutter size (spacing between columns)
     *
     * @var string|null
     */
    protected ?string $gutter = null;

    /**
     * Vertical alignment
     *
     * @var string|null
     */
    protected ?string $alignItems = null;

    /**
     * Horizontal alignment
     *
     * @var string|null
     */
    protected ?string $justifyContent = null;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['gutter'])) {
            $this->gutter = $config['gutter'];
        }

        if (isset($config['alignItems'])) {
            $this->alignItems = $config['alignItems'];
        }

        if (isset($config['justifyContent'])) {
            $this->justifyContent = $config['justifyContent'];
        }
    }

    /**
     * Set gutter size
     *
     * @param string $size 0, 1, 2, 3, 4, 5
     * @return static
     */
    public function gutter(string $size): static
    {
        $this->gutter = $size;
        return $this;
    }

    /**
     * Remove gutter (no spacing)
     *
     * @return static
     */
    public function noGutter(): static
    {
        return $this->gutter('0');
    }

    /**
     * Set vertical alignment
     *
     * @param string $alignment start|center|end|stretch|baseline
     * @return static
     */
    public function alignItems(string $alignment): static
    {
        $this->alignItems = $alignment;
        return $this;
    }

    /**
     * Align items to start
     *
     * @return static
     */
    public function alignStart(): static
    {
        return $this->alignItems('start');
    }

    /**
     * Align items to center
     *
     * @return static
     */
    public function alignCenter(): static
    {
        return $this->alignItems('center');
    }

    /**
     * Align items to end
     *
     * @return static
     */
    public function alignEnd(): static
    {
        return $this->alignItems('end');
    }

    /**
     * Set horizontal alignment
     *
     * @param string $alignment start|center|end|between|around|evenly
     * @return static
     */
    public function justifyContent(string $alignment): static
    {
        $this->justifyContent = $alignment;
        return $this;
    }

    /**
     * Justify content to start
     *
     * @return static
     */
    public function justifyStart(): static
    {
        return $this->justifyContent('start');
    }

    /**
     * Justify content to center
     *
     * @return static
     */
    public function justifyCenter(): static
    {
        return $this->justifyContent('center');
    }

    /**
     * Justify content to end
     *
     * @return static
     */
    public function justifyEnd(): static
    {
        return $this->justifyContent('end');
    }

    /**
     * Justify content with space between
     *
     * @return static
     */
    public function justifyBetween(): static
    {
        return $this->justifyContent('between');
    }

    /**
     * Justify content with space around
     *
     * @return static
     */
    public function justifyAround(): static
    {
        return $this->justifyContent('around');
    }

    /**
     * Add a column to this row
     *
     * @param int|string|null $size Column size (1-12) or null for auto
     * @param ElementInterface|array|null $content Column content
     * @return static
     */
    public function col(int|string|null $size = null, ElementInterface|array|null $content = null): static
    {
        $config = ['type' => 'column'];

        if ($size !== null) {
            $config['size'] = $size;
        }

        if ($content !== null) {
            $config['children'] = is_array($content) ? $content : [$content];
        }

        return $this->add(ElementFactory::create($config));
    }

    /**
     * Add multiple equal-width columns
     *
     * @param int $count Number of columns
     * @return static
     */
    public function cols(int $count): static
    {
        for ($i = 0; $i < $count; $i++) {
            $this->col();
        }

        return $this;
    }

    /**
     * Build the CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        // Add base row class
        $this->addClass(CssPrefix::cls('row'));

        // Gutter class
        if ($this->gutter !== null) {
            $this->addClass(CssPrefix::cls('g', $this->gutter));
        }

        // Alignment classes
        if ($this->alignItems !== null) {
            $this->addClass(CssPrefix::cls('align-items', $this->alignItems));
        }

        if ($this->justifyContent !== null) {
            $this->addClass(CssPrefix::cls('justify-content', $this->justifyContent));
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

        if ($this->gutter !== null) {
            $config['gutter'] = $this->gutter;
        }

        if ($this->alignItems !== null) {
            $config['alignItems'] = $this->alignItems;
        }

        if ($this->justifyContent !== null) {
            $config['justifyContent'] = $this->justifyContent;
        }

        return $config;
    }
}
