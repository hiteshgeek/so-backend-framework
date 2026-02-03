<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * ListGroup - Flexible list component
 *
 * Displays a series of content in a flexible list with optional
 * actions, badges, icons, and various styling options.
 */
class ListGroup extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'list-group';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'ul';

    /**
     * List items
     *
     * @var array
     */
    protected array $items = [];

    /**
     * Flush style (no outer borders)
     *
     * @var bool
     */
    protected bool $flush = false;

    /**
     * Numbered list
     *
     * @var bool
     */
    protected bool $numbered = false;

    /**
     * Horizontal layout
     *
     * @var bool|string
     */
    protected bool|string $horizontal = false;

    /**
     * Size variant
     *
     * @var string|null
     */
    protected ?string $size = null;

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

        if (isset($config['flush'])) {
            $this->flush = (bool) $config['flush'];
        }

        if (isset($config['numbered'])) {
            $this->numbered = (bool) $config['numbered'];
        }

        if (isset($config['horizontal'])) {
            $this->horizontal = $config['horizontal'];
        }

        if (isset($config['size'])) {
            $this->size = $config['size'];
        }
    }

    // ==================
    // Content Methods
    // ==================

    /**
     * Set all items at once
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
     * Add a single item (alias for addItem)
     *
     * @param string $content
     * @param array $options
     * @return static
     */
    public function item(string $content, array $options = []): static
    {
        return $this->addItem(
            content: $content,
            badge: $options['badge'] ?? null,
            variant: $options['variant'] ?? null,
            active: $options['active'] ?? false,
            disabled: $options['disabled'] ?? false,
            url: $options['url'] ?? $options['href'] ?? null,
            icon: $options['icon'] ?? null,
            badgeVariant: $options['badgeVariant'] ?? null
        );
    }

    /**
     * Add item with full parameters
     *
     * @param string $content
     * @param string|int|null $badge
     * @param string|null $variant
     * @param bool $active
     * @param bool $disabled
     * @param string|null $url
     * @param string|null $icon
     * @param string|null $badgeVariant
     * @return static
     */
    public function addItem(
        string $content,
        string|int|null $badge = null,
        ?string $variant = null,
        bool $active = false,
        bool $disabled = false,
        ?string $url = null,
        ?string $icon = null,
        ?string $badgeVariant = null
    ): static {
        $item = ['content' => $content];

        if ($badge !== null) {
            $item['badge'] = $badge;
        }
        if ($variant !== null) {
            $item['variant'] = $variant;
        }
        if ($active) {
            $item['active'] = true;
        }
        if ($disabled) {
            $item['disabled'] = true;
        }
        if ($url !== null) {
            $item['url'] = $url;
        }
        if ($icon !== null) {
            $item['icon'] = $icon;
        }
        if ($badgeVariant !== null) {
            $item['badgeVariant'] = $badgeVariant;
        }

        $this->items[] = $item;
        return $this;
    }

    /**
     * Update item at index
     *
     * @param int $index
     * @param array $updates
     * @return static
     */
    public function updateItem(int $index, array $updates): static
    {
        if (isset($this->items[$index])) {
            $this->items[$index] = array_merge($this->items[$index], $updates);
        }
        return $this;
    }

    /**
     * Remove item at index
     *
     * @param int $index
     * @return static
     */
    public function removeItem(int $index): static
    {
        if (isset($this->items[$index])) {
            array_splice($this->items, $index, 1);
        }
        return $this;
    }

    /**
     * Clear all items
     *
     * @return static
     */
    public function clearItems(): static
    {
        $this->items = [];
        return $this;
    }

    /**
     * Get item at index
     *
     * @param int $index
     * @return array|null
     */
    public function getItem(int $index): ?array
    {
        return $this->items[$index] ?? null;
    }

    /**
     * Get all items
     *
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Get item count
     *
     * @return int
     */
    public function getItemCount(): int
    {
        return count($this->items);
    }

    // ==================
    // Styling Methods
    // ==================

    /**
     * Set flush style (no borders/rounded corners)
     *
     * @param bool $flush
     * @return static
     */
    public function flush(bool $flush = true): static
    {
        $this->flush = $flush;
        return $this;
    }

    /**
     * Set numbered list
     *
     * @param bool $numbered
     * @return static
     */
    public function numbered(bool $numbered = true): static
    {
        $this->numbered = $numbered;
        if ($numbered) {
            $this->tagName = 'ol';
        }
        return $this;
    }

    /**
     * Set horizontal layout
     *
     * @param bool|string $horizontal true, 'sm', 'md', 'lg', 'xl'
     * @return static
     */
    public function horizontal(bool|string $horizontal = true): static
    {
        $this->horizontal = $horizontal;
        return $this;
    }

    /**
     * Set size variant
     *
     * @param string $size 'sm' or 'lg'
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
    // State Methods
    // ==================

    /**
     * Set active state on item
     *
     * @param int $index
     * @param bool $active
     * @return static
     */
    public function setActive(int $index, bool $active = true): static
    {
        return $this->updateItem($index, ['active' => $active]);
    }

    /**
     * Set disabled state on item
     *
     * @param int $index
     * @param bool $disabled
     * @return static
     */
    public function setDisabled(int $index, bool $disabled = true): static
    {
        return $this->updateItem($index, ['disabled' => $disabled]);
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
        $this->addClass(CssPrefix::cls('list-group'));

        if ($this->flush) {
            $this->addClass(CssPrefix::cls('list-group-flush'));
        }

        if ($this->numbered) {
            $this->addClass(CssPrefix::cls('list-group-numbered'));
        }

        if ($this->horizontal !== false) {
            if ($this->horizontal === true) {
                $this->addClass(CssPrefix::cls('list-group-horizontal'));
            } else {
                $this->addClass(CssPrefix::cls('list-group-horizontal-' . $this->horizontal));
            }
        }

        if ($this->size !== null) {
            $this->addClass(CssPrefix::cls('list-group-' . $this->size));
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
            $isLink = isset($item['url']);
            $tag = $isLink ? 'a' : 'li';

            $itemClass = CssPrefix::cls('list-group-item');

            // Add action class if URL is present
            if ($isLink) {
                $itemClass .= ' ' . CssPrefix::cls('list-group-item-action');
            }

            // Add variant class
            if (isset($item['variant'])) {
                $itemClass .= ' ' . CssPrefix::cls('list-group-item-' . $item['variant']);
            }

            // Add state classes
            if (!empty($item['active'])) {
                $itemClass .= ' ' . CssPrefix::cls('active');
            }

            if (!empty($item['disabled'])) {
                $itemClass .= ' disabled';
            }

            $html .= '<' . $tag . ' class="' . $itemClass . '"';

            if ($isLink) {
                $html .= ' href="' . e($item['url']) . '"';
            }

            if (!empty($item['active'])) {
                $html .= ' aria-current="true"';
            }

            if (!empty($item['disabled'])) {
                $html .= ' aria-disabled="true"';
                if ($isLink) {
                    $html .= ' tabindex="-1"';
                }
            }

            $html .= ' data-so-index="' . $index . '"';
            $html .= '>';

            // Render content with icon and/or badge
            if (isset($item['icon']) || isset($item['badge'])) {
                $html .= '<div class="' . CssPrefix::cls('d-flex') . ' ' . CssPrefix::cls('justify-content-between') . ' ' . CssPrefix::cls('align-items-center') . '">';

                // Icon + content
                if (isset($item['icon'])) {
                    $html .= '<div class="' . CssPrefix::cls('d-flex') . ' ' . CssPrefix::cls('align-items-center') . '">';
                    $html .= '<span class="material-icons ' . CssPrefix::cls('me-3') . ' ' . CssPrefix::cls('text-primary') . '">' . e($item['icon']) . '</span>';
                    $html .= '<span>' . e($item['content']) . '</span>';
                    $html .= '</div>';
                } else {
                    $html .= '<span>' . e($item['content']) . '</span>';
                }

                // Badge
                if (isset($item['badge'])) {
                    $badgeVariant = $item['badgeVariant'] ?? 'primary';
                    $html .= '<span class="' . CssPrefix::cls('badge') . ' ' . CssPrefix::cls('badge-' . $badgeVariant) . ' ' . CssPrefix::cls('badge-pill') . '">';
                    $html .= e($item['badge']);
                    $html .= '</span>';
                }

                $html .= '</div>';
            } else {
                $html .= e($item['content']);
            }

            $html .= '</' . $tag . '>';
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

        if ($this->flush) {
            $config['flush'] = true;
        }

        if ($this->numbered) {
            $config['numbered'] = true;
        }

        if ($this->horizontal !== false) {
            $config['horizontal'] = $this->horizontal;
        }

        if ($this->size !== null) {
            $config['size'] = $this->size;
        }

        return $config;
    }
}
