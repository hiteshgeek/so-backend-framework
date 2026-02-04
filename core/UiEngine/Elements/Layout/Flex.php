<?php

namespace Core\UiEngine\Elements\Layout;

use Core\UiEngine\Elements\ContainerElement;
use Core\UiEngine\Support\CssPrefix;

/**
 * Flex - Flexbox layout wrapper
 *
 * Provides Flexbox layout functionality with utilities
 */
class Flex extends ContainerElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'flex';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Flex direction
     *
     * @var string|null
     */
    protected ?string $direction = null;

    /**
     * Justify content
     *
     * @var string|null
     */
    protected ?string $justify = null;

    /**
     * Align items
     *
     * @var string|null
     */
    protected ?string $align = null;

    /**
     * Align content
     *
     * @var string|null
     */
    protected ?string $alignContent = null;

    /**
     * Flex wrap
     *
     * @var string|null
     */
    protected ?string $wrap = null;

    /**
     * Gap
     *
     * @var int|null
     */
    protected ?int $flexGap = null;

    /**
     * Inline flex
     *
     * @var bool
     */
    protected bool $inline = false;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['direction'])) {
            $this->direction = $config['direction'];
        }

        if (isset($config['justify'])) {
            $this->justify = $config['justify'];
        }

        if (isset($config['align'])) {
            $this->align = $config['align'];
        }

        if (isset($config['alignContent'])) {
            $this->alignContent = $config['alignContent'];
        }

        if (isset($config['wrap'])) {
            $this->wrap = $config['wrap'];
        }

        if (isset($config['gap'])) {
            $this->flexGap = (int) $config['gap'];
        }

        if (isset($config['inline'])) {
            $this->inline = (bool) $config['inline'];
        }
    }

    /**
     * Set flex direction
     *
     * @param string $direction
     * @return static
     */
    public function direction(string $direction): static
    {
        $this->direction = $direction;
        return $this;
    }

    /**
     * Row direction
     *
     * @return static
     */
    public function row(): static
    {
        return $this->direction('row');
    }

    /**
     * Row reverse direction
     *
     * @return static
     */
    public function rowReverse(): static
    {
        return $this->direction('row-reverse');
    }

    /**
     * Column direction
     *
     * @return static
     */
    public function column(): static
    {
        return $this->direction('column');
    }

    /**
     * Column reverse direction
     *
     * @return static
     */
    public function columnReverse(): static
    {
        return $this->direction('column-reverse');
    }

    /**
     * Set justify content
     *
     * @param string $justify
     * @return static
     */
    public function justify(string $justify): static
    {
        $this->justify = $justify;
        return $this;
    }

    /**
     * Justify start
     *
     * @return static
     */
    public function justifyStart(): static
    {
        return $this->justify('start');
    }

    /**
     * Justify center
     *
     * @return static
     */
    public function justifyCenter(): static
    {
        return $this->justify('center');
    }

    /**
     * Justify end
     *
     * @return static
     */
    public function justifyEnd(): static
    {
        return $this->justify('end');
    }

    /**
     * Justify between
     *
     * @return static
     */
    public function justifyBetween(): static
    {
        return $this->justify('between');
    }

    /**
     * Justify around
     *
     * @return static
     */
    public function justifyAround(): static
    {
        return $this->justify('around');
    }

    /**
     * Justify evenly
     *
     * @return static
     */
    public function justifyEvenly(): static
    {
        return $this->justify('evenly');
    }

    /**
     * Set align items
     *
     * @param string $align
     * @return static
     */
    public function align(string $align): static
    {
        $this->align = $align;
        return $this;
    }

    /**
     * Align start
     *
     * @return static
     */
    public function alignStart(): static
    {
        return $this->align('start');
    }

    /**
     * Align center
     *
     * @return static
     */
    public function alignCenter(): static
    {
        return $this->align('center');
    }

    /**
     * Align end
     *
     * @return static
     */
    public function alignEnd(): static
    {
        return $this->align('end');
    }

    /**
     * Align baseline
     *
     * @return static
     */
    public function alignBaseline(): static
    {
        return $this->align('baseline');
    }

    /**
     * Align stretch
     *
     * @return static
     */
    public function alignStretch(): static
    {
        return $this->align('stretch');
    }

    /**
     * Set align content
     *
     * @param string $alignContent
     * @return static
     */
    public function alignContent(string $alignContent): static
    {
        $this->alignContent = $alignContent;
        return $this;
    }

    /**
     * Set flex wrap
     *
     * @param string $wrap
     * @return static
     */
    public function wrap(string $wrap = 'wrap'): static
    {
        $this->wrap = $wrap;
        return $this;
    }

    /**
     * No wrap
     *
     * @return static
     */
    public function nowrap(): static
    {
        return $this->wrap('nowrap');
    }

    /**
     * Wrap reverse
     *
     * @return static
     */
    public function wrapReverse(): static
    {
        return $this->wrap('wrap-reverse');
    }

    /**
     * Set gap
     *
     * @param int $gap
     * @return static
     */
    public function gap(int $gap): static
    {
        $this->flexGap = $gap;
        return $this;
    }

    /**
     * Set inline flex
     *
     * @param bool $inline
     * @return static
     */
    public function inline(bool $inline = true): static
    {
        $this->inline = $inline;
        return $this;
    }

    /**
     * Center both horizontally and vertically
     *
     * @return static
     */
    public function center(): static
    {
        return $this->justifyCenter()->alignCenter();
    }

    /**
     * Build CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        if ($this->inline) {
            $this->addClass(CssPrefix::cls('d-inline-flex'));
        } else {
            $this->addClass(CssPrefix::cls('d-flex'));
        }

        if ($this->direction !== null) {
            $this->addClass(CssPrefix::cls('flex', $this->direction));
        }

        if ($this->justify !== null) {
            $this->addClass(CssPrefix::cls('justify-content', $this->justify));
        }

        if ($this->align !== null) {
            $this->addClass(CssPrefix::cls('align-items', $this->align));
        }

        if ($this->alignContent !== null) {
            $this->addClass(CssPrefix::cls('align-content', $this->alignContent));
        }

        if ($this->wrap !== null) {
            $this->addClass(CssPrefix::cls('flex', $this->wrap));
        }

        if ($this->flexGap !== null) {
            $this->addClass(CssPrefix::cls('gap', $this->flexGap));
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

        if ($this->direction !== null) {
            $config['direction'] = $this->direction;
        }

        if ($this->justify !== null) {
            $config['justify'] = $this->justify;
        }

        if ($this->align !== null) {
            $config['align'] = $this->align;
        }

        if ($this->alignContent !== null) {
            $config['alignContent'] = $this->alignContent;
        }

        if ($this->wrap !== null) {
            $config['wrap'] = $this->wrap;
        }

        if ($this->flexGap !== null) {
            $config['gap'] = $this->flexGap;
        }

        if ($this->inline) {
            $config['inline'] = true;
        }

        return $config;
    }
}
