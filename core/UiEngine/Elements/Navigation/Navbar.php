<?php

namespace Core\UiEngine\Elements\Navigation;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * Navbar - Top navigation bar
 *
 * Provides responsive navigation bar
 */
class Navbar extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'navbar';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'nav';

    /**
     * Brand text/logo
     *
     * @var string|null
     */
    protected ?string $brand = null;

    /**
     * Brand URL
     *
     * @var string
     */
    protected string $brandUrl = '/';

    /**
     * Brand image
     *
     * @var string|null
     */
    protected ?string $brandImage = null;

    /**
     * Navigation items
     *
     * @var array
     */
    protected array $items = [];

    /**
     * Right-aligned items
     *
     * @var array
     */
    protected array $rightItems = [];

    /**
     * Color scheme
     *
     * @var string
     */
    protected string $colorScheme = 'light';

    /**
     * Background variant
     *
     * @var string|null
     */
    protected ?string $background = null;

    /**
     * Expand breakpoint
     *
     * @var string
     */
    protected string $expand = 'lg';

    /**
     * Fixed position
     *
     * @var string|null
     */
    protected ?string $fixed = null;

    /**
     * Sticky position
     *
     * @var bool
     */
    protected bool $sticky = false;

    /**
     * Container type
     *
     * @var string
     */
    protected string $container = 'container';

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['brand'])) {
            $this->brand = $config['brand'];
        }

        if (isset($config['brandUrl'])) {
            $this->brandUrl = $config['brandUrl'];
        }

        if (isset($config['brandImage'])) {
            $this->brandImage = $config['brandImage'];
        }

        if (isset($config['items'])) {
            $this->items = $config['items'];
        }

        if (isset($config['rightItems'])) {
            $this->rightItems = $config['rightItems'];
        }

        if (isset($config['colorScheme'])) {
            $this->colorScheme = $config['colorScheme'];
        }

        if (isset($config['background'])) {
            $this->background = $config['background'];
        }

        if (isset($config['expand'])) {
            $this->expand = $config['expand'];
        }

        if (isset($config['fixed'])) {
            $this->fixed = $config['fixed'];
        }

        if (isset($config['sticky'])) {
            $this->sticky = (bool) $config['sticky'];
        }

        if (isset($config['container'])) {
            $this->container = $config['container'];
        }
    }

    /**
     * Set brand
     *
     * @param string $brand
     * @param string $url
     * @return static
     */
    public function brand(string $brand, string $url = '/'): static
    {
        $this->brand = $brand;
        $this->brandUrl = $url;
        return $this;
    }

    /**
     * Set brand image
     *
     * @param string $url
     * @return static
     */
    public function brandImage(string $url): static
    {
        $this->brandImage = $url;
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
     * Add nav item (fluent API)
     *
     * @param string $label
     * @param string $url
     * @param array $options Options: active, disabled
     * @return static
     */
    public function item(string $label, string $url = '#', array $options = []): static
    {
        $this->items[] = [
            'type' => 'link',
            'label' => $label,
            'url' => $url,
            'active' => $options['active'] ?? false,
            'disabled' => $options['disabled'] ?? false,
        ];
        return $this;
    }

    /**
     * Add nav item (legacy method)
     *
     * @param string $label
     * @param string $url
     * @param bool $active
     * @param bool $disabled
     * @return static
     */
    public function addItem(string $label, string $url = '#', bool $active = false, bool $disabled = false): static
    {
        return $this->item($label, $url, ['active' => $active, 'disabled' => $disabled]);
    }

    /**
     * Add dropdown (fluent API)
     *
     * @param string $label
     * @param array $items
     * @return static
     */
    public function dropdown(string $label, array $items): static
    {
        $this->items[] = [
            'type' => 'dropdown',
            'label' => $label,
            'items' => $items,
        ];
        return $this;
    }

    /**
     * Add dropdown item (legacy method)
     *
     * @param string $label
     * @param array $items
     * @return static
     */
    public function addDropdown(string $label, array $items): static
    {
        return $this->dropdown($label, $items);
    }

    /**
     * Add action button
     *
     * @param string $label
     * @param string $url
     * @param array $options Options: variant
     * @return static
     */
    public function action(string $label, string $url = '#', array $options = []): static
    {
        $this->rightItems[] = [
            'type' => 'action',
            'label' => $label,
            'url' => $url,
            'variant' => $options['variant'] ?? 'primary',
        ];
        return $this;
    }

    /**
     * Set theme/color scheme (fluent alias)
     *
     * @param string $theme light, dark, primary, secondary, success, danger, warning, info
     * @return static
     */
    public function theme(string $theme): static
    {
        $this->colorScheme = $theme;
        return $this;
    }

    /**
     * Set right items
     *
     * @param array $items
     * @return static
     */
    public function rightItems(array $items): static
    {
        $this->rightItems = $items;
        return $this;
    }

    /**
     * Set color scheme
     *
     * @param string $scheme
     * @return static
     */
    public function colorScheme(string $scheme): static
    {
        $this->colorScheme = $scheme;
        return $this;
    }

    /**
     * Light color scheme
     *
     * @return static
     */
    public function light(): static
    {
        return $this->colorScheme('light');
    }

    /**
     * Dark color scheme
     *
     * @return static
     */
    public function dark(): static
    {
        return $this->colorScheme('dark');
    }

    /**
     * Set background
     *
     * @param string $background
     * @return static
     */
    public function background(string $background): static
    {
        $this->background = $background;
        return $this;
    }

    /**
     * Set expand breakpoint
     *
     * @param string $breakpoint
     * @return static
     */
    public function expand(string $breakpoint): static
    {
        $this->expand = $breakpoint;
        return $this;
    }

    /**
     * Set fixed position
     *
     * @param string $position
     * @return static
     */
    public function fixed(string $position): static
    {
        $this->fixed = $position;
        return $this;
    }

    /**
     * Fixed top
     *
     * @return static
     */
    public function fixedTop(): static
    {
        return $this->fixed('top');
    }

    /**
     * Fixed bottom
     *
     * @return static
     */
    public function fixedBottom(): static
    {
        return $this->fixed('bottom');
    }

    /**
     * Sticky top
     *
     * @param bool $sticky
     * @return static
     */
    public function sticky(bool $sticky = true): static
    {
        $this->sticky = $sticky;
        return $this;
    }

    /**
     * Set container type
     *
     * @param string $container
     * @return static
     */
    public function container(string $container): static
    {
        $this->container = $container;
        return $this;
    }

    /**
     * Fluid container
     *
     * @return static
     */
    public function fluid(): static
    {
        return $this->container('container-fluid');
    }

    /**
     * Build CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('component-navbar'));

        if ($this->expand) {
            $this->addClass(CssPrefix::cls('component-navbar-expand-' . $this->expand));
        }

        // Color scheme - includes light, dark, primary, secondary, success, danger, warning, info
        $this->addClass(CssPrefix::cls('component-navbar-' . $this->colorScheme));

        if ($this->fixed !== null) {
            $this->addClass(CssPrefix::cls('component-navbar-fixed-' . $this->fixed));
        }

        if ($this->sticky) {
            $this->addClass(CssPrefix::cls('component-navbar-sticky-top'));
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
        $html = '<div class="' . CssPrefix::cls('component-navbar-container') . '">';

        // Brand
        $html .= '<a class="' . CssPrefix::cls('component-navbar-brand') . '" href="' . e($this->brandUrl) . '">';
        if ($this->brandImage !== null) {
            $html .= '<img src="' . e($this->brandImage) . '" alt="' . e($this->brand ?? '') . '" height="30">';
        }
        if ($this->brand !== null) {
            $html .= e($this->brand);
        }
        $html .= '</a>';

        // Toggler
        $html .= '<button class="' . CssPrefix::cls('component-navbar-toggler') . '" type="button"';
        $html .= ' aria-expanded="false" aria-label="Toggle navigation">';
        $html .= '<span class="' . CssPrefix::cls('component-navbar-toggler-icon') . '"></span>';
        $html .= '</button>';

        // Collapsible content
        $html .= '<div class="' . CssPrefix::cls('component-navbar-collapse') . '">';

        // Main nav items
        $html .= '<ul class="' . CssPrefix::cls('component-navbar-nav') . ' ' . CssPrefix::cls('component-navbar-nav-start') . '">';
        $html .= $this->renderNavItems($this->items);
        $html .= '</ul>';

        // Right nav items / actions
        if (!empty($this->rightItems)) {
            $html .= '<div class="' . CssPrefix::cls('component-navbar-actions') . '">';
            $html .= $this->renderNavItems($this->rightItems);
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Render nav items
     *
     * @param array $items
     * @return string
     */
    protected function renderNavItems(array $items): string
    {
        $html = '';

        foreach ($items as $item) {
            $type = $item['type'] ?? 'link';

            if ($type === 'dropdown') {
                $html .= '<li class="' . CssPrefix::cls('component-navbar-item') . ' ' . CssPrefix::cls('dropdown') . '" ' . CssPrefix::data('dropdown') . '>';
                $html .= '<a class="' . CssPrefix::cls('component-navbar-link') . ' ' . CssPrefix::cls('dropdown-toggle') . '" href="#">';
                $html .= e($item['label']);
                $html .= ' <span class="material-icons ' . CssPrefix::cls('dropdown-arrow') . '">expand_more</span>';
                $html .= '</a>';

                $html .= '<div class="' . CssPrefix::cls('dropdown-menu') . '">';
                foreach ($item['items'] as $subItem) {
                    if (!empty($subItem['divider'])) {
                        $html .= '<div class="' . CssPrefix::cls('dropdown-divider') . '"></div>';
                    } else {
                        $html .= '<a class="' . CssPrefix::cls('dropdown-item') . '" href="' . e($subItem['url'] ?? '#') . '">';
                        $html .= e($subItem['label']);
                        $html .= '</a>';
                    }
                }
                $html .= '</div>';

                $html .= '</li>';
            } elseif ($type === 'action') {
                // Action button
                $variant = $item['variant'] ?? 'primary';
                $btnClass = CssPrefix::cls('btn') . ' ' . CssPrefix::cls('btn-' . $variant) . ' ' . CssPrefix::cls('btn-sm');
                $html .= '<a href="' . e($item['url'] ?? '#') . '" class="' . $btnClass . '">';
                $html .= e($item['label']);
                $html .= '</a>';
            } else {
                $itemClass = CssPrefix::cls('component-navbar-item');
                $linkClass = CssPrefix::cls('component-navbar-link');

                if (!empty($item['active'])) {
                    $linkClass .= ' ' . CssPrefix::cls('active');
                }

                if (!empty($item['disabled'])) {
                    $linkClass .= ' ' . CssPrefix::cls('disabled');
                }

                $html .= '<li class="' . $itemClass . '">';
                $html .= '<a class="' . $linkClass . '" href="' . e($item['url'] ?? '#') . '"';

                if (!empty($item['active'])) {
                    $html .= ' aria-current="page"';
                }

                $html .= '>' . e($item['label']) . '</a>';
                $html .= '</li>';
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

        if ($this->brand !== null) {
            $config['brand'] = $this->brand;
        }

        if ($this->brandUrl !== '/') {
            $config['brandUrl'] = $this->brandUrl;
        }

        if ($this->brandImage !== null) {
            $config['brandImage'] = $this->brandImage;
        }

        if (!empty($this->items)) {
            $config['items'] = $this->items;
        }

        if (!empty($this->rightItems)) {
            $config['rightItems'] = $this->rightItems;
        }

        if ($this->colorScheme !== 'light') {
            $config['colorScheme'] = $this->colorScheme;
        }

        if ($this->background !== null) {
            $config['background'] = $this->background;
        }

        if ($this->expand !== 'lg') {
            $config['expand'] = $this->expand;
        }

        if ($this->fixed !== null) {
            $config['fixed'] = $this->fixed;
        }

        if ($this->sticky) {
            $config['sticky'] = true;
        }

        if ($this->container !== 'container') {
            $config['container'] = $this->container;
        }

        return $config;
    }
}
