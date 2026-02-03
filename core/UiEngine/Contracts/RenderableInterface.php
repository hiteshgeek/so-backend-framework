<?php

namespace Core\UiEngine\Contracts;

/**
 * Interface for objects that can be rendered to HTML
 *
 * Provides a consistent contract for rendering UI elements.
 */
interface RenderableInterface
{
    /**
     * Render to HTML string
     *
     * @return string
     */
    public function render(): string;

    /**
     * Convert to string (alias for render)
     *
     * @return string
     */
    public function __toString(): string;

    /**
     * Get the HTML tag name for this element
     *
     * @return string
     */
    public function getTagName(): string;

    /**
     * Build the opening tag with attributes
     *
     * @return string
     */
    public function renderOpenTag(): string;

    /**
     * Build the closing tag
     *
     * @return string
     */
    public function renderCloseTag(): string;

    /**
     * Render the element content (between tags)
     *
     * @return string
     */
    public function renderContent(): string;

    /**
     * Build all HTML attributes as a string
     *
     * @return string
     */
    public function renderAttributes(): string;

    /**
     * Check if element is self-closing
     *
     * @return bool
     */
    public function isSelfClosing(): bool;
}
