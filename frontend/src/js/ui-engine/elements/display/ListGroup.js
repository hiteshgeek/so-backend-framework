// ============================================
// SIXORBIT UI ENGINE - LIST GROUP ELEMENT
// Flexible list component for content display
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * ListGroup - Flexible list component
 *
 * Displays a series of content in a flexible list with optional
 * actions, badges, icons, and various styling options.
 */
class ListGroup extends Element {
    static NAME = 'ui-list-group';

    static DEFAULTS = {
        ...Element.DEFAULTS,
        type: 'list-group',
        tagName: 'ul',
    };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);

        this._items = config.items || [];
        this._flush = config.flush || false;
        this._numbered = config.numbered || false;
        this._horizontal = config.horizontal || false;
        this._size = config.size || null;
    }

    // ==================
    // Content Methods
    // ==================

    /**
     * Set all items at once
     * @param {Array} items
     * @returns {this}
     */
    items(items) {
        this._items = items;
        return this;
    }

    /**
     * Add a single item (alias for addItem)
     * @param {string} content
     * @param {Object} options
     * @returns {this}
     */
    item(content, options = {}) {
        return this.addItem(
            content,
            options.badge || null,
            options.variant || null,
            options.active || false,
            options.disabled || false,
            options.url || options.href || null,
            options.icon || null,
            options.badgeVariant || null
        );
    }

    /**
     * Add item with full parameters
     * @param {string} content
     * @param {string|null} badge
     * @param {string|null} variant
     * @param {boolean} active
     * @param {boolean} disabled
     * @param {string|null} url
     * @param {string|null} icon
     * @param {string|null} badgeVariant
     * @returns {this}
     */
    addItem(
        content,
        badge = null,
        variant = null,
        active = false,
        disabled = false,
        url = null,
        icon = null,
        badgeVariant = null
    ) {
        const item = { content };

        if (badge !== null) item.badge = badge;
        if (variant !== null) item.variant = variant;
        if (active) item.active = true;
        if (disabled) item.disabled = true;
        if (url !== null) item.url = url;
        if (icon !== null) item.icon = icon;
        if (badgeVariant !== null) item.badgeVariant = badgeVariant;

        this._items.push(item);
        return this;
    }

    /**
     * Update item at index
     * @param {number} index
     * @param {Object} updates
     * @returns {this}
     */
    updateItem(index, updates) {
        if (this._items[index]) {
            this._items[index] = { ...this._items[index], ...updates };
            this._triggerEvent('so:item:updated', { index, item: this._items[index] });
        }
        return this;
    }

    /**
     * Remove item at index
     * @param {number} index
     * @returns {this}
     */
    removeItem(index) {
        if (this._items[index]) {
            const removed = this._items.splice(index, 1)[0];
            this._triggerEvent('so:item:removed', { index, item: removed });
        }
        return this;
    }

    /**
     * Clear all items
     * @returns {this}
     */
    clearItems() {
        this._items = [];
        this._triggerEvent('so:items:cleared');
        return this;
    }

    /**
     * Get item at index
     * @param {number} index
     * @returns {Object|null}
     */
    getItem(index) {
        return this._items[index] || null;
    }

    /**
     * Get all items
     * @returns {Array}
     */
    getItems() {
        return [...this._items];
    }

    /**
     * Get item count
     * @returns {number}
     */
    getItemCount() {
        return this._items.length;
    }

    // ==================
    // Styling Methods
    // ==================

    /**
     * Set flush style (no borders/rounded corners)
     * @param {boolean} flush
     * @returns {this}
     */
    flush(flush = true) {
        this._flush = flush;
        return this;
    }

    /**
     * Set numbered list
     * @param {boolean} numbered
     * @returns {this}
     */
    numbered(numbered = true) {
        this._numbered = numbered;
        if (numbered) {
            this._tagName = 'ol';
        }
        return this;
    }

    /**
     * Set horizontal layout
     * @param {boolean|string} horizontal - true, 'sm', 'md', 'lg', 'xl'
     * @returns {this}
     */
    horizontal(horizontal = true) {
        this._horizontal = horizontal;
        return this;
    }

    /**
     * Set size variant
     * @param {string} size - 'sm' or 'lg'
     * @returns {this}
     */
    size(size) {
        this._size = size;
        return this;
    }

    /**
     * Small size
     * @returns {this}
     */
    small() {
        return this.size('sm');
    }

    /**
     * Large size
     * @returns {this}
     */
    large() {
        return this.size('lg');
    }

    // ==================
    // State Methods
    // ==================

    /**
     * Set active state on item
     * @param {number} index
     * @param {boolean} active
     * @returns {this}
     */
    setActive(index, active = true) {
        return this.updateItem(index, { active });
    }

    /**
     * Set disabled state on item
     * @param {number} index
     * @param {boolean} disabled
     * @returns {this}
     */
    setDisabled(index, disabled = true) {
        return this.updateItem(index, { disabled });
    }

    /**
     * Toggle active state on item
     * @param {number} index
     * @returns {this}
     */
    toggleActive(index) {
        if (this._items[index]) {
            this._items[index].active = !this._items[index].active;
            this._triggerEvent('so:item:toggled', { index, active: this._items[index].active });
        }
        return this;
    }

    // ==================
    // Event Methods
    // ==================

    /**
     * Add click event listener
     * @param {Function} callback
     * @returns {this}
     */
    onClick(callback) {
        return this.on('so:click', callback);
    }

    /**
     * Add item click event listener
     * @param {Function} callback
     * @returns {this}
     */
    onItemClick(callback) {
        return this.on('so:item:click', callback);
    }

    /**
     * Trigger custom event
     * @param {string} eventName
     * @param {Object} detail
     * @private
     */
    _triggerEvent(eventName, detail = {}) {
        if (this._element) {
            const event = new CustomEvent(eventName, {
                detail: { ...detail, listGroup: this },
                bubbles: true,
                cancelable: true,
            });
            this._element.dispatchEvent(event);
        }
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Build CSS classes
     * @returns {string}
     */
    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('list-group'));

        if (this._flush) {
            this._extraClasses.add(SixOrbit.cls('list-group-flush'));
        }

        if (this._numbered) {
            this._extraClasses.add(SixOrbit.cls('list-group-numbered'));
        }

        if (this._horizontal !== false) {
            if (this._horizontal === true) {
                this._extraClasses.add(SixOrbit.cls('list-group-horizontal'));
            } else {
                this._extraClasses.add(SixOrbit.cls(`list-group-horizontal-${this._horizontal}`));
            }
        }

        if (this._size) {
            this._extraClasses.add(SixOrbit.cls(`list-group-${this._size}`));
        }

        return super.buildClassString();
    }

    /**
     * Render content
     * @returns {string}
     */
    renderContent() {
        let html = '';

        this._items.forEach((item, index) => {
            let itemClass = SixOrbit.cls('list-group-item');

            // Add action class if URL is present
            if (item.url) {
                itemClass += ` ${SixOrbit.cls('list-group-item-action')}`;
            }

            // Add variant class
            if (item.variant) {
                itemClass += ` ${SixOrbit.cls(`list-group-item-${item.variant}`)}`;
            }

            // Add state classes
            if (item.active) {
                itemClass += ` ${SixOrbit.cls('active')}`;
            }

            if (item.disabled) {
                itemClass += ' disabled';
            }

            const tag = item.url ? 'a' : 'li';
            html += `<${tag} class="${itemClass}"`;

            if (item.url) {
                html += ` href="${this._escapeHtml(item.url)}"`;
            }

            if (item.active) {
                html += ' aria-current="true"';
            }

            if (item.disabled) {
                html += ' aria-disabled="true"';
                if (item.url) {
                    html += ' tabindex="-1"';
                }
            }

            html += ` data-so-index="${index}"`;
            html += '>';

            // Render content with icon and/or badge
            if (item.icon || item.badge) {
                html += '<div class="' + SixOrbit.cls('d-flex') + ' ' + SixOrbit.cls('justify-content-between') + ' ' + SixOrbit.cls('align-items-center') + '">';

                // Icon + content
                if (item.icon) {
                    html += '<div class="' + SixOrbit.cls('d-flex') + ' ' + SixOrbit.cls('align-items-center') + '">';
                    html += '<span class="material-icons ' + SixOrbit.cls('me-3') + ' ' + SixOrbit.cls('text-primary') + '">' + this._escapeHtml(item.icon) + '</span>';
                    html += '<span>' + this._escapeHtml(item.content) + '</span>';
                    html += '</div>';
                } else {
                    html += '<span>' + this._escapeHtml(item.content) + '</span>';
                }

                // Badge
                if (item.badge) {
                    const badgeVariant = item.badgeVariant || 'primary';
                    html += '<span class="' + SixOrbit.cls('badge') + ' ' + SixOrbit.cls(`badge-${badgeVariant}`) + ' ' + SixOrbit.cls('badge-pill') + '">';
                    html += this._escapeHtml(item.badge);
                    html += '</span>';
                }

                html += '</div>';
            } else {
                html += this._escapeHtml(item.content);
            }

            html += `</${tag}>`;
        });

        return html;
    }

    /**
     * After render hook - attach event listeners
     * @param {HTMLElement} element
     * @protected
     */
    _afterRender(element) {
        super._afterRender(element);

        // Attach click listeners to items
        element.querySelectorAll('[data-so-index]').forEach((item) => {
            item.addEventListener('click', (e) => {
                const index = parseInt(item.getAttribute('data-so-index'));
                const itemData = this._items[index];

                if (itemData && !itemData.disabled) {
                    this._triggerEvent('so:item:click', {
                        index,
                        item: itemData,
                        element: item,
                        originalEvent: e,
                    });
                }
            });
        });
    }

    // ==================
    // Config Export
    // ==================

    /**
     * Convert to config
     * @returns {Object}
     */
    toConfig() {
        const config = super.toConfig();

        if (this._items.length > 0) config.items = this._items;
        if (this._flush) config.flush = true;
        if (this._numbered) config.numbered = true;
        if (this._horizontal !== false) config.horizontal = this._horizontal;
        if (this._size) config.size = this._size;

        return config;
    }
}

export default ListGroup;
export { ListGroup };
