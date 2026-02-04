<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\ContainerElement;
use Core\UiEngine\Support\CssPrefix;

/**
 * Card - Card container display element
 *
 * Creates SixOrbit-style cards with header, body, and footer sections.
 */
class Card extends ContainerElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'card';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Card title
     *
     * @var string|null
     */
    protected ?string $title = null;

    /**
     * Card title as sanitized HTML
     *
     * @var string|null
     */
    protected ?string $titleHtml = null;

    /**
     * Card subtitle
     *
     * @var string|null
     */
    protected ?string $subtitle = null;

    /**
     * Header content
     *
     * @var string|null
     */
    protected ?string $header = null;

    /**
     * Footer content
     *
     * @var string|null
     */
    protected ?string $footer = null;

    /**
     * Card image URL
     *
     * @var string|null
     */
    protected ?string $image = null;

    /**
     * Image position (top, bottom)
     *
     * @var string
     */
    protected string $imagePosition = 'top';

    /**
     * Image alt text
     *
     * @var string
     */
    protected string $imageAlt = '';

    /**
     * Body text content
     *
     * @var string|null
     */
    protected ?string $bodyText = null;

    /**
     * Card border variant (primary, success, danger, etc.)
     *
     * @var string|null
     */
    protected ?string $variant = null;

    /**
     * Card header variant (primary, success, danger, etc.)
     *
     * @var string|null
     */
    protected ?string $headerVariant = null;

    /**
     * Whether header uses soft style
     *
     * @var bool
     */
    protected bool $headerSoft = false;

    /**
     * Card style (bordered, flat, elevated, padded)
     *
     * @var string|null
     */
    protected ?string $cardStyle = null;

    /**
     * Card spacing (compact, spacious)
     *
     * @var string|null
     */
    protected ?string $spacing = null;

    /**
     * Whether card is horizontal layout
     *
     * @var bool
     */
    protected bool $horizontal = false;

    /**
     * Whether to show shadow
     *
     * @var bool
     */
    protected bool $shadow = false;

    /**
     * Shadow size (sm, md, lg)
     *
     * @var string
     */
    protected string $shadowSize = 'md';

    /**
     * Whether card is collapsible
     *
     * @var bool
     */
    protected bool $collapsible = false;

    /**
     * Whether card starts collapsed
     *
     * @var bool
     */
    protected bool $collapsed = false;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['title'])) {
            $this->title = $config['title'];
        }

        if (isset($config['titleHtml'])) {
            $this->titleHtml = $this->sanitizeHtml($config['titleHtml']);
        }

        if (isset($config['subtitle'])) {
            $this->subtitle = $config['subtitle'];
        }

        if (isset($config['header'])) {
            $this->header = $config['header'];
        }

        if (isset($config['footer'])) {
            $this->footer = $config['footer'];
        }

        if (isset($config['image'])) {
            $this->image = $config['image'];
        }

        if (isset($config['imagePosition'])) {
            $this->imagePosition = $config['imagePosition'];
        }

        if (isset($config['imageAlt'])) {
            $this->imageAlt = $config['imageAlt'];
        }

        if (isset($config['bodyText'])) {
            $this->bodyText = $config['bodyText'];
        }

        if (isset($config['variant'])) {
            $this->variant = $config['variant'];
        }

        if (isset($config['headerVariant'])) {
            $this->headerVariant = $config['headerVariant'];
        }

        if (isset($config['headerSoft'])) {
            $this->headerSoft = (bool) $config['headerSoft'];
        }

        if (isset($config['cardStyle'])) {
            $this->cardStyle = $config['cardStyle'];
        }

        if (isset($config['spacing'])) {
            $this->spacing = $config['spacing'];
        }

        if (isset($config['horizontal'])) {
            $this->horizontal = (bool) $config['horizontal'];
        }

        if (isset($config['shadow'])) {
            $this->shadow = (bool) $config['shadow'];
        }

        if (isset($config['shadowSize'])) {
            $this->shadowSize = $config['shadowSize'];
        }

        if (isset($config['collapsible'])) {
            $this->collapsible = (bool) $config['collapsible'];
        }

        if (isset($config['collapsed'])) {
            $this->collapsed = (bool) $config['collapsed'];
        }
    }

    /**
     * Set card title
     *
     * @param string $title
     * @return static
     */
    public function title(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set card title as HTML (XSS-safe)
     *
     * Only allows safe tags (h1-h6, span, div, p, strong, em) and
     * safe attributes (class, id). All event handlers and dangerous
     * content are stripped.
     *
     * @param string $html
     * @return static
     */
    public function titleHtml(string $html): static
    {
        $this->titleHtml = $this->sanitizeHtml($html);
        return $this;
    }

    /**
     * Set card subtitle
     *
     * @param string $subtitle
     * @return static
     */
    public function subtitle(string $subtitle): static
    {
        $this->subtitle = $subtitle;
        return $this;
    }

    /**
     * Set header content
     *
     * @param string $header
     * @return static
     */
    public function header(string $header): static
    {
        $this->header = $header;
        return $this;
    }

    /**
     * Set footer content
     *
     * @param string $footer
     * @return static
     */
    public function footer(string $footer): static
    {
        $this->footer = $footer;
        return $this;
    }

    /**
     * Set card image
     *
     * @param string $url
     * @param string $position top|bottom
     * @param string $alt
     * @return static
     */
    public function image(string $url, string $position = 'top', string $alt = ''): static
    {
        $this->image = $url;
        $this->imagePosition = $position;
        $this->imageAlt = $alt;
        return $this;
    }

    /**
     * Set body text
     *
     * @param string $text
     * @return static
     */
    public function bodyText(string $text): static
    {
        $this->bodyText = $text;
        return $this;
    }

    /**
     * Set card variant (border color)
     *
     * @param string $variant
     * @return static
     */
    public function variant(string $variant): static
    {
        $this->variant = $variant;
        return $this;
    }

    /**
     * Primary border
     *
     * @return static
     */
    public function primary(): static
    {
        return $this->variant('primary');
    }

    /**
     * Success border
     *
     * @return static
     */
    public function success(): static
    {
        return $this->variant('success');
    }

    /**
     * Danger border
     *
     * @return static
     */
    public function danger(): static
    {
        return $this->variant('danger');
    }

    /**
     * Warning border
     *
     * @return static
     */
    public function warning(): static
    {
        return $this->variant('warning');
    }

    /**
     * Info border
     *
     * @return static
     */
    public function info(): static
    {
        return $this->variant('info');
    }

    /**
     * Secondary border
     *
     * @return static
     */
    public function secondary(): static
    {
        return $this->variant('secondary');
    }

    /**
     * Light border
     *
     * @return static
     */
    public function light(): static
    {
        return $this->variant('light');
    }

    /**
     * Dark border
     *
     * @return static
     */
    public function dark(): static
    {
        return $this->variant('dark');
    }

    /**
     * Primary header color
     *
     * @return static
     */
    public function headerPrimary(): static
    {
        return $this->headerColor('primary', false);
    }

    /**
     * Success header color
     *
     * @return static
     */
    public function headerSuccess(): static
    {
        return $this->headerColor('success', false);
    }

    /**
     * Danger header color
     *
     * @return static
     */
    public function headerDanger(): static
    {
        return $this->headerColor('danger', false);
    }

    /**
     * Warning header color
     *
     * @return static
     */
    public function headerWarning(): static
    {
        return $this->headerColor('warning', false);
    }

    /**
     * Info header color
     *
     * @return static
     */
    public function headerInfo(): static
    {
        return $this->headerColor('info', false);
    }

    /**
     * Secondary header color
     *
     * @return static
     */
    public function headerSecondary(): static
    {
        return $this->headerColor('secondary', false);
    }

    /**
     * Light header color
     *
     * @return static
     */
    public function headerLight(): static
    {
        return $this->headerColor('light', false);
    }

    /**
     * Dark header color
     *
     * @return static
     */
    public function headerDark(): static
    {
        return $this->headerColor('dark', false);
    }

    /**
     * Soft primary header color
     *
     * @return static
     */
    public function headerSoftPrimary(): static
    {
        return $this->headerColor('primary', true);
    }

    /**
     * Soft success header color
     *
     * @return static
     */
    public function headerSoftSuccess(): static
    {
        return $this->headerColor('success', true);
    }

    /**
     * Soft danger header color
     *
     * @return static
     */
    public function headerSoftDanger(): static
    {
        return $this->headerColor('danger', true);
    }

    /**
     * Soft warning header color
     *
     * @return static
     */
    public function headerSoftWarning(): static
    {
        return $this->headerColor('warning', true);
    }

    /**
     * Soft info header color
     *
     * @return static
     */
    public function headerSoftInfo(): static
    {
        return $this->headerColor('info', true);
    }

    /**
     * Soft secondary header color
     *
     * @return static
     */
    public function headerSoftSecondary(): static
    {
        return $this->headerColor('secondary', true);
    }

    /**
     * Soft light header color
     *
     * @return static
     */
    public function headerSoftLight(): static
    {
        return $this->headerColor('light', true);
    }

    /**
     * Soft dark header color
     *
     * @return static
     */
    public function headerSoftDark(): static
    {
        return $this->headerColor('dark', true);
    }

    /**
     * Enable shadow
     *
     * @param string $size sm|md|lg
     * @return static
     */
    public function shadow(string $size = 'md'): static
    {
        $this->shadow = true;
        $this->shadowSize = $size;
        return $this;
    }

    /**
     * Make card collapsible
     *
     * @param bool $startCollapsed
     * @return static
     */
    public function collapsible(bool $startCollapsed = false): static
    {
        $this->collapsible = true;
        $this->collapsed = $startCollapsed;
        return $this;
    }

    /**
     * Set header color variant
     *
     * @param string $variant
     * @param bool $soft Use soft/light style
     * @return static
     */
    public function headerColor(string $variant, bool $soft = false): static
    {
        $this->headerVariant = $variant;
        $this->headerSoft = $soft;
        return $this;
    }

    /**
     * Set card style (bordered, flat, elevated, padded)
     *
     * @param string $style
     * @return static
     */
    public function cardStyleType(string $style): static
    {
        $this->cardStyle = $style;
        return $this;
    }

    /**
     * Bordered style (border, no shadow)
     *
     * @return static
     */
    public function bordered(): static
    {
        return $this->cardStyleType('bordered');
    }

    /**
     * Flat style (no shadow, no border)
     *
     * @return static
     */
    public function flat(): static
    {
        return $this->cardStyleType('flat');
    }

    /**
     * Elevated style (larger shadow)
     *
     * @return static
     */
    public function elevated(): static
    {
        return $this->cardStyleType('elevated');
    }

    /**
     * Padded style (direct padding on card)
     *
     * @return static
     */
    public function padded(): static
    {
        return $this->cardStyleType('padded');
    }

    /**
     * Set card spacing
     *
     * @param string $spacing compact or spacious
     * @return static
     */
    public function spacing(string $spacing): static
    {
        $this->spacing = $spacing;
        return $this;
    }

    /**
     * Compact spacing
     *
     * @return static
     */
    public function compact(): static
    {
        return $this->spacing('compact');
    }

    /**
     * Spacious spacing
     *
     * @return static
     */
    public function spacious(): static
    {
        return $this->spacing('spacious');
    }

    /**
     * Horizontal layout
     *
     * @param bool $horizontal
     * @return static
     */
    public function horizontal(bool $horizontal = true): static
    {
        $this->horizontal = $horizontal;
        return $this;
    }

    /**
     * Build the CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('card'));

        // Border color variant: so-card-border-{variant}
        if ($this->variant !== null) {
            $this->addClass(CssPrefix::cls('card-border', $this->variant));
        }

        // Header color variant: so-card-header-{variant} or so-card-header-soft-{variant}
        if ($this->headerVariant !== null) {
            if ($this->headerSoft) {
                $this->addClass(CssPrefix::cls('card-header-soft', $this->headerVariant));
            } else {
                $this->addClass(CssPrefix::cls('card-header', $this->headerVariant));
            }
        }

        // Card style: so-card-{style}
        if ($this->cardStyle !== null) {
            $this->addClass(CssPrefix::cls('card', $this->cardStyle));
        }

        // Spacing: so-card-{spacing}
        if ($this->spacing !== null) {
            $this->addClass(CssPrefix::cls('card', $this->spacing));
        }

        // Horizontal layout
        if ($this->horizontal) {
            $this->addClass(CssPrefix::cls('card-horizontal'));
        }

        // Shadow
        if ($this->shadow) {
            $this->addClass(CssPrefix::cls('shadow', $this->shadowSize));
        }

        return parent::buildClassString();
    }

    /**
     * Sanitize HTML to prevent XSS
     *
     * Allows only safe tags and attributes:
     * - Tags: h1-h6, span, div, p, strong, em, br
     * - Attributes: class, id
     *
     * @param string $html
     * @return string
     */
    protected function sanitizeHtml(string $html): string
    {
        // Allowed tags
        $allowedTags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'span', 'div', 'p', 'strong', 'em', 'br'];

        // Strip all tags except allowed ones
        $html = strip_tags($html, '<' . implode('><', $allowedTags) . '>');

        // Remove dangerous attributes (event handlers, style, etc.)
        $html = preg_replace('/\s*on\w+\s*=\s*["\'].*?["\']/i', '', $html);
        $html = preg_replace('/\s*style\s*=\s*["\'].*?["\']/i', '', $html);
        $html = preg_replace('/\s*onclick\s*=\s*["\'].*?["\']/i', '', $html);
        $html = preg_replace('/javascript:/i', '', $html);

        // Only allow class and id attributes
        $html = preg_replace_callback(
            '/<(\w+)([^>]*)>/i',
            function($matches) {
                $tag = $matches[1];
                $attrs = $matches[2];

                // Extract only class and id attributes
                $safeAttrs = '';
                if (preg_match('/\s+class\s*=\s*["\']([^"\']*)["\']/', $attrs, $classMatch)) {
                    $safeAttrs .= ' class="' . htmlspecialchars($classMatch[1], ENT_QUOTES, 'UTF-8') . '"';
                }
                if (preg_match('/\s+id\s*=\s*["\']([^"\']*)["\']/', $attrs, $idMatch)) {
                    $safeAttrs .= ' id="' . htmlspecialchars($idMatch[1], ENT_QUOTES, 'UTF-8') . '"';
                }

                return '<' . $tag . $safeAttrs . '>';
            },
            $html
        );

        return $html;
    }

    /**
     * Render the content
     *
     * @return string
     */
    public function renderContent(): string
    {
        $html = '';

        // Image at top
        if ($this->image !== null && $this->imagePosition === 'top') {
            $html .= $this->renderImage();
        }

        // Header
        if ($this->header !== null || ($this->title !== null && $this->collapsible)) {
            $html .= $this->renderHeader();
        }

        // Body
        $html .= $this->renderBody();

        // Image at bottom
        if ($this->image !== null && $this->imagePosition === 'bottom') {
            $html .= $this->renderImage();
        }

        // Footer
        if ($this->footer !== null) {
            $html .= '<div class="' . CssPrefix::cls('card-footer') . '">' . e($this->footer) . '</div>';
        }

        return $html;
    }

    /**
     * Render card image
     *
     * @return string
     */
    protected function renderImage(): string
    {
        $class = $this->imagePosition === 'top' ? CssPrefix::cls('card-img-top') : CssPrefix::cls('card-img-bottom');
        return '<img src="' . e($this->image) . '" class="' . $class . '" alt="' . e($this->imageAlt) . '">';
    }

    /**
     * Render card header
     *
     * @return string
     */
    protected function renderHeader(): string
    {
        $html = '<div class="' . CssPrefix::cls('card-header');

        if ($this->collapsible) {
            $html .= ' ' . CssPrefix::cls('d-flex') . ' ' . CssPrefix::cls('justify-content-between') . ' ' . CssPrefix::cls('align-items-center');
        }

        $html .= '">';

        if ($this->header !== null) {
            $html .= e($this->header);
        } elseif ($this->title !== null && $this->collapsible) {
            $html .= '<span>' . e($this->title) . '</span>';

            $collapseId = $this->id ? $this->id . '-collapse' : 'card-collapse-' . uniqid();
            $icon = $this->collapsed ? 'expand_more' : 'expand_less';

            $html .= '<button type="button" class="' . CssPrefix::cls('btn') . ' ' . CssPrefix::cls('btn-link') . ' ' . CssPrefix::cls('p-0') . '" ';
            $html .= CssPrefix::data('toggle') . '="collapse" ' . CssPrefix::data('target') . '="#' . e($collapseId) . '">';
            $html .= '<span class="material-icons">' . $icon . '</span>';
            $html .= '</button>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Render card body
     *
     * @return string
     */
    protected function renderBody(): string
    {
        $collapseId = $this->id ? $this->id . '-collapse' : 'card-collapse-' . uniqid();
        $collapseClass = $this->collapsed ? CssPrefix::cls('collapse') : CssPrefix::cls('collapse') . ' ' . CssPrefix::cls('show');

        $html = '';

        if ($this->collapsible) {
            $html .= '<div class="' . $collapseClass . '" id="' . e($collapseId) . '">';
        }

        $html .= '<div class="' . CssPrefix::cls('card-body') . '">';

        // Title (if not in header)
        if ($this->titleHtml !== null && !$this->collapsible) {
            $html .= $this->titleHtml;
        } elseif ($this->title !== null && !$this->collapsible) {
            $html .= '<h5 class="' . CssPrefix::cls('card-title') . '">' . e($this->title) . '</h5>';
        }

        // Subtitle
        if ($this->subtitle !== null) {
            $html .= '<h6 class="' . CssPrefix::cls('card-subtitle') . ' ' . CssPrefix::cls('mb-2') . ' ' . CssPrefix::cls('text-muted') . '">' . e($this->subtitle) . '</h6>';
        }

        // Body text
        if ($this->bodyText !== null) {
            $html .= '<p class="' . CssPrefix::cls('card-text') . '">' . e($this->bodyText) . '</p>';
        }

        // Children
        $html .= $this->renderChildren();

        $html .= '</div>';

        if ($this->collapsible) {
            $html .= '</div>';
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

        if ($this->title !== null) {
            $config['title'] = $this->title;
        }

        if ($this->titleHtml !== null) {
            $config['titleHtml'] = $this->titleHtml;
        }

        if ($this->subtitle !== null) {
            $config['subtitle'] = $this->subtitle;
        }

        if ($this->header !== null) {
            $config['header'] = $this->header;
        }

        if ($this->footer !== null) {
            $config['footer'] = $this->footer;
        }

        if ($this->image !== null) {
            $config['image'] = $this->image;
            $config['imagePosition'] = $this->imagePosition;
            $config['imageAlt'] = $this->imageAlt;
        }

        if ($this->bodyText !== null) {
            $config['bodyText'] = $this->bodyText;
        }

        if ($this->variant !== null) {
            $config['variant'] = $this->variant;
        }

        if ($this->headerVariant !== null) {
            $config['headerVariant'] = $this->headerVariant;
            $config['headerSoft'] = $this->headerSoft;
        }

        if ($this->cardStyle !== null) {
            $config['cardStyle'] = $this->cardStyle;
        }

        if ($this->spacing !== null) {
            $config['spacing'] = $this->spacing;
        }

        if ($this->horizontal) {
            $config['horizontal'] = true;
        }

        if ($this->shadow) {
            $config['shadow'] = true;
            $config['shadowSize'] = $this->shadowSize;
        }

        if ($this->collapsible) {
            $config['collapsible'] = true;
            $config['collapsed'] = $this->collapsed;
        }

        return $config;
    }
}
