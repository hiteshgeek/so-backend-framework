<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\ContainerElement;
use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * Card - Simple card container with header, body, and footer
 *
 * A flexible container that accepts nested elements for complex layouts.
 * Use renderMixed() to handle any nested Element objects.
 */
class Card extends ContainerElement
{
    /**
     * Element type identifier
     */
    protected string $type = 'card';

    /**
     * HTML tag name
     */
    protected string $tagName = 'div';

    /**
     * Card header content (accepts Element|string|array)
     */
    protected Element|string|array|null $header = null;

    /**
     * Card body content (accepts Element|string|array)
     */
    protected Element|string|array|null $body = null;

    /**
     * Card footer content (accepts Element|string|array)
     */
    protected Element|string|array|null $footer = null;

    /**
     * Card border variant (primary, success, danger, warning, info, secondary)
     */
    protected ?string $variant = null;

    /**
     * Set card header content
     */
    public function header(Element|string|array $content): static
    {
        $this->header = $content;
        return $this;
    }

    /**
     * Set card body content
     */
    public function body(Element|string|array $content): static
    {
        $this->body = $content;
        return $this;
    }

    /**
     * Set card footer content
     */
    public function footer(Element|string|array $content): static
    {
        $this->footer = $content;
        return $this;
    }

    /**
     * Set card border variant
     */
    public function variant(string $variant): static
    {
        $this->variant = $variant;
        return $this;
    }

    /**
     * Variant shortcuts
     */
    public function primary(): static { return $this->variant('primary'); }
    public function secondary(): static { return $this->variant('secondary'); }
    public function success(): static { return $this->variant('success'); }
    public function danger(): static { return $this->variant('danger'); }
    public function warning(): static { return $this->variant('warning'); }
    public function info(): static { return $this->variant('info'); }

    /**
     * Build CSS classes
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('card'));

        // Variant class
        if ($this->variant !== null) {
            $this->addClass(CssPrefix::cls('card-border-' . $this->variant));
        }

        return parent::buildClassString();
    }

    /**
     * Render card content
     */
    public function renderContent(): string
    {
        $html = '';

        // Header
        if ($this->header !== null) {
            $html .= '<div class="' . CssPrefix::cls('card-header') . '">';
            $html .= $this->renderMixed($this->header);
            $html .= '</div>';
        }

        // Body
        if ($this->body !== null) {
            $html .= '<div class="' . CssPrefix::cls('card-body') . '">';
            $html .= $this->renderMixed($this->body);
            $html .= '</div>';
        }

        // Render children (if using add() method)
        $html .= $this->renderChildren();

        // Footer
        if ($this->footer !== null) {
            $html .= '<div class="' . CssPrefix::cls('card-footer') . '">';
            $html .= $this->renderMixed($this->footer);
            $html .= '</div>';
        }

        return $html;
    }

    /**
     * Convert to array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        if ($this->header !== null) {
            $config['header'] = $this->header;
        }

        if ($this->body !== null) {
            $config['body'] = $this->body;
        }

        if ($this->footer !== null) {
            $config['footer'] = $this->footer;
        }

        if ($this->variant !== null) {
            $config['variant'] = $this->variant;
        }

        return $config;
    }
}
