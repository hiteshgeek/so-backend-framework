<?php

namespace Core\UiEngine\Elements\Form;

use Core\UiEngine\Elements\FormElement;

/**
 * Hidden - Hidden input form element
 *
 * Used for storing data that should be submitted but not displayed.
 */
class Hidden extends FormElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'hidden';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'input';

    /**
     * Add base CSS classes
     *
     * @return void
     */
    protected function addBaseClasses(): void
    {
        // Hidden inputs don't need classes
    }

    /**
     * Build the CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        // Return only custom classes, no base form-control
        return implode(' ', array_unique($this->classes));
    }

    /**
     * Gather all attributes
     *
     * @return array<string, mixed>
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = [];

        // ID
        if ($this->id !== null) {
            $attrs['id'] = $this->id;
        }

        // Name
        if ($this->name !== null) {
            $attrs['name'] = $this->name;
        }

        // Value
        if ($this->value !== null) {
            $attrs['value'] = $this->value;
        }

        // Type
        $attrs['type'] = 'hidden';

        // Data attributes
        if (method_exists($this, 'buildDataAttributes')) {
            $attrs = array_merge($attrs, $this->buildDataAttributes());
        }

        return $attrs;
    }

    /**
     * Render the form group (hidden inputs don't have labels/help)
     *
     * @return string
     */
    public function renderGroup(): string
    {
        return $this->render();
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'name' => $this->name,
            'value' => $this->value,
            'id' => $this->id,
        ];
    }
}
