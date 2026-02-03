<?php

namespace Core\UiEngine\Elements\Layout;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * Divider - Horizontal rule/separator element
 *
 * Creates a visual separator between content sections.
 * Can be a simple hr or a styled divider with text.
 */
class Divider extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'divider';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'hr';

    /**
     * Divider text (for text dividers)
     *
     * @var string|null
     */
    protected ?string $text = null;

    /**
     * Divider variant (line, dashed, dotted)
     *
     * @var string
     */
    protected string $variant = 'line';

    /**
     * Spacing size
     *
     * @var string
     */
    protected string $spacing = 'md';

    /**
     * Text position (left, center, right)
     *
     * @var string
     */
    protected string $textPosition = 'center';

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['text'])) {
            $this->text = $config['text'];
        }

        if (isset($config['variant'])) {
            $this->variant = $config['variant'];
        }

        if (isset($config['spacing'])) {
            $this->spacing = $config['spacing'];
        }

        if (isset($config['textPosition'])) {
            $this->textPosition = $config['textPosition'];
        }
    }

    /**
     * Set divider text
     *
     * @param string $text
     * @return static
     */
    public function text(string $text): static
    {
        $this->text = $text;
        $this->tagName = 'div'; // Switch to div for text dividers
        return $this;
    }

    /**
     * Set divider variant
     *
     * @param string $variant line|dashed|dotted
     * @return static
     */
    public function variant(string $variant): static
    {
        $this->variant = $variant;
        return $this;
    }

    /**
     * Set to dashed style
     *
     * @return static
     */
    public function dashed(): static
    {
        return $this->variant('dashed');
    }

    /**
     * Set to dotted style
     *
     * @return static
     */
    public function dotted(): static
    {
        return $this->variant('dotted');
    }

    /**
     * Set spacing size
     *
     * @param string $size sm|md|lg|xl
     * @return static
     */
    public function spacing(string $size): static
    {
        $this->spacing = $size;
        return $this;
    }

    /**
     * Small spacing
     *
     * @return static
     */
    public function small(): static
    {
        return $this->spacing('sm');
    }

    /**
     * Large spacing
     *
     * @return static
     */
    public function large(): static
    {
        return $this->spacing('lg');
    }

    /**
     * Extra large spacing
     *
     * @return static
     */
    public function extraLarge(): static
    {
        return $this->spacing('xl');
    }

    /**
     * Set text position
     *
     * @param string $position left|center|right
     * @return static
     */
    public function textPosition(string $position): static
    {
        $this->textPosition = $position;
        return $this;
    }

    /**
     * Align text to left
     *
     * @return static
     */
    public function textLeft(): static
    {
        return $this->textPosition('left');
    }

    /**
     * Align text to center
     *
     * @return static
     */
    public function textCenter(): static
    {
        return $this->textPosition('center');
    }

    /**
     * Align text to right
     *
     * @return static
     */
    public function textRight(): static
    {
        return $this->textPosition('right');
    }

    /**
     * Check if this is a self-closing element
     *
     * @return bool
     */
    public function isSelfClosing(): bool
    {
        // Only hr is self-closing, div with text is not
        return $this->text === null;
    }

    /**
     * Render the content
     *
     * @return string
     */
    public function renderContent(): string
    {
        if ($this->text === null) {
            return '';
        }

        return '<span class="' . CssPrefix::cls('divider-text') . '">' . e($this->text) . '</span>';
    }

    /**
     * Build the CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('divider'));

        // Variant class
        if ($this->variant !== 'line') {
            $this->addClass(CssPrefix::cls('divider', $this->variant));
        }

        // Spacing class
        $this->addClass(CssPrefix::cls('my', $this->spacing));

        // Text divider classes
        if ($this->text !== null) {
            $this->addClass(CssPrefix::cls('divider-text', $this->textPosition));
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

        if ($this->text !== null) {
            $config['text'] = $this->text;
        }

        if ($this->variant !== 'line') {
            $config['variant'] = $this->variant;
        }

        if ($this->spacing !== 'md') {
            $config['spacing'] = $this->spacing;
        }

        if ($this->textPosition !== 'center') {
            $config['textPosition'] = $this->textPosition;
        }

        return $config;
    }
}
