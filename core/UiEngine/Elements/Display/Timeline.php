<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * Timeline - Vertical timeline display
 *
 * Displays events/items in a vertical timeline format
 */
class Timeline extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'timeline';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Timeline items
     *
     * @var array
     */
    protected array $items = [];

    /**
     * Alternate sides
     *
     * @var bool
     */
    protected bool $alternate = false;

    /**
     * Centered timeline
     *
     * @var bool
     */
    protected bool $centered = false;

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

        if (isset($config['alternate'])) {
            $this->alternate = (bool) $config['alternate'];
        }

        if (isset($config['centered'])) {
            $this->centered = (bool) $config['centered'];
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
     * @param string $title
     * @param string|null $content
     * @param string|null $date
     * @param string|null $icon
     * @param string|null $variant
     * @return static
     */
    public function addItem(string $title, ?string $content = null, ?string $date = null, ?string $icon = null, ?string $variant = null): static
    {
        $item = ['title' => $title];
        if ($content !== null) {
            $item['content'] = $content;
        }
        if ($date !== null) {
            $item['date'] = $date;
        }
        if ($icon !== null) {
            $item['icon'] = $icon;
        }
        if ($variant !== null) {
            $item['variant'] = $variant;
        }
        $this->items[] = $item;
        return $this;
    }

    /**
     * Enable alternating sides
     *
     * @param bool $alternate
     * @return static
     */
    public function alternate(bool $alternate = true): static
    {
        $this->alternate = $alternate;
        return $this;
    }

    /**
     * Enable centered layout
     *
     * @param bool $centered
     * @return static
     */
    public function centered(bool $centered = true): static
    {
        $this->centered = $centered;
        return $this;
    }

    /**
     * Build CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('timeline'));

        if ($this->alternate) {
            $this->addClass(CssPrefix::cls('timeline-alternate'));
        }

        if ($this->centered) {
            $this->addClass(CssPrefix::cls('timeline-centered'));
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

        foreach ($this->items as $index => $item) {
            $itemClass = CssPrefix::cls('timeline-item');

            if ($this->alternate) {
                $itemClass .= ' ' . CssPrefix::cls($index % 2 === 0 ? 'timeline-left' : 'timeline-right');
            }

            $html .= '<div class="' . $itemClass . '">';

            // Marker
            $markerClass = CssPrefix::cls('timeline-marker');
            if (isset($item['variant'])) {
                $markerClass .= ' ' . CssPrefix::cls('bg', $item['variant']);
            }

            $html .= '<div class="' . $markerClass . '">';
            if (isset($item['icon'])) {
                $html .= '<span class="material-icons">' . e($item['icon']) . '</span>';
            }
            $html .= '</div>';

            // Content
            $html .= '<div class="' . CssPrefix::cls('timeline-content') . '">';

            // Date
            if (isset($item['date'])) {
                $html .= '<span class="' . CssPrefix::cls('timeline-date') . '">' . e($item['date']) . '</span>';
            }

            // Title
            $html .= '<h5 class="' . CssPrefix::cls('timeline-title') . '">' . e($item['title']) . '</h5>';

            // Content
            if (isset($item['content'])) {
                $html .= '<p class="' . CssPrefix::cls('timeline-text') . '">' . e($item['content']) . '</p>';
            }

            $html .= '</div>';
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

        if (!empty($this->items)) {
            $config['items'] = $this->items;
        }

        if ($this->alternate) {
            $config['alternate'] = true;
        }

        if ($this->centered) {
            $config['centered'] = true;
        }

        return $config;
    }
}
