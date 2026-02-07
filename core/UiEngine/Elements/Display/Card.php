<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\ContainerElement;
use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;
use Core\UiEngine\Support\ElementFactory;
use Core\UiEngine\Traits\HasDragDrop;

/**
 * Card - Simple card container with header, body, and footer
 *
 * A flexible container that accepts nested elements for complex layouts.
 * Supports full card colors, borderless sections, actions, and drag-drop.
 *
 * Config Example:
 *   Card::make([
 *       'header' => 'Card Title',
 *       'body' => 'Card content',
 *       'color' => 'primary',
 *       'headerBorderless' => true,
 *       'draggable' => true,
 *       'dragHandle' => '.so-card-header',
 *   ]);
 *
 * Fluent API Example:
 *   Card::make()
 *       ->header('Card Title')
 *       ->body('Card content')
 *       ->colorPrimary()
 *       ->headerBorderless()
 *       ->draggable()
 *       ->dragHandle('.so-card-header');
 */
class Card extends ContainerElement
{
    use HasDragDrop;

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
     * Full card color (primary, success, danger, warning, info, secondary, light, dark)
     */
    protected ?string $color = null;

    /**
     * Remove header bottom border
     */
    protected bool $_headerBorderless = false;

    /**
     * Remove footer top border
     */
    protected bool $_footerBorderless = false;

    /**
     * Card action states
     */
    protected bool $_collapsible = false;
    protected bool $_refreshable = false;
    protected ?string $_refreshHandler = null;
    protected bool $_maximizable = false;
    protected bool $_closeable = false;
    protected ?string $_closeConfirm = null;

    // ==================
    // Content Methods
    // ==================

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

    // ==================
    // Border Variant Methods
    // ==================

    /**
     * Set card border variant
     */
    public function variant(string $variant): static
    {
        $this->variant = $variant;
        return $this;
    }

    /**
     * Border variant shortcuts
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

    // ==================
    // Full Card Color Methods
    // ==================

    /**
     * Set full card background color
     */
    public function color(string $color): static
    {
        $this->color = $color;
        return $this;
    }

    /**
     * Full card color shortcuts
     */
    public function colorPrimary(): static
    {
        return $this->color('primary');
    }

    public function colorSecondary(): static
    {
        return $this->color('secondary');
    }

    public function colorSuccess(): static
    {
        return $this->color('success');
    }

    public function colorDanger(): static
    {
        return $this->color('danger');
    }

    public function colorWarning(): static
    {
        return $this->color('warning');
    }

    public function colorInfo(): static
    {
        return $this->color('info');
    }

    public function colorLight(): static
    {
        return $this->color('light');
    }

    public function colorDark(): static
    {
        return $this->color('dark');
    }

    // ==================
    // Borderless Section Methods
    // ==================

    /**
     * Remove header bottom border
     */
    public function headerBorderless(): static
    {
        $this->_headerBorderless = true;
        return $this;
    }

    /**
     * Remove footer top border
     */
    public function footerBorderless(): static
    {
        $this->_footerBorderless = true;
        return $this;
    }

    /**
     * Remove both header and footer borders
     */
    public function borderlessSections(): static
    {
        $this->_headerBorderless = true;
        $this->_footerBorderless = true;
        return $this;
    }

    // ==================
    // Action Configuration Methods
    // ==================

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
     *
     * @param string|null $handler - JavaScript function name to call on refresh
     */
    public function refreshable(?string $handler = null): static
    {
        $this->_refreshable = true;
        $this->_refreshHandler = $handler;
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

    // ==================
    // Config Initialization
    // ==================

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

        // Border variant
        if (isset($config['variant'])) {
            $this->variant = $config['variant'];
        }

        // Full card color
        if (isset($config['color'])) {
            $this->color = $config['color'];
        }

        // Borderless sections
        if (isset($config['headerBorderless'])) {
            $this->_headerBorderless = (bool) $config['headerBorderless'];
        }
        if (isset($config['footerBorderless'])) {
            $this->_footerBorderless = (bool) $config['footerBorderless'];
        }
        if (isset($config['borderlessSections']) && $config['borderlessSections']) {
            $this->_headerBorderless = true;
            $this->_footerBorderless = true;
        }

        // Actions
        if (isset($config['collapsible']) && $config['collapsible']) {
            $this->_collapsible = true;
        }
        if (isset($config['refreshable'])) {
            $this->_refreshable = true;
            if (is_string($config['refreshable'])) {
                $this->_refreshHandler = $config['refreshable'];
            }
        }
        if (isset($config['maximizable']) && $config['maximizable']) {
            $this->_maximizable = true;
        }
        if (isset($config['closeable'])) {
            $this->_closeable = true;
            if (is_string($config['closeable'])) {
                $this->_closeConfirm = $config['closeable'];
            }
        }

        // Initialize drag-drop from config (from HasDragDrop trait)
        $this->initDragDropFromConfig($config);
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

    // ==================
    // Rendering
    // ==================

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
            $refreshAttr = $this->_refreshHandler ? ' data-refresh-handler="' . htmlspecialchars($this->_refreshHandler) . '"' : '';
            $html .= '<button type="button" class="' . CssPrefix::cls('btn') . ' ';
            $html .= CssPrefix::cls('btn-icon') . ' ' . CssPrefix::cls('btn-ghost') . ' ';
            $html .= CssPrefix::cls('btn-sm') . ' ' . CssPrefix::cls('card-action-btn') . '" ';
            $html .= 'data-action="refresh"' . $refreshAttr . ' title="Refresh">';
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

        // Border variant class
        if ($this->variant !== null) {
            $this->addClass(CssPrefix::cls('card-border-' . $this->variant));
        }

        // Full card color class
        if ($this->color !== null) {
            $this->addClass(CssPrefix::cls('card-' . $this->color));
        }

        // Borderless section classes
        if ($this->_headerBorderless) {
            $this->addClass(CssPrefix::cls('card-header-borderless'));
        }
        if ($this->_footerBorderless) {
            $this->addClass(CssPrefix::cls('card-footer-borderless'));
        }

        return parent::buildClassString();
    }

    /**
     * Gather all HTML attributes including drag attributes
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = parent::gatherAllAttributes();

        // Add drag-drop attributes (from HasDragDrop trait)
        $attrs = array_merge($attrs, $this->getDragAttributes());

        // Add action data attributes for JS initialization
        if ($this->_collapsible) {
            $attrs['data-so-collapsible'] = 'true';
        }
        if ($this->_refreshable) {
            $attrs['data-so-refreshable'] = 'true';
        }
        if ($this->_maximizable) {
            $attrs['data-so-maximizable'] = 'true';
        }
        if ($this->_closeable) {
            $attrs['data-so-closeable'] = 'true';
        }

        return $attrs;
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

        if ($this->color !== null) {
            $config['color'] = $this->color;
        }

        if ($this->_headerBorderless) {
            $config['headerBorderless'] = true;
        }

        if ($this->_footerBorderless) {
            $config['footerBorderless'] = true;
        }

        if ($this->_draggable) {
            $config['draggable'] = true;
            if ($this->_dragHandle) {
                $config['dragHandle'] = $this->_dragHandle;
            }
            if ($this->_dragGroup) {
                $config['dragGroup'] = $this->_dragGroup;
            }
            if ($this->_liveReorder) {
                $config['liveReorder'] = true;
            }
        }

        return $config;
    }
}
