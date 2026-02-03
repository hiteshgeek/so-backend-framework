<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * Breadcrumb - Navigation breadcrumb
 *
 * Provides breadcrumb navigation trail
 */
class Breadcrumb extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'breadcrumb';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'nav';

    /**
     * Breadcrumb items
     *
     * @var array
     */
    protected array $items = [];

    /**
     * Custom divider
     *
     * @var string|null
     */
    protected ?string $divider = null;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['items'])) {
            $this->items = $config['items'];
        }

        if (isset($config['divider'])) {
            $this->divider = $config['divider'];
        }
    }

    /**
     * Set items
     *
     * @param array $items
     * @return static
     */
    public function items(array $items): static
    {
        $this->items = $items;
        return $this;
    }

    /**
     * Add item
     *
     * @param string $label
     * @param string|null $url
     * @param string|null $icon
     * @return static
     */
    public function addItem(string $label, ?string $url = null, ?string $icon = null): static
    {
        $item = ['label' => $label];
        if ($url !== null) {
            $item['url'] = $url;
        }
        if ($icon !== null) {
            $item['icon'] = $icon;
        }
        $this->items[] = $item;
        return $this;
    }

    /**
     * Set custom divider
     *
     * @param string $divider
     * @return static
     */
    public function divider(string $divider): static
    {
        $this->divider = $divider;
        return $this;
    }

    /**
     * Use arrow divider
     *
     * @return static
     */
    public function arrowDivider(): static
    {
        return $this->divider('>');
    }

    /**
     * Use slash divider
     *
     * @return static
     */
    public function slashDivider(): static
    {
        return $this->divider('/');
    }

    /**
     * Use chevron divider
     *
     * @return static
     */
    public function chevronDivider(): static
    {
        return $this->addClass('breadcrumb-chevron');
    }

    /**
     * Use pipe divider
     *
     * @return static
     */
    public function pipeDivider(): static
    {
        return $this->addClass('breadcrumb-pipe');
    }

    /**
     * Use dot divider
     *
     * @return static
     */
    public function dotDivider(): static
    {
        return $this->addClass('breadcrumb-dot');
    }

    /**
     * Use icon divider
     *
     * @return static
     */
    public function iconDivider(): static
    {
        return $this->addClass('breadcrumb-icon');
    }

    /**
     * Use filled background style
     *
     * @return static
     */
    public function filled(): static
    {
        return $this->addClass('breadcrumb-filled');
    }

    /**
     * Use pills style
     *
     * @return static
     */
    public function pills(): static
    {
        return $this->addClass('breadcrumb-pills');
    }

    /**
     * Set color variant
     *
     * @param string $variant
     * @return static
     */
    public function variant(string $variant): static
    {
        return $this->addClass('breadcrumb-' . $variant);
    }

    /**
     * Use primary color variant
     *
     * @return static
     */
    public function primary(): static
    {
        return $this->variant('primary');
    }

    /**
     * Use success color variant
     *
     * @return static
     */
    public function success(): static
    {
        return $this->variant('success');
    }

    /**
     * Use danger color variant
     *
     * @return static
     */
    public function danger(): static
    {
        return $this->variant('danger');
    }

    /**
     * Use warning color variant
     *
     * @return static
     */
    public function warning(): static
    {
        return $this->variant('warning');
    }

    /**
     * Use info color variant
     *
     * @return static
     */
    public function info(): static
    {
        return $this->variant('info');
    }

    /**
     * Set size
     *
     * @param string $size
     * @return static
     */
    public function size(string $size): static
    {
        return $this->addClass('breadcrumb-' . $size);
    }

    /**
     * Use small size
     *
     * @return static
     */
    public function small(): static
    {
        return $this->size('sm');
    }

    /**
     * Use large size
     *
     * @return static
     */
    public function large(): static
    {
        return $this->size('lg');
    }

    /**
     * Enable text truncation
     *
     * @return static
     */
    public function truncate(): static
    {
        return $this->addClass('breadcrumb-truncate');
    }

    /**
     * Enable responsive collapse
     *
     * @return static
     */
    public function collapse(): static
    {
        return $this->addClass('breadcrumb-collapse');
    }

    /**
     * Gather all attributes
     *
     * @return array<string, mixed>
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = parent::gatherAllAttributes();

        $attrs['aria-label'] = 'breadcrumb';

        if ($this->divider !== null) {
            $attrs['style'] = '--' . CssPrefix::getPrefix() . '-breadcrumb-divider: \'' . e($this->divider) . '\';';
        }

        return $attrs;
    }

    /**
     * Render content
     *
     * @return string
     */
    public function renderContent(): string
    {
        $html = '<ol class="' . CssPrefix::cls('breadcrumb') . '">';

        $lastIndex = count($this->items) - 1;

        foreach ($this->items as $index => $item) {
            $isActive = $index === $lastIndex || !isset($item['url']);
            $itemClass = CssPrefix::cls('breadcrumb-item');

            if ($isActive) {
                $itemClass .= ' ' . CssPrefix::cls('active');
            }

            $html .= '<li class="' . $itemClass . '"';
            if ($isActive) {
                $html .= ' aria-current="page"';
            }
            $html .= '>';

            // Icon
            $iconHtml = '';
            if (isset($item['icon'])) {
                $iconHtml = '<span class="material-icons ' . CssPrefix::cls('me-1') . '">' . e($item['icon']) . '</span>';
            }

            if (!$isActive && isset($item['url'])) {
                $html .= '<a href="' . e($item['url']) . '">' . $iconHtml . e($item['label']) . '</a>';
            } else {
                $html .= $iconHtml . e($item['label']);
            }

            $html .= '</li>';
        }

        $html .= '</ol>';

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

        if (!empty($this->items)) {
            $config['items'] = $this->items;
        }

        if ($this->divider !== null) {
            $config['divider'] = $this->divider;
        }

        return $config;
    }
}
