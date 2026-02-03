<?php

namespace Core\UiEngine\Elements\Form;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Traits\HasEvents;
use Core\UiEngine\Support\CssPrefix;

/**
 * Button - Button form element
 *
 * Supports various button types, variants, sizes, and icons.
 */
class Button extends Element
{
    use HasEvents;

    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'button';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'button';

    /**
     * Button type attribute (button, submit, reset)
     *
     * @var string
     */
    protected string $buttonType = 'button';

    /**
     * Button text
     *
     * @var string|null
     */
    protected ?string $text = null;

    /**
     * Button variant (primary, secondary, success, danger, warning, info, light, dark)
     *
     * @var string
     */
    protected string $variant = 'primary';

    /**
     * Outline style
     *
     * @var bool
     */
    protected bool $outline = false;

    /**
     * Button size (sm, md, lg)
     *
     * @var string
     */
    protected string $size = 'md';

    /**
     * Full width button
     *
     * @var bool
     */
    protected bool $block = false;

    /**
     * Disabled state
     *
     * @var bool
     */
    protected bool $disabled = false;

    /**
     * Loading state
     *
     * @var bool
     */
    protected bool $loading = false;

    /**
     * Loading text
     *
     * @var string|null
     */
    protected ?string $loadingText = null;

    /**
     * Icon (left)
     *
     * @var string|null
     */
    protected ?string $icon = null;

    /**
     * Icon position (left, right)
     *
     * @var string
     */
    protected string $iconPosition = 'left';

    /**
     * Icon-only button (no text)
     *
     * @var bool
     */
    protected bool $iconOnly = false;

    /**
     * Link href (renders as anchor)
     *
     * @var string|null
     */
    protected ?string $href = null;

    /**
     * Link target
     *
     * @var string|null
     */
    protected ?string $target = null;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['buttonType'])) {
            $this->buttonType = $config['buttonType'];
        }

        if (isset($config['text'])) {
            $this->text = $config['text'];
        }

        if (isset($config['variant'])) {
            $this->variant = $config['variant'];
        }

        if (isset($config['outline'])) {
            $this->outline = (bool) $config['outline'];
        }

        if (isset($config['size'])) {
            $this->size = $config['size'];
        }

        if (isset($config['block'])) {
            $this->block = (bool) $config['block'];
        }

        if (isset($config['disabled'])) {
            $this->disabled = (bool) $config['disabled'];
        }

        if (isset($config['loading'])) {
            $this->loading = (bool) $config['loading'];
        }

        if (isset($config['loadingText'])) {
            $this->loadingText = $config['loadingText'];
        }

        if (isset($config['icon'])) {
            $this->icon = $config['icon'];
        }

        if (isset($config['iconPosition'])) {
            $this->iconPosition = $config['iconPosition'];
        }

        if (isset($config['iconOnly'])) {
            $this->iconOnly = (bool) $config['iconOnly'];
        }

        if (isset($config['href'])) {
            $this->href = $config['href'];
            $this->tagName = 'a';
        }

        if (isset($config['target'])) {
            $this->target = $config['target'];
        }

        // Event handlers
        if (isset($config['events']) && is_array($config['events'])) {
            $this->onMany($config['events']);
        }
    }

    /**
     * Set button type
     *
     * @param string $type button|submit|reset
     * @return static
     */
    public function buttonType(string $type): static
    {
        $this->buttonType = $type;
        return $this;
    }

    /**
     * Set as submit button
     *
     * @return static
     */
    public function submit(): static
    {
        return $this->buttonType('submit');
    }

    /**
     * Set as reset button
     *
     * @return static
     */
    public function reset(): static
    {
        return $this->buttonType('reset');
    }

    /**
     * Set button text
     *
     * @param string $text
     * @return static
     */
    public function text(string $text): static
    {
        $this->text = $text;
        return $this;
    }

    /**
     * Set button variant
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
     * Success variant
     *
     * @return static
     */
    public function success(): static
    {
        return $this->variant('success');
    }

    /**
     * Danger variant
     *
     * @return static
     */
    public function danger(): static
    {
        return $this->variant('danger');
    }

    /**
     * Warning variant
     *
     * @return static
     */
    public function warning(): static
    {
        return $this->variant('warning');
    }

    /**
     * Info variant
     *
     * @return static
     */
    public function info(): static
    {
        return $this->variant('info');
    }

    /**
     * Light variant
     *
     * @return static
     */
    public function light(): static
    {
        return $this->variant('light');
    }

    /**
     * Dark variant
     *
     * @return static
     */
    public function dark(): static
    {
        return $this->variant('dark');
    }

    /**
     * Link variant
     *
     * @return static
     */
    public function link(): static
    {
        return $this->variant('link');
    }

    /**
     * Enable outline style
     *
     * @param bool $outline
     * @return static
     */
    public function outline(bool $outline = true): static
    {
        $this->outline = $outline;
        return $this;
    }

    /**
     * Set button size
     *
     * @param string $size sm|md|lg
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

    /**
     * Full width button
     *
     * @param bool $block
     * @return static
     */
    public function block(bool $block = true): static
    {
        $this->block = $block;
        return $this;
    }

    /**
     * Set disabled state
     *
     * @param bool $disabled
     * @return static
     */
    public function disabled(bool $disabled = true): static
    {
        $this->disabled = $disabled;
        return $this;
    }

    /**
     * Set loading state
     *
     * @param bool $loading
     * @param string|null $loadingText
     * @return static
     */
    public function loading(bool $loading = true, ?string $loadingText = null): static
    {
        $this->loading = $loading;
        $this->loadingText = $loadingText;
        return $this;
    }

    /**
     * Set icon
     *
     * @param string $icon Material Icons name
     * @param string $position left|right
     * @return static
     */
    public function icon(string $icon, string $position = 'left'): static
    {
        $this->icon = $icon;
        $this->iconPosition = $position;
        return $this;
    }

    /**
     * Set as icon-only button
     *
     * @param string $icon
     * @return static
     */
    public function iconOnly(string $icon): static
    {
        $this->icon = $icon;
        $this->iconOnly = true;
        return $this;
    }

    /**
     * Set as link button
     *
     * @param string $href
     * @param string|null $target
     * @return static
     */
    public function href(string $href, ?string $target = null): static
    {
        $this->href = $href;
        $this->target = $target;
        $this->tagName = 'a';
        return $this;
    }

    /**
     * Open link in new tab
     *
     * @return static
     */
    public function newTab(): static
    {
        $this->target = '_blank';
        return $this;
    }

    /**
     * Build the CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('btn'));

        // Variant class
        $variantClass = $this->outline ? CssPrefix::cls('btn-outline', $this->variant) : CssPrefix::cls('btn', $this->variant);
        $this->addClass($variantClass);

        // Size class
        if ($this->size !== 'md') {
            $this->addClass(CssPrefix::cls('btn', $this->size));
        }

        // Block class
        if ($this->block) {
            $this->addClass(CssPrefix::cls('w-100'));
        }

        // Loading state
        if ($this->loading) {
            $this->addClass(CssPrefix::cls('btn-loading'));
        }

        // Icon-only
        if ($this->iconOnly) {
            $this->addClass(CssPrefix::cls('btn-icon'));
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

        if ($this->tagName === 'button') {
            $attrs['type'] = $this->buttonType;
        }

        if ($this->tagName === 'a') {
            $attrs['href'] = $this->href ?? '#';
            $attrs['role'] = 'button';

            if ($this->target !== null) {
                $attrs['target'] = $this->target;
                if ($this->target === '_blank') {
                    $attrs['rel'] = 'noopener noreferrer';
                }
            }
        }

        if ($this->disabled) {
            if ($this->tagName === 'button') {
                $attrs['disabled'] = true;
            } else {
                $attrs['aria-disabled'] = 'true';
                $attrs['tabindex'] = '-1';
            }
        }

        if ($this->loading) {
            $attrs[CssPrefix::data('loading')] = 'true';
            if ($this->loadingText !== null) {
                $attrs[CssPrefix::data('loading-text')] = $this->loadingText;
            }
        }

        // Event attributes
        $attrs = array_merge($attrs, $this->buildEventAttributes());

        return $attrs;
    }

    /**
     * Render the content
     *
     * @return string
     */
    public function renderContent(): string
    {
        $html = '';

        // Loading spinner
        if ($this->loading) {
            $html .= '<span class="' . CssPrefix::cls('spinner') . ' ' . CssPrefix::cls('spinner-border') . ' ' . CssPrefix::cls('spinner-border-sm') . '" role="status" aria-hidden="true"></span> ';
        }

        // Icon (left)
        if ($this->icon !== null && $this->iconPosition === 'left' && !$this->loading) {
            $html .= '<span class="material-icons">' . e($this->icon) . '</span>';
            if (!$this->iconOnly && $this->text !== null) {
                $html .= ' ';
            }
        }

        // Text
        if (!$this->iconOnly && $this->text !== null) {
            if ($this->loading && $this->loadingText !== null) {
                $html .= e($this->loadingText);
            } else {
                $html .= e($this->text);
            }
        }

        // Icon (right)
        if ($this->icon !== null && $this->iconPosition === 'right' && !$this->loading) {
            if (!$this->iconOnly && $this->text !== null) {
                $html .= ' ';
            }
            $html .= '<span class="material-icons">' . e($this->icon) . '</span>';
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

        if ($this->buttonType !== 'button') {
            $config['buttonType'] = $this->buttonType;
        }

        if ($this->text !== null) {
            $config['text'] = $this->text;
        }

        if ($this->variant !== 'primary') {
            $config['variant'] = $this->variant;
        }

        if ($this->outline) {
            $config['outline'] = true;
        }

        if ($this->size !== 'md') {
            $config['size'] = $this->size;
        }

        if ($this->block) {
            $config['block'] = true;
        }

        if ($this->disabled) {
            $config['disabled'] = true;
        }

        if ($this->loading) {
            $config['loading'] = true;
            if ($this->loadingText !== null) {
                $config['loadingText'] = $this->loadingText;
            }
        }

        if ($this->icon !== null) {
            $config['icon'] = $this->icon;
            $config['iconPosition'] = $this->iconPosition;
        }

        if ($this->iconOnly) {
            $config['iconOnly'] = true;
        }

        if ($this->href !== null) {
            $config['href'] = $this->href;
        }

        if ($this->target !== null) {
            $config['target'] = $this->target;
        }

        if (!empty($this->events)) {
            $config['events'] = $this->events;
        }

        return $config;
    }
}
