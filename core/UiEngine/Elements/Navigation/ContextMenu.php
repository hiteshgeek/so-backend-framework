<?php

namespace Core\UiEngine\Elements\Navigation;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * ContextMenu - Right-click context menu
 *
 * Provides context menu functionality for elements
 */
class ContextMenu extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'context-menu';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Menu items
     *
     * @var array
     */
    protected array $items = [];

    /**
     * Target selector
     *
     * @var string|null
     */
    protected ?string $target = null;

    /**
     * Dark mode
     *
     * @var bool
     */
    protected bool $dark = false;

    /**
     * Menu size
     *
     * @var string|null
     */
    protected ?string $menuSize = null;

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

        if (isset($config['target'])) {
            $this->target = $config['target'];
        }

        if (isset($config['dark'])) {
            $this->dark = (bool) $config['dark'];
        }

        if (isset($config['size'])) {
            $this->menuSize = $config['size'];
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
     * Add item (fluent API)
     *
     * @param string $label
     * @param string|null $id
     * @param array $options Options: icon, shortcut, disabled, danger
     * @return static
     */
    public function item(string $label, ?string $id = null, array $options = []): static
    {
        $this->items[] = [
            'type' => 'item',
            'label' => $label,
            'action' => $id,
            'icon' => $options['icon'] ?? null,
            'shortcut' => $options['shortcut'] ?? null,
            'disabled' => $options['disabled'] ?? false,
            'danger' => $options['danger'] ?? false,
        ];
        return $this;
    }

    /**
     * Add item (legacy method)
     *
     * @param string $label
     * @param string|null $icon
     * @param string|null $action
     * @param string|null $shortcut
     * @param bool $disabled
     * @param bool $danger
     * @return static
     */
    public function addItem(string $label, ?string $icon = null, ?string $action = null, ?string $shortcut = null, bool $disabled = false, bool $danger = false): static
    {
        return $this->item($label, $action, [
            'icon' => $icon,
            'shortcut' => $shortcut,
            'disabled' => $disabled,
            'danger' => $danger,
        ]);
    }

    /**
     * Add danger item (fluent API)
     *
     * @param string $label
     * @param string|null $id
     * @param array $options
     * @return static
     */
    public function dangerItem(string $label, ?string $id = null, array $options = []): static
    {
        $options['danger'] = true;
        return $this->item($label, $id, $options);
    }

    /**
     * Add danger item (legacy method)
     *
     * @param string $label
     * @param string|null $icon
     * @param string|null $action
     * @param string|null $shortcut
     * @return static
     */
    public function addDangerItem(string $label, ?string $icon = null, ?string $action = null, ?string $shortcut = null): static
    {
        return $this->addItem($label, $icon, $action, $shortcut, false, true);
    }

    /**
     * Add divider (fluent alias)
     *
     * @return static
     */
    public function divider(): static
    {
        $this->items[] = ['type' => 'divider'];
        return $this;
    }

    /**
     * Add divider (legacy method)
     *
     * @return static
     */
    public function addDivider(): static
    {
        return $this->divider();
    }

    /**
     * Add submenu (fluent API)
     *
     * @param string $label
     * @param array $items
     * @param array $options Options: icon
     * @return static
     */
    public function submenu(string $label, array $items, array $options = []): static
    {
        $this->items[] = [
            'type' => 'submenu',
            'label' => $label,
            'icon' => $options['icon'] ?? null,
            'items' => $items,
        ];
        return $this;
    }

    /**
     * Add submenu (legacy method)
     *
     * @param string $label
     * @param array $items
     * @param string|null $icon
     * @return static
     */
    public function addSubmenu(string $label, array $items, ?string $icon = null): static
    {
        return $this->submenu($label, $items, ['icon' => $icon]);
    }

    /**
     * Add header/label
     *
     * @param string $text
     * @return static
     */
    public function header(string $text): static
    {
        $this->items[] = ['type' => 'header', 'label' => $text];
        return $this;
    }

    /**
     * Set menu size
     *
     * @param string $size 'sm' or 'lg'
     * @return static
     */
    public function size(string $size): static
    {
        $this->menuSize = $size;
        return $this;
    }

    /**
     * Set target selector
     *
     * @param string $selector
     * @return static
     */
    public function target(string $selector): static
    {
        $this->target = $selector;
        return $this;
    }

    /**
     * Dark mode
     *
     * @param bool $dark
     * @return static
     */
    public function dark(bool $dark = true): static
    {
        $this->dark = $dark;
        return $this;
    }

    /**
     * Build CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('context-menu'));

        if ($this->dark) {
            $this->addClass(CssPrefix::cls('context-menu-dark'));
        }

        if ($this->menuSize !== null) {
            $this->addClass(CssPrefix::cls('context-menu-' . $this->menuSize));
        }

        return parent::buildClassString();
    }

    /**
     * Gather all attributes
     *
     * @return array<string, mixed>
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = parent::gatherAllAttributes();

        $attrs['role'] = 'menu';

        return $attrs;
    }

    /**
     * Render content
     *
     * @return string
     */
    public function renderContent(): string
    {
        return $this->renderMenuItems($this->items);
    }

    /**
     * Render menu items
     *
     * @param array $items
     * @return string
     */
    protected function renderMenuItems(array $items): string
    {
        $html = '';

        foreach ($items as $item) {
            $type = $item['type'] ?? 'item';

            if ($type === 'divider') {
                $html .= '<div class="' . CssPrefix::cls('context-menu-divider') . '"></div>';
            } elseif ($type === 'header') {
                $html .= '<div class="' . CssPrefix::cls('context-menu-header') . '">' . e($item['label']) . '</div>';
            } elseif ($type === 'submenu') {
                $itemClass = CssPrefix::cls('context-menu-item') . ' has-submenu';

                $html .= '<div class="' . $itemClass . '">';

                if (!empty($item['icon'])) {
                    $html .= '<span class="' . CssPrefix::cls('context-menu-item-icon') . '"><span class="material-icons">' . e($item['icon']) . '</span></span>';
                }

                $html .= '<span class="' . CssPrefix::cls('context-menu-item-text') . '">' . e($item['label']) . '</span>';
                $html .= '<span class="' . CssPrefix::cls('context-menu-item-arrow') . '"><span class="material-icons">chevron_right</span></span>';

                // Nested submenu
                $html .= '<div class="' . CssPrefix::cls('context-menu') . ' ' . CssPrefix::cls('context-submenu') . '">';
                $html .= $this->renderMenuItems($item['items'] ?? []);
                $html .= '</div>';

                $html .= '</div>';
            } else {
                $itemClass = CssPrefix::cls('context-menu-item');
                if (!empty($item['disabled'])) {
                    $itemClass .= ' ' . CssPrefix::cls('disabled');
                }
                if (!empty($item['danger'])) {
                    $itemClass .= ' ' . CssPrefix::cls('danger');
                }

                $html .= '<div class="' . $itemClass . '"';

                if (!empty($item['action'])) {
                    $html .= ' ' . CssPrefix::data('id') . '="' . e($item['action']) . '"';
                }

                $html .= '>';

                if (!empty($item['icon'])) {
                    $html .= '<span class="' . CssPrefix::cls('context-menu-item-icon') . '"><span class="material-icons">' . e($item['icon']) . '</span></span>';
                }

                $html .= '<span class="' . CssPrefix::cls('context-menu-item-text') . '">' . e($item['label']) . '</span>';

                if (!empty($item['shortcut'])) {
                    $html .= '<span class="' . CssPrefix::cls('context-menu-item-shortcut') . '">' . e($item['shortcut']) . '</span>';
                }

                $html .= '</div>';
            }
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

        if ($this->target !== null) {
            $config['target'] = $this->target;
        }

        if ($this->dark) {
            $config['dark'] = true;
        }

        if ($this->menuSize !== null) {
            $config['size'] = $this->menuSize;
        }

        return $config;
    }
}
