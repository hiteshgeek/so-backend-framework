<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\ContainerElement;
use Core\UiEngine\Support\CssPrefix;

/**
 * Modal - Modal dialog display element
 *
 * Creates Bootstrap-style modal dialogs with header, body, and footer.
 */
class Modal extends ContainerElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'modal';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Modal title
     *
     * @var string|null
     */
    protected ?string $title = null;

    /**
     * Footer content/buttons
     *
     * @var array
     */
    protected array $footerButtons = [];

    /**
     * Modal size (sm, md, lg, xl, fullscreen)
     *
     * @var string
     */
    protected string $size = 'md';

    /**
     * Whether modal is scrollable
     *
     * @var bool
     */
    protected bool $scrollable = false;

    /**
     * Whether modal is centered
     *
     * @var bool
     */
    protected bool $centered = false;

    /**
     * Static backdrop (don't close on outside click)
     *
     * @var bool
     */
    protected bool $staticBackdrop = false;

    /**
     * Show close button
     *
     * @var bool
     */
    protected bool $showClose = true;

    /**
     * Keyboard closable (Escape key)
     *
     * @var bool
     */
    protected bool $keyboard = true;

    /**
     * Focus on first focusable element
     *
     * @var bool
     */
    protected bool $focus = true;

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

        if (isset($config['footerButtons'])) {
            $this->footerButtons = $config['footerButtons'];
        }

        if (isset($config['size'])) {
            $this->size = $config['size'];
        }

        if (isset($config['scrollable'])) {
            $this->scrollable = (bool) $config['scrollable'];
        }

        if (isset($config['centered'])) {
            $this->centered = (bool) $config['centered'];
        }

        if (isset($config['staticBackdrop'])) {
            $this->staticBackdrop = (bool) $config['staticBackdrop'];
        }

        if (isset($config['showClose'])) {
            $this->showClose = (bool) $config['showClose'];
        }

        if (isset($config['keyboard'])) {
            $this->keyboard = (bool) $config['keyboard'];
        }

        if (isset($config['focus'])) {
            $this->focus = (bool) $config['focus'];
        }
    }

    /**
     * Set modal title
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
     * Add footer button
     *
     * @param string $text
     * @param string $variant
     * @param bool $dismiss
     * @param array $attributes
     * @return static
     */
    public function addButton(string $text, string $variant = 'secondary', bool $dismiss = false, array $attributes = []): static
    {
        $this->footerButtons[] = [
            'text' => $text,
            'variant' => $variant,
            'dismiss' => $dismiss,
            'attributes' => $attributes,
        ];

        return $this;
    }

    /**
     * Add close button to footer
     *
     * @param string $text
     * @return static
     */
    public function closeButton(string $text = 'Close'): static
    {
        return $this->addButton($text, 'secondary', true);
    }

    /**
     * Add save/submit button to footer
     *
     * @param string $text
     * @param string $variant
     * @return static
     */
    public function saveButton(string $text = 'Save', string $variant = 'primary'): static
    {
        return $this->addButton($text, $variant, false, ['type' => 'submit']);
    }

    /**
     * Set modal size
     *
     * @param string $size sm|md|lg|xl|fullscreen
     * @return static
     */
    public function size(string $size): static
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Small modal
     *
     * @return static
     */
    public function small(): static
    {
        return $this->size('sm');
    }

    /**
     * Large modal
     *
     * @return static
     */
    public function large(): static
    {
        return $this->size('lg');
    }

    /**
     * Extra large modal
     *
     * @return static
     */
    public function extraLarge(): static
    {
        return $this->size('xl');
    }

    /**
     * Fullscreen modal
     *
     * @return static
     */
    public function fullscreen(): static
    {
        return $this->size('fullscreen');
    }

    /**
     * Make modal scrollable
     *
     * @param bool $scrollable
     * @return static
     */
    public function scrollable(bool $scrollable = true): static
    {
        $this->scrollable = $scrollable;
        return $this;
    }

    /**
     * Center modal vertically
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
     * Use static backdrop
     *
     * @param bool $static
     * @return static
     */
    public function staticBackdrop(bool $static = true): static
    {
        $this->staticBackdrop = $static;
        return $this;
    }

    /**
     * Hide close button
     *
     * @return static
     */
    public function hideClose(): static
    {
        $this->showClose = false;
        return $this;
    }

    /**
     * Disable keyboard close
     *
     * @return static
     */
    public function noKeyboard(): static
    {
        $this->keyboard = false;
        return $this;
    }

    /**
     * Disable focus
     *
     * @return static
     */
    public function noFocus(): static
    {
        $this->focus = false;
        return $this;
    }

    /**
     * Build the CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('modal'));

        // Size classes on outer modal: so-modal-{size}
        if ($this->size !== 'md') {
            if ($this->size === 'fullscreen') {
                $this->addClass(CssPrefix::cls('modal-fullscreen'));
            } else {
                $this->addClass(CssPrefix::cls('modal', $this->size));
            }
        }

        // Scrollable on outer modal
        if ($this->scrollable) {
            $this->addClass(CssPrefix::cls('modal-scrollable'));
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

        $attrs['tabindex'] = '-1';
        $attrs['aria-hidden'] = 'true';
        $attrs['role'] = 'dialog';

        if ($this->title !== null) {
            $labelId = ($this->id ?? 'modal') . '-label';
            $attrs['aria-labelledby'] = $labelId;
        }

        if ($this->staticBackdrop) {
            $attrs[CssPrefix::data('backdrop')] = 'static';
        }

        if (!$this->keyboard) {
            $attrs[CssPrefix::data('keyboard')] = 'false';
        }

        if (!$this->focus) {
            $attrs[CssPrefix::data('focus')] = 'false';
        }

        return $attrs;
    }

    /**
     * Render the content
     *
     * @return string
     */
    public function renderContent(): string
    {
        $dialogClass = CssPrefix::cls('modal-dialog');

        // Centered dialog modifier
        if ($this->centered) {
            $dialogClass .= ' ' . CssPrefix::cls('modal-dialog-centered');
        }

        $html = '<div class="' . $dialogClass . '">';

        // Header
        $html .= $this->renderHeader();

        // Body
        $html .= $this->renderBody();

        // Footer
        if (!empty($this->footerButtons)) {
            $html .= $this->renderFooter();
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Render modal header
     *
     * @return string
     */
    protected function renderHeader(): string
    {
        if ($this->title === null && !$this->showClose) {
            return '';
        }

        $html = '<div class="' . CssPrefix::cls('modal-header') . '">';

        if ($this->title !== null) {
            $labelId = ($this->id ?? 'modal') . '-label';
            $html .= '<h5 class="' . CssPrefix::cls('modal-title') . '" id="' . e($labelId) . '">' . e($this->title) . '</h5>';
        }

        if ($this->showClose) {
            $html .= '<button class="' . CssPrefix::cls('modal-close') . '" data-dismiss="modal">';
            $html .= '<span class="material-icons">close</span>';
            $html .= '</button>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Render modal body
     *
     * @return string
     */
    protected function renderBody(): string
    {
        $html = '<div class="' . CssPrefix::cls('modal-body') . '">';
        $html .= $this->renderChildren();
        $html .= '</div>';

        return $html;
    }

    /**
     * Render modal footer
     *
     * @return string
     */
    protected function renderFooter(): string
    {
        $html = '<div class="' . CssPrefix::cls('modal-footer') . '">';

        foreach ($this->footerButtons as $button) {
            $class = CssPrefix::cls('btn') . ' ' . CssPrefix::cls('btn', $button['variant'] ?? 'secondary');
            $attrs = $button['attributes'] ?? [];

            $attrStr = 'class="' . e($class) . '"';

            if ($button['dismiss'] ?? false) {
                $attrStr .= ' ' . CssPrefix::data('dismiss') . '="modal"';
            }

            foreach ($attrs as $name => $value) {
                $attrStr .= ' ' . e($name) . '="' . e($value) . '"';
            }

            $html .= '<button ' . $attrStr . '>' . e($button['text']) . '</button>';
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

        if ($this->title !== null) {
            $config['title'] = $this->title;
        }

        if (!empty($this->footerButtons)) {
            $config['footerButtons'] = $this->footerButtons;
        }

        if ($this->size !== 'md') {
            $config['size'] = $this->size;
        }

        if ($this->scrollable) {
            $config['scrollable'] = true;
        }

        if ($this->centered) {
            $config['centered'] = true;
        }

        if ($this->staticBackdrop) {
            $config['staticBackdrop'] = true;
        }

        if (!$this->showClose) {
            $config['showClose'] = false;
        }

        if (!$this->keyboard) {
            $config['keyboard'] = false;
        }

        if (!$this->focus) {
            $config['focus'] = false;
        }

        return $config;
    }
}
