// ============================================
// SIXORBIT UI ENGINE - BREADCRUMB ELEMENT
// Navigation breadcrumbs
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

class Breadcrumb extends Element {
    static NAME = 'ui-breadcrumb';
    static DEFAULTS = { ...Element.DEFAULTS, type: 'breadcrumb', tagName: 'nav' };

    /**
     * Initialize from config
     * @param {Object} config
     * @private
     */
    _initFromConfig(config) {
        super._initFromConfig(config);
        this._items = config.items || [];
        this._divider = config.divider || null;
    }

    // ==================
    // Configuration Methods
    // ==================

    /**
     * Set items
     * @param {Array} items
     * @returns {this}
     */
    items(items) {
        this._items = items;
        return this;
    }

    /**
     * Add item
     * @param {string} label
     * @param {string|null} url
     * @param {string|null} icon
     * @returns {this}
     */
    addItem(label, url = null, icon = null) {
        const item = { label };
        if (url !== null) item.url = url;
        if (icon !== null) item.icon = icon;
        this._items.push(item);
        return this;
    }

    /**
     * Set custom divider
     * @param {string} divider
     * @returns {this}
     */
    divider(divider) {
        this._divider = divider;
        return this;
    }

    /**
     * Use chevron divider
     * @returns {this}
     */
    chevronDivider() {
        return this.addClass('breadcrumb-chevron');
    }

    /**
     * Use arrow divider
     * @returns {this}
     */
    arrowDivider() {
        return this.addClass('breadcrumb-arrow');
    }

    /**
     * Use slash divider
     * @returns {this}
     */
    slashDivider() {
        return this.addClass('breadcrumb-slash');
    }

    /**
     * Use pipe divider
     * @returns {this}
     */
    pipeDivider() {
        return this.addClass('breadcrumb-pipe');
    }

    /**
     * Use dot divider
     * @returns {this}
     */
    dotDivider() {
        return this.addClass('breadcrumb-dot');
    }

    /**
     * Use icon divider
     * @returns {this}
     */
    iconDivider() {
        return this.addClass('breadcrumb-icon');
    }

    /**
     * Use filled background style
     * @returns {this}
     */
    filled() {
        return this.addClass('breadcrumb-filled');
    }

    /**
     * Use pills style
     * @returns {this}
     */
    pills() {
        return this.addClass('breadcrumb-pills');
    }

    /**
     * Set color variant
     * @param {string} variant
     * @returns {this}
     */
    variant(variant) {
        return this.addClass('breadcrumb-' + variant);
    }

    /**
     * Use primary color variant
     * @returns {this}
     */
    primary() {
        return this.variant('primary');
    }

    /**
     * Use success color variant
     * @returns {this}
     */
    success() {
        return this.variant('success');
    }

    /**
     * Use danger color variant
     * @returns {this}
     */
    danger() {
        return this.variant('danger');
    }

    /**
     * Use warning color variant
     * @returns {this}
     */
    warning() {
        return this.variant('warning');
    }

    /**
     * Use info color variant
     * @returns {this}
     */
    info() {
        return this.variant('info');
    }

    /**
     * Set size
     * @param {string} size
     * @returns {this}
     */
    size(size) {
        return this.addClass('breadcrumb-' + size);
    }

    /**
     * Use small size
     * @returns {this}
     */
    small() {
        return this.size('sm');
    }

    /**
     * Use large size
     * @returns {this}
     */
    large() {
        return this.size('lg');
    }

    /**
     * Enable text truncation
     * @returns {this}
     */
    truncate() {
        return this.addClass('breadcrumb-truncate');
    }

    /**
     * Enable responsive collapse
     * @returns {this}
     */
    collapse() {
        return this.addClass('breadcrumb-collapse');
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Build attributes
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = super.buildAttributes();
        attrs['aria-label'] = 'breadcrumb';
        if (this._divider !== null) {
            attrs.style = `--${SixOrbit.getPrefix()}-breadcrumb-divider: '${this._divider}';`;
        }
        return attrs;
    }

    /**
     * Render content
     * @returns {string}
     */
    renderContent() {
        let html = `<ol class="${SixOrbit.cls('breadcrumb')}">`;
        this._items.forEach((item, idx) => {
            const isLast = idx === this._items.length - 1;
            const isActive = isLast || !item.url;
            let itemClass = SixOrbit.cls('breadcrumb-item');
            if (isActive) itemClass += ` ${SixOrbit.cls('active')}`;

            html += `<li class="${itemClass}"`;
            if (isActive) html += ' aria-current="page"';
            html += '>';

            // Icon
            let iconHtml = '';
            if (item.icon) {
                iconHtml = `<span class="material-icons ${SixOrbit.cls('me-1')}">${this._escapeHtml(item.icon)}</span>`;
            }

            if (!isActive && item.url) {
                html += `<a href="${this._escapeHtml(item.url)}">${iconHtml}${this._escapeHtml(item.label)}</a>`;
            } else {
                html += iconHtml + this._escapeHtml(item.label);
            }

            html += '</li>';
        });
        html += '</ol>';
        return html;
    }

    // ==================
    // Interactivity Methods
    // ==================

    /**
     * Set items dynamically
     * @param {Array} items
     * @returns {this}
     */
    setItems(items) {
        this._items = items;
        if (this.element) {
            this._updateContent();
        }
        return this;
    }

    /**
     * Get current items
     * @returns {Array}
     */
    getItems() {
        return this._items;
    }

    /**
     * Remove item by index
     * @param {number} index
     * @returns {this}
     */
    removeItem(index) {
        if (index >= 0 && index < this._items.length) {
            this._items.splice(index, 1);
            if (this.element) {
                this._updateContent();
            }
        }
        return this;
    }

    /**
     * Update item by index
     * @param {number} index
     * @param {Object} item
     * @returns {this}
     */
    updateItem(index, item) {
        if (index >= 0 && index < this._items.length) {
            this._items[index] = { ...this._items[index], ...item };
            if (this.element) {
                this._updateContent();
            }
        }
        return this;
    }

    /**
     * Clear all items
     * @returns {this}
     */
    clearItems() {
        this._items = [];
        if (this.element) {
            this._updateContent();
        }
        return this;
    }

    /**
     * Set custom divider dynamically
     * @param {string} divider
     * @returns {this}
     */
    setDivider(divider) {
        this._divider = divider;
        if (this.element) {
            const olElement = this.element.querySelector('ol');
            if (olElement) {
                olElement.style.setProperty(`--${SixOrbit.getPrefix()}-breadcrumb-divider`, `'${divider}'`);
            }
        }
        return this;
    }

    /**
     * Update the breadcrumb content
     * @private
     */
    _updateContent() {
        if (this.element) {
            this.element.innerHTML = this.renderContent();
        }
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
        if (this._divider !== null) config.divider = this._divider;
        return config;
    }
}

export default Breadcrumb;
export { Breadcrumb };
