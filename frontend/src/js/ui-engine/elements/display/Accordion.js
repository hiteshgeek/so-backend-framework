// ============================================
// SIXORBIT UI ENGINE - ACCORDION ELEMENT
// Collapsible accordion component
// ============================================

import { ContainerElement } from '../../core/ContainerElement.js';
import SixOrbit from '../../../core/so-config.js';

/**
 * Accordion - Collapsible accordion element
 */
class Accordion extends ContainerElement {
    static NAME = 'ui-accordion';

    static DEFAULTS = {
        ...ContainerElement.DEFAULTS,
        type: 'accordion',
        tagName: 'div',
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
        this._alwaysOpen = config.alwaysOpen || false;
        this._activeItem = config.activeItem ?? 0;
    }

    // ==================
    // Fluent API
    // ==================

    /**
     * Add an accordion item
     * @param {string} title - Item header title
     * @param {string} content - Item content
     * @param {boolean} open - Start expanded
     * @returns {this}
     */
    item(title, content, open = false) {
        const index = this._items.length;
        this._items.push({ title, content, expanded: open });
        if (open) {
            this._activeItem = index;
        }
        return this;
    }

    /**
     * Add accordion item (alias for item with object config)
     * @param {Object} itemConfig - {title, content, expanded, icon}
     * @returns {this}
     */
    addItem(itemConfig) {
        this._items.push(itemConfig);
        return this;
    }

    /**
     * Set multiple items
     * @param {Array} items
     * @returns {this}
     */
    items(items) {
        this._items = items;
        return this;
    }

    /**
     * Set active item
     * @param {number} index
     * @returns {this}
     */
    activeItem(index) {
        this._activeItem = index;
        return this;
    }

    /**
     * Start with all collapsed
     * @returns {this}
     */
    collapsed() {
        this._activeItem = -1;
        return this;
    }

    /**
     * Set flush style (removes borders)
     * @param {boolean} flush
     * @returns {this}
     */
    flush(flush = true) {
        this._flush = flush;
        return this;
    }

    /**
     * Allow multiple items open at once
     * @param {boolean} alwaysOpen
     * @returns {this}
     */
    alwaysOpen(alwaysOpen = true) {
        this._alwaysOpen = alwaysOpen;
        return this;
    }

    // ==================
    // Rendering
    // ==================

    /**
     * Build CSS classes
     * @returns {string}
     */
    buildClassString() {
        this._extraClasses.add(SixOrbit.cls('accordion'));

        if (this._flush) {
            this._extraClasses.add(SixOrbit.cls('accordion-flush'));
        }

        return super.buildClassString();
    }

    /**
     * Build attributes
     * @returns {Object}
     */
    buildAttributes() {
        const attrs = super.buildAttributes();

        // Add data-so-accordion attribute for JS initialization
        attrs[SixOrbit.data('accordion')] = '';

        return attrs;
    }

    /**
     * Render content
     * @returns {string}
     */
    renderContent() {
        let html = '';
        const accordionId = this._id || `accordion-${Math.random().toString(36).substring(2, 11)}`;

        this._items.forEach((item, index) => {
            const headerId = `${accordionId}-header-${index}`;
            const collapseId = `${accordionId}-collapse-${index}`;
            // Use _activeItem if set, otherwise check item.expanded
            const isOpen = this._activeItem !== undefined
                ? index === this._activeItem
                : (item.expanded || false);

            html += `<div class="${SixOrbit.cls('accordion-item')}">`;

            // Header
            html += `<h2 class="${SixOrbit.cls('accordion-header')}" id="${headerId}">`;
            html += `<button class="${SixOrbit.cls('accordion-button')}${isOpen ? '' : ` ${SixOrbit.cls('collapsed')}`}" `;
            html += `type="button" `;
            html += `${SixOrbit.data('toggle')}="collapse" `;
            html += `${SixOrbit.data('target')}="#${collapseId}" `;
            html += `aria-expanded="${isOpen ? 'true' : 'false'}" `;
            html += `aria-controls="${collapseId}">`;

            if (item.icon) {
                html += `<span class="material-icons ${SixOrbit.cls('me-2')}">${this._escapeHtml(item.icon)}</span>`;
            }

            html += this._escapeHtml(item.title);
            html += '</button></h2>';

            // Collapse content
            html += `<div id="${collapseId}" `;
            html += `class="${SixOrbit.cls('accordion-collapse')} ${SixOrbit.cls('collapse')}${isOpen ? ` ${SixOrbit.cls('show')}` : ''}" `;
            html += `aria-labelledby="${headerId}" `;

            if (!this._alwaysOpen) {
                html += `${SixOrbit.data('parent')}="#${accordionId}"`;
            }

            html += '>';
            html += `<div class="${SixOrbit.cls('accordion-body')}">`;
            html += item.content || '';
            html += '</div></div>';

            html += '</div>';
        });

        // Render children
        html += this.renderChildren();

        return html;
    }

    // ==================
    // Interactivity Methods
    // ==================

    /**
     * Get collapse element by index
     * @param {number} index
     * @returns {HTMLElement|null}
     * @private
     */
    _getCollapseEl(index) {
        if (!this.element || !this._id) return null;
        return this.element.querySelector(`#${this._id}-collapse-${index}`);
    }

    /**
     * Get button element by index
     * @param {number} index
     * @returns {HTMLElement|null}
     * @private
     */
    _getButtonEl(index) {
        if (!this.element || !this._id) return null;
        return this.element.querySelector(`#${this._id}-header-${index} button`);
    }

    /**
     * Expand item by index
     * @param {number} index
     * @returns {this}
     */
    expand(index) {
        if (!this.element) return this;

        const collapseEl = this._getCollapseEl(index);
        const button = this._getButtonEl(index);

        if (!collapseEl) return this;

        // Dispatch show event (cancelable)
        const showEvent = new CustomEvent(SixOrbit.evt('accordion:show'), {
            detail: { index, collapseEl },
            bubbles: true,
            cancelable: true
        });
        if (!this.element.dispatchEvent(showEvent)) return this;

        // Close siblings if not alwaysOpen
        if (!this._alwaysOpen) {
            this._items.forEach((_, i) => {
                if (i !== index) {
                    this._collapseItem(i);
                }
            });
        }

        // Expand
        collapseEl.classList.add(SixOrbit.cls('show'));
        if (button) {
            button.classList.remove(SixOrbit.cls('collapsed'));
            button.setAttribute('aria-expanded', 'true');
        }

        // Dispatch shown event
        this.element.dispatchEvent(new CustomEvent(SixOrbit.evt('accordion:shown'), {
            detail: { index, collapseEl },
            bubbles: true
        }));

        return this;
    }

    /**
     * Collapse item by index
     * @param {number} index
     * @returns {this}
     */
    collapse(index) {
        if (!this.element) return this;

        const collapseEl = this._getCollapseEl(index);
        if (!collapseEl) return this;

        // Dispatch hide event (cancelable)
        const hideEvent = new CustomEvent(SixOrbit.evt('accordion:hide'), {
            detail: { index, collapseEl },
            bubbles: true,
            cancelable: true
        });
        if (!this.element.dispatchEvent(hideEvent)) return this;

        this._collapseItem(index);

        // Dispatch hidden event
        this.element.dispatchEvent(new CustomEvent(SixOrbit.evt('accordion:hidden'), {
            detail: { index, collapseEl },
            bubbles: true
        }));

        return this;
    }

    /**
     * Internal collapse without events
     * @param {number} index
     * @private
     */
    _collapseItem(index) {
        const collapseEl = this._getCollapseEl(index);
        const button = this._getButtonEl(index);

        if (collapseEl) {
            collapseEl.classList.remove(SixOrbit.cls('show'));
        }
        if (button) {
            button.classList.add(SixOrbit.cls('collapsed'));
            button.setAttribute('aria-expanded', 'false');
        }
    }

    /**
     * Toggle item by index
     * @param {number} index
     * @returns {this}
     */
    toggle(index) {
        if (!this.element) return this;

        const collapseEl = this._getCollapseEl(index);
        if (collapseEl?.classList.contains(SixOrbit.cls('show'))) {
            return this.collapse(index);
        } else {
            return this.expand(index);
        }
    }

    /**
     * Expand all items
     * @returns {this}
     */
    expandAll() {
        this._items.forEach((_, index) => this.expand(index));
        return this;
    }

    /**
     * Collapse all items
     * @returns {this}
     */
    collapseAll() {
        this._items.forEach((_, index) => this.collapse(index));
        return this;
    }

    /**
     * Check if item is expanded
     * @param {number} index
     * @returns {boolean}
     */
    isExpanded(index) {
        const collapseEl = this._getCollapseEl(index);
        return collapseEl?.classList.contains(SixOrbit.cls('show')) ?? false;
    }

    /**
     * Get count of items
     * @returns {number}
     */
    getItemCount() {
        return this._items.length;
    }

    /**
     * Listen to accordion show events
     * @param {Function} callback
     * @returns {this}
     */
    onShow(callback) {
        return this.on(SixOrbit.evt('accordion:show'), callback);
    }

    /**
     * Listen to accordion shown events
     * @param {Function} callback
     * @returns {this}
     */
    onShown(callback) {
        return this.on(SixOrbit.evt('accordion:shown'), callback);
    }

    /**
     * Listen to accordion hide events
     * @param {Function} callback
     * @returns {this}
     */
    onHide(callback) {
        return this.on(SixOrbit.evt('accordion:hide'), callback);
    }

    /**
     * Listen to accordion hidden events
     * @param {Function} callback
     * @returns {this}
     */
    onHidden(callback) {
        return this.on(SixOrbit.evt('accordion:hidden'), callback);
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
        if (this._activeItem !== 0) config.activeItem = this._activeItem;
        if (this._flush) config.flush = true;
        if (this._alwaysOpen) config.alwaysOpen = true;

        return config;
    }
}

export default Accordion;
export { Accordion };
