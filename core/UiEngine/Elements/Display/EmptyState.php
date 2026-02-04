<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * EmptyState - Empty state placeholder
 *
 * Displays a placeholder when no content is available
 */
class EmptyState extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'empty-state';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Title text
     *
     * @var string|null
     */
    protected ?string $title = null;

    /**
     * Description text
     *
     * @var string|null
     */
    protected ?string $description = null;

    /**
     * Icon name
     *
     * @var string|null
     */
    protected ?string $icon = null;

    /**
     * Image URL
     *
     * @var string|null
     */
    protected ?string $image = null;

    /**
     * Action buttons
     *
     * @var array
     */
    protected array $actions = [];

    /**
     * Contextual variant
     *
     * @var string|null
     */
    protected ?string $variant = null;

    /**
     * Size variant
     *
     * @var string|null
     */
    protected ?string $size = null;

    /**
     * Icon style variant
     *
     * @var string|null
     */
    protected ?string $iconStyle = null;

    /**
     * Compact layout
     *
     * @var bool
     */
    protected bool $compact = false;

    /**
     * Card styling
     *
     * @var bool
     */
    protected bool $card = false;

    /**
     * Heading level (h3, h4, h5)
     *
     * @var string
     */
    protected string $headingLevel = 'h3';

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

        if (isset($config['description'])) {
            $this->description = $config['description'];
        }

        if (isset($config['icon'])) {
            $this->icon = $config['icon'];
        }

        if (isset($config['image'])) {
            $this->image = $config['image'];
        }

        if (isset($config['actions'])) {
            $this->actions = $config['actions'];
        }

        if (isset($config['variant'])) {
            $this->variant = $config['variant'];
        }

        if (isset($config['size'])) {
            $this->size = $config['size'];
        }

        if (isset($config['iconStyle'])) {
            $this->iconStyle = $config['iconStyle'];
        }

        if (isset($config['compact'])) {
            $this->compact = (bool) $config['compact'];
        }

        if (isset($config['card'])) {
            $this->card = (bool) $config['card'];
        }

        if (isset($config['headingLevel'])) {
            $this->headingLevel = $config['headingLevel'];
        }
    }

    // ==================
    // Content Methods
    // ==================

    /**
     * Set title
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
     * Set description
     *
     * @param string $description
     * @return static
     */
    public function description(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Set icon
     *
     * @param string $icon
     * @return static
     */
    public function icon(string $icon): static
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Set image
     *
     * @param string $url
     * @return static
     */
    public function image(string $url): static
    {
        $this->image = $url;
        return $this;
    }

    /**
     * Set heading level
     *
     * @param string $level h3, h4, h5
     * @return static
     */
    public function headingLevel(string $level): static
    {
        $this->headingLevel = $level;
        return $this;
    }

    // ==================
    // Actions
    // ==================

    /**
     * Add action button
     *
     * @param string $text
     * @param string|null $url
     * @param string $variant
     * @return static
     */
    public function addAction(string $text, ?string $url = null, string $variant = 'primary'): static
    {
        $this->actions[] = [
            'text' => $text,
            'url' => $url,
            'variant' => $variant,
        ];
        return $this;
    }

    /**
     * Set single action button (for backwards compatibility)
     *
     * @param string $text
     * @param string|null $url
     * @param string $variant
     * @return static
     */
    public function action(string $text, ?string $url = null, string $variant = 'primary'): static
    {
        $this->actions = [
            [
                'text' => $text,
                'url' => $url,
                'variant' => $variant,
            ]
        ];
        return $this;
    }

    /**
     * Set multiple actions
     *
     * @param array $actions
     * @return static
     */
    public function actions(array $actions): static
    {
        $this->actions = $actions;
        return $this;
    }

    // ==================
    // Contextual Variants
    // ==================

    /**
     * Set contextual variant
     *
     * @param string $variant search, error, success, warning, info, no-permission
     * @return static
     */
    public function variant(string $variant): static
    {
        $this->variant = $variant;
        return $this;
    }

    /**
     * Search empty state
     *
     * @return static
     */
    public function search(): static
    {
        return $this->variant('search');
    }

    /**
     * Error/danger empty state
     *
     * @return static
     */
    public function error(): static
    {
        return $this->variant('error');
    }

    /**
     * Danger empty state (alias for error)
     *
     * @return static
     */
    public function danger(): static
    {
        return $this->variant('danger');
    }

    /**
     * Success empty state
     *
     * @return static
     */
    public function success(): static
    {
        return $this->variant('success');
    }

    /**
     * Warning empty state
     *
     * @return static
     */
    public function warning(): static
    {
        return $this->variant('warning');
    }

    /**
     * Info empty state
     *
     * @return static
     */
    public function info(): static
    {
        return $this->variant('info');
    }

    /**
     * No permission / forbidden empty state
     *
     * @return static
     */
    public function noPermission(): static
    {
        return $this->variant('no-permission');
    }

    /**
     * Forbidden empty state (alias for noPermission)
     *
     * @return static
     */
    public function forbidden(): static
    {
        return $this->variant('forbidden');
    }

    // ==================
    // Size Variants
    // ==================

    /**
     * Set size variant
     *
     * @param string $size sm, lg
     * @return static
     */
    public function size(string $size): static
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Small size
     *
     * @return static
     */
    public function small(): static
    {
        return $this->size('sm');
    }

    /**
     * Large size
     *
     * @return static
     */
    public function large(): static
    {
        return $this->size('lg');
    }

    // ==================
    // Icon Styling
    // ==================

    /**
     * Set icon style
     *
     * @param string $style circle, gradient
     * @return static
     */
    public function iconStyle(string $style): static
    {
        $this->iconStyle = $style;
        return $this;
    }

    /**
     * Circle icon style
     *
     * @return static
     */
    public function iconCircle(): static
    {
        return $this->iconStyle('circle');
    }

    /**
     * Gradient icon style
     *
     * @return static
     */
    public function iconGradient(): static
    {
        return $this->iconStyle('gradient');
    }

    // ==================
    // Layout Variants
    // ==================

    /**
     * Compact/inline layout
     *
     * @param bool $compact
     * @return static
     */
    public function compact(bool $compact = true): static
    {
        $this->compact = $compact;
        return $this;
    }

    /**
     * Card styling
     *
     * @param bool $card
     * @return static
     */
    public function card(bool $card = true): static
    {
        $this->card = $card;
        return $this;
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Build CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('empty-state'));

        // Contextual variant
        if ($this->variant !== null) {
            $this->addClass(CssPrefix::cls('empty-state-' . $this->variant));
        }

        // Size variant
        if ($this->size !== null) {
            $this->addClass(CssPrefix::cls('empty-state-' . $this->size));
        }

        // Layout variants
        if ($this->compact) {
            $this->addClass(CssPrefix::cls('empty-state-compact'));
        }

        if ($this->card) {
            $this->addClass(CssPrefix::cls('empty-state-card'));
        }

        return parent::buildClassString();
    }

    /**
     * Render content
     *
     * @return string
     */
    public function renderContent(): string
    {
        $html = '';

        // Image or icon
        if ($this->image !== null) {
            $html .= '<img src="' . e($this->image) . '" class="' . CssPrefix::cls('empty-state-image') . '" alt="">';
        } elseif ($this->icon !== null) {
            $iconClasses = CssPrefix::cls('empty-state-icon');

            // Add icon style variant
            if ($this->iconStyle !== null) {
                $iconClasses .= ' ' . CssPrefix::cls('empty-state-icon-' . $this->iconStyle);
            }

            $html .= '<div class="' . $iconClasses . '">';
            $html .= '<span class="material-icons">' . e($this->icon) . '</span>';
            $html .= '</div>';
        }

        // Title
        if ($this->title !== null) {
            $html .= '<' . $this->headingLevel . ' class="' . CssPrefix::cls('empty-state-title') . '">' . e($this->title) . '</' . $this->headingLevel . '>';
        }

        // Description (text)
        if ($this->description !== null) {
            $html .= '<p class="' . CssPrefix::cls('empty-state-text') . '">' . e($this->description) . '</p>';
        }

        // Actions
        if (!empty($this->actions)) {
            $html .= '<div class="' . CssPrefix::cls('empty-state-actions') . '">';

            foreach ($this->actions as $actionConfig) {
                $btnClass = CssPrefix::cls('btn') . ' ' . CssPrefix::cls('btn-' . ($actionConfig['variant'] ?? 'primary'));

                if (isset($actionConfig['url']) && $actionConfig['url'] !== null) {
                    $html .= '<a href="' . e($actionConfig['url']) . '" class="' . $btnClass . '">';
                    $html .= e($actionConfig['text']);
                    $html .= '</a>';
                } else {
                    $html .= '<button type="button" class="' . $btnClass . '">';
                    $html .= e($actionConfig['text']);
                    $html .= '</button>';
                }
            }

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

        if ($this->description !== null) {
            $config['description'] = $this->description;
        }

        if ($this->icon !== null) {
            $config['icon'] = $this->icon;
        }

        if ($this->image !== null) {
            $config['image'] = $this->image;
        }

        if (!empty($this->actions)) {
            $config['actions'] = $this->actions;
        }

        if ($this->variant !== null) {
            $config['variant'] = $this->variant;
        }

        if ($this->size !== null) {
            $config['size'] = $this->size;
        }

        if ($this->iconStyle !== null) {
            $config['iconStyle'] = $this->iconStyle;
        }

        if ($this->compact) {
            $config['compact'] = true;
        }

        if ($this->card) {
            $config['card'] = true;
        }

        if ($this->headingLevel !== 'h3') {
            $config['headingLevel'] = $this->headingLevel;
        }

        return $config;
    }
}
