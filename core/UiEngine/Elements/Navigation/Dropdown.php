<?php

namespace Core\UiEngine\Elements\Navigation;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * Dropdown - Dropdown menu
 *
 * Provides dropdown menu functionality
 */
class Dropdown extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'dropdown';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Trigger text/content
     *
     * @var string|null
     */
    protected ?string $trigger = null;

    /**
     * Trigger icon
     *
     * @var string|null
     */
    protected ?string $triggerIcon = null;

    /**
     * Dropdown items
     *
     * @var array
     */
    protected array $items = [];

    /**
     * Dropdown direction
     *
     * @var string
     */
    protected string $direction = 'down';

    /**
     * Alignment
     *
     * @var string
     */
    protected string $alignment = 'start';

    /**
     * Button variant
     *
     * @var string
     */
    protected string $variant = 'secondary';

    /**
     * Split button mode
     *
     * @var bool
     */
    protected bool $split = false;

    /**
     * Button size
     *
     * @var string|null
     */
    protected ?string $buttonSize = null;

    /**
     * Dark menu
     *
     * @var bool
     */
    protected bool $dark = false;

    /**
     * Auto close behavior
     *
     * @var bool|string
     */
    protected bool|string $autoClose = true;

    /**
     * Searchable dropdown
     *
     * @var bool
     */
    protected bool $searchable = false;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['trigger'])) {
            $this->trigger = $config['trigger'];
        }

        if (isset($config['triggerIcon'])) {
            $this->triggerIcon = $config['triggerIcon'];
        }

        if (isset($config['items'])) {
            $this->items = $config['items'];
        }

        if (isset($config['direction'])) {
            $this->direction = $config['direction'];
        }

        if (isset($config['alignment'])) {
            $this->alignment = $config['alignment'];
        }

        if (isset($config['variant'])) {
            $this->variant = $config['variant'];
        }

        if (isset($config['split'])) {
            $this->split = (bool) $config['split'];
        }

        if (isset($config['size'])) {
            $this->buttonSize = $config['size'];
        }

        if (isset($config['dark'])) {
            $this->dark = (bool) $config['dark'];
        }

        if (isset($config['autoClose'])) {
            $this->autoClose = $config['autoClose'];
        }

        if (isset($config['searchable'])) {
            $this->searchable = (bool) $config['searchable'];
        }
    }

    /**
     * Set trigger text
     *
     * @param string $trigger
     * @return static
     */
    public function trigger(string $trigger): static
    {
        $this->trigger = $trigger;
        return $this;
    }

    /**
     * Set trigger icon
     *
     * @param string $icon
     * @return static
     */
    public function triggerIcon(string $icon): static
    {
        $this->triggerIcon = $icon;
        return $this;
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
     * @param string|null $value
     * @param array $options Options: icon, active, disabled, danger
     * @return static
     */
    public function item(string $label, ?string $value = null, array $options = []): static
    {
        $this->items[] = [
            'type' => 'item',
            'label' => $label,
            'value' => $value ?? $label,
            'icon' => $options['icon'] ?? null,
            'active' => $options['active'] ?? false,
            'disabled' => $options['disabled'] ?? false,
            'danger' => $options['danger'] ?? false,
        ];
        return $this;
    }

    /**
     * Add item (legacy method)
     *
     * @param string $label
     * @param string|null $url
     * @param string|null $icon
     * @param bool $active
     * @param bool $disabled
     * @return static
     */
    public function addItem(string $label, ?string $url = null, ?string $icon = null, bool $active = false, bool $disabled = false): static
    {
        return $this->item($label, $url, [
            'icon' => $icon,
            'active' => $active,
            'disabled' => $disabled,
        ]);
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
     * Add header (fluent alias)
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
     * Add header (legacy method)
     *
     * @param string $text
     * @return static
     */
    public function addHeader(string $text): static
    {
        return $this->header($text);
    }

    /**
     * Set trigger icon (fluent alias)
     *
     * @param string $icon
     * @return static
     */
    public function icon(string $icon): static
    {
        $this->triggerIcon = $icon;
        return $this;
    }

    /**
     * Create icon-only trigger button
     *
     * @param string $icon
     * @return static
     */
    public function iconOnly(string $icon): static
    {
        $this->triggerIcon = $icon;
        $this->trigger = null;
        return $this;
    }

    /**
     * Set alignment (fluent alias)
     *
     * @param string $alignment
     * @return static
     */
    public function align(string $alignment): static
    {
        $this->alignment = $alignment;
        return $this;
    }

    /**
     * Make dropdown searchable
     *
     * @param bool $searchable
     * @return static
     */
    public function searchable(bool $searchable = true): static
    {
        $this->searchable = $searchable;
        return $this;
    }

    /**
     * Set direction
     *
     * @param string $direction
     * @return static
     */
    public function direction(string $direction): static
    {
        $this->direction = $direction;
        return $this;
    }

    /**
     * Drop down
     *
     * @return static
     */
    public function dropDown(): static
    {
        return $this->direction('down');
    }

    /**
     * Drop up
     *
     * @return static
     */
    public function dropUp(): static
    {
        return $this->direction('up');
    }

    /**
     * Drop start (left)
     *
     * @return static
     */
    public function dropStart(): static
    {
        return $this->direction('start');
    }

    /**
     * Drop end (right)
     *
     * @return static
     */
    public function dropEnd(): static
    {
        return $this->direction('end');
    }

    /**
     * Set alignment
     *
     * @param string $alignment
     * @return static
     */
    public function alignment(string $alignment): static
    {
        $this->alignment = $alignment;
        return $this;
    }

    /**
     * Align end
     *
     * @return static
     */
    public function alignEnd(): static
    {
        return $this->alignment('end');
    }

    /**
     * Set variant
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
     * Primary variant
     *
     * @return static
     */
    public function primary(): static
    {
        return $this->variant('primary');
    }

    /**
     * Secondary variant
     *
     * @return static
     */
    public function secondary(): static
    {
        return $this->variant('secondary');
    }

    /**
     * Enable split button
     *
     * @param bool $split
     * @return static
     */
    public function split(bool $split = true): static
    {
        $this->split = $split;
        return $this;
    }

    /**
     * Set button size
     *
     * @param string $size
     * @return static
     */
    public function size(string $size): static
    {
        $this->buttonSize = $size;
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

    /**
     * Dark menu
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
     * Set auto close behavior
     *
     * @param bool|string $autoClose
     * @return static
     */
    public function autoClose(bool|string $autoClose): static
    {
        $this->autoClose = $autoClose;
        return $this;
    }

    /**
     * Build CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('dropdown'));

        if ($this->searchable) {
            $this->addClass(CssPrefix::cls('dropdown-searchable'));
        }

        if ($this->direction !== 'down') {
            $this->addClass(CssPrefix::cls('drop' . $this->direction));
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
        $attrs[CssPrefix::data('dropdown')] = '';

        $config = [];
        if ($this->autoClose !== true) {
            $config['autoClose'] = $this->autoClose;
        }
        if ($this->alignment !== 'start') {
            $config['alignment'] = $this->alignment;
        }

        if (!empty($config)) {
            $attrs[CssPrefix::data('ui-config')] = htmlspecialchars(json_encode($config), ENT_QUOTES);
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
        $html = '';

        // Trigger button
        $triggerClass = CssPrefix::cls('dropdown-trigger');

        if ($this->buttonSize !== null) {
            $triggerClass .= ' ' . CssPrefix::cls('btn-' . $this->buttonSize);
        }

        // Icon-only button
        if ($this->trigger === null && $this->triggerIcon !== null) {
            $triggerClass .= ' ' . CssPrefix::cls('btn') . ' ' . CssPrefix::cls('btn-' . $this->variant) . ' ' . CssPrefix::cls('btn-icon');
            $html .= '<button type="button" class="' . $triggerClass . '">';
            $html .= '<span class="material-icons">' . e($this->triggerIcon) . '</span>';
            $html .= '</button>';
        } else {
            $triggerClass .= ' ' . CssPrefix::cls('btn') . ' ' . CssPrefix::cls('btn-' . $this->variant);
            $html .= '<button type="button" class="' . $triggerClass . '">';

            if ($this->triggerIcon !== null) {
                $html .= '<span class="material-icons ' . CssPrefix::cls('me-1') . '">' . e($this->triggerIcon) . '</span>';
            }

            $html .= '<span class="' . CssPrefix::cls('dropdown-selected') . '">' . e($this->trigger ?? 'Select') . '</span>';
            $html .= '<span class="material-icons ' . CssPrefix::cls('dropdown-arrow') . '">expand_more</span>';
            $html .= '</button>';
        }

        // Menu
        $menuClass = CssPrefix::cls('dropdown-menu');

        if ($this->dark) {
            $menuClass .= ' ' . CssPrefix::cls('dropdown-menu-dark');
        }

        if ($this->alignment === 'end') {
            $menuClass .= ' ' . CssPrefix::cls('dropdown-menu-end');
        }

        $html .= '<div class="' . $menuClass . '">';

        // Search input for searchable dropdown
        if ($this->searchable) {
            $html .= '<div class="' . CssPrefix::cls('dropdown-search') . '">';
            $html .= '<input type="text" class="' . CssPrefix::cls('dropdown-search-input') . '" placeholder="Search...">';
            $html .= '</div>';
            $html .= '<div class="' . CssPrefix::cls('dropdown-items') . '">';
        }

        foreach ($this->items as $item) {
            $type = $item['type'] ?? 'item';

            if ($type === 'divider') {
                $html .= '<div class="' . CssPrefix::cls('dropdown-divider') . '"></div>';
            } elseif ($type === 'header') {
                $html .= '<div class="' . CssPrefix::cls('dropdown-header') . '">' . e($item['label']) . '</div>';
            } else {
                $itemClass = CssPrefix::cls('dropdown-item');
                if (!empty($item['active'])) {
                    $itemClass .= ' ' . CssPrefix::cls('active');
                }
                if (!empty($item['disabled'])) {
                    $itemClass .= ' ' . CssPrefix::cls('dropdown-item-disabled');
                }
                if (!empty($item['danger'])) {
                    $itemClass .= ' ' . CssPrefix::cls('dropdown-item-danger');
                }

                $dataValue = $item['value'] ?? $item['label'] ?? '';
                $html .= '<div class="' . $itemClass . '" data-value="' . e($dataValue) . '">';

                if (!empty($item['icon'])) {
                    $html .= '<span class="material-icons">' . e($item['icon']) . '</span>';
                }

                if (!empty($item['icon'])) {
                    $html .= '<span>' . e($item['label']) . '</span>';
                } else {
                    $html .= e($item['label']);
                }

                $html .= '</div>';
            }
        }

        if ($this->searchable) {
            $html .= '</div>'; // Close dropdown-items
        }

        $html .= '</div>';

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

        if ($this->trigger !== null) {
            $config['trigger'] = $this->trigger;
        }

        if ($this->triggerIcon !== null) {
            $config['triggerIcon'] = $this->triggerIcon;
        }

        if (!empty($this->items)) {
            $config['items'] = $this->items;
        }

        if ($this->direction !== 'down') {
            $config['direction'] = $this->direction;
        }

        if ($this->alignment !== 'start') {
            $config['alignment'] = $this->alignment;
        }

        if ($this->variant !== 'secondary') {
            $config['variant'] = $this->variant;
        }

        if ($this->split) {
            $config['split'] = true;
        }

        if ($this->buttonSize !== null) {
            $config['size'] = $this->buttonSize;
        }

        if ($this->dark) {
            $config['dark'] = true;
        }

        if ($this->autoClose !== true) {
            $config['autoClose'] = $this->autoClose;
        }

        if ($this->searchable) {
            $config['searchable'] = true;
        }

        return $config;
    }
}
