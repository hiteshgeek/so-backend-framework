<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\ContainerElement;
use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;
use Core\UiEngine\Support\ElementFactory;

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
     * Card action states
     */
    protected bool $_collapsible = false;
    protected bool $_refreshable = false;
    protected bool $_maximizable = false;
    protected bool $_closeable = false;
    protected ?string $_closeConfirm = null;
    protected bool $_draggable = false;
    protected array $_dragConfig = [];

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
    public function primary(): static
    {
        return $this->variant('primary');
    }
    public function secondary(): static
    {
        return $this->variant('secondary');
    }
    public function success(): static
    {
        return $this->variant('success');
    }
    public function danger(): static
    {
        return $this->variant('danger');
    }
    public function warning(): static
    {
        return $this->variant('warning');
    }
    public function info(): static
    {
        return $this->variant('info');
    }

    /**
     * Action Configuration Methods
     */

    /**
     * Enable collapse action
     */
    public function collapsible(): static
    {
        $this->_collapsible = true;
        return $this;
    }

    /**
     * Enable refresh action
     */
    public function refreshable(): static
    {
        $this->_refreshable = true;
        return $this;
    }

    /**
     * Enable fullscreen/maximize action
     */
    public function maximizable(): static
    {
        $this->_maximizable = true;
        return $this;
    }

    /**
     * Enable close action
     *
     * @param bool $confirm - Whether to show confirmation dialog
     * @param string|null $message - Custom confirmation message
     */
    public function closeable(bool $confirm = false, ?string $message = null): static
    {
        $this->_closeable = true;
        if ($confirm) {
            $this->_closeConfirm = $message ?? 'Are you sure you want to close this card?';
        }
        return $this;
    }

    /**
     * Enable draggable functionality
     *
     * @param array $config - SODragDrop configuration options
     */
    public function draggable(array $config = []): static
    {
        $this->_draggable = true;
        $this->_dragConfig = $config;
        return $this;
    }

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        // Header content (accepts array of configs, Element, or string)
        if (isset($config['header'])) {
            $this->header = $this->processConfigContent($config['header']);
        }

        // Body content (accepts array of configs, Element, or string)
        if (isset($config['body'])) {
            $this->body = $this->processConfigContent($config['body']);
        }

        // Footer content (accepts array of configs, Element, or string)
        if (isset($config['footer'])) {
            $this->footer = $this->processConfigContent($config['footer']);
        }

        // Variant
        if (isset($config['variant'])) {
            $this->variant = $config['variant'];
        }
    }

    /**
     * Process config content (convert config arrays to Elements)
     *
     * @param mixed $content
     * @return Element|string|array|null
     */
    protected function processConfigContent(mixed $content): Element|string|array|null
    {
        // Already an Element or string - return as-is
        if ($content instanceof Element || is_string($content)) {
            return $content;
        }

        // Array of items - process each
        if (is_array($content)) {
            // Check if it's a config array (has 'type' key) or array of items
            if (isset($content['type'])) {
                // Single config object - convert to Element
                return ElementFactory::create($content);
            }

            // Array of items - convert each config to Element
            return array_map(function ($item) {
                if ($item instanceof Element) {
                    return $item;
                }
                if (is_array($item) && isset($item['type'])) {
                    return ElementFactory::create($item);
                }
                return $item;
            }, $content);
        }

        return $content;
    }

    /**
     * Check if card has any actions enabled
     */
    protected function hasActions(): bool
    {
        return $this->_collapsible || $this->_refreshable ||
               $this->_maximizable || $this->_closeable;
    }

    /**
     * Render action buttons
     */
    protected function renderActions(): string
    {
        if (!$this->hasActions()) {
            return '';
        }

        $html = '<div class="' . CssPrefix::cls('card-header-actions') . '">';

        // Collapse button
        if ($this->_collapsible) {
            $html .= '<button type="button" class="' . CssPrefix::cls('btn') . ' ';
            $html .= CssPrefix::cls('btn-icon') . ' ' . CssPrefix::cls('btn-ghost') . ' ';
            $html .= CssPrefix::cls('btn-sm') . ' ' . CssPrefix::cls('card-action-btn') . '" ';
            $html .= 'data-action="collapse" title="Collapse">';
            $html .= '<span class="material-icons">expand_less</span>';
            $html .= '</button>';
        }

        // Refresh button
        if ($this->_refreshable) {
            $html .= '<button type="button" class="' . CssPrefix::cls('btn') . ' ';
            $html .= CssPrefix::cls('btn-icon') . ' ' . CssPrefix::cls('btn-ghost') . ' ';
            $html .= CssPrefix::cls('btn-sm') . ' ' . CssPrefix::cls('card-action-btn') . '" ';
            $html .= 'data-action="refresh" title="Refresh">';
            $html .= '<span class="material-icons">refresh</span>';
            $html .= '</button>';
        }

        // Fullscreen button
        if ($this->_maximizable) {
            $html .= '<button type="button" class="' . CssPrefix::cls('btn') . ' ';
            $html .= CssPrefix::cls('btn-icon') . ' ' . CssPrefix::cls('btn-ghost') . ' ';
            $html .= CssPrefix::cls('btn-sm') . ' ' . CssPrefix::cls('card-action-btn') . '" ';
            $html .= 'data-action="fullscreen" title="Fullscreen">';
            $html .= '<span class="material-icons">fullscreen</span>';
            $html .= '</button>';
        }

        // Close button
        if ($this->_closeable) {
            $closeAttr = $this->_closeConfirm ? ' data-confirm="' . htmlspecialchars($this->_closeConfirm) . '"' : '';
            $html .= '<button type="button" class="' . CssPrefix::cls('btn') . ' ';
            $html .= CssPrefix::cls('btn-icon') . ' ' . CssPrefix::cls('btn-ghost') . ' ';
            $html .= CssPrefix::cls('btn-sm') . ' ' . CssPrefix::cls('card-action-btn') . '" ';
            $html .= 'data-action="close"' . $closeAttr . ' title="Close">';
            $html .= '<span class="material-icons">close</span>';
            $html .= '</button>';
        }

        $html .= '</div>';
        return $html;
    }

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

        // Header (include actions if present)
        if ($this->header !== null || $this->hasActions()) {
            $html .= '<div class="' . CssPrefix::cls('card-header') . '">';
            if ($this->header !== null) {
                $html .= $this->renderMixed($this->header);
            }
            $html .= $this->renderActions();
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
