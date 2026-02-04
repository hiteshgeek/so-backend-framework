<?php

namespace Core\UiEngine\Traits;

/**
 * Trait for rendering UI elements to HTML
 *
 * Provides methods for converting UI elements to HTML strings,
 * arrays, and JSON format.
 */
trait Renderable
{
    /**
     * Render the element to HTML
     *
     * @return string
     */
    public function render(): string
    {
        if ($this->isSelfClosing()) {
            return $this->renderSelfClosingTag();
        }

        return $this->renderOpenTag()
            . $this->renderContent()
            . $this->renderCloseTag();
    }

    /**
     * Convert to string (alias for render)
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Get the HTML tag name for this element
     *
     * Override in subclasses to specify the tag
     *
     * @return string
     */
    public function getTagName(): string
    {
        return $this->tagName ?? 'div';
    }

    /**
     * Check if element is self-closing (void element)
     *
     * @return bool
     */
    public function isSelfClosing(): bool
    {
        $voidElements = [
            'area', 'base', 'br', 'col', 'embed', 'hr', 'img',
            'input', 'link', 'meta', 'param', 'source', 'track', 'wbr'
        ];

        return in_array($this->getTagName(), $voidElements, true);
    }

    /**
     * Render the opening tag with attributes
     *
     * @return string
     */
    public function renderOpenTag(): string
    {
        $tag = $this->getTagName();
        $attrs = $this->renderAttributes();

        if ($attrs !== '') {
            return "<{$tag} {$attrs}>";
        }

        return "<{$tag}>";
    }

    /**
     * Render a self-closing tag
     *
     * @return string
     */
    public function renderSelfClosingTag(): string
    {
        $tag = $this->getTagName();
        $attrs = $this->renderAttributes();

        if ($attrs !== '') {
            return "<{$tag} {$attrs}>";
        }

        return "<{$tag}>";
    }

    /**
     * Render the closing tag
     *
     * @return string
     */
    public function renderCloseTag(): string
    {
        return "</{$this->getTagName()}>";
    }

    /**
     * Render the element content (between tags)
     *
     * Override in subclasses to provide content
     *
     * @return string
     */
    public function renderContent(): string
    {
        return '';
    }

    /**
     * Build all HTML attributes as a string
     *
     * @return string
     */
    public function renderAttributes(): string
    {
        $allAttributes = $this->gatherAllAttributes();
        $parts = [];

        foreach ($allAttributes as $name => $value) {
            if ($value === false || $value === null) {
                continue; // Skip false/null attributes
            }

            if ($value === true) {
                // Boolean attribute
                $parts[] = e($name);
            } else {
                // Regular attribute
                $parts[] = e($name) . '="' . e((string) $value) . '"';
            }
        }

        return implode(' ', $parts);
    }

    /**
     * Gather all attributes from various sources
     *
     * @return array<string, mixed>
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = [];

        // ID
        if (isset($this->id) && $this->id !== null) {
            $attrs['id'] = $this->id;
        }

        // CSS classes
        if (method_exists($this, 'buildClassString')) {
            $classString = $this->buildClassString();
            if ($classString !== '') {
                $attrs['class'] = $classString;
            }
        }

        // Regular HTML attributes
        if (method_exists($this, 'getAttributes')) {
            $attrs = array_merge($attrs, $this->getAttributes());
        }

        // Data attributes
        if (method_exists($this, 'buildDataAttributes')) {
            $attrs = array_merge($attrs, $this->buildDataAttributes());
        }

        // Event attributes
        if (method_exists($this, 'buildEventAttributes')) {
            $attrs = array_merge($attrs, $this->buildEventAttributes());
        }

        return $attrs;
    }

    /**
     * Convert element configuration to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = [
            'type' => $this->getType(),
        ];

        if (isset($this->id) && $this->id !== null) {
            $config['id'] = $this->id;
        }

        if (method_exists($this, 'getClasses') && !empty($this->getClasses())) {
            $config['class'] = $this->getClasses();
        }

        if (method_exists($this, 'getAttributes') && !empty($this->getAttributes())) {
            $config['attributes'] = $this->getAttributes();
        }

        if (method_exists($this, 'getDataAttributes') && !empty($this->getDataAttributes())) {
            $config['data'] = $this->getDataAttributes();
        }

        if (method_exists($this, 'getEvents') && !empty($this->getEvents())) {
            $config['events'] = $this->getEvents();
        }

        // Form element properties
        if (method_exists($this, 'getName') && $this->getName() !== null) {
            $config['name'] = $this->getName();
        }

        if (method_exists($this, 'getLabel') && $this->getLabel() !== null) {
            $config['label'] = $this->getLabel();
        }

        if (method_exists($this, 'getValue') && $this->getValue() !== null) {
            $config['value'] = $this->getValue();
        }

        if (method_exists($this, 'getPlaceholder') && $this->getPlaceholder() !== null) {
            $config['placeholder'] = $this->getPlaceholder();
        }

        if (method_exists($this, 'getRules') && !empty($this->getRules())) {
            $config['rules'] = $this->getRules();
        }

        if (method_exists($this, 'getMessages') && !empty($this->getMessages())) {
            $config['messages'] = $this->getMessages();
        }

        // Container children
        if (method_exists($this, 'getChildren') && !empty($this->getChildren())) {
            $config['children'] = array_map(
                fn($child) => $child->toArray(),
                $this->getChildren()
            );
        }

        return $config;
    }

    /**
     * Convert element configuration to JSON
     *
     * @param int $flags JSON encoding flags
     * @return string
     */
    public function toJson(int $flags = 0): string
    {
        return json_encode($this->toArray(), $flags);
    }

    /**
     * Get the element type identifier
     *
     * Override in subclasses to specify the type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type ?? 'element';
    }

    /**
     * Wrap content in a tag
     *
     * @param string $tag
     * @param string $content
     * @param array $attributes
     * @return string
     */
    protected function wrapInTag(string $tag, string $content, array $attributes = []): string
    {
        $attrString = '';

        if (!empty($attributes)) {
            $parts = [];
            foreach ($attributes as $name => $value) {
                if ($value === true) {
                    $parts[] = e($name);
                } elseif ($value !== false && $value !== null) {
                    $parts[] = e($name) . '="' . e((string) $value) . '"';
                }
            }
            $attrString = ' ' . implode(' ', $parts);
        }

        return "<{$tag}{$attrString}>{$content}</{$tag}>";
    }

    /**
     * Escape HTML content
     *
     * @param string $content
     * @return string
     */
    protected function escapeHtml(string $content): string
    {
        return e($content);
    }
}
