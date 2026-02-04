<?php

namespace Core\UiEngine\Elements;

/**
 * Html - Generic HTML element
 *
 * Creates any HTML element with specified tag name.
 * Useful for creating wrapper divs, spans, paragraphs, links, etc.
 */
class Html extends ContainerElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'html';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Text content
     *
     * @var string|null
     */
    protected ?string $textContent = null;

    /**
     * Inner HTML content
     *
     * @var string|null
     */
    protected ?string $innerHTML = null;

    /**
     * Self-closing tag
     *
     * @var bool
     */
    protected bool $selfClosing = false;

    /**
     * For <a> tags - href attribute
     *
     * @var string|null
     */
    protected ?string $href = null;

    /**
     * For <a> tags - target attribute
     *
     * @var string|null
     */
    protected ?string $target = null;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['tag'])) {
            $this->tagName = $config['tag'];
        }

        if (isset($config['textContent'])) {
            $this->textContent = $config['textContent'];
        }

        if (isset($config['innerHTML'])) {
            $this->innerHTML = $config['innerHTML'];
        }

        if (isset($config['selfClosing'])) {
            $this->selfClosing = (bool) $config['selfClosing'];
        }

        if (isset($config['href'])) {
            $this->href = $config['href'];
        }

        if (isset($config['target'])) {
            $this->target = $config['target'];
        }
    }

    /**
     * Set HTML tag name
     *
     * @param string $tag
     * @return static
     */
    public function tag(string $tag): static
    {
        $this->tagName = $tag;
        return $this;
    }

    /**
     * Set text content (escaped)
     *
     * @param string $text
     * @return static
     */
    public function text(string $text): static
    {
        $this->textContent = $text;
        return $this;
    }

    /**
     * Set innerHTML (raw HTML, use with caution)
     *
     * @param string $html
     * @return static
     */
    public function html(string $html): static
    {
        $this->innerHTML = $html;
        return $this;
    }

    /**
     * Set as self-closing tag
     *
     * @param bool $selfClosing
     * @return static
     */
    public function selfClosing(bool $selfClosing = true): static
    {
        $this->selfClosing = $selfClosing;
        return $this;
    }

    /**
     * Set href attribute (for links)
     *
     * @param string $href
     * @return static
     */
    public function href(string $href): static
    {
        $this->href = $href;
        return $this;
    }

    /**
     * Set target attribute (for links)
     *
     * @param string $target
     * @return static
     */
    public function target(string $target): static
    {
        $this->target = $target;
        return $this;
    }

    /**
     * Open link in new tab
     *
     * @return static
     */
    public function newTab(): static
    {
        return $this->target('_blank');
    }

    /**
     * Get tag name
     *
     * @return string
     */
    public function getTagName(): string
    {
        return $this->tagName;
    }

    /**
     * Gather all attributes
     *
     * @return array<string, mixed>
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = parent::gatherAllAttributes();

        if ($this->href !== null) {
            $attrs['href'] = $this->href;
        }

        if ($this->target !== null) {
            $attrs['target'] = $this->target;
        }

        return $attrs;
    }

    /**
     * Render element content
     *
     * @return string
     */
    public function renderContent(): string
    {
        $html = '';

        // Raw innerHTML takes precedence
        if ($this->innerHTML !== null) {
            $html .= $this->innerHTML;
        }
        // Then text content (escaped)
        elseif ($this->textContent !== null) {
            $html .= e($this->textContent);
        }

        // Render children
        $html .= $this->renderChildren();

        return $html;
    }

    /**
     * Render the complete element
     *
     * @return string
     */
    public function render(): string
    {
        // Self-closing tags
        if ($this->selfClosing) {
            $attrs = $this->buildAttributeString();
            return '<' . $this->tagName . ($attrs ? ' ' . $attrs : '') . '>';
        }

        // Normal tags
        return parent::render();
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        if ($this->tagName !== 'div') {
            $config['tag'] = $this->tagName;
        }

        if ($this->textContent !== null) {
            $config['textContent'] = $this->textContent;
        }

        if ($this->innerHTML !== null) {
            $config['innerHTML'] = $this->innerHTML;
        }

        if ($this->selfClosing) {
            $config['selfClosing'] = true;
        }

        if ($this->href !== null) {
            $config['href'] = $this->href;
        }

        if ($this->target !== null) {
            $config['target'] = $this->target;
        }

        return $config;
    }
}
