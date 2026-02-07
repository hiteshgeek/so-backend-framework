<?php

namespace Core\UiEngine\Traits;

use Core\UiEngine\Support\CssPrefix;

/**
 * HasDragDrop - Add drag-drop functionality to any UiEngine element
 *
 * This trait can be used by any UiEngine element class to add drag-drop capabilities.
 * It works with both fluent API and config-based initialization.
 *
 * Usage:
 *   class MyElement extends Element {
 *       use HasDragDrop;
 *
 *       protected function initializeFromConfig(array $config): void {
 *           parent::initializeFromConfig($config);
 *           $this->initDragDropFromConfig($config);
 *       }
 *
 *       protected function gatherAllAttributes(): array {
 *           $attrs = parent::gatherAllAttributes();
 *           return array_merge($attrs, $this->getDragAttributes());
 *       }
 *   }
 *
 *   // Fluent API:
 *   MyElement::make()->draggable()->dragHandle('.handle');
 *
 *   // Config API:
 *   MyElement::make(['draggable' => true, 'dragHandle' => '.handle']);
 */
trait HasDragDrop
{
    /**
     * Whether drag-drop is enabled
     */
    protected bool $_draggable = false;

    /**
     * Drag handle selector (element used to initiate drag)
     */
    protected ?string $_dragHandle = null;

    /**
     * Drag group for cross-container dragging
     */
    protected ?string $_dragGroup = null;

    /**
     * Draggable items selector
     */
    protected ?string $_dragItems = null;

    /**
     * Enable live reordering during drag
     */
    protected bool $_liveReorder = false;

    /**
     * Storage type ('localStorage' or 'sessionStorage')
     */
    protected ?string $_dragStorage = null;

    /**
     * Storage key for persistence
     */
    protected ?string $_dragStorageKey = null;

    /**
     * Additional drag-drop options
     */
    protected array $_dragOptions = [];

    /**
     * Initialize drag-drop properties from config array
     * Call this in initializeFromConfig()
     *
     * Supported config keys:
     * - draggable: bool
     * - dragHandle: string (selector)
     * - dragGroup: string
     * - dragItems: string (selector)
     * - liveReorder: bool
     * - dragStorage: 'localStorage' | 'sessionStorage'
     * - dragStorageKey: string
     * - dragOptions: array (additional SODragDrop options)
     */
    protected function initDragDropFromConfig(array $config): void
    {
        if (isset($config['draggable']) && $config['draggable']) {
            $this->_draggable = true;
        }
        if (isset($config['dragHandle'])) {
            $this->_dragHandle = $config['dragHandle'];
        }
        if (isset($config['dragGroup'])) {
            $this->_dragGroup = $config['dragGroup'];
        }
        if (isset($config['dragItems'])) {
            $this->_dragItems = $config['dragItems'];
        }
        if (isset($config['liveReorder'])) {
            $this->_liveReorder = (bool) $config['liveReorder'];
        }
        if (isset($config['dragStorage'])) {
            $this->_dragStorage = $config['dragStorage'];
        }
        if (isset($config['dragStorageKey'])) {
            $this->_dragStorageKey = $config['dragStorageKey'];
        }
        if (isset($config['dragOptions']) && is_array($config['dragOptions'])) {
            $this->_dragOptions = $config['dragOptions'];
        }
    }

    /**
     * Enable drag-drop functionality
     *
     * @param array $options - Additional SODragDrop options
     * @return static
     */
    public function draggable(array $options = []): static
    {
        $this->_draggable = true;
        $this->_dragOptions = array_merge($this->_dragOptions, $options);
        return $this;
    }

    /**
     * Set drag handle selector (element used to initiate drag)
     *
     * @param string $selector - CSS selector for drag handle
     * @return static
     */
    public function dragHandle(string $selector): static
    {
        $this->_dragHandle = $selector;
        return $this;
    }

    /**
     * Set drag group for cross-container dragging
     *
     * @param string $group - Group name
     * @return static
     */
    public function dragGroup(string $group): static
    {
        $this->_dragGroup = $group;
        return $this;
    }

    /**
     * Set draggable items selector
     *
     * @param string $selector - CSS selector for items
     * @return static
     */
    public function dragItems(string $selector): static
    {
        $this->_dragItems = $selector;
        return $this;
    }

    /**
     * Enable live reordering during drag (vs only on drop)
     *
     * @param bool $enabled
     * @return static
     */
    public function liveReorder(bool $enabled = true): static
    {
        $this->_liveReorder = $enabled;
        return $this;
    }

    /**
     * Set storage for drag order persistence
     *
     * @param string $type - 'localStorage' or 'sessionStorage'
     * @param string $key - Storage key
     * @return static
     */
    public function dragStorage(string $type, string $key): static
    {
        $this->_dragStorage = $type;
        $this->_dragStorageKey = $key;
        return $this;
    }

    /**
     * Disable dragging
     *
     * @param bool $disabled
     * @return static
     */
    public function dragDisabled(bool $disabled = true): static
    {
        $this->_dragOptions['disabled'] = $disabled;
        return $this;
    }

    /**
     * Check if element is draggable
     *
     * @return bool
     */
    public function isDraggable(): bool
    {
        return $this->_draggable;
    }

    /**
     * Get drag-related data attributes for HTML rendering
     * Call this in gatherAllAttributes() or buildAttributes()
     *
     * @return array
     */
    protected function getDragAttributes(): array
    {
        if (!$this->_draggable) {
            return [];
        }

        $attrs = [];

        // Mark as draggable
        $attrs['draggable'] = 'true';
        $attrs['data-so-draggable'] = 'true';

        // Individual options as data attributes
        if ($this->_dragHandle) {
            $attrs['data-so-handle'] = $this->_dragHandle;
        }

        if ($this->_dragGroup) {
            $attrs['data-so-group'] = $this->_dragGroup;
        }

        if ($this->_dragItems) {
            $attrs['data-so-items'] = $this->_dragItems;
        }

        if ($this->_liveReorder) {
            $attrs['data-so-live-reorder'] = 'true';
        }

        if ($this->_dragStorage) {
            $attrs['data-so-storage'] = $this->_dragStorage;
        }

        if ($this->_dragStorageKey) {
            $attrs['data-so-storage-key'] = $this->_dragStorageKey;
        }

        // Additional options as JSON config
        if (!empty($this->_dragOptions)) {
            $attrs['data-so-drag-config'] = json_encode($this->_dragOptions);
        }

        return $attrs;
    }

    /**
     * Build drag class (adds so-draggable class if enabled)
     *
     * @return array
     */
    protected function buildDragClasses(): array
    {
        $classes = [];
        if ($this->_draggable) {
            $classes[] = CssPrefix::cls('draggable');
        }
        return $classes;
    }
}
