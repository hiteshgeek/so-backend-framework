// ============================================
// SIXORBIT UI ENGINE - HAS DRAG DROP MIXIN
// Adds drag-drop functionality to any element
// ============================================

import SixOrbit from '../../core/so-config.js';

/**
 * HasDragDrop Mixin
 * Adds drag-drop functionality to any UiEngine element
 *
 * This mixin works with both fluent API and config-based initialization.
 *
 * Usage with class extension:
 *   class MyElement extends HasDragDrop(ContainerElement) {
 *       _initFromConfig(config) {
 *           super._initFromConfig(config);
 *           this._initDragDrop(config);
 *       }
 *   }
 *
 * Usage with method mixing:
 *   class MyElement extends Element { }
 *   Object.assign(MyElement.prototype, HasDragDropMethods);
 *
 * Config API:
 *   new Card({
 *       draggable: true,
 *       dragHandle: '.so-card-header',
 *       dragGroup: 'cards',
 *       liveReorder: true,
 *       dragStorage: 'localStorage',
 *       dragStorageKey: 'my-order'
 *   });
 *
 * Fluent API:
 *   new Card({}).draggable().dragHandle('.so-card-header').liveReorder();
 */

/**
 * Mixin function - extends a base class with drag-drop capabilities
 * @param {Class} Base - The base class to extend
 * @returns {Class} - Extended class with drag-drop methods
 */
const HasDragDrop = (Base) => class extends Base {
    /**
     * Initialize drag-drop properties from config
     * Call this in _initFromConfig or constructor
     *
     * Automatically reads these config keys:
     * - draggable: boolean
     * - dragHandle: string (selector)
     * - dragGroup: string
     * - dragItems: string (selector)
     * - liveReorder: boolean
     * - dragStorage: 'localStorage' | 'sessionStorage'
     * - dragStorageKey: string
     * - dragOptions: object (additional SODragDrop options)
     *
     * @param {Object} config - Configuration object
     */
    _initDragDrop(config = {}) {
        this._draggable = config.draggable || false;
        this._dragHandle = config.dragHandle || null;
        this._dragGroup = config.dragGroup || null;
        this._dragItems = config.dragItems || null;
        this._liveReorder = config.liveReorder || false;
        this._dragStorage = config.dragStorage || null;
        this._dragStorageKey = config.dragStorageKey || null;
        this._dragOptions = config.dragOptions || {};
        this._dragdropInstance = null;
    }

    /**
     * Enable drag-drop functionality
     * @param {Object} options - Additional SODragDrop options
     * @returns {this}
     */
    draggable(options = {}) {
        this._draggable = true;
        this._dragOptions = { ...this._dragOptions, ...options };
        return this;
    }

    /**
     * Set drag handle selector
     * @param {string} selector - CSS selector for drag handle
     * @returns {this}
     */
    dragHandle(selector) {
        this._dragHandle = selector;
        return this;
    }

    /**
     * Set drag group for cross-container dragging
     * @param {string} group - Group name
     * @returns {this}
     */
    dragGroup(group) {
        this._dragGroup = group;
        return this;
    }

    /**
     * Set draggable items selector
     * @param {string} selector - CSS selector for items
     * @returns {this}
     */
    dragItems(selector) {
        this._dragItems = selector;
        return this;
    }

    /**
     * Enable live reordering during drag
     * @param {boolean} enabled
     * @returns {this}
     */
    liveReorder(enabled = true) {
        this._liveReorder = enabled;
        return this;
    }

    /**
     * Set storage for drag order persistence
     * @param {string} type - 'localStorage' or 'sessionStorage'
     * @param {string} key - Storage key
     * @returns {this}
     */
    dragStorage(type, key) {
        this._dragStorage = type;
        this._dragStorageKey = key;
        return this;
    }

    /**
     * Disable dragging
     * @param {boolean} disabled
     * @returns {this}
     */
    dragDisabled(disabled = true) {
        this._dragOptions.disabled = disabled;
        return this;
    }

    /**
     * Check if element is draggable
     * @returns {boolean}
     */
    isDraggable() {
        return this._draggable;
    }

    /**
     * Initialize SODragDrop on the parent container
     * Call this after element is rendered and in DOM
     * @returns {this}
     */
    enableDragDrop() {
        if (!this._draggable || !this.element) {
            return this;
        }

        // Check if SODragDrop is available
        if (!window.SODragDrop) {
            console.warn('SODragDrop component not loaded. Include so-dragdrop.js bundle.');
            return this;
        }

        const container = this.element.parentElement;
        if (!container) {
            console.warn('Element must be in DOM to enable drag-drop');
            return this;
        }

        // Build config from properties
        const config = {
            items: this._dragItems || `.${SixOrbit.cls(this._type || 'card')}`,
            handle: this._dragHandle,
            group: this._dragGroup,
            liveReorder: this._liveReorder,
            storage: this._dragStorage,
            storageKey: this._dragStorageKey,
            ...this._dragOptions
        };

        // Remove null/undefined values
        Object.keys(config).forEach(key => {
            if (config[key] === null || config[key] === undefined) {
                delete config[key];
            }
        });

        // Initialize SODragDrop on container
        this._dragdropInstance = window.SODragDrop.getInstance(container, config);

        // Forward events
        this._dragdropInstance.on('dragdrop:start', (e) => {
            this.emit('so:dragdrop:start', e.detail);
        });

        this._dragdropInstance.on('dragdrop:move', (e) => {
            this.emit('so:dragdrop:move', e.detail);
        });

        this._dragdropInstance.on('dragdrop:reorder', (e) => {
            this.emit('so:dragdrop:reorder', e.detail);
        });

        this._dragdropInstance.on('dragdrop:end', (e) => {
            this.emit('so:dragdrop:end', e.detail);
        });

        return this;
    }

    /**
     * Disable and destroy drag-drop instance
     * @returns {this}
     */
    disableDragDrop() {
        if (this._dragdropInstance) {
            this._dragdropInstance.destroy();
            this._dragdropInstance = null;
        }
        this._draggable = false;
        return this;
    }

    /**
     * Get current order of items
     * @returns {Array|null}
     */
    getDragOrder() {
        return this._dragdropInstance ? this._dragdropInstance.getOrder() : null;
    }

    /**
     * Set order of items
     * @param {Array} order - Array of IDs or indices
     * @returns {this}
     */
    setDragOrder(order) {
        if (this._dragdropInstance) {
            this._dragdropInstance.setOrder(order);
        }
        return this;
    }

    /**
     * Refresh drag-drop (recalculate items)
     * @returns {this}
     */
    refreshDragDrop() {
        if (this._dragdropInstance) {
            this._dragdropInstance.refresh();
        }
        return this;
    }

    /**
     * Build drag data attributes for HTML rendering
     * @returns {Object}
     */
    _buildDragAttributes() {
        if (!this._draggable) {
            return {};
        }

        const attrs = {
            'draggable': 'true',
            'data-so-draggable': 'true'
        };

        if (this._dragHandle) attrs['data-so-handle'] = this._dragHandle;
        if (this._dragGroup) attrs['data-so-group'] = this._dragGroup;
        if (this._dragItems) attrs['data-so-items'] = this._dragItems;
        if (this._liveReorder) attrs['data-so-live-reorder'] = 'true';
        if (this._dragStorage) attrs['data-so-storage'] = this._dragStorage;
        if (this._dragStorageKey) attrs['data-so-storage-key'] = this._dragStorageKey;

        if (Object.keys(this._dragOptions).length > 0) {
            attrs['data-so-drag-config'] = JSON.stringify(this._dragOptions);
        }

        return attrs;
    }
};

/**
 * Alternative: Standalone methods object for manual mixing
 * Usage: Object.assign(MyClass.prototype, HasDragDropMethods);
 */
export const HasDragDropMethods = {
    _initDragDrop(config = {}) {
        this._draggable = config.draggable || false;
        this._dragHandle = config.dragHandle || null;
        this._dragGroup = config.dragGroup || null;
        this._dragItems = config.dragItems || null;
        this._liveReorder = config.liveReorder || false;
        this._dragStorage = config.dragStorage || null;
        this._dragStorageKey = config.dragStorageKey || null;
        this._dragOptions = config.dragOptions || {};
        this._dragdropInstance = null;
    },

    draggable(options = {}) {
        this._draggable = true;
        this._dragOptions = { ...this._dragOptions, ...options };
        return this;
    },

    dragHandle(selector) {
        this._dragHandle = selector;
        return this;
    },

    dragGroup(group) {
        this._dragGroup = group;
        return this;
    },

    dragItems(selector) {
        this._dragItems = selector;
        return this;
    },

    liveReorder(enabled = true) {
        this._liveReorder = enabled;
        return this;
    },

    dragStorage(type, key) {
        this._dragStorage = type;
        this._dragStorageKey = key;
        return this;
    },

    dragDisabled(disabled = true) {
        this._dragOptions.disabled = disabled;
        return this;
    },

    isDraggable() {
        return this._draggable;
    },

    enableDragDrop() {
        if (!this._draggable || !this.element) {
            return this;
        }

        if (!window.SODragDrop) {
            console.warn('SODragDrop component not loaded.');
            return this;
        }

        const container = this.element.parentElement;
        if (!container) return this;

        const config = {
            items: this._dragItems || `.${SixOrbit.cls(this._type || 'card')}`,
            handle: this._dragHandle,
            group: this._dragGroup,
            liveReorder: this._liveReorder,
            storage: this._dragStorage,
            storageKey: this._dragStorageKey,
            ...this._dragOptions
        };

        Object.keys(config).forEach(key => {
            if (config[key] === null || config[key] === undefined) {
                delete config[key];
            }
        });

        this._dragdropInstance = window.SODragDrop.getInstance(container, config);

        ['start', 'move', 'reorder', 'end'].forEach(event => {
            this._dragdropInstance.on(`dragdrop:${event}`, (e) => {
                this.emit(`so:dragdrop:${event}`, e.detail);
            });
        });

        return this;
    },

    disableDragDrop() {
        if (this._dragdropInstance) {
            this._dragdropInstance.destroy();
            this._dragdropInstance = null;
        }
        this._draggable = false;
        return this;
    },

    getDragOrder() {
        return this._dragdropInstance ? this._dragdropInstance.getOrder() : null;
    },

    setDragOrder(order) {
        if (this._dragdropInstance) {
            this._dragdropInstance.setOrder(order);
        }
        return this;
    },

    refreshDragDrop() {
        if (this._dragdropInstance) {
            this._dragdropInstance.refresh();
        }
        return this;
    },

    _buildDragAttributes() {
        if (!this._draggable) return {};

        const attrs = {
            'draggable': 'true',
            'data-so-draggable': 'true'
        };

        if (this._dragHandle) attrs['data-so-handle'] = this._dragHandle;
        if (this._dragGroup) attrs['data-so-group'] = this._dragGroup;
        if (this._dragItems) attrs['data-so-items'] = this._dragItems;
        if (this._liveReorder) attrs['data-so-live-reorder'] = 'true';
        if (this._dragStorage) attrs['data-so-storage'] = this._dragStorage;
        if (this._dragStorageKey) attrs['data-so-storage-key'] = this._dragStorageKey;

        if (Object.keys(this._dragOptions).length > 0) {
            attrs['data-so-drag-config'] = JSON.stringify(this._dragOptions);
        }

        return attrs;
    }
};

export default HasDragDrop;
